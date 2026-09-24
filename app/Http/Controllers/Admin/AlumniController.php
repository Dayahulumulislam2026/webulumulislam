<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AuditLog;
use App\Models\FeaturedAlumni;
use App\Models\Institution;
use App\Models\Statistic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'all');

        $query = Alumni::with('featured');

        if ($tab !== 'all') {
            $query->where(function ($q) use ($tab) {
                $q->where('graduation_levels', 'like', "%{$tab}%")
                  ->orWhere('display_units', 'like', "%{$tab}%");
            });
        }

        $alumni = $query->orderByDesc('created_at')->get();

        $institution = null;
        $totalAlumniStat = 0;
        if (in_array($tab, ['smp', 'sma'])) {
            $institution = Institution::where('type', $tab)->first();
            if ($institution) {
                $totalAlumniStat = Statistic::where('institution_id', $institution->id)
                    ->where('metric', 'total_alumni')
                    ->first()?->value ?? 0;
            }
        }

        return view('admin.alumni.index', compact('alumni', 'tab', 'totalAlumniStat', 'institution'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'graduation_levels' => ['required', 'array'],
            'display_units' => ['nullable', 'array'],
            'career_type' => ['required', 'string'],
            'position_or_program' => ['required', 'string', 'max:255'],
            'institution_or_company' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'is_home_pinned' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('alumni', 'public');
        }

        $displayUnits = $request->filled('display_units')
            ? implode(',', $request->display_units)
            : implode(',', $request->graduation_levels);

        $alumni = Alumni::create([
            'name' => $request->name,
            'graduation_levels' => implode(',', $request->graduation_levels),
            'display_units' => $displayUnits,
            'career_type' => $request->career_type,
            'position_or_program' => $request->position_or_program,
            'institution_or_company' => $request->institution_or_company,
            'short_description' => $request->short_description,
            'status' => $request->status,
            'is_home_pinned' => $request->boolean('is_home_pinned', false),
            'photo_path' => $photoPath ? '/storage/' . $photoPath : null,
        ]);

        if ($request->boolean('is_home_pinned')) {
            FeaturedAlumni::updateOrCreate(
                ['alumni_id' => $alumni->id],
                ['placement' => 'home', 'sort_order' => 10]
            );
        }

        AuditLog::log('create', 'alumni', $alumni->id, "Menambahkan data alumni: {$alumni->name}.");

        return back()->with('success', "Data alumni {$alumni->name} berhasil ditambahkan.");
    }

    public function update(Request $request, Alumni $alumnus): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'graduation_levels' => ['required', 'array'],
            'display_units' => ['nullable', 'array'],
            'career_type' => ['required', 'string'],
            'position_or_program' => ['required', 'string', 'max:255'],
            'institution_or_company' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'is_home_pinned' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $displayUnits = $request->filled('display_units')
            ? implode(',', $request->display_units)
            : implode(',', $request->graduation_levels);

        $isHomePinned = $request->boolean('is_home_pinned', false);

        $data = [
            'name' => $request->name,
            'graduation_levels' => implode(',', $request->graduation_levels),
            'display_units' => $displayUnits,
            'career_type' => $request->career_type,
            'position_or_program' => $request->position_or_program,
            'institution_or_company' => $request->institution_or_company,
            'short_description' => $request->short_description,
            'status' => $request->status,
            'is_home_pinned' => $isHomePinned,
        ];

        if ($request->hasFile('photo')) {
            if ($alumnus->photo_path && str_starts_with($alumnus->photo_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $alumnus->photo_path));
            }
            $path = $request->file('photo')->store('alumni', 'public');
            $data['photo_path'] = '/storage/' . $path;
        }

        $alumnus->update($data);

        if ($isHomePinned) {
            FeaturedAlumni::updateOrCreate(
                ['alumni_id' => $alumnus->id],
                ['placement' => 'home', 'sort_order' => 10]
            );
        } else {
            FeaturedAlumni::where('alumni_id', $alumnus->id)->delete();
        }

        AuditLog::log('update', 'alumni', $alumnus->id, "Memperbarui data alumni: {$alumnus->name}.");

        return back()->with('success', "Data alumni {$alumnus->name} berhasil diperbarui.");
    }

    public function destroy(Alumni $alumnus): RedirectResponse
    {
        $name = $alumnus->name;
        if ($alumnus->photo_path && str_starts_with($alumnus->photo_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $alumnus->photo_path));
        }
        FeaturedAlumni::where('alumni_id', $alumnus->id)->delete();
        $alumnus->delete();

        AuditLog::log('delete', 'alumni', $alumnus->id, "Menghapus data alumni: {$name}.");

        return back()->with('success', "Data alumni {$name} berhasil dihapus.");
    }

    public function togglePinHome(Alumni $alumnus): RedirectResponse
    {
        $newPinned = !$alumnus->is_home_pinned;
        $alumnus->update(['is_home_pinned' => $newPinned]);

        if ($newPinned) {
            FeaturedAlumni::updateOrCreate(
                ['alumni_id' => $alumnus->id],
                ['placement' => 'home', 'sort_order' => 10]
            );
            $msg = "Alumni {$alumnus->name} berhasil disematkan di Beranda Utama (⭐).";
        } else {
            FeaturedAlumni::where('alumni_id', $alumnus->id)->delete();
            $msg = "Pin Beranda untuk {$alumnus->name} berhasil dilepas.";
        }

        AuditLog::log('toggle_pin_home', 'alumni', $alumnus->id, $msg);

        return back()->with('success', $msg);
    }

    public function updateTotalAlumni(Request $request): RedirectResponse
    {
        $request->validate([
            'institution_id' => ['required', 'exists:institutions,id'],
            'total_alumni_val' => ['required', 'integer', 'min:0'],
        ]);

        Statistic::updateOrCreate(
            ['institution_id' => $request->institution_id, 'metric' => 'total_alumni'],
            ['value' => $request->total_alumni_val]
        );

        AuditLog::log('update_stat', 'statistic', $request->institution_id, "Memperbarui statistik total alumni menjadi {$request->total_alumni_val}.");

        return back()->with('success', "Angka statistik total alumni berhasil disimpan.");
    }
}
