@extends('layouts.admin')

@section('title', 'Alumni & Prestasi')
@section('page_title', 'Manajemen Data Alumni')
@section('page_subtitle', 'Kelola direktori alumni, testimoni, pin beranda, dan angka statistik manual')

@section('content')
    <!-- Unit Selector Tabs (Tanpa Tab IKADA) -->
    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-border-main pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.alumni.index', ['tab' => 'all']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'all' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🌐 Semua Alumni
            </a>
            <a href="{{ route('admin.alumni.index', ['tab' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'smp' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                📚 SMP Ulumul Islam
            </a>
            <a href="{{ route('admin.alumni.index', ['tab' => 'sma']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'sma' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🎓 SMA Ulumul Islam
            </a>
        </div>

        <button onclick="openModal('add-alumni-modal')" class="px-4 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Tambah Data Alumni
        </button>
    </div>

    <!-- Statistik Total Alumni (Manual Override) -->
    @if($institution)
    <div class="bg-white rounded-3xl p-6 border border-border-main shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-black text-sm text-slate-900">Total Akumulasi Alumni {{ strtoupper($tab) }}</h3>
            <p class="text-xs text-slate-500 font-medium">Angka ini tampil pada widget ringkasan statistik di halaman publik.</p>
        </div>
        <form method="POST" action="{{ route('admin.alumni.update_total') }}" class="flex items-center gap-3 w-full sm:w-auto">
            @csrf
            <input type="hidden" name="institution_id" value="{{ $institution->id }}">
            <input type="number" name="total_alumni_val" value="{{ $totalAlumniStat }}" required min="0" class="w-32 px-3.5 py-2 rounded-xl border border-slate-300 font-black text-sm text-center">
            <button type="submit" class="px-4 py-2 rounded-xl bg-accent-gold hover:bg-accent-gold-hover text-primary-950 font-black text-xs uppercase tracking-wider shadow-xs transition-colors whitespace-nowrap">
                Simpan Angka
            </button>
        </form>
    </div>
    @endif

    <!-- Alumni List Table -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-black uppercase tracking-wider border-b border-border-main">
                    <tr>
                        <th class="py-4 px-6">Nama Alumni</th>
                        <th class="py-4 px-6">Jenjang Diikuti</th>
                        <th class="py-4 px-6">Tampil di Halaman</th>
                        <th class="py-4 px-6">Jalur & Instansi</th>
                        <th class="py-4 px-6 text-center">Pin Beranda</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($alumni as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($item->photo_path)
                                <img src="{{ $item->photo_path }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-xl object-cover border border-primary-900 shrink-0">
                                @else
                                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-900 font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($item->name, 0, 2)) }}
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-900">{{ $item->name }}</p>
                                    <p class="text-[10px] text-slate-400 truncate max-w-xs">{{ $item->position_or_program }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                @foreach($item->graduation_levels_array as $lvl)
                                <span class="px-2 py-0.5 rounded bg-primary-50 text-primary-950 font-bold text-[9px] uppercase border border-primary-200">
                                    {{ $lvl }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                @foreach($item->display_units_array as $u)
                                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-900 font-bold text-[9px] uppercase border border-emerald-200">
                                    {{ $u }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900 block">{{ $item->institution_or_company }}</span>
                            <span class="text-[10px] text-slate-400 capitalize">{{ str_replace('_', ' ', $item->career_type) }}</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <form method="POST" action="{{ route('admin.alumni.toggle_pin_home', $item->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider transition-colors {{ $item->is_home_pinned ? 'bg-amber-100 text-amber-950 border border-amber-300' : 'bg-slate-100 text-slate-400 hover:bg-slate-200' }}" title="{{ $item->is_home_pinned ? 'Lepas Pin Beranda' : 'Sematkan di Beranda Utama' }}">
                                    {{ $item->is_home_pinned ? '⭐ Pinned' : '☆ Pin' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $item->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                            <button onclick="openEditAlumniModal({{ json_encode($item) }})" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-100" title="Edit Alumni">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.alumni.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Hapus data alumni {{ $item->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50" title="Hapus Alumni">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">Belum ada data alumni yang dicatat pada filter ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Alumni -->
<div id="add-alumni-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Tambah Data Alumni Baru</h3>
        <form method="POST" action="{{ route('admin.alumni.store') }}" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Alumni & Gelar</label>
                <input type="text" name="name" required placeholder="Contoh: Muhammad Farhan, S.Kom" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <!-- Jenjang yang Diikuti -->
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <label class="block font-black text-slate-800 uppercase tracking-wider text-[11px]">1. Jenjang yang Diikuti di Ulumul Islam</label>
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700"><input type="checkbox" name="graduation_levels[]" value="dayah" class="rounded text-primary-900"> Dayah Terpadu</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700"><input type="checkbox" name="graduation_levels[]" value="smp" class="rounded text-primary-900" {{ $tab === 'smp' ? 'checked' : '' }}> SMP</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700"><input type="checkbox" name="graduation_levels[]" value="sma" class="rounded text-primary-900" {{ $tab === 'sma' ? 'checked' : '' }}> SMA</label>
                </div>
            </div>

            <!-- Multi-Placement Unit -->
            <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-200 space-y-2">
                <label class="block font-black text-emerald-950 uppercase tracking-wider text-[11px]">2. Tampilkan di Halaman Profil Unit (Multi-Placement)</label>
                <p class="text-[10px] text-slate-500">Pilih di halaman website unit mana saja profil alumni ini boleh ditampilkan:</p>
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900"><input type="checkbox" name="display_units[]" value="dayah" class="rounded text-emerald-800"> Dayah</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900"><input type="checkbox" name="display_units[]" value="smp" class="rounded text-emerald-800" {{ $tab === 'smp' ? 'checked' : '' }}> SMP</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900"><input type="checkbox" name="display_units[]" value="sma" class="rounded text-emerald-800" {{ $tab === 'sma' ? 'checked' : '' }}> SMA</label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jalur Karir / Studi</label>
                    <select name="career_type" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="perguruan_tinggi">Perguruan Tinggi Negeri / Swasta</option>
                        <option value="timur_tengah">Universitas Timur Tengah</option>
                        <option value="kedinasan">Sekolah Kedinasan / TNI-POLRI</option>
                        <option value="profesional">Profesional / Karir</option>
                        <option value="wirausaha">Wirausaha / Bisnis</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jurusan / Profesi / Jabatan</label>
                    <input type="text" name="position_or_program" required placeholder="Contoh: Teknik Informatika / Dokter" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Kampus / Lembaga / Perusahaan</label>
                <input type="text" name="institution_or_company" required placeholder="Contoh: Universitas Indonesia / RSUD" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Kesan / Testimoni Alumni</label>
                <textarea name="short_description" rows="3" required placeholder="Kesan selama menuntut ilmu di Ulumul Islam..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Foto Formal Alumni</label>
                    <input type="file" name="photo" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="1:1">
                    <span class="text-[9px] text-slate-400">Rasio 1:1 • Didukung Pemotong Gambar</span>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Publikasi</label>
                    <select name="status" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="published">Published (Tayang)</option>
                        <option value="draft">Draft (Disimpan)</option>
                    </select>
                </div>
            </div>

            <div class="p-3 bg-amber-50 rounded-2xl border border-amber-200">
                <label class="flex items-center gap-2 font-bold text-amber-950 cursor-pointer">
                    <input type="checkbox" name="is_home_pinned" value="1" class="rounded text-amber-600">
                    <span>⭐ Sematkan di Beranda Utama (Featured Home Alumni)</span>
                </label>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-alumni-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Simpan Alumni</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Alumni -->
<div id="edit-alumni-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Data Alumni</h3>
        <form id="edit-alumni-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Alumni & Gelar</label>
                <input type="text" id="edit-alumni-name" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <!-- Jenjang yang Diikuti -->
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <label class="block font-black text-slate-800 uppercase tracking-wider text-[11px]">1. Jenjang yang Diikuti di Ulumul Islam</label>
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700"><input type="checkbox" id="edit-lvl-dayah" name="graduation_levels[]" value="dayah" class="rounded text-primary-900"> Dayah Terpadu</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700"><input type="checkbox" id="edit-lvl-smp" name="graduation_levels[]" value="smp" class="rounded text-primary-900"> SMP</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700"><input type="checkbox" id="edit-lvl-sma" name="graduation_levels[]" value="sma" class="rounded text-primary-900"> SMA</label>
                </div>
            </div>

            <!-- Multi-Placement Unit -->
            <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-200 space-y-2">
                <label class="block font-black text-emerald-950 uppercase tracking-wider text-[11px]">2. Tampilkan di Halaman Profil Unit (Multi-Placement)</label>
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900"><input type="checkbox" id="edit-disp-dayah" name="display_units[]" value="dayah" class="rounded text-emerald-800"> Dayah</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900"><input type="checkbox" id="edit-disp-smp" name="display_units[]" value="smp" class="rounded text-emerald-800"> SMP</label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-bold text-emerald-900"><input type="checkbox" id="edit-disp-sma" name="display_units[]" value="sma" class="rounded text-emerald-800"> SMA</label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jalur Karir / Studi</label>
                    <select id="edit-alumni-career" name="career_type" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="perguruan_tinggi">Perguruan Tinggi</option>
                        <option value="timur_tengah">Universitas Timur Tengah</option>
                        <option value="kedinasan">Sekolah Kedinasan</option>
                        <option value="profesional">Profesional / Karir</option>
                        <option value="wirausaha">Wirausaha</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jurusan / Profesi / Jabatan</label>
                    <input type="text" id="edit-alumni-pos" name="position_or_program" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Kampus / Lembaga / Perusahaan</label>
                <input type="text" id="edit-alumni-inst" name="institution_or_company" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Kesan / Testimoni</label>
                <textarea id="edit-alumni-desc" name="short_description" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="photo" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="1:1">
                    <span class="text-[9px] text-slate-400">Rasio 1:1 • Didukung Pemotong Gambar</span>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Publikasi</label>
                    <select id="edit-alumni-status" name="status" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="p-3 bg-amber-50 rounded-2xl border border-amber-200">
                <label class="flex items-center gap-2 font-bold text-amber-950 cursor-pointer">
                    <input type="checkbox" id="edit-alumni-home-pinned" name="is_home_pinned" value="1" class="rounded text-amber-600">
                    <span>⭐ Sematkan di Beranda Utama (Featured Home Alumni)</span>
                </label>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-alumni-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    function openEditAlumniModal(item) {
        document.getElementById('edit-alumni-form').action = `/admin/alumni/${item.id}`;
        document.getElementById('edit-alumni-name').value = item.name;
        document.getElementById('edit-alumni-career').value = item.career_type;
        document.getElementById('edit-alumni-pos').value = item.position_or_program;
        document.getElementById('edit-alumni-inst').value = item.institution_or_company;
        document.getElementById('edit-alumni-desc').value = item.short_description;
        document.getElementById('edit-alumni-status').value = item.status;
        document.getElementById('edit-alumni-home-pinned').checked = !!item.is_home_pinned;

        const lvls = (item.graduation_levels || '').toLowerCase();
        document.getElementById('edit-lvl-smp').checked = lvls.includes('smp');
        document.getElementById('edit-lvl-sma').checked = lvls.includes('sma');
        document.getElementById('edit-lvl-dayah').checked = lvls.includes('dayah');

        const disps = (item.display_units || item.graduation_levels || '').toLowerCase();
        document.getElementById('edit-disp-smp').checked = disps.includes('smp');
        document.getElementById('edit-disp-sma').checked = disps.includes('sma');
        document.getElementById('edit-disp-dayah').checked = disps.includes('dayah');

        openModal('edit-alumni-modal');
    }
</script>
@endpush
@endsection
