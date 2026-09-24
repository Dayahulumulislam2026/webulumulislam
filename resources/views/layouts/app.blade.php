<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', site_setting('site_meta_title', 'Yayasan & Dayah Terpadu Ulumul Islam')) | Ulumul Islam</title>
    <meta name="description" content="@yield('description', site_setting('site_meta_description', 'Portal Resmi Yayasan Pendidikan dan Pondok Pesantren Dayah Terpadu Ulumul Islam (SMP, SMA, Dayah).'))">
    <meta name="keywords" content="@yield('keywords', site_setting('site_meta_keywords', 'dayah, pesantren, smp ulumul islam, sma ulumul islam, dayah terpadu, aceh, tahfidz'))">
    <link rel="icon" type="image/png" href="/logo.png">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', site_setting('site_meta_title', 'Yayasan & Dayah Terpadu Ulumul Islam')) | Ulumul Islam">
    <meta property="og:description" content="@yield('description', site_setting('site_meta_description', 'Portal Resmi Yayasan Pendidikan dan Pondok Pesantren Dayah Terpadu Ulumul Islam.'))">
    <meta property="og:image" content="@yield('og_image', site_setting('site_og_image') ? asset(site_setting('site_og_image')) : asset('logo.png'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', site_setting('site_meta_title', 'Yayasan & Dayah Terpadu Ulumul Islam')) | Ulumul Islam">
    <meta name="twitter:description" content="@yield('description', site_setting('site_meta_description', 'Portal Resmi Yayasan Pendidikan dan Pondok Pesantren Dayah Terpadu Ulumul Islam.'))">
    <meta name="twitter:image" content="@yield('og_image', site_setting('site_og_image') ? asset(site_setting('site_og_image')) : asset('logo.png'))">

    @if(site_setting('google_site_verification'))
    <meta name="google-site-verification" content="{{ site_setting('google_site_verification') }}">
    @endif

    @if(site_setting('google_analytics_id'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ site_setting('google_analytics_id') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ site_setting('google_analytics_id') }}');
    </script>
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:wght@700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN dengan Konfigurasi Token Warna Resmi) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        arabic: ['"Amiri"', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16',
                        },
                        accent: {
                            gold: '#d4a72c',
                            'gold-hover': '#b88d1f',
                            'gold-light': '#fef9c3',
                        },
                        'bg-warm': '#faf9f6',
                        'bg-alt': '#f3f4f6',
                        'border-main': '#e5e7eb',
                        'text-main': '#1f2937',
                        'text-sub': '#6b7280',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #faf9f6;
            color: #1f2937;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        /* Pulse Page Loader Animation */
        #global-page-loader {
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.5s;
        }
        #global-page-loader.hidden-loader {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        .pulse-heartbeat {
            animation: heartbeat 1.8s ease-in-out infinite;
        }

        /* Scroll Reveal Animation */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #14532d;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #052e16;
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen antialiased">

    <!-- Global Pulse Page Loader -->
    <div id="global-page-loader" class="fixed inset-0 z-[9999] bg-[#faf9f6] flex flex-col items-center justify-center">
        <div class="flex flex-col items-center gap-4">
            <div class="h-24 w-24 rounded-full bg-white p-3 shadow-xl border border-border-main flex items-center justify-center pulse-heartbeat">
                <img src="/logo.png" alt="Logo Ulumul Islam" class="h-full w-full object-contain">
            </div>
            <div class="flex flex-col items-center text-center">
                <span class="text-sm font-extrabold text-primary-950 uppercase tracking-widest">Ulumul Islam</span>
                <span class="text-[11px] font-semibold text-accent-gold uppercase tracking-wider mt-0.5">Memuat Halaman...</span>
            </div>
        </div>
    </div>

    <!-- Header / Navbar Publik -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-border-main shadow-xs transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand (Solid White Background) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                    <div class="h-12 w-12 rounded-xl bg-white p-1.5 shadow-sm border border-border-main flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <img src="/logo.png" alt="Logo Ulumul Islam" class="h-full w-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-base sm:text-lg text-primary-950 leading-tight group-hover:text-primary-800 transition-colors">
                            Ulumul Islam
                        </span>
                        <span class="text-[10px] sm:text-xs font-semibold text-accent-gold uppercase tracking-wider">
                            Yayasan & Dayah Terpadu
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('home') ? 'text-primary-950 bg-primary-50 font-extrabold' : 'text-text-main hover:text-primary-900 hover:bg-bg-alt' }}">
                        Beranda
                    </a>

                    <!-- Dropdown: Tentang Kami (Yayasan, SMP, SMA, Dayah) -->
                    @php
                        $isTentangActive = request()->routeIs('tentang-kami') || request()->routeIs('smp') || request()->routeIs('sma') || request()->routeIs('dayah');
                    @endphp
                    <div class="relative group" id="desktop-dropdown-tentang">
                        <button type="button" class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ $isTentangActive ? 'text-primary-950 bg-primary-50 font-extrabold' : 'text-text-main hover:text-primary-900 hover:bg-bg-alt' }}">
                            <span>Tentang Kami</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu Box -->
                        <div class="absolute left-0 top-full mt-1 w-60 bg-white rounded-2xl shadow-xl border border-border-main py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('tentang-kami') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold transition-colors {{ request()->routeIs('tentang-kami') ? 'bg-primary-50 text-primary-900 font-extrabold' : 'text-text-main hover:bg-bg-alt hover:text-primary-900' }}">
                                <div class="w-7 h-7 rounded-lg bg-primary-100 text-primary-800 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold">Tentang Yayasan</p>
                                    <p class="text-[10px] text-text-sub font-normal">Profil & Sejarah Utama</p>
                                </div>
                            </a>
                            <a href="{{ route('dayah') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold transition-colors {{ request()->routeIs('dayah') ? 'bg-primary-50 text-primary-900 font-extrabold' : 'text-text-main hover:bg-bg-alt hover:text-primary-900' }}">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold">Dayah Terpadu</p>
                                    <p class="text-[10px] text-text-sub font-normal">Pondok Pesantren</p>
                                </div>
                            </a>
                            <a href="{{ route('smp') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold transition-colors {{ request()->routeIs('smp') ? 'bg-primary-50 text-primary-900 font-extrabold' : 'text-text-main hover:bg-bg-alt hover:text-primary-900' }}">
                                <div class="w-7 h-7 rounded-lg bg-cyan-100 text-cyan-800 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold">SMP Ulumul Islam</p>
                                    <p class="text-[10px] text-text-sub font-normal">Pendidikan Menengah Pertama</p>
                                </div>
                            </a>
                            <a href="{{ route('sma') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold transition-colors {{ request()->routeIs('sma') ? 'bg-primary-50 text-primary-900 font-extrabold' : 'text-text-main hover:bg-bg-alt hover:text-primary-900' }}">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold">SMA Ulumul Islam</p>
                                    <p class="text-[10px] text-text-sub font-normal">Pendidikan Menengah Atas</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- IKADA UI Nav Link Mandiri -->
                    <a href="{{ route('ikada') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('ikada') ? 'text-primary-950 bg-primary-50 font-extrabold' : 'text-text-main hover:text-primary-900 hover:bg-bg-alt' }}">
                        IKADA UI
                    </a>

                    <a href="{{ route('news.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('news.*') ? 'text-primary-950 bg-primary-50 font-extrabold' : 'text-text-main hover:text-primary-900 hover:bg-bg-alt' }}">
                        Berita
                    </a>
                    <a href="{{ route('gallery.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('gallery.*') ? 'text-primary-950 bg-primary-50 font-extrabold' : 'text-text-main hover:text-primary-900 hover:bg-bg-alt' }}">
                        Galeri
                    </a>
                </nav>

                <!-- Action CTA -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('admission') }}" class="px-5 py-2.5 rounded-full text-xs font-extrabold uppercase tracking-wider bg-primary-900 hover:bg-primary-950 text-white shadow-md transition-all hover:shadow-lg">
                        Pendaftaran
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden p-2 rounded-xl text-text-main hover:bg-bg-alt focus:outline-none" aria-label="Buka Menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-drawer" class="lg:hidden hidden border-t border-border-main bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-950' : 'text-text-main hover:bg-bg-alt' }}">
                Beranda
            </a>

            <!-- Mobile Accordion: Tentang Kami -->
            <div class="border border-border-main rounded-xl overflow-hidden">
                <button id="mobile-accordion-tentang-btn" type="button" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-bold uppercase tracking-wider bg-bg-warm text-text-main">
                    <span>Tentang Lembaga</span>
                    <svg id="mobile-accordion-arrow" class="w-4 h-4 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="mobile-accordion-tentang-content" class="px-3 py-2 space-y-1 bg-white">
                    <a href="{{ route('tentang-kami') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('tentang-kami') ? 'bg-primary-50 text-primary-950 font-bold' : 'text-text-sub hover:bg-bg-alt' }}">
                        • Tentang Yayasan
                    </a>
                    <a href="{{ route('dayah') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('dayah') ? 'bg-primary-50 text-primary-950 font-bold' : 'text-text-sub hover:bg-bg-alt' }}">
                        • Dayah Terpadu
                    </a>
                    <a href="{{ route('smp') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('smp') ? 'bg-primary-50 text-primary-950 font-bold' : 'text-text-sub hover:bg-bg-alt' }}">
                        • SMP Ulumul Islam
                    </a>
                    <a href="{{ route('sma') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('sma') ? 'bg-primary-50 text-primary-950 font-bold' : 'text-text-sub hover:bg-bg-alt' }}">
                        • SMA Ulumul Islam
                    </a>
                </div>
            </div>

            <!-- Mobile IKADA UI Mandiri -->
            <a href="{{ route('ikada') }}" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ request()->routeIs('ikada') ? 'bg-primary-50 text-primary-950' : 'text-text-main hover:bg-bg-alt' }}">
                IKADA UI (Ikatan Alumni)
            </a>

            <a href="{{ route('news.index') }}" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ request()->routeIs('news.*') ? 'bg-primary-50 text-primary-950' : 'text-text-main hover:bg-bg-alt' }}">
                Berita & Informasi
            </a>
            <a href="{{ route('gallery.index') }}" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider {{ request()->routeIs('gallery.*') ? 'bg-primary-50 text-primary-950' : 'text-text-main hover:bg-bg-alt' }}">
                Galeri Foto & Video
            </a>
            <div class="pt-2">
                <a href="{{ route('admission') }}" class="block w-full text-center px-4 py-3 rounded-xl text-xs font-extrabold uppercase tracking-wider bg-primary-900 text-white shadow-sm">
                    Informasi Pendaftaran
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Publik -->
    <footer class="bg-primary-950 text-white border-t border-primary-900/50 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-xl bg-white p-1.5 shadow-sm border border-white/20 flex items-center justify-center shrink-0">
                            <img src="/logo.png" alt="Logo Ulumul Islam" class="h-full w-full object-contain">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-base tracking-wide text-white">Ulumul Islam</span>
                            <span class="text-[10px] font-semibold text-accent-gold uppercase tracking-wider">Pendidikan & Dayah Terpadu</span>
                        </div>
                    </div>
                    <p class="text-xs text-primary-100/80 leading-relaxed font-medium">
                        Membina generasi Rabbani yang berilmu amaliyah, beramal ilmiah, dan berakhlakul karimah berlandaskan nilai-nilai Al-Quran dan Sunnah.
                    </p>
                </div>

                <!-- Tautan Jenjang Pendidikan -->
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-accent-gold border-b border-primary-800 pb-2">Unit & Lembaga</h4>
                    <ul class="space-y-2 text-xs font-medium text-primary-100/90">
                        <li><a href="{{ route('smp') }}" class="hover:text-accent-gold transition-colors">SMP Ulumul Islam</a></li>
                        <li><a href="{{ route('sma') }}" class="hover:text-accent-gold transition-colors">SMA Ulumul Islam</a></li>
                        <li><a href="{{ route('dayah') }}" class="hover:text-accent-gold transition-colors">Dayah Terpadu (Pesantren)</a></li>
                        <li><a href="{{ route('tentang-kami') }}" class="hover:text-accent-gold transition-colors">Yayasan Ulumul Islam</a></li>
                        <li><a href="{{ route('ikada') }}" class="hover:text-accent-gold transition-colors">IKADA UI (Ikatan Alumni)</a></li>
                    </ul>
                </div>

                <!-- Tautan Publikasi -->
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-accent-gold border-b border-primary-800 pb-2">Informasi & Media</h4>
                    <ul class="space-y-2 text-xs font-medium text-primary-100/90">
                        <li><a href="{{ route('admission') }}" class="hover:text-accent-gold transition-colors">Penerimaan Santri Baru</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-accent-gold transition-colors">Warta & Berita Kegiatan</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-accent-gold transition-colors">Galeri Foto & Dokumentasi Video</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-accent-gold transition-colors">Portal Pengelola (Admin)</a></li>
                    </ul>
                </div>

                <!-- Kontak & Alamat + Google Maps -->
                <div class="space-y-3">
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-accent-gold border-b border-primary-800 pb-2 flex items-center justify-between">
                        <span>Hubungi & Lokasi</span>
                    </h4>
                    <div class="space-y-2 text-xs text-primary-100/90 font-medium">
                        <p class="leading-relaxed flex items-start gap-2">
                            <svg class="w-4 h-4 text-accent-gold shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ site_setting('site_address', 'Jl. Ulumul Islam No. 1, Aceh') }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-accent-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Telepon / WA: <a href="{{ generate_whatsapp_link(site_setting('site_phone', '628111111111'), site_setting('whatsapp_template_general', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Yayasan & Dayah Terpadu Ulumul Islam.')) }}" target="_blank" rel="noopener noreferrer" class="font-mono text-accent-gold font-bold hover:underline">+{{ site_setting('site_phone', '628111111111') }}</a></span>
                        </p>

                        <!-- Peta Interaktif Google Maps -->
                        <div class="pt-2">
                            <div class="relative w-full h-36 rounded-2xl overflow-hidden border border-white/15 bg-primary-900/50 shadow-inner group">
                                <iframe 
                                    src="{{ format_gmaps_embed_url(site_setting('site_gmaps')) }}" 
                                    class="w-full h-full border-0 rounded-2xl opacity-90 group-hover:opacity-100 transition-opacity" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade"
                                    title="Peta Lokasi Ulumul Islam">
                                </iframe>
                                <a href="{{ get_gmaps_direct_url(site_setting('site_gmaps')) }}" target="_blank" rel="noopener noreferrer" class="absolute bottom-2 right-2 px-2.5 py-1 rounded-lg bg-primary-950/85 hover:bg-primary-900 text-accent-gold hover:text-white border border-white/20 text-[10px] font-bold tracking-wider backdrop-blur-xs flex items-center gap-1 shadow-md transition-all">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Buka Peta
                                </a>
                            </div>
                        </div>

                        <div class="pt-1 flex flex-wrap gap-2">
                            <a href="{{ generate_whatsapp_link(site_setting('site_phone', '628111111111'), site_setting('whatsapp_template_general', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Yayasan & Dayah Terpadu Ulumul Islam.')) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-md">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                </svg>
                                Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-primary-900 flex flex-col sm:flex-row items-center justify-between text-xs text-primary-200/60 gap-4">
                <p>&copy; {{ date('Y') }} Yayasan & Dayah Terpadu Ulumul Islam. Hak Cipta Dilindungi.</p>
                <p class="text-[11px]">Sistem Informasi & Manajemen Digital</p>
            </div>
        </div>
    </footer>

    <!-- Global Modal Detail Pengumuman -->
    <div id="global-announcement-modal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto space-y-5 animate-in fade-in zoom-in duration-200">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="space-y-1">
                    <span id="ann-modal-badge" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-primary-50 text-primary-900 border border-primary-100">
                        Pengumuman
                    </span>
                    <p id="ann-modal-date" class="text-xs text-slate-400 font-medium"></p>
                </div>
                <button type="button" onclick="closeAnnouncementModal()" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Flyer / Gambar Pengumuman -->
            <div id="ann-modal-image-container" class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 max-h-80 flex items-center justify-center hidden">
                <img id="ann-modal-image" src="" alt="Flyer Pengumuman" class="w-full h-full object-contain">
            </div>

            <div>
                <h3 id="ann-modal-title" class="text-lg sm:text-xl font-black text-slate-900 leading-tight"></h3>
                <div id="ann-modal-content" class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed whitespace-pre-line mt-3"></div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                <button type="button" id="ann-modal-share-wa" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-xs">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                    Bagikan WA
                </button>
                <button type="button" onclick="closeAnnouncementModal()" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Global Modal Detail Alumni -->
    <div id="global-alumni-modal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto space-y-6 animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">PROFIL LULUSAN & ALUMNI</span>
                <button type="button" onclick="closeAlumniDetailModal()" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="text-center space-y-3">
                <div class="relative w-24 h-24 mx-auto">
                    <img id="alumni-modal-img" src="" alt="Foto Alumni" class="w-24 h-24 rounded-3xl object-cover mx-auto border-2 border-primary-900 shadow-md hidden">
                    <div id="alumni-modal-fallback" class="w-24 h-24 rounded-3xl mx-auto bg-primary-100 text-primary-900 flex items-center justify-center font-black text-2xl border border-primary-200 shadow-sm">
                        UI
                    </div>
                    <span id="alumni-modal-year" class="absolute -bottom-2 -right-2 px-2 py-0.5 rounded-lg bg-accent-gold text-primary-950 text-[10px] font-black uppercase shadow-xs">
                    </span>
                </div>
                <div>
                    <h3 id="alumni-modal-name" class="text-lg font-black text-slate-900"></h3>
                    <p id="alumni-modal-level" class="text-[11px] text-accent-gold font-bold uppercase tracking-wider mt-0.5"></p>
                </div>
            </div>

            <div class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jalur / Bidang Karir</span>
                    <p id="alumni-modal-career" class="font-bold text-slate-800 capitalize mt-0.5">-</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Profesi / Jurusan Saat Ini</span>
                    <p id="alumni-modal-position" class="font-bold text-primary-950 mt-0.5">-</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Instansi / Kampus</span>
                    <p id="alumni-modal-institution" class="font-bold text-slate-800 mt-0.5">-</p>
                </div>
            </div>

            <div id="alumni-modal-testimonial-container" class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/80 text-xs space-y-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-800">Pesan & Testimoni Alumni</span>
                <p id="alumni-modal-testimonial" class="text-slate-700 italic leading-relaxed"></p>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" onclick="closeAlumniDetailModal()" class="w-full py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Global Announcement Modal Handlers
        function openAnnouncementModal(data) {
            document.getElementById('ann-modal-title').textContent = data.title || '';
            document.getElementById('ann-modal-content').textContent = data.content || '';
            document.getElementById('ann-modal-date').textContent = data.date || '';
            document.getElementById('ann-modal-badge').textContent = data.badge || 'Pengumuman';

            const imgContainer = document.getElementById('ann-modal-image-container');
            const imgEl = document.getElementById('ann-modal-image');
            if (data.image) {
                imgEl.src = data.image;
                imgContainer.classList.remove('hidden');
            } else {
                imgContainer.classList.add('hidden');
            }

            const waBtn = document.getElementById('ann-modal-share-wa');
            if (waBtn) {
                const currentUrl = window.location.origin + '/berita';
                const shareText = encodeURIComponent(`*PENGUMUMAN ULUMUL ISLAM*\n\n*${data.title}*\n${data.content || ''}\n\nSelengkapnya: ${currentUrl}`);
                waBtn.onclick = () => window.open(`https://api.whatsapp.com/send?text=${shareText}`, '_blank');
            }

            const modal = document.getElementById('global-announcement-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAnnouncementModal() {
            const modal = document.getElementById('global-announcement-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Global Alumni Modal Handlers
        function openAlumniDetailModal(alum) {
            document.getElementById('alumni-modal-name').textContent = alum.name || '';
            document.getElementById('alumni-modal-level').textContent = (alum.graduation_levels || 'Alumni').toUpperCase();
            document.getElementById('alumni-modal-career').textContent = (alum.career_type || '-').replace('_', ' ');
            document.getElementById('alumni-modal-position').textContent = alum.position_or_program || alum.profession || '-';
            document.getElementById('alumni-modal-institution').textContent = alum.institution_or_company || alum.current_activity || '-';
            
            const yearEl = document.getElementById('alumni-modal-year');
            if (alum.graduation_year) {
                yearEl.textContent = "'" + String(alum.graduation_year).slice(-2);
                yearEl.classList.remove('hidden');
            } else {
                yearEl.classList.add('hidden');
            }

            const imgEl = document.getElementById('alumni-modal-img');
            const fallbackEl = document.getElementById('alumni-modal-fallback');
            if (alum.photo_url || alum.photo_path) {
                imgEl.src = alum.photo_url || alum.photo_path;
                imgEl.classList.remove('hidden');
                fallbackEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                fallbackEl.classList.remove('hidden');
                fallbackEl.textContent = (alum.name || 'UI').substring(0, 2).toUpperCase();
            }

            const testContainer = document.getElementById('alumni-modal-testimonial-container');
            const testEl = document.getElementById('alumni-modal-testimonial');
            const quote = alum.testimonial || alum.short_description || '';
            if (quote.trim()) {
                testEl.textContent = `"${quote}"`;
                testContainer.classList.remove('hidden');
            } else {
                testContainer.classList.add('hidden');
            }

            const modal = document.getElementById('global-alumni-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAlumniDetailModal() {
            const modal = document.getElementById('global-alumni-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function scrollAlumniTrack(trackId, direction) {
            const track = document.getElementById(trackId);
            if (track) {
                const card = track.firstElementChild;
                const scrollAmount = card ? (card.offsetWidth + 16) : 240;
                track.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
            }
        }

        // Page Loader Fadeout
        window.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('global-page-loader');
            if (loader) {
                setTimeout(() => {
                    loader.classList.add('hidden-loader');
                }, 200);
            }
        });

        // Mobile Drawer Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        if (menuBtn && drawer) {
            menuBtn.addEventListener('click', () => {
                drawer.classList.toggle('hidden');
            });
        }

        // Mobile Accordion Toggle
        const accordionBtn = document.getElementById('mobile-accordion-tentang-btn');
        const accordionContent = document.getElementById('mobile-accordion-tentang-content');
        const accordionArrow = document.getElementById('mobile-accordion-arrow');
        if (accordionBtn && accordionContent) {
            accordionBtn.addEventListener('click', () => {
                accordionContent.classList.toggle('hidden');
                if (accordionArrow) {
                    accordionArrow.classList.toggle('rotate-180');
                }
            });
        }

        // Scroll Reveal Observer
        const revealElements = document.querySelectorAll('.scroll-reveal');
        if ('IntersectionObserver' in window && revealElements.length > 0) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealElements.forEach(el => observer.observe(el));
        } else {
            revealElements.forEach(el => el.classList.add('revealed'));
        }
    </script>
    @stack('scripts')
</body>
</html>
