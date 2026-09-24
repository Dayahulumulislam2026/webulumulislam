@extends('layouts.admin')

@section('title', 'Manajemen Akun Admin')
@section('page_title', 'Manajemen Akun Pengelola')
@section('page_subtitle', 'Kelola akun Super Admin, Co-Super Admin, dan Administrator')

@section('content')
<div class="space-y-8">
    <!-- Notice & Quota Information -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="p-5 rounded-3xl bg-amber-50 border border-amber-200 text-amber-950 space-y-1">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-800">👑 Super Admin</span>
                <span class="px-2 py-0.5 rounded-full bg-amber-200 text-amber-900 font-extrabold text-[10px]">Akses Penuh</span>
            </div>
            <p class="text-xs font-medium">Satu-satunya role yang berwenang menambah, mengedit data, mereset sandi, dan menghapus akun pengelola.</p>
        </div>

        <div class="p-5 rounded-3xl bg-emerald-50 border border-emerald-200 text-emerald-950 space-y-1">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800">🛡️ Co-Super Admin</span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-200 text-emerald-900 font-extrabold text-[10px]">
                    {{ $coSuperAdminCount }} / 2 Akun
                </span>
            </div>
            <p class="text-xs font-medium">Memiliki akses manajemen modul penuh. Pada modul akun admin berstatus <strong>Hanya Lihat (Read-Only)</strong>.</p>
        </div>

        <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200 text-slate-800 space-y-1">
            <span class="text-[10px] font-black uppercase tracking-wider text-slate-600">👤 Admin Konten</span>
            <p class="text-xs font-medium">Dapat mengelola seluruh konten publik operasional (Berita, Pengumuman, Galeri, Pendaftaran, Alumni).</p>
        </div>
    </div>

    <!-- Header Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <h2 class="text-base font-black text-slate-900">Daftar Akun Pengelola ({{ $users->count() }})</h2>
            @if(auth()->user()->isCoSuperAdmin())
            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-900 border border-emerald-200">
                Mode Read-Only (Hanya Lihat)
            </span>
            @endif
        </div>

        @if(auth()->user()->canModifyUsers())
        <button onclick="openModal('add-user-modal')" class="px-4 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Akun Baru
        </button>
        @endif
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-black uppercase tracking-wider border-b border-border-main">
                    <tr>
                        <th class="py-4 px-6">Nama & Email</th>
                        <th class="py-4 px-6">Peran / Role</th>
                        <th class="py-4 px-6">Status Akun</th>
                        <th class="py-4 px-6">Terdaftar Pada</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-primary-100 text-primary-900 font-black flex items-center justify-center text-xs">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                    <p class="text-[11px] text-slate-400 font-mono">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($user->role === 'super_admin')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-200">
                                👑 Super Admin
                            </span>
                            @elseif($user->role === 'co_super_admin')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-900 border border-emerald-200">
                                🛡️ Co-Super Admin
                            </span>
                            @elseif($user->role === 'admin_ikada')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-100 text-teal-900 border border-teal-200">
                                🤝 Admin IKADA UI
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700">
                                👤 Admin Konten
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($user->is_active)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Aktif
                            </span>
                            @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <!-- Detail View Button (Available for all who have access to this page) -->
                            <button onclick="openDetailModal({{ json_encode($user) }})" class="p-1.5 rounded-lg text-slate-600 hover:text-primary-900 hover:bg-slate-100 transition-colors" title="Lihat Detail Akun">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>

                            <!-- Edit & Delete Buttons (ONLY for Super Admin) -->
                            @if(auth()->user()->canModifyUsers())
                            <button onclick="openEditModal({{ json_encode($user) }})" class="p-1.5 rounded-lg text-slate-600 hover:text-primary-900 hover:bg-slate-100 transition-colors" title="Edit Akun">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>

                            @if(auth()->user()->id !== $user->id)
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }} permanen? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition-colors" title="Hapus Akun">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Akun (Read-Only) -->
<div id="detail-user-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Detail Akun Pengelola</h3>
            <button onclick="closeModal('detail-user-modal')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>

        <div class="space-y-4 text-xs">
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                <p id="detail-name" class="font-bold text-sm text-slate-900 mt-0.5">-</p>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Alamat Email</span>
                <p id="detail-email" class="font-mono text-xs text-slate-800 mt-0.5">-</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Peran (Role)</span>
                    <p id="detail-role" class="font-bold text-xs text-primary-950 mt-0.5">-</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Akun</span>
                    <p id="detail-status" class="font-bold text-xs text-slate-800 mt-0.5">-</p>
                </div>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Terdaftar Pada</span>
                <p id="detail-created" class="text-xs text-slate-600 mt-0.5">-</p>
            </div>
        </div>

        <div class="pt-4 flex justify-end border-t border-slate-100">
            <button type="button" onclick="closeModal('detail-user-modal')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold uppercase tracking-wider text-xs">
                Tutup
            </button>
        </div>
    </div>
