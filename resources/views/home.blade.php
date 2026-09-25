@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-primary-950 via-primary-900 to-primary-950 text-white overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-32">
    @if(!empty($settings['home_hero_image']))
    <div class="absolute inset-0 z-0">
        <img src="{{ $settings['home_hero_image'] }}" alt="Hero Ulumul Islam" class="w-full h-full object-cover opacity-75">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/70 to-primary-950/30"></div>
    </div>
    @endif

    <!-- Ambient Islamic Glow -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-accent-gold/15 via-transparent to-transparent pointer-events-none"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-gold/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left scroll-reveal">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-accent-gold animate-ping"></span>
                    <span class="text-xs font-black uppercase tracking-wider text-accent-gold">Pendidikan Islam Terpadu & Modern</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                    Mencetak Generasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-gold via-amber-200 to-accent-gold">Qurani & Berprestasi</span>
                </h1>

                <p class="text-sm sm:text-base text-primary-100/90 max-w-2xl mx-auto lg:mx-0 font-medium leading-relaxed">
                    {{ $foundation->description ?? 'Yayasan dan Dayah Terpadu Ulumul Islam memadukan pendidikan formal SMP & SMA berbasis kurikulum nasional dengan tradisi keilmuan Islam Dayah, Tahfidzul Quran, serta penguasaan bahasa internasional.' }}
                </p>

                <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('admission') }}" class="px-7 py-3.5 rounded-2xl bg-accent-gold hover:bg-accent-gold-hover text-primary-950 font-black text-xs uppercase tracking-wider shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        Daftar Santri Baru
                    </a>
                    <a href="{{ route('tentang-kami') }}" class="px-7 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-black text-xs uppercase tracking-wider border border-white/20 backdrop-blur-md transition-all">
                        Tentang Yayasan
                    </a>
                    <a href="{{ generate_whatsapp_link($settings['phone'] ?? '628111111111', $settings['wa_general'] ?? 'Assalamualaikum') }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3.5 rounded-2xl bg-emerald-600/30 hover:bg-emerald-600/50 text-emerald-200 border border-emerald-500/40 font-bold text-xs uppercase tracking-wider transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <!-- Right Hero Card / Visual Preview -->
            <div class="lg:col-span-5 scroll-reveal">
                <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/20 shadow-2xl space-y-6">
                    <div class="flex items-center gap-4">
                        <img src="/logo.png" alt="Logo" class="h-16 w-16 object-contain bg-white rounded-2xl p-2 shadow-inner">
                        <div>
                            <h3 class="text-lg font-black text-white leading-snug">Pondok Pesantren Terpadu</h3>
                            <span class="text-xs font-bold text-accent-gold uppercase tracking-wider">Ulumul Islam</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2 text-xs text-primary-100/90 font-medium">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>SMP Berbasis Pesantren & Tahfidz Quran</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>SMA IPA/IPS Berorientasi PTN & Timur Tengah</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>Kurikulum Dayah Salafiyah & Bahasa Asing</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-white/10 flex items-center justify-between text-xs font-semibold text-primary-200">
                        <span>Penerimaan Santri Baru Aktif</span>
                        <a href="{{ route('admission') }}" class="text-accent-gold font-bold hover:underline flex items-center gap-1">
                            Lihat Kuota &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mini Kontainer Pengumuman (Max 10 Items, Berjejer 5 & Bisa Digeser) -->
@if($announcements->count() > 0)
<section class="bg-gradient-to-r from-amber-500/10 via-primary-900/5 to-amber-500/10 border-y border-amber-500/20 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 mb-3">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-accent-gold animate-ping"></span>
                <span class="text-xs font-black uppercase tracking-wider text-accent-gold">Warta & Pengumuman Terbaru</span>
            </div>
            <span class="text-[11px] text-slate-500 font-medium hidden sm:inline">Geser & klik untuk rincian lengkap / flyer</span>
        </div>

        <!-- Horizontal Scrollable Container (5 cards per view on lg) -->
        <div class="flex gap-3.5 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-amber-300 snap-x">
            @foreach($announcements as $ann)
            <div onclick="openAnnouncementModal({
                    title: {{ json_encode($ann->title) }},
                    content: {{ json_encode($ann->content) }},
                    date: '{{ $ann->published_at ? $ann->published_at->translatedFormat('d F Y') : $ann->created_at->translatedFormat('d F Y') }}',
                    badge: '{{ strtoupper($ann->scope ?? 'UMUM') }}',
                    image: '{{ $ann->image_path ?: '' }}'
                })"
                class="min-w-[240px] sm:min-w-[250px] lg:min-w-[220px] xl:min-w-[235px] flex-shrink-0 bg-white rounded-2xl p-4 border border-border-main shadow-xs hover:shadow-md hover:border-accent-gold transition-all cursor-pointer group snap-start flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-primary-50 text-primary-900 border border-primary-100">
                            {{ strtoupper($ann->scope ?? 'UMUM') }}
                        </span>
                        <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap">
                            {{ $ann->published_at ? $ann->published_at->translatedFormat('d M') : $ann->created_at->translatedFormat('d M') }}
                        </span>
                    </div>
                    <h4 class="font-bold text-xs text-slate-900 group-hover:text-primary-900 transition-colors line-clamp-2 leading-snug">
                        {{ $ann->title }}
                    </h4>
                </div>
                <div class="pt-3 mt-2 border-t border-slate-100 flex items-center justify-between text-[10px] font-bold text-primary-900 group-hover:text-accent-gold transition-colors">
                    <span>Lihat Detail</span>
                    <span>&rarr;</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Aggregated Statistics Section -->
