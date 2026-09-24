@extends('layouts.app')

@section('title', $institution->name ?? 'SMP Ulumul Islam')
@section('description', 'Profil Lengkap Sekolah Menengah Pertama (SMP) Terpadu Ulumul Islam.')

@section('content')
<!-- Header Banner Unit -->
<section class="relative bg-gradient-to-b from-primary-950 via-primary-900 to-primary-950 text-white py-16 lg:py-24 overflow-hidden">
    @if($institution->banner_url)
    <div class="absolute inset-0 z-0">
        <img src="{{ $institution->banner_url }}" alt="Banner {{ $institution->name }}" class="w-full h-full object-cover opacity-75">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/70 to-primary-950/30"></div>
    </div>
    @endif

    <!-- Ambient Islamic Glow -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-blue-500/20 via-transparent to-transparent pointer-events-none"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-gold/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-5 scroll-reveal">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-accent-gold animate-ping"></span>
                    <span class="text-xs font-black uppercase tracking-wider text-accent-gold">Jenjang Sekolah Menengah Pertama</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $institution->name }}
                </h1>

                <p class="text-sm sm:text-base text-primary-100/90 leading-relaxed font-medium max-w-2xl">
                    {{ $institution->short_description ?? 'Membina Generasi Unggul, Mandiri, dan Berakhlakul Karimah Berlandaskan Al-Quran dan Sunnah.' }}
                </p>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a href="{{ route('admission') }}" class="px-6 py-3.5 rounded-2xl bg-accent-gold hover:bg-accent-gold-hover text-primary-950 font-black text-xs uppercase tracking-wider shadow-lg transition-all inline-flex items-center gap-2">
                        Pendaftaran SMP
                    </a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs uppercase tracking-wider transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4 fill-current text-emerald-400" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        Hubungi SMP via WA
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 scroll-reveal">
                <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/20 shadow-2xl space-y-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $institution->logo_url }}" alt="Logo {{ $institution->name }}" class="h-16 w-16 object-contain bg-white rounded-2xl p-2 shadow-inner">
                        <div>
                            <h3 class="text-lg font-black text-white leading-snug">{{ $institution->name }}</h3>
                            <span class="text-xs font-bold text-accent-gold uppercase tracking-wider">Pendidikan Formal Terpadu</span>
                        </div>
                    </div>
                    <p class="text-xs text-primary-100/80 leading-relaxed">
                        Memadukan kurikulum nasional Kemendikbudristek dengan pendalaman materi keagamaan Islam, tahfidz Al-Quran, sains, serta teknologi digital.
                    </p>
                    <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs text-primary-200">
                        <span>📚 NPSN Resmi Terdaftar</span>
                        <span class="text-accent-gold font-bold">Terakreditasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 1. Deskripsi, Visi, Misi -->
<section class="py-16 bg-white border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-5 space-y-4 scroll-reveal">
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Tentang SMP</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Pendidikan Terpadu Jenjang Menengah Pertama</h2>
                <p class="text-xs sm:text-sm text-text-sub font-medium leading-relaxed whitespace-pre-line">
                    {{ $institution->description ?? 'SMP Ulumul Islam menyelenggarakan pendidikan menengah yang memadukan kurikulum nasional dari Kementerian Pendidikan dengan nilai-nilai kepesantrenan yang kokoh.' }}
                </p>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6 scroll-reveal">
                <div class="bg-primary-50 p-6 rounded-3xl border border-primary-100 shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-xs">
                        VISI
                    </div>
                    <h3 class="text-base font-black text-slate-900">Visi Lembaga</h3>
                    <p class="text-xs text-text-sub font-medium leading-relaxed">
                        {{ $institution->vision ?? 'Terwujudnya generasi Islam yang berilmu amaliyah, beramal ilmiah, dan berakhlakul karimah.' }}
                    </p>
                </div>

                <div class="bg-amber-50 p-6 rounded-3xl border border-amber-100 shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-black text-xs">
                        MISI
                    </div>
                    <h3 class="text-base font-black text-slate-900">Misi Lembaga</h3>
                    <div class="text-xs text-text-sub font-medium leading-relaxed">
                        @if(!empty($institution->mission_list))
                            <ul class="space-y-1 list-disc list-inside">
                                @foreach($institution->mission_list as $m)
                                    <li>{{ $m }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $institution->mission_text ?? "1. Menyelenggarakan pendidikan formal berkualitas.\n2. Menanamkan adab dan akhlak mulia.\n3. Mengembangkan potensi santri." }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Struktur Utama SMP & Tombol Bagan Lengkap -->