</div>

@if(auth()->user()->canModifyUsers())
<!-- Modal Tambah Akun (HANYA UNTUK SUPER ADMIN) -->
<div id="add-user-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Tambah Akun Pengelola Baru</h3>
            <button onclick="closeModal('add-user-modal')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Contoh: Ustadz Ahmad, S.Pd">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="admin@ulumulislam.com">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                <div class="relative">
                    <input type="password" id="add-password" name="password" required minlength="6" class="w-full pl-3.5 pr-10 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePasswordVisibility('add-password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors" title="Lihat/Sembunyikan Sandi">
                        <svg class="eye-open w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="eye-closed w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Peran (Role)</label>
                <select name="role" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 font-medium">
                    <option value="admin">Admin Konten</option>
                    @php
                        $ikadaCount = \App\Models\User::where('role', 'admin_ikada')->count();
                    @endphp
                    @if($ikadaCount < 1)
                    <option value="admin_ikada">Admin IKADA UI (Maks. 1 Akun, Sisa: 1)</option>
                    @endif
                    @if($coSuperAdminCount < 2)
                    <option value="co_super_admin">Co-Super Admin (Sisa Kuota: {{ 2 - $coSuperAdminCount }})</option>
                    @endif
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" value="1" checked id="add-active" class="w-4 h-4 rounded text-primary-900 border-slate-300">
                <label for="add-active" class="text-slate-700 font-medium">Akun Aktif</label>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-user-modal')" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 font-bold uppercase tracking-wider">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-extrabold uppercase tracking-wider shadow-sm">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun (HANYA UNTUK SUPER ADMIN) -->
<div id="edit-user-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Akun Pengelola</h3>
            <button onclick="closeModal('edit-user-modal')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>

        <form id="edit-user-form" method="POST" action="" class="space-y-4 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input type="text" id="edit-name" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                <input type="email" id="edit-email" name="email" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi Baru (Opsional)</label>
                <div class="relative">
                    <input type="password" id="edit-password" name="password" minlength="6" class="w-full pl-3.5 pr-10 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Kosongkan jika tidak ingin mengubah">
                    <button type="button" onclick="togglePasswordVisibility('edit-password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors" title="Lihat/Sembunyikan Sandi">
                        <svg class="eye-open w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="eye-closed w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Peran (Role)</label>
                <select id="edit-role" name="role" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 font-medium">
                    <option value="admin">Admin Konten</option>
                    <option value="admin_ikada">Admin IKADA UI (Khusus 1 Akun)</option>
                    <option value="co_super_admin">Co-Super Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" value="1" id="edit-active" class="w-4 h-4 rounded text-primary-900 border-slate-300">
                <label for="edit-active" class="text-slate-700 font-medium">Akun Aktif</label>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-user-modal')" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 font-bold uppercase tracking-wider">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-extrabold uppercase tracking-wider shadow-sm">
                    Perbarui Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
    function openModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
        }
    }
    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
        }
    }

    function openDetailModal(user) {
        document.getElementById('detail-name').textContent = user.name || '-';
        document.getElementById('detail-email').textContent = user.email || '-';
        
        let roleName = 'Admin Konten';
        if (user.role === 'super_admin') roleName = 'Super Admin';
        else if (user.role === 'co_super_admin') roleName = 'Co-Super Admin';
        else if (user.role === 'admin_ikada') roleName = 'Admin IKADA UI';
        document.getElementById('detail-role').textContent = roleName;

        document.getElementById('detail-status').textContent = user.is_active ? 'Aktif' : 'Nonaktif';
        document.getElementById('detail-created').textContent = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
        
        openModal('detail-user-modal');
    }

    @if(auth()->user()->canModifyUsers())
    function openEditModal(user) {
        document.getElementById('edit-user-form').action = `/admin/users/${user.id}`;
        document.getElementById('edit-name').value = user.name;
        document.getElementById('edit-email').value = user.email;
        document.getElementById('edit-role').value = user.role;
        document.getElementById('edit-active').checked = !!user.is_active;
        openModal('edit-user-modal');
    }
    @endif

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');
        if (eyeOpen && eyeClosed) {
            if (isPassword) {
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    }
</script>
@endpush
@endsection
