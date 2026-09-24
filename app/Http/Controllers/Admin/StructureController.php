<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Institution;
use App\Models\StructureMember;
use App\Models\StructurePosition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StructureController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'foundation');
        $institutions = Institution::all()->keyBy('type');
        $currentInstitution = $institutions->get($tab) ?? $institutions->first();

        $positions = StructurePosition::with(['members' => function ($q) {
            $q->orderBy('sort_order')->orderBy('id');
        }])
            ->where('institution_id', $currentInstitution->id)
            ->orderBy('sort_order')
            ->get();

        $leaders = $positions->where('category', 'leader');
        $vices = $positions->where('category', 'vice');
        $divisions = $positions->where('category', 'division');

        return view('admin.structure.index', compact('institutions', 'currentInstitution', 'positions', 'leaders', 'vices', 'divisions', 'tab'));
    }

    public function storePosition(Request $request): RedirectResponse
    {
        $request->validate([
            'institution_id' => ['required', 'exists:institutions,id'],
            'category' => ['required', 'in:leader,vice,division'],
            'position_name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_pinned' => ['nullable', 'boolean'],
        ]);

        $position = StructurePosition::create([
            'institution_id' => $request->institution_id,
            'category' => $request->category,
            'position_name' => $request->position_name,
            'sort_order' => $request->integer('sort_order', 1),
            'is_pinned' => $request->boolean('is_pinned', false),
            'is_active' => true,
        ]);

        $categoryLabel = match ($request->category) {
            'leader' => 'Pimpinan Utama',
            'vice' => 'Wakil Pimpinan',
            'division' => 'Divisi / Bidang',
            default => 'Posisi',
        };

        AuditLog::log('create', 'structure_position', $position->id, "Menambah {$categoryLabel}: {$position->position_name}.");

        return back()->with('success', "{$categoryLabel} \"{$position->position_name}\" berhasil ditambahkan.");
    }

    public function updatePosition(Request $request, StructurePosition $position): RedirectResponse
    {
        $request->validate([
            'category' => ['required', 'in:leader,vice,division'],
            'position_name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_pinned' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $position->update([
            'category' => $request->category,
            'position_name' => $request->position_name,
            'sort_order' => $request->integer('sort_order', 1),
            'is_pinned' => $request->boolean('is_pinned', false),
            'is_active' => $request->boolean('is_active', true),
        ]);

        AuditLog::log('update', 'structure_position', $position->id, "Memperbarui data posisi/divisi: {$position->position_name}.");

        return back()->with('success', "Posisi/Divisi \"{$position->position_name}\" berhasil diperbarui.");
    }

    public function destroyPosition(StructurePosition $position): RedirectResponse
    {
        $name = $position->position_name;

        // Delete photo files of members in this position
        foreach ($position->members as $member) {
            if ($member->photo_path && str_starts_with($member->photo_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $member->photo_path));
            }
        }

        $position->delete();

        AuditLog::log('delete', 'structure_position', $position->id, "Menghapus posisi/divisi: {$name}.");

        return back()->with('success', "Posisi/Divisi \"{$name}\" beserta seluruh anggotanya berhasil dihapus.");
    }

    public function storeMember(Request $request): RedirectResponse
    {
        $request->validate([
            'position_id' => ['required', 'exists:structure_positions,id'],
            'name' => ['required', 'string', 'max:255'],
            'member_role' => ['nullable', 'in:leader,vice,head,member'],
            'title' => ['nullable', 'string', 'max:255'],
            'sub_role' => ['nullable', 'string', 'max:500'],
            'period' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('structures', 'public');
        }

        $member = StructureMember::create([
            'position_id' => $request->position_id,
            'name' => $request->name,
            'member_role' => $request->input('member_role', 'member'),
            'title' => $request->title,
            'sub_role' => $request->sub_role,
            'period' => $request->period,
            'photo_path' => $photoPath ? '/storage/' . $photoPath : null,
            'sort_order' => $request->integer('sort_order', 0),
            'is_active' => true,
        ]);

        AuditLog::log('create', 'structure_member', $member->id, "Menambah data pengurus: {$member->name}.");

        return back()->with('success', "Pengurus \"{$member->name}\" berhasil ditambahkan.");
    }

    public function updateMember(Request $request, StructureMember $member): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'member_role' => ['nullable', 'in:leader,vice,head,member'],
            'title' => ['nullable', 'string', 'max:255'],
            'sub_role' => ['nullable', 'string', 'max:500'],
            'period' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'name' => $request->name,
            'member_role' => $request->input('member_role', 'member'),
            'title' => $request->title,
            'sub_role' => $request->sub_role,
            'period' => $request->period,
            'sort_order' => $request->integer('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('photo')) {
            if ($member->photo_path && str_starts_with($member->photo_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $member->photo_path));
            }
            $path = $request->file('photo')->store('structures', 'public');
            $data['photo_path'] = '/storage/' . $path;
        }

        $member->update($data);

        AuditLog::log('update', 'structure_member', $member->id, "Memperbarui data pengurus: {$member->name}.");

        return back()->with('success', "Data pengurus \"{$member->name}\" berhasil diperbarui.");
    }

    public function destroyMember(StructureMember $member): RedirectResponse
    {
        $name = $member->name;
        if ($member->photo_path && str_starts_with($member->photo_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $member->photo_path));
        }
        $member->delete();

        AuditLog::log('delete', 'structure_member', $member->id, "Menghapus pengurus: {$name}.");

        return back()->with('success', "Pengurus \"{$name}\" berhasil dihapus.");
    }

    public function togglePin(StructurePosition $position): RedirectResponse
    {
        $position->update(['is_pinned' => !$position->is_pinned]);
        $statusText = $position->is_pinned ? 'Disematkan (Pin)' : 'Pin dilepas';
        AuditLog::log('toggle_pin', 'structure_position', $position->id, "{$statusText} posisi {$position->position_name}.");

        return back()->with('success', "Status {$position->position_name}: {$statusText}.");
    }
}