<section class="py-16 bg-white border-b border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Stat 1: Total Santri Aktif (SMP + SMA) -->
            <div class="p-6 rounded-3xl bg-primary-50/60 border border-primary-100 text-center space-y-1 scroll-reveal">
                <span class="text-3xl sm:text-4xl font-black text-primary-950">{{ number_format($stats['total_santri']) }}</span>
                <p class="text-xs font-extrabold uppercase tracking-wider text-primary-800">Santri Aktif</p>
                <p class="text-[11px] text-text-sub font-medium">SMP & SMA Terpadu</p>
            </div>

            <!-- Stat 2: Total Alumni Terlacak -->
            <div class="p-6 rounded-3xl bg-primary-50/60 border border-primary-100 text-center space-y-1 scroll-reveal">
                <span class="text-3xl sm:text-4xl font-black text-primary-950">{{ number_format($stats['total_alumni']) }}</span>
                <p class="text-xs font-extrabold uppercase tracking-wider text-primary-800">Alumni Tersebar</p>
                <p class="text-[11px] text-text-sub font-medium">Di Berbagai PTN & Karir</p>
            </div>

            <!-- Stat 3: Tenaga Pendidik / Asatidz -->
            <div class="p-6 rounded-3xl bg-primary-50/60 border border-primary-100 text-center space-y-1 scroll-reveal">
                <span class="text-3xl sm:text-4xl font-black text-primary-950">{{ number_format($stats['total_asatidz']) }}</span>
                <p class="text-xs font-extrabold uppercase tracking-wider text-primary-800">Asatidz & Pengajar</p>
                <p class="text-[11px] text-text-sub font-medium">Kompeten & Berdedikasi</p>
            </div>
        </div>
    </div>
</section>

