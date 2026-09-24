@extends('layouts.app')

@section('title', 'Tentang Yayasan')
@section('description', 'Profil Lengkap Yayasan Dayah Terpadu Ulumul Islam - Sejarah, Visi Misi, Struktur Pengurus, Berita, dan Galeri.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-b from-primary-950 via-primary-900 to-primary-950 text-white py-16 lg:py-24 overflow-hidden">
    @if($foundation->banner_url)
    <div class="absolute inset-0 z-0">
        <img src="{{ $foundation->banner_url }}" alt="Banner {{ $foundation->name }}" class="w-full h-full object-cover opacity-75">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/70 to-primary-950/30"></div>
    </div>
    @endif

    <!-- Ambient Islamic Glow -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-accent-gold/20 via-transparent to-transparent pointer-events-none"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-gold/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-5 scroll-reveal">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-accent-gold animate-ping"></span>
                    <span class="text-xs font-black uppercase tracking-wider text-accent-gold">Lembaga Induk Yayasan</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $foundation->name }}
                </h1>

                <p class="text-sm sm:text-base text-primary-100/90 leading-relaxed font-medium max-w-2xl">
                    {{ $foundation->short_description ?? 'Mendedikasikan Diri untuk Melahirkan Generasi Rabbani yang Menguasai Ilmu Agama dan Pengetahuan Umum.' }}
                </p>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a href="{{ $settings['wa_link'] }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 rounded-2xl bg-accent-gold hover:bg-accent-gold-hover text-primary-950 font-black text-xs uppercase tracking-wider shadow-lg transition-all inline-flex items-center gap-2">
                        Hubungi Sekretariat
                    </a>
                    <a href="{{ route('structure.public', ['unit' => 'foundation']) }}" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-black text-xs uppercase tracking-wider border border-white/20 backdrop-blur-md transition-all">
                        Struktur Organisasi
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 scroll-reveal">
                <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/20 shadow-2xl space-y-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $foundation->logo_url }}" alt="Logo {{ $foundation->name }}" class="h-16 w-16 object-contain bg-white rounded-2xl p-2 shadow-inner">
                        <div>
                            <h3 class="text-lg font-black text-white leading-snug">{{ $foundation->name }}</h3>
                            <span class="text-xs font-bold text-accent-gold uppercase tracking-wider">Pendidikan Islam Terpadu</span>
                        </div>
                    </div>
                    <p class="text-xs text-primary-100/80 leading-relaxed">
                        Menyelenggarakan pendidikan komprehensif memadukan tradisi keilmuan Dayah Pesantren dengan kurikulum formal nasional SMP & SMA.
                    </p>
                    <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs text-primary-200">
                        <span>📍 Lhokseumawe, Aceh</span>
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
            <div class="lg:col-span-6 space-y-4 scroll-reveal">
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Sejarah & Landasan</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Membangun Peradaban Melalui Pendidikan Islam</h2>
                <p class="text-xs sm:text-sm text-text-sub font-medium leading-relaxed whitespace-pre-line">
                    {{ $foundation->description ?? 'Yayasan Ulumul Islam didirikan dengan tekad mulia untuk menyediakan wadah pembinaan generasi muda Islam yang komprehensif, mengintegrasikan sistem pendidikan formal dengan nilai-nilai luhur kepesantrenan.' }}
                </p>
            </div>

            <div class="lg:col-span-6 space-y-6 scroll-reveal">
                <div class="bg-primary-50 p-6 rounded-3xl border border-primary-100 space-y-3">
                    <span class="text-xs font-black uppercase tracking-wider text-primary-800">VISI YAYASAN</span>
                    <p class="text-xs sm:text-sm text-primary-950 font-medium leading-relaxed">
                        {{ $foundation->vision ?? 'Terwujudnya lembaga pendidikan Islam terpadu yang unggul dalam mencetak insan beriman, berilmu, dan berakhlak mulia.' }}
                    </p>
                </div>

                <div class="bg-amber-50 p-6 rounded-3xl border border-amber-100 space-y-3">
                    <span class="text-xs font-black uppercase tracking-wider text-amber-800">MISI YAYASAN</span>
                    <div class="text-xs sm:text-sm text-amber-950 font-medium leading-relaxed">
                        @if(!empty($foundation->mission_list))
                            <ul class="space-y-1 list-disc list-inside">
                                @foreach($foundation->mission_list as $m)
                                    <li>{{ $m }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $foundation->mission_text ?? "1. Menyelenggarakan pendidikan formal berkualitas.\n2. Mengembangkan kepesantrenan.\n3. Membina kemandirian santri." }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Struktur Pengurus Inti & Tombol Struktur Lengkap -->
