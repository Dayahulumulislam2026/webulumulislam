@extends('layouts.admin')

@section('title', 'Profil & Konten Lembaga')
@section('page_title', 'Profil, Media & Konten Lembaga')
@section('page_subtitle', 'Kelola deskripsi, visi, misi, logo, banner sampul, dan kontak resmi per unit pendidikan')

@section('content')
<div class="space-y-8">
    <!-- Unit Selector Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-border-main pb-4">
        @if(!auth()->user()->isAdminIkada())
        <a href="{{ route('admin.institutions.index', ['tab' => 'foundation']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'foundation' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
            🏛️ Yayasan
        </a>
        <a href="{{ route('admin.institutions.index', ['tab' => 'dayah']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'dayah' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
            🕌 Dayah Terpadu
        </a>
        <a href="{{ route('admin.institutions.index', ['tab' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'smp' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
            📚 SMP Ulumul Islam
        </a>
        <a href="{{ route('admin.institutions.index', ['tab' => 'sma']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'sma' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
            🎓 SMA Ulumul Islam
        </a>
        @endif
        <a href="{{ route('admin.institutions.index', ['tab' => 'ikada']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'ikada' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
            🤝 IKADA UI (Ikatan Alumni)
        </a>
    </div>

    @if($current)
    <!-- Edit Form Card -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs p-6 sm:p-10 space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">UNIT: {{ strtoupper($current->type) }}</span>
                <h2 class="text-xl font-black text-slate-900">{{ $current->name }}</h2>
            </div>
            <div>
                @php
                    $pubRoute = match($current->type) {
                        'foundation' => route('tentang-kami'),
                        'smp' => route('smp'),
                        'sma' => route('sma'),
                        'dayah' => route('dayah'),
                        'ikada' => route('ikada'),
                        default => route('home')
                    };
                @endphp
                <a href="{{ $pubRoute }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-primary-900 bg-primary-50 hover:bg-primary-100 transition-colors border border-primary-200 inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Halaman Publik
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.institutions.update', $current->id) }}" enctype="multipart/form-data" class="space-y-8 text-xs font-medium">
            @csrf
            @method('PUT')

            <!-- Media Section: Logo & Banner Sampul -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-6">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Media Visual Lembaga (Logo & Banner Sampul)
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Upload Logo -->
                    <div class="space-y-3">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider">Logo Lembaga (Solid Background Preview)</label>
                        <div class="flex items-center gap-4">
                            <div class="h-20 w-20 rounded-2xl bg-white p-2 border-2 border-dashed border-slate-300 shadow-xs flex items-center justify-center shrink-0 overflow-hidden">
                                <img id="logo-preview-img" src="{{ $current->logo_url }}" alt="Logo {{ $current->name }}" class="h-full w-full object-contain">
                            </div>
                            <div class="flex-1 space-y-1.5">
                                <input type="file" name="logo" id="logo-input" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="cropper-auto block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-900 file:text-white hover:file:bg-primary-950 cursor-pointer" data-aspect-ratio="1:1" data-preview="#logo-preview-img">
                                <p class="text-[10px] text-slate-500">Format: PNG, JPG, WEBP, SVG (Maks. 5MB). Otomatis crop 1:1 saat dipilih.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Banner Sampul / Hero Image -->
                    <div class="space-y-3">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider">Banner Sampul / Hero Section</label>
                        <div class="space-y-2">
                            <div class="h-24 w-full rounded-2xl bg-slate-200 border-2 border-dashed border-slate-300 overflow-hidden relative flex items-center justify-center">
                                @if($current->banner_path)
                                    <img id="banner-preview-img" src="{{ $current->banner_url }}" alt="Banner {{ $current->name }}" class="h-full w-full object-cover">
                                @else
                                    <div id="banner-preview-placeholder" class="text-slate-400 text-xs font-semibold flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Belum ada banner khusus (menggunakan gaya default)
                                    </div>
                                    <img id="banner-preview-img" src="" alt="Banner Preview" class="h-full w-full object-cover hidden">
                                @endif
                            </div>
                            <input type="file" name="banner" id="banner-input" accept="image/png,image/jpeg,image/webp" class="cropper-auto block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-900 file:text-white hover:file:bg-primary-950 cursor-pointer" data-aspect-ratio="16/7" data-preview="#banner-preview-img">
                            <p class="text-[10px] text-slate-500">Format: JPG, PNG, WEBP (Maks. 10MB). Otomatis crop 16:7 saat dipilih.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identitas Lembaga -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Resmi Lembaga</label>
                    <input type="text" name="name" value="{{ old('name', $current->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat / Slogan / Tagline</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $current->short_description) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Slogan atau ringkasan profil...">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap & Sejarah Lembaga</label>
                <textarea name="description" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 leading-relaxed" placeholder="Tuliskan latar belakang, profil, dan sejarah lembaga...">{{ old('description', $current->description) }}</textarea>
            </div>

            <!-- Visi & Misi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Visi Lembaga</label>
                    <textarea name="vision" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 leading-relaxed" placeholder="Visi lembaga...">{{ old('vision', $current->vision) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Misi Lembaga (Tuliskan satu baris per poin)</label>
                    @php
                        $missionText = is_array($current->mission) ? implode("\n", $current->mission) : $current->mission;
                    @endphp
                    <textarea name="mission" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 leading-relaxed" placeholder="Menyelenggarakan pendidikan berkualitas...&#10;Membina generasi berakhlak mulia...&#10;Mengembangkan wawasan global...">{{ old('mission', $missionText) }}</textarea>
                </div>
            </div>

            <!-- Kontak & Alamat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon Kantor</label>
                    <input type="text" name="phone" value="{{ old('phone', $current->phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="0811xxxx">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Resmi (Format: 628xxx)</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $current->whatsapp) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="62811xxxx">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap Unit</label>
                <input type="text" name="address" value="{{ old('address', $current->address) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Jl. Ulumul Islam No. 1, Aceh">
            </div>

            @if($current->type === 'ikada')
            <!-- Pengaturan Statistik Khusus IKADA UI -->
            <div class="p-6 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-4">
                <div class="border-b border-emerald-200/60 pb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800">RINGKASAN METRIK IKADA</span>
                    <h4 class="text-sm font-black text-emerald-950">Statistik Angka IKADA UI (Halaman Depan IKADA)</h4>
                    <p class="text-[11px] text-emerald-700">Kelola 3 angka metrik utama yang tampil pada widget beranda IKADA UI.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Total Alumni Terdata</label>
                        <input type="number" name="total_alumni" value="{{ old('total_alumni', $ikadaStats['total_alumni'] ?? 1250) }}" min="0" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-700 font-black text-sm">
                        <span class="text-[10px] text-slate-500">Lintas angkatan sejak berdiri</span>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Total Angkatan Alumni</label>
                        <input type="number" name="total_angkatan" value="{{ old('total_angkatan', $ikadaStats['total_angkatan'] ?? 15) }}" min="0" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-700 font-black text-sm">
                        <span class="text-[10px] text-slate-500">Jejaring aktif di Indonesia</span>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Total Kampus PTN & LN</label>
                        <input type="number" name="total_ptn" value="{{ old('total_ptn', $ikadaStats['total_ptn'] ?? 85) }}" min="0" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-700 font-black text-sm">
                        <span class="text-[10px] text-slate-500">Al-Azhar, Timur Tengah, PTN</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-8 py-3.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan Lembaga & Media
                </button>
            </div>
        </form>
    </div>

    <!-- Section Struktur Kepengurusan Unit / IKADA -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs p-6 sm:p-10 space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">KEPENGURUSAN {{ strtoupper($current->name) }}</span>
                <h2 class="text-xl font-black text-slate-900">Struktur Organisasi & Divisi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola pimpinan, wakil, dan divisi/bidang kustom beserta tugas anggota</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="openAddPosModal('division')" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Tambah Divisi
                </button>
                <button onclick="openAddPosModal('leader')" class="px-4 py-2 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Tambah Posisi
                </button>
            </div>
        </div>

        <!-- 1. Pimpinan Utama -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-black text-slate-900">👑 Pimpinan Utama</span>
                    <span class="text-[10px] text-accent-gold font-bold uppercase">Kepala / Ketua / Mudir</span>
                </div>
            </div>

            @if($leaders && $leaders->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($leaders as $leadPos)
                <div class="bg-slate-50/70 rounded-2xl p-5 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-primary-100 text-primary-950 font-black text-[10px] uppercase tracking-wider border border-primary-300">
                                {{ $leadPos->position_name }}
                            </span>
                            @if($leadPos->is_pinned)
                            <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-900 font-bold text-[10px]">
                                ⭐ Pinned
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1">
                            <form method="POST" action="{{ route('admin.structure.positions.toggle_pin', $leadPos->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="p-1 rounded text-slate-400 hover:text-amber-500" title="{{ $leadPos->is_pinned ? 'Lepas Pin' : 'Sematkan' }}">
                                    <svg class="w-4 h-4 {{ $leadPos->is_pinned ? 'text-amber-500 fill-amber-500' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                </button>
                            </form>
                            <button onclick="openEditPosModal({{ json_encode($leadPos) }})" class="p-1 rounded text-slate-500 hover:text-primary-900" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.structure.positions.destroy', $leadPos->id) }}" class="inline" onsubmit="return confirm('Hapus posisi {{ $leadPos->position_name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded text-red-500 hover:text-red-700" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    @forelse($leadPos->members as $member)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-white border border-slate-200 gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($member->photo_path)
                            <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-11 h-11 rounded-xl object-cover border border-primary-900 shrink-0">
                            @else
                            <div class="w-11 h-11 rounded-xl bg-primary-900 text-white font-bold flex items-center justify-center text-xs shrink-0">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-bold text-xs text-slate-900 truncate">{{ $member->name }}</h4>
                                <p class="text-[11px] text-primary-900 font-semibold">{{ $member->title ?: $leadPos->position_name }}</p>
                                <p class="text-[10px] text-slate-400">Periode: {{ $member->period }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="openEditMemberModal({{ json_encode($member) }})" class="p-1 text-slate-500 hover:text-slate-900">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.structure.members.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Hapus pengurus {{ $member->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-500 hover:text-red-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3 bg-white rounded-xl border border-dashed border-slate-200">
                        <button onclick="openAddMemberModal({{ $leadPos->id }}, '{{ addslashes($leadPos->position_name) }}', 'leader')" class="px-3 py-1 rounded-lg bg-primary-900 text-white font-bold text-[10px] uppercase">
                            + Masukkan Pejabat Pimpinan
                        </button>
                    </div>
                    @endforelse
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500">Belum ada posisi Pimpinan Utama.</p>
                <button onclick="openAddPosModal('leader')" class="mt-2 px-3 py-1.5 rounded-xl bg-primary-900 text-white font-bold text-xs uppercase">
                    + Tambah Pimpinan Utama
                </button>
            </div>
            @endif
        </div>

        <!-- 2. Jajaran Wakil -->
        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-black text-slate-900">🛡️ Jajaran Wakil Pimpinan</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase">Wakil Ketua / Sekretaris / Bendahara</span>
                </div>
                <button onclick="openAddPosModal('vice')" class="text-xs font-bold text-primary-900 hover:underline">
                    + Tambah Wakil
                </button>
            </div>

            @if($vices && $vices->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($vices as $vicePos)
                <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-xs text-slate-800">{{ $vicePos->position_name }}</span>
                        <div class="flex items-center gap-1">
                            <button onclick="openAddMemberModal({{ $vicePos->id }}, '{{ addslashes($vicePos->position_name) }}', 'vice')" class="p-1 text-slate-500 hover:text-emerald-700" title="Tambah Pejabat">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                            <button onclick="openEditPosModal({{ json_encode($vicePos) }})" class="p-1 text-slate-500 hover:text-primary-900" title="Edit Posisi">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.structure.positions.destroy', $vicePos->id) }}" class="inline" onsubmit="return confirm('Hapus posisi {{ $vicePos->position_name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-500 hover:text-red-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    @forelse($vicePos->members as $member)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-white border border-slate-200 gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            @if($member->photo_path)
                            <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-9 h-9 rounded-lg object-cover border border-primary-900 shrink-0">
                            @else
                            <div class="w-9 h-9 rounded-lg bg-slate-800 text-white font-bold flex items-center justify-center text-[10px] shrink-0">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-bold text-xs text-slate-900 truncate">{{ $member->name }}</h4>
                                <p class="text-[10px] text-slate-500">{{ $member->period }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button onclick="openEditMemberModal({{ json_encode($member) }})" class="p-1 text-slate-500 hover:text-slate-900">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.structure.members.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Hapus {{ $member->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-500 hover:text-red-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-[11px] text-slate-400 italic">Belum ada pengurus di jabatan ini.</p>
                    @endforelse
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500">Belum ada jajaran wakil.</p>
            </div>
            @endif
        </div>

        <!-- 3. Divisi / Bidang Kustom -->
        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-black text-slate-900">📂 Divisi, Bidang & Seksi Kustom</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase">Kepala Divisi & Staf (Tupoksi)</span>
                </div>
                <button onclick="openAddPosModal('division')" class="text-xs font-bold text-emerald-800 hover:underline">
                    + Tambah Divisi Baru
                </button>
            </div>

            @if($divisions && $divisions->count() > 0)
            <div class="space-y-4">
                @foreach($divisions as $div)
                <div class="bg-white rounded-2xl border border-border-main shadow-2xs overflow-hidden">
                    <div class="p-4 bg-slate-50 border-b border-border-main flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs">
                                #{{ $div->sort_order }}
                            </span>
                            <div>
                                <h4 class="font-black text-xs sm:text-sm text-slate-900">{{ $div->position_name }}</h4>
                                <p class="text-[10px] text-slate-500">{{ $div->members->count() }} Anggota Pengurus</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <button onclick="openAddMemberModal({{ $div->id }}, '{{ addslashes($div->position_name) }}', 'division')" class="px-3 py-1 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-[10px] uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                + Staf/Anggota
                            </button>
                            <button onclick="openEditPosModal({{ json_encode($div) }})" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.structure.positions.destroy', $div->id) }}" class="inline" onsubmit="return confirm('Hapus divisi {{ $div->position_name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5">
                        @if($div->members->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($div->members as $member)
                            <div class="p-3.5 rounded-xl border {{ $member->member_role === 'head' ? 'border-emerald-300 bg-emerald-50/30' : 'border-slate-200 bg-white' }} space-y-2">
                                <div class="flex items-start gap-2.5">
                                    @if($member->photo_path)
                                    <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-lg object-cover border border-primary-900 shrink-0">
                                    @else
                                    <div class="w-10 h-10 rounded-lg {{ $member->member_role === 'head' ? 'bg-emerald-800 text-white' : 'bg-primary-100 text-primary-900' }} font-bold flex items-center justify-center text-[11px] shrink-0">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1 flex-wrap">
                                            <h4 class="font-bold text-xs text-slate-900 truncate">{{ $member->name }}</h4>
                                            @if($member->member_role === 'head')
                                            <span class="px-1.5 py-0.5 rounded bg-emerald-600 text-white font-extrabold text-[8px] uppercase">
                                                Kepala
                                            </span>
                                            @endif
                                        </div>
                                        @if($member->title)
                                        <p class="text-[10px] font-semibold text-primary-900">{{ $member->title }}</p>
                                        @endif
                                        @if($member->sub_role)
                                        <div class="mt-1 p-1.5 rounded-lg bg-slate-100 border border-slate-200 text-[10px] text-slate-700 leading-snug">
                                            <span class="font-bold text-[9px] text-slate-500 uppercase block">Bagian:</span>
                                            {{ $member->sub_role }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                                    <span>Periode: {{ $member->period }}</span>
                                    <div class="flex items-center gap-1">
                                        <button onclick="openEditMemberModal({{ json_encode($member) }})" class="p-1 text-slate-600 hover:text-slate-900">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.structure.members.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Hapus {{ $member->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-red-500 hover:text-red-700">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-xs text-slate-400 italic text-center py-2">Belum ada pengurus di divisi ini.</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500">Belum ada divisi atau bidang kustom.</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Modals for Structure Management -->
<!-- Modal Tambah Posisi / Divisi -->
<div id="add-pos-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 id="add-pos-modal-title" class="font-black text-sm uppercase tracking-wider text-slate-900">Tambah Posisi / Divisi</h3>
        <form method="POST" action="{{ route('admin.structure.positions.store') }}" class="space-y-4 text-xs font-medium">
            @csrf
            <input type="hidden" name="institution_id" value="{{ $current->id }}">
            
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori Struktur</label>
                <select id="add-pos-category" name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                    <option value="leader">👑 Pimpinan Utama (Ketua / Mudir / Kepala)</option>
                    <option value="vice">🛡️ Jajaran Wakil Pimpinan</option>
                    <option value="division">📂 Divisi / Bidang / Seksi Kustom</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Jabatan / Nama Divisi</label>
                <input type="text" name="position_name" required placeholder="Contoh: Ketua Umum / Divisi Humas" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Urut Tampil</label>
                    <input type="number" name="sort_order" value="1" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" class="rounded text-primary-900">
                        Pin Utama (⭐)
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-pos-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Posisi / Divisi -->
<div id="edit-pos-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Posisi / Divisi</h3>
        <form id="edit-pos-form" method="POST" action="" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori Struktur</label>
                <select id="edit-pos-category" name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                    <option value="leader">👑 Pimpinan Utama</option>
                    <option value="vice">🛡️ Jajaran Wakil Pimpinan</option>
                    <option value="division">📂 Divisi / Bidang / Seksi Kustom</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Jabatan / Nama Divisi</label>
                <input type="text" id="edit-pos-name" name="position_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Urut</label>
                    <input type="number" id="edit-pos-order" name="sort_order" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" id="edit-pos-pinned" name="is_pinned" value="1" class="rounded text-primary-900">
                        Pin Utama (⭐)
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-pos-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Anggota Pengurus / Staf -->
<div id="add-member-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Tambah Anggota Pengurus / Staf</h3>
        <p id="add-member-subtitle" class="text-xs text-slate-500 font-medium"></p>
        <form method="POST" action="{{ route('admin.structure.members.store') }}" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            <input type="hidden" id="add-member-pos-id" name="position_id" value="">
            
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap & Gelar</label>
                <input type="text" name="name" required placeholder="Contoh: Tgk. Ahmad Fauzi, S.Pd" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Peran dalam Jabatan/Divisi</label>
                    <select id="add-member-role" name="member_role" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="head">⭐ Kepala / Koordinator Divisi</option>
                        <option value="member" selected>👤 Anggota / Staf</option>
                        <option value="leader">👑 Pimpinan Utama</option>
                        <option value="vice">🛡️ Wakil Pimpinan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Sebutan Jabatan (Opsional)</label>
                    <input type="text" name="title" placeholder="Contoh: Koordinator Hubungan Alumni" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Penjelasan Bagian yang Dipegang / Tugas</label>
                <textarea name="sub_role" rows="2" placeholder="Contoh: Penanggung Jawab Wilayah Barat & Database Alumni" class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Periode Jabatan</label>
                    <input type="text" name="period" required value="{{ date('Y') }} - Sekarang" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" value="0" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Foto Formal (Opsional)</label>
                <input type="file" name="photo" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="1:1">
                <span class="text-[9px] text-slate-400">Rasio 1:1 • Didukung Pemotong Gambar</span>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-member-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-700 text-white font-bold">Simpan Pengurus</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Anggota Pengurus -->
<div id="edit-member-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Data Pengurus / Staf</h3>
        <form id="edit-member-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap & Gelar</label>
                <input type="text" id="edit-member-name" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Peran dalam Posisi/Divisi</label>
                    <select id="edit-member-role" name="member_role" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="head">⭐ Kepala / Koordinator Divisi</option>
                        <option value="member">👤 Anggota / Staf</option>
                        <option value="leader">👑 Pimpinan Utama</option>
                        <option value="vice">🛡️ Wakil Pimpinan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Sebutan Jabatan</label>
                    <input type="text" id="edit-member-title" name="title" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Penjelasan Bagian yang Dipegang / Tugas</label>
                <textarea id="edit-member-sub-role" name="sub_role" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Periode Jabatan</label>
                    <input type="text" id="edit-member-period" name="period" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan</label>
                    <input type="number" id="edit-member-order" name="sort_order" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Ganti Foto Formal (Opsional)</label>
                <input type="file" name="photo" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="1:1">
                <span class="text-[9px] text-slate-400">Rasio 1:1 • Didukung Pemotong Gambar</span>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-member-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Live Image Previews
    const logoInput = document.getElementById('logo-input');
    const logoPreview = document.getElementById('logo-preview-img');
    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    logoPreview.src = evt.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    const bannerInput = document.getElementById('banner-input');
    const bannerPreview = document.getElementById('banner-preview-img');
    const bannerPlaceholder = document.getElementById('banner-preview-placeholder');
    if (bannerInput && bannerPreview) {
        bannerInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    bannerPreview.src = evt.target.result;
                    bannerPreview.classList.remove('hidden');
                    if (bannerPlaceholder) {
                        bannerPlaceholder.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Modal Helpers
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    function openAddPosModal(category = 'leader') {
        document.getElementById('add-pos-category').value = category;
        const titleEl = document.getElementById('add-pos-modal-title');
        if (category === 'division') {
            titleEl.textContent = 'Tambah Divisi / Bidang Baru';
        } else if (category === 'vice') {
            titleEl.textContent = 'Tambah Jabatan Wakil Pimpinan';
        } else {
            titleEl.textContent = 'Tambah Posisi Pimpinan Utama';
        }
        openModal('add-pos-modal');
    }

    function openEditPosModal(pos) {
        document.getElementById('edit-pos-form').action = `/admin/struktur/posisi/${pos.id}`;
        document.getElementById('edit-pos-name').value = pos.position_name;
        document.getElementById('edit-pos-category').value = pos.category || 'division';
        document.getElementById('edit-pos-order').value = pos.sort_order || 1;
        document.getElementById('edit-pos-pinned').checked = !!pos.is_pinned;
        openModal('edit-pos-modal');
    }

    function openAddMemberModal(posId, posName, roleContext = 'member') {
        document.getElementById('add-member-pos-id').value = posId;
        document.getElementById('add-member-subtitle').textContent = `Posisi / Divisi: ${posName}`;
        const roleEl = document.getElementById('add-member-role');
        if (roleContext === 'leader') roleEl.value = 'leader';
        else if (roleContext === 'vice') roleEl.value = 'vice';
        else if (roleContext === 'division') roleEl.value = 'member';
        openModal('add-member-modal');
    }

    function openEditMemberModal(member) {
        document.getElementById('edit-member-form').action = `/admin/struktur/anggota/${member.id}`;
        document.getElementById('edit-member-name').value = member.name;
        document.getElementById('edit-member-role').value = member.member_role || 'member';
        document.getElementById('edit-member-title').value = member.title || '';
        document.getElementById('edit-member-sub-role').value = member.sub_role || '';
        document.getElementById('edit-member-period').value = member.period || '';
        document.getElementById('edit-member-order').value = member.sort_order || 0;
        openModal('edit-member-modal');
    }
</script>
@endpush
@endsection