<!-- Tiga Pilar Pendidikan Terpadu -->
<section class="py-20 bg-bg-warm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="text-center space-y-3 max-w-2xl mx-auto scroll-reveal">
            <span class="text-xs font-extrabold uppercase tracking-widest text-accent-gold">Pilar Pendidikan</span>
            <h2 class="text-2xl sm:text-4xl font-black text-primary-950 tracking-tight">Jenjang & Program Terpadu</h2>
            <p class="text-xs sm:text-sm text-text-sub font-medium">Sistem pendidikan holistik memadukan kurikulum formal kementerian dan kurikulum pondok pesantren modern.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Unit 1: SMP -->
            <div class="bg-white rounded-3xl p-8 border border-border-main shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between scroll-reveal group">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-white p-1.5 border border-border-main shadow-xs flex items-center justify-center shrink-0">
                        <img src="{{ $smp?->logo_url ?? asset('logo.png') }}" alt="{{ $smp?->name ?? 'SMP Ulumul Islam' }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-xl font-black text-slate-900">{{ $smp?->name ?? 'SMP Ulumul Islam' }}</h3>
                    <p class="text-xs text-text-sub leading-relaxed font-medium">
                        {{ Str::limit($smp->description ?? 'Membina dasar keilmuan umum dan kepribadian Islami yang kuat dengan hafalan Al-Quran dan pembiasaan adab harian.', 140) }}
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('smp') }}" class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-primary-900 group-hover:text-accent-gold transition-colors">
                        Profil Lengkap SMP &rarr;
                    </a>
                </div>
            </div>

            <!-- Unit 2: SMA -->
            <div class="bg-white rounded-3xl p-8 border border-border-main shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between scroll-reveal group">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-white p-1.5 border border-border-main shadow-xs flex items-center justify-center shrink-0">
                        <img src="{{ $sma?->logo_url ?? asset('logo.png') }}" alt="{{ $sma?->name ?? 'SMA Ulumul Islam' }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-xl font-black text-slate-900">{{ $sma?->name ?? 'SMA Ulumul Islam' }}</h3>
                    <p class="text-xs text-text-sub leading-relaxed font-medium">
                        {{ Str::limit($sma->description ?? 'Menyiapkan santri unggul dalam sains, sosial, dan agama dengan fokus kelulusan perguruan tinggi favorit serta universitas Timur Tengah.', 140) }}
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('sma') }}" class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-primary-900 group-hover:text-accent-gold transition-colors">
                        Profil Lengkap SMA &rarr;
                    </a>
                </div>
            </div>

            <!-- Unit 3: Dayah Terpadu -->
            <div class="bg-white rounded-3xl p-8 border border-border-main shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between scroll-reveal group">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-white p-1.5 border border-border-main shadow-xs flex items-center justify-center shrink-0">
                        <img src="{{ $dayah?->logo_url ?? asset('logo.png') }}" alt="{{ $dayah?->name ?? 'Dayah Terpadu' }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-xl font-black text-slate-900">{{ $dayah?->name ?? 'Dayah Terpadu' }}</h3>
                    <p class="text-xs text-text-sub leading-relaxed font-medium">
                        {{ Str::limit($dayah->description ?? 'Pusat pengkaderan ulama amilin dengan pendalaman kitab turots (kitab kuning), bahasa Arab-Inggris aktif, dan pembinaan 24 jam.', 140) }}
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('dayah') }}" class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-primary-900 group-hover:text-accent-gold transition-colors">
                        Profil Dayah Terpadu &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Warta & Berita Terbaru -->