<section class="py-16 bg-bg-warm border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 scroll-reveal">
            <div>
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Amanah & Kepemimpinan</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Pimpinan Utama Yayasan</h2>
                <p class="text-xs text-text-sub font-medium mt-1">Jajaran kepengurusan inti penggerak Yayasan Ulumul Islam.</p>
            </div>
            <a href="{{ route('structure.public', ['unit' => 'foundation']) }}" class="px-5 py-2.5 rounded-2xl bg-white hover:bg-primary-900 text-primary-900 hover:text-white border border-primary-900/20 font-extrabold text-xs uppercase tracking-wider shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
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
                        <div class="w-24 h-24 rounded-full mx-auto overflow-hidden bg-primary-950/10 ring-4 ring-primary-100 shadow-xs">
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
            <p class="text-xs text-slate-500">Susunan pengurus inti yayasan sedang dalam proses pembaruan.</p>
        </div>
        @endif
    </div>
</section>



<!-- 4. 5 Berita Terbaru Yayasan (Kotak Persegi Panjang Vertikal) -->
<section class="py-16 bg-bg-warm border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 scroll-reveal">
            <div>
                <span class="text-xs font-black uppercase tracking-widest text-accent-gold">Warta & Kabar Terkini</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Berita & Informasi Yayasan</h2>
                <p class="text-xs text-text-sub font-medium mt-1">Publikasi warta dan kegiatan resmi Yayasan Ulumul Islam.</p>
            </div>
            <a href="{{ route('news.index', ['unit' => 'foundation']) }}" class="px-5 py-2.5 rounded-2xl bg-white hover:bg-primary-900 text-primary-900 hover:text-white border border-primary-900/20 font-extrabold text-xs uppercase tracking-wider shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
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
                            Warta Yayasan
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
                        <h3 class="text-base font-black text-slate-900 leading-snug line-clamp-2 group-hover:text-primary-800 transition-colors">
                            <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                        </h3>
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
            <p class="font-bold text-slate-700 text-sm">Belum Ada Berita Yayasan</p>
            <p class="text-xs text-slate-500">Saat ini belum ada warta atau berita yang dipublikasikan pada kategori Yayasan.</p>
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
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950">Galeri Foto Yayasan</h2>
                <p class="text-xs text-text-sub font-medium mt-1">Dokumentasi sarana prasarana dan aktivitas lingkungan pesantren.</p>
            </div>
            <a href="{{ route('gallery.index', ['unit' => 'foundation']) }}" class="px-5 py-2.5 rounded-2xl bg-bg-warm hover:bg-primary-900 text-primary-900 hover:text-white border border-primary-900/20 font-extrabold text-xs uppercase tracking-wider shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
                <span>Buka Galeri Foto &rarr;</span>
            </a>
        </div>

        @if(isset($galleryPhotos) && $galleryPhotos->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 scroll-reveal">
            @foreach($galleryPhotos as $photo)
            <div class="group relative rounded-2xl overflow-hidden aspect-square bg-slate-100 border border-slate-200 shadow-xs hover:shadow-xl transition-all">
                <img src="{{ $photo->file_path }}" alt="{{ $photo->title ?: 'Dokumentasi Yayasan' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-3 flex flex-col justify-end">
                    <p class="text-[11px] font-bold text-white leading-tight line-clamp-2">{{ $photo->title ?: ($photo->album->title ?? 'Galeri Ulumul Islam') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-bg-warm rounded-3xl border border-dashed border-slate-300 p-8 space-y-2">
            <p class="font-bold text-slate-700 text-sm">Belum Ada Foto Dokumentasi Yayasan</p>
            <p class="text-xs text-slate-500">Dokumentasi foto kegiatan Yayasan akan ditampilkan di sini.</p>
        </div>
        @endif
    </div>
</section>
@endsection
