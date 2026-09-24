<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        $coSuperAdminCount = User::where('role', 'co_super_admin')->count();
        $adminIkadaCount = User::where('role', 'admin_ikada')->count();

        return view('admin.users.index', compact('users', 'coSuperAdminCount', 'adminIkadaCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $currentUser = Auth::user();

        // Aturan Keras: HANYA Super Admin yang berhak menambah akun pengelola baru
        if (!$currentUser->canModifyUsers()) {
            return back()->with('error', 'Akses ditolak: Co-Super Admin berstatus Read-Only dan tidak memiliki hak untuk menambah akun admin baru.')->withInput();
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['super_admin', 'co_super_admin', 'admin', 'admin_ikada'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $role = $request->role;

        // Aturan: Batas kuota Co-Super Admin maksimal 2 orang
        if ($role === 'co_super_admin') {
            $existingCoSuperAdmin = User::where('role', 'co_super_admin')->count();
            if ($existingCoSuperAdmin >= 2) {
                return back()->with('error', 'Batas kuota Co-Super Admin maksimal 2 orang telah tercapai. Tidak dapat menambah Co-Super Admin baru.')->withInput();
            }
        }

        // Aturan: Batas kuota Admin IKADA maksimal 1 orang
        if ($role === 'admin_ikada') {
            $existingIkadaAdmin = User::where('role', 'admin_ikada')->count();
            if ($existingIkadaAdmin >= 1) {
                return back()->with('error', 'Batas kuota Admin Khusus IKADA UI maksimal 1 akun telah terisi. Tidak dapat menambah Admin IKADA baru.')->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_active' => $request->boolean('is_active', true),
        ]);

        AuditLog::log('create', 'user', $user->id, "Membuat akun pengelola baru: {$user->name} ({$user->email}) dengan peran {$user->role}.");

        return redirect()->route('admin.users.index')->with('success', "Akun {$user->name} ({$user->role}) berhasil dibuat.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $currentUser = Auth::user();

        // Aturan Keras: HANYA Super Admin yang berhak mengedit data akun pengelola
        if (!$currentUser->canModifyUsers()) {
            return back()->with('error', 'Akses ditolak: Co-Super Admin berstatus Read-Only dan tidak memiliki hak untuk mengubah data admin.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(['super_admin', 'co_super_admin', 'admin', 'admin_ikada'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $newRole = $request->role;

        // Aturan: Batas kuota Co-Super Admin maksimal 2 orang
        if ($newRole === 'co_super_admin' && $user->role !== 'co_super_admin') {
            $existingCoSuperAdmin = User::where('role', 'co_super_admin')->count();
            if ($existingCoSuperAdmin >= 2) {
                return back()->with('error', 'Batas kuota Co-Super Admin maksimal 2 orang telah tercapai.');
            }
        }

        // Aturan: Batas kuota Admin IKADA maksimal 1 orang
        if ($newRole === 'admin_ikada' && $user->role !== 'admin_ikada') {
            $existingIkadaAdmin = User::where('role', 'admin_ikada')->where('id', '!=', $user->id)->count();
            if ($existingIkadaAdmin >= 1) {
                return back()->with('error', 'Batas kuota Admin Khusus IKADA UI maksimal 1 akun telah terisi.');
            }
        }

        $data = [
            'name' => $request->name,
            'email' => strtolower($request->email),
            'role' => $newRole,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        AuditLog::log('update', 'user', $user->id, "Memperbarui profil/peran akun pengelola: {$user->name} ({$user->email}).");

        return redirect()->route('admin.users.index')->with('success', "Data akun {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        $currentUser = Auth::user();

        // Aturan Keras: HANYA Super Admin yang berhak menghapus akun pengelola
        if (!$currentUser->canModifyUsers() || !$currentUser->canDeleteUsers()) {
            return back()->with('error', 'Akses ditolak: Co-Super Admin berstatus Read-Only dan tidak memiliki izin untuk menghapus akun pengelola.');
        }

        // Mencegah Super Admin menghapus akunnya sendiri
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $user->delete();

        AuditLog::log('delete', 'user', $user->id, "Menghapus akun pengelola: {$userName} ({$userEmail}).");

        return redirect()->route('admin.users.index')->with('success', "Akun {$userName} berhasil dihapus permanen.");
    }
}