<section class="py-20 bg-white border-t border-border-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 scroll-reveal">
            <div class="space-y-2">
                <span class="text-xs font-extrabold uppercase tracking-widest text-accent-gold">Warta Pesantren</span>
                <h2 class="text-2xl sm:text-3xl font-black text-primary-950 tracking-tight">Berita & Informasi Terkini</h2>
            </div>
            @if($news->count() > 0)
            <a href="{{ route('news.index') }}" class="text-xs font-extrabold uppercase tracking-wider text-primary-900 hover:text-accent-gold transition-colors inline-flex items-center gap-1.5">
                Lihat Semua Berita &rarr;
            </a>
            @endif
        </div>

        @if($news->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($news->take(3) as $item)
            <article class="bg-bg-warm rounded-3xl overflow-hidden border border-border-main shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col scroll-reveal">
                @if($item->featured_image)
                <div class="aspect-video w-full overflow-hidden bg-slate-100">
                    <img src="{{ $item->featured_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                @else
                <div class="aspect-video w-full bg-primary-950/10 flex items-center justify-center text-primary-900 font-bold text-xs uppercase tracking-wider">
                    Ulumul Islam
                </div>
                @endif
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <span class="text-[11px] font-bold text-accent-gold uppercase tracking-wider">
                            {{ $item->published_at ? $item->published_at->translatedFormat('d F Y') : '' }}
                        </span>
                        <h3 class="text-base font-black text-slate-900 leading-snug line-clamp-2 hover:text-primary-800 transition-colors">
                            <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                        </h3>
                        <p class="text-xs text-text-sub font-medium line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-border-main flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Oleh {{ $item->author_name ?? 'Admin' }}</span>
                        <a href="{{ route('news.show', $item->slug) }}" class="font-bold text-primary-900 hover:text-accent-gold transition-colors">
                            Baca Selengkapnya &rarr;
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="py-14 px-6 rounded-3xl bg-bg-warm border border-dashed border-border-main text-center space-y-2 max-w-xl mx-auto scroll-reveal">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-accent-gold flex items-center justify-center mx-auto text-2xl">
                📰
            </div>
            <h4 class="text-sm font-bold text-slate-800">Belum ada berita yang di publish</h4>
            <p class="text-xs text-text-sub">Warta dan informasi kegiatan pesantren akan tampil di sini setelah dipublikasikan.</p>
        </div>
        @endif
    </div>
</section>

<!-- Alumni Berprestasi Section -->
<section class="py-20 bg-primary-950 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 relative z-10">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 scroll-reveal">
            <div class="space-y-1">
                <span class="text-xs font-extrabold uppercase tracking-widest text-accent-gold">Jejak Langkah Santri</span>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Kiprah & Prestasi Alumni</h2>
                <p class="text-xs text-primary-200/80 font-medium">Klik profil alumni untuk melihat testimoni dan rincian lengkap.</p>
            </div>
            @if($featuredAlumni->count() > 5)
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" onclick="scrollAlumniTrack('home-alumni-track', -1)" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center border border-white/20 transition-colors shadow-xs" title="Geser ke Kiri">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" onclick="scrollAlumniTrack('home-alumni-track', 1)" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center border border-white/20 transition-colors shadow-xs" title="Geser ke Kanan">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
            @endif
        </div>

        @if($featuredAlumni->count() > 0)
        <div id="home-alumni-track" class="flex gap-4 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-accent-gold/40 snap-x scroll-smooth">
            @foreach($featuredAlumni as $alum)
            <div onclick="openAlumniDetailModal({{ json_encode($alum) }})" class="w-[85%] sm:w-[calc(50%-12px)] md:w-[calc(33.333%-14px)] lg:w-[calc(20%-13px)] shrink-0 bg-white/10 backdrop-blur-md rounded-3xl p-5 border border-white/15 space-y-4 flex flex-col justify-between scroll-reveal cursor-pointer group hover:border-accent-gold/60 hover:bg-white/15 transition-all snap-start">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        @if($alum->photo_url || $alum->photo_path)
                        <img src="{{ $alum->photo_url ?: $alum->photo_path }}" alt="{{ $alum->name }}" class="w-12 h-12 rounded-2xl object-cover border border-accent-gold/40 shrink-0">
                        @else
                        <div class="w-12 h-12 rounded-2xl bg-accent-gold/20 text-accent-gold font-black flex items-center justify-center text-sm border border-accent-gold/30 shrink-0">
                            {{ strtoupper(substr($alum->name, 0, 2)) }}
                        </div>
                        @endif
                        <div class="overflow-hidden">
                            <h4 class="font-black text-sm text-white group-hover:text-accent-gold transition-colors truncate">{{ $alum->name }}</h4>
                            <p class="text-[10px] text-accent-gold font-bold uppercase truncate">{{ strtoupper($alum->graduation_levels ?? 'Alumni') }}</p>
                        </div>
                    </div>
                    @php
                        $quote = $alum->testimonial ?: $alum->short_description;
                    @endphp
                    @if($quote)
                    <blockquote class="text-xs text-primary-100/80 font-medium italic leading-relaxed line-clamp-3">
                        "{{ $quote }}"
                    </blockquote>
                    @endif
                </div>
                <div class="pt-3 border-t border-white/10 flex items-center justify-between text-[11px] text-primary-200/90 font-medium">
                    <p class="font-bold text-white truncate max-w-[80%]">{{ $alum->position_or_program ?: ($alum->profession ?: ($alum->institution_or_company ?: 'Alumni')) }}</p>
                    <span class="text-accent-gold text-xs font-bold">&rarr;</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="py-14 px-6 rounded-3xl bg-white/5 border border-dashed border-white/20 text-center space-y-2 max-w-xl mx-auto scroll-reveal">
            <div class="w-12 h-12 rounded-2xl bg-white/10 text-accent-gold flex items-center justify-center mx-auto text-2xl">
                🎓
            </div>
            <h4 class="text-sm font-bold text-white">Belum ada data alumni yang dimasukkan</h4>
            <p class="text-xs text-primary-200/70">Profil lulusan dan jejak prestasi alumni Ulumul Islam akan segera diperbarui.</p>
        </div>
        @endif
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-16 bg-gradient-to-r from-primary-900 to-primary-950 text-white border-t border-primary-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 scroll-reveal">
        <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
            Wujudkan Masa Depan Gemilang Bersama Ulumul Islam
        </h2>
        <p class="text-xs sm:text-sm text-primary-100/90 max-w-2xl mx-auto font-medium leading-relaxed">
            Penerimaan santri baru dibuka setiap tahun ajaran. Dapatkan bimbingan pendidikan formal unggul dan penempaan karakter Qurani di lingkungan yang asri dan aman.
        </p>
        <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('admission') }}" class="px-8 py-3.5 rounded-2xl bg-accent-gold hover:bg-accent-gold-hover text-primary-950 font-black text-xs uppercase tracking-wider shadow-xl transition-all">
                Info Pendaftaran Santri Baru
            </a>
            <a href="{{ generate_whatsapp_link($settings['phone'] ?? '628111111111', $settings['wa_general'] ?? 'Assalamualaikum') }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-black text-xs uppercase tracking-wider border border-white/20 transition-all">
                Konsultasi Pendaftaran
            </a>
        </div>
    </div>
</section>
@endsection
