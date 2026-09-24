<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Institution;
use App\Models\Statistic;
use App\Models\StructureMember;
use App\Models\StructurePosition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $defaultTab = ($user && $user->isAdminIkada()) ? 'ikada' : 'foundation';
        $tab = $request->query('tab', $defaultTab);

        // Jika user adalah Admin IKADA, paksa tab ke 'ikada'
        if ($user && $user->isAdminIkada()) {
            $tab = 'ikada';
        }

        $institutions = Institution::all()->keyBy('type');
        $current = $institutions->get($tab) ?? $institutions->first();

        $positions = StructurePosition::with(['members' => function ($q) {
            $q->orderBy('sort_order')->orderBy('id');
        }])
            ->where('institution_id', $current->id)
            ->orderBy('sort_order')
            ->get();

        $leaders = $positions->where('category', 'leader');
        $vices = $positions->where('category', 'vice');
        $divisions = $positions->where('category', 'division');

        $ikadaStats = [
            'total_alumni' => Statistic::where('institution_id', $current->id)->where('metric', 'total_alumni')->first()?->value ?? 1250,
            'total_angkatan' => Statistic::where('institution_id', $current->id)->where('metric', 'total_angkatan')->first()?->value ?? 15,
            'total_ptn' => Statistic::where('institution_id', $current->id)->where('metric', 'total_ptn')->first()?->value ?? 85,
        ];

        return view('admin.institutions.index', compact('institutions', 'current', 'tab', 'positions', 'leaders', 'vices', 'divisions', 'ikadaStats'));
    }

    public function update(Request $request, Institution $institution): RedirectResponse
    {
        $user = auth()->user();
        if ($user && $user->isAdminIkada() && $institution->type !== 'ikada') {
            abort(403, 'Akses ditolak: Admin IKADA hanya berhak mengelola halaman IKADA UI.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'], // newline separated
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ]);

        $missionArray = $request->filled('mission')
            ? array_values(array_filter(array_map('trim', explode("\n", $request->mission))))
            : [];

        $data = [
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'vision' => $request->vision,
            'mission' => $missionArray,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
        ];

        // Handle upload logo
        if ($request->hasFile('logo')) {
            if ($institution->logo_path && str_starts_with($institution->logo_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $institution->logo_path));
            }
            $logoPath = $request->file('logo')->store('institutions/logos', 'public');
            $data['logo_path'] = '/storage/' . $logoPath;
        }

        // Handle upload banner
        if ($request->hasFile('banner')) {
            if ($institution->banner_path && str_starts_with($institution->banner_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $institution->banner_path));
            }
            $bannerPath = $request->file('banner')->store('institutions/banners', 'public');
            $data['banner_path'] = '/storage/' . $bannerPath;
        }

        $institution->update($data);

        // Jika institusi adalah IKADA, simpan statistik dinamisnya
        if ($institution->type === 'ikada') {
            if ($request->has('total_alumni')) {
                Statistic::updateOrCreate(
                    ['institution_id' => $institution->id, 'metric' => 'total_alumni'],
                    ['value' => (int) $request->input('total_alumni')]
                );
            }
            if ($request->has('total_angkatan')) {
                Statistic::updateOrCreate(
                    ['institution_id' => $institution->id, 'metric' => 'total_angkatan'],
                    ['value' => (int) $request->input('total_angkatan')]
                );
            }
            if ($request->has('total_ptn')) {
                Statistic::updateOrCreate(
                    ['institution_id' => $institution->id, 'metric' => 'total_ptn'],
                    ['value' => (int) $request->input('total_ptn')]
                );
            }
        }

        AuditLog::log('update', 'institution', $institution->id, "Memperbarui profil dan media institusi {$institution->name}.");

        return back()->with('success', "Profil dan media {$institution->name} berhasil diperbarui.");
    }
}