<section class="py-16 bg-bg-warm border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 scroll-reveal">
            <div>
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Kepemimpinan Sekolah</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Pimpinan Utama SMP</h2>
                <p class="text-xs text-text-sub font-medium mt-1">Kepala sekolah dan pimpinan kurikulum SMP Ulumul Islam.</p>
            </div>
            <a href="{{ route('structure.public', ['unit' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl bg-white hover:bg-primary-900 text-primary-900 hover:text-white border border-primary-900/20 font-extrabold text-xs uppercase tracking-wider shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
                <span>Bagan Struktur Keseluruhan</span>
                <span>&rarr;</span>
            </a>
        </div>

        @if(isset($topStructureMembers) && $topStructureMembers->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 scroll-reveal">
            @foreach($topStructureMembers as $item)
                @php
                    $member = $item['member'];
                    $pos = $item['position'];
                @endphp
                <div class="bg-white rounded-3xl p-6 border border-border-main text-center space-y-4 shadow-xs hover:shadow-lg transition-all flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-24 h-24 rounded-full mx-auto overflow-hidden bg-primary-900/10 ring-4 ring-primary-100 shadow-xs">
                            @if($member->photo_path)
                            <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-primary-100 text-primary-900 font-black text-xl">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </div>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-black text-sm text-slate-900 leading-snug">{{ $member->name }}</h4>
                            <p class="text-[11px] text-accent-gold font-bold uppercase tracking-wider">{{ $member->title ?: $pos->position_name }}</p>
                        </div>
                    </div>
                    @if($member->period)
                    <div class="pt-2 border-t border-slate-100">
                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-semibold">
                            Periode: {{ $member->period }}
                        </span>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-300 p-8 space-y-2">
            <p class="font-bold text-slate-700 text-sm">Belum Ada Data Struktur Kepengurusan</p>
            <p class="text-xs text-slate-500">Susunan pengurus dan pimpinan SMP sedang dalam proses pembaruan.</p>
        </div>
        @endif
    </div>
</section>

<!-- 3. List Alumni SMP Pilihan (Maks 13, 5 Tampil Utama, Selebihnya Digeser) -->
<section class="py-16 bg-white border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 scroll-reveal">
            <div class="space-y-1">
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Jejak Alumni SMP</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Sosok Alumni SMP Pilihan</h2>
                <p class="text-xs sm:text-sm text-text-sub font-medium">Klik profil alumni untuk melihat jenjang studi lanjutan dan prestasi para lulusan.</p>
            </div>
            @if(isset($alumni) && $alumni->count() > 5)
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" onclick="scrollAlumniTrack('smp-alumni-track', -1)" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-primary-900 hover:text-white text-slate-700 border border-slate-200 transition-colors shadow-xs flex items-center justify-center" title="Geser ke Kiri">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" onclick="scrollAlumniTrack('smp-alumni-track', 1)" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-primary-900 hover:text-white text-slate-700 border border-slate-200 transition-colors shadow-xs flex items-center justify-center" title="Geser ke Kanan">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
            @endif
        </div>

        @if(isset($alumni) && $alumni->count() > 0)
        <div id="smp-alumni-track" class="flex gap-4 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-accent-gold/40 snap-x scroll-smooth">
            @foreach($alumni as $alum)
            <div onclick="openAlumniDetailModal({{ json_encode($alum) }})" class="w-[85%] sm:w-[calc(50%-12px)] md:w-[calc(33.333%-14px)] lg:w-[calc(20%-13px)] shrink-0 bg-bg-warm rounded-3xl p-5 border border-border-main shadow-xs hover:shadow-xl hover:border-primary-900/40 transition-all text-center flex flex-col justify-between cursor-pointer group hover:-translate-y-1 snap-start">
                <div class="space-y-3">
                    <div class="relative w-20 h-20 mx-auto">
                        @if($alum->photo_path)
                        <img src="{{ $alum->photo_path }}" alt="{{ $alum->name }}" class="w-20 h-20 rounded-2xl object-cover mx-auto ring-2 ring-primary-800 shadow-xs">
                        @else
                        <div class="w-20 h-20 rounded-2xl mx-auto bg-primary-100 text-primary-900 flex items-center justify-center font-black text-lg border border-primary-200">
                            {{ strtoupper(substr($alum->name, 0, 2)) }}
                        </div>
                        @endif
                        <span class="absolute -bottom-2 -right-2 px-1.5 py-0.5 rounded-md bg-accent-gold text-primary-950 text-[9px] font-black uppercase shadow-xs">
                            SMP
                        </span>
                    </div>
                    <div>
                        <h4 class="font-black text-xs text-slate-900 group-hover:text-primary-900 transition-colors line-clamp-1">{{ $alum->name }}</h4>
                        <p class="text-[10px] text-primary-900 font-bold uppercase tracking-wider mt-0.5 line-clamp-1">{{ $alum->position_or_program ?? $alum->career_type ?? 'Alumni' }}</p>
                        @if($alum->institution_or_company)
                        <p class="text-[10px] text-slate-500 font-medium line-clamp-1 mt-0.5">{{ $alum->institution_or_company }}</p>
                        @endif
                    </div>
                </div>
                <div class="pt-3 mt-3 border-t border-slate-200 flex items-center justify-center gap-1 text-[11px] font-bold text-primary-900 group-hover:text-accent-gold transition-colors">
                    <span>Lihat Detail</span>
                    <span>&rarr;</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-bg-warm rounded-3xl border border-dashed border-slate-300 p-8 space-y-2">
            <p class="font-bold text-slate-700 text-sm">Belum Ada Profil Alumni SMP</p>
            <p class="text-xs text-slate-500">Data alumni SMP Ulumul Islam sedang dalam tahap kurasi dan penginputan.</p>
        </div>
        @endif
    </div>
</section>

<!-- 4. 5 Berita Terbaru SMP (Kotak Persegi Panjang Vertikal) -->
<section class="py-16 bg-bg-warm border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 scroll-reveal">
            <div>
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">WARTA & KABAR SMP</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Berita & Informasi SMP</h2>
                <p class="text-xs text-text-sub font-medium mt-1">Publikasi warta akademik, prestasi, dan kegiatan kesiswaan SMP.</p>
            </div>
            <a href="{{ route('news.index', ['unit' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl bg-white hover:bg-primary-900 text-primary-900 hover:text-white border border-primary-900/20 font-extrabold text-xs uppercase tracking-wider shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
                <span>Arsip Seluruh Berita</span>
                <span>&rarr;</span>
            </a>
        </div>

        @if(isset($latestNews) && $latestNews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 scroll-reveal">
            @foreach($latestNews as $item)
            <article class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1">
                <div>
                    <div class="aspect-video bg-slate-100 overflow-hidden relative">
                        @if($item->cover_image || $item->featured_image)
                        <img src="{{ $item->cover_image ?: $item->featured_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-primary-950/10 text-primary-900 font-bold text-xs">
                            Warta SMP
                        </div>
                        @endif
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-primary-950/85 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider shadow-xs">
                            {{ $item->institution_badge }}
                        </span>
                    </div>

                    <div class="p-6 space-y-3">
                        <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                            <span class="font-bold text-accent-gold uppercase">{{ $item->published_at ? $item->published_at->translatedFormat('d F Y') : $item->created_at->translatedFormat('d F Y') }}</span>
                            <span>•</span>
                            <span>{{ $item->author_name ?? 'Admin' }}</span>
                        </div>
                        <h2 class="text-base font-black text-slate-900 leading-snug line-clamp-2 group-hover:text-primary-800 transition-colors">
                            <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                        </h2>
                        <p class="text-xs text-text-sub font-medium line-clamp-3 leading-relaxed">
                            {{ $item->excerpt }}
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 flex items-center justify-between text-xs border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 font-medium">Warta Resmi</span>
                    <a href="{{ route('news.show', $item->slug) }}" class="font-extrabold text-primary-900 hover:text-accent-gold transition-colors inline-flex items-center gap-1">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-300 p-8 space-y-2">
            <p class="font-bold text-slate-700 text-sm">Belum Ada Berita SMP</p>
            <p class="text-xs text-slate-500">Saat ini belum ada artikel berita atau warta yang dipublikasikan pada kategori SMP.</p>
        </div>
        @endif
    </div>
</section>

<!-- 5. 5 Foto Galeri Dokumentasi Terbaru -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 scroll-reveal">
            <div>
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Dokumentasi Visual</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Galeri Foto SMP</h2>
                <p class="text-xs text-text-sub font-medium mt-1">Dokumentasi kegiatan belajar mengajar, lomba, dan aktivitas kesiswaan SMP.</p>
            </div>
            <a href="{{ route('gallery.index', ['unit' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl bg-bg-warm hover:bg-primary-900 text-primary-900 hover:text-white border border-primary-900/20 font-extrabold text-xs uppercase tracking-wider shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
                <span>Buka Galeri Foto &rarr;</span>
            </a>
        </div>

        @if(isset($galleryPhotos) && $galleryPhotos->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 scroll-reveal">
            @foreach($galleryPhotos as $photo)
            <div class="group relative rounded-2xl overflow-hidden aspect-square bg-slate-100 border border-slate-200 shadow-xs hover:shadow-xl transition-all">
                <img src="{{ $photo->file_path }}" alt="{{ $photo->title ?: 'Dokumentasi SMP' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-3 flex flex-col justify-end">
                    <p class="text-[11px] font-bold text-white leading-tight line-clamp-2">{{ $photo->title ?: ($photo->album->title ?? 'Galeri SMP') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-bg-warm rounded-3xl border border-dashed border-slate-300 p-8 space-y-2">
            <p class="font-bold text-slate-700 text-sm">Belum Ada Foto Dokumentasi SMP</p>
            <p class="text-xs text-slate-500">Dokumentasi foto kegiatan SMP akan ditampilkan di sini.</p>
        </div>
        @endif
    </div>
</section>
@endsection
