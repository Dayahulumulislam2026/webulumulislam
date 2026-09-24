<!DOCTYPE html>
<html lang="id" class="h-full bg-[#faf9f6]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') | Panel Ulumul Islam</title>
    <link rel="icon" type="image/png" href="/logo.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
                        'border-main': '#e5e7eb',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #14532d;
            border-radius: 3px;
        }
    </style>
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

    @stack('styles')
</head>
<body class="h-full antialiased flex text-slate-800">

    <!-- Sidebar Backdrop Mobile -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 lg:hidden hidden transition-opacity"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-primary-950 text-white flex flex-col transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex-shrink-0">
        <!-- Brand Header -->
        <div class="h-20 flex items-center gap-3 px-6 border-b border-primary-900/60 bg-primary-950/80">
            <div class="h-11 w-11 rounded-xl bg-white p-1.5 shadow-sm flex items-center justify-center shrink-0 border border-white/20">
                <img src="/logo.png" alt="Logo Ulumul Islam" class="h-full w-full object-contain">
            </div>
            <div class="flex flex-col">
                <span class="font-black text-sm tracking-wide text-white leading-tight">ULUMUL ISLAM</span>
                <span class="text-[10px] font-bold text-accent-gold uppercase tracking-wider">Panel Pengelola</span>
            </div>
            <button id="sidebar-close-btn" class="ml-auto lg:hidden text-primary-300 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto px-4 py-5 space-y-6">
            <!-- Group: Utama -->
            <div>
                <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-accent-gold/80">Menu Utama</span>
                <nav class="mt-2 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-accent-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                </nav>
            </div>

            <!-- Group: Konten & Operasional -->
            <div>
                <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-accent-gold/80">Konten & Operasional</span>
                <nav class="mt-2 space-y-1">
                    <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.news.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Berita & Warta
                    </a>

                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.announcements.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Pengumuman (Flyer & Teks)
                    </a>

                    <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.gallery.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Galeri (Foto & Video)
                    </a>

                    @if(auth()->user()->role !== 'admin_ikada')
                    <a href="{{ route('admin.admission.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.admission.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Penerimaan Santri (PSB)
                    </a>
                    @endif

                    <a href="{{ route('admin.alumni.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.alumni.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                        Alumni & Prestasi
                    </a>

                    @if(auth()->user()->isAdminIkada())
                    <a href="{{ route('admin.institutions.index', ['tab' => 'ikada']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.institutions.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Profil & Program IKADA UI
                    </a>
                    @endif
                </nav>
            </div>

            <!-- Group: Konfigurasi & Otoritas Khusus (Hanya Super Admin & Co-Super Admin) -->
            @if(auth()->user() && auth()->user()->canManageUsers())
            <div>
                <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-accent-gold/80">Sistem & Otoritas</span>
                <nav class="mt-2 space-y-1">
                    <a href="{{ route('admin.institutions.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.institutions.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Profil & Program Lembaga
                    </a>

                    <a href="{{ route('admin.structure.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.structure.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Struktur Organisasi
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pengaturan Situs
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manajemen Akun Admin
                        @if(auth()->user()->isCoSuperAdmin())
                        <span class="ml-auto text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Lihat</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.audit_logs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.audit_logs.*') ? 'bg-primary-800 text-white shadow-md' : 'text-primary-100/80 hover:bg-primary-900 hover:text-white' }}">
                        <svg class="w-4 h-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Log Aktivitas (Audit)
                    </a>
                </nav>
            </div>
            @endif
        </div>

        <!-- User Profile Footer in Sidebar -->
        <div class="p-4 border-t border-primary-900/60 bg-primary-950/90 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-accent-gold/20 text-accent-gold font-black flex items-center justify-center text-xs border border-accent-gold/30">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                <span class="inline-block text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full mt-0.5 {{ auth()->user()->role === 'super_admin' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : (auth()->user()->role === 'co_super_admin' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : (auth()->user()->role === 'admin_ikada' ? 'bg-teal-500/20 text-teal-300 border border-teal-500/30' : 'bg-slate-700 text-slate-300')) }}">
                    {{ auth()->user()->role_badge ?? ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-border-main flex items-center justify-between px-4 sm:px-6 lg:px-8 z-20 flex-shrink-0">
            <div class="flex items-center gap-3">
                <button id="sidebar-open-btn" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex flex-col">
                    <h1 class="text-base sm:text-lg font-black text-slate-900 leading-tight">@yield('page_title', 'Dashboard')</h1>
                    <span class="text-xs text-slate-500 font-medium">@yield('page_subtitle', 'Kelola informasi dan data sistem terpadu')</span>
                </div>
            </div>

            <!-- Topbar Actions -->
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-primary-900 bg-primary-50 hover:bg-primary-100 transition-colors border border-primary-200">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat Website Publik
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 transition-colors border border-red-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Workspace Area -->
        <main class="flex-1 overflow-y-auto bg-[#faf9f6] p-4 sm:p-6 lg:p-8">
            <!-- Flash Message Alerts -->
            @if(session('success'))
            <div class="mb-6 flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-sm animate-fade">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 flex items-center justify-between p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 shadow-sm animate-fade">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-red-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold">{{ session('error') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-extrabold uppercase tracking-wide">Terdapat beberapa kesalahan input:</p>
                        <ul class="mt-1 list-disc list-inside text-xs text-amber-800 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Universal Image Cropper Modal -->
    <div id="global-cropper-modal" class="fixed inset-0 z-[100] bg-black/80 hidden items-center justify-center p-4 backdrop-blur-xs">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-5 shadow-2xl flex flex-col max-h-[92vh]">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-primary-100 text-primary-900 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Sesuaikan & Potong Gambar</h3>
                        <p class="text-[11px] text-slate-500 font-medium">Geser atau atur bingkai agar gambar pas dan proporsional.</p>
                    </div>
                </div>
                <button type="button" onclick="closeCropperModal(false)" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Cropper Workspace -->
            <div class="flex-1 min-h-[300px] max-h-[50vh] bg-slate-900 rounded-2xl overflow-hidden flex items-center justify-center">
                <img id="cropper-image" src="" alt="Gambar untuk dipotong" class="max-w-full max-h-full block">
            </div>

            <!-- Controls Toolbar -->
            <div class="flex flex-wrap items-center justify-between gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-200 text-xs">
                <!-- Aspect Ratio Buttons -->
                <div class="flex flex-wrap items-center gap-1.5" id="cropper-ratio-buttons">
                    <button type="button" onclick="setCropperRatio(16/9)" data-ratio="1.777" class="ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-primary-900 text-white shadow-xs">16:9 (Berita/Cover)</button>
                    <button type="button" onclick="setCropperRatio(1/1)" data-ratio="1" class="ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-white text-slate-700 hover:bg-slate-200 border border-slate-200">1:1 (Foto Profil)</button>
                    <button type="button" onclick="setCropperRatio(4/5)" data-ratio="0.8" class="ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-white text-slate-700 hover:bg-slate-200 border border-slate-200">4:5 (Flyer/Poster)</button>
                    <button type="button" onclick="setCropperRatio(16/7)" data-ratio="2.285" class="ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-white text-slate-700 hover:bg-slate-200 border border-slate-200">16:7 (Hero Banner)</button>
                    <button type="button" onclick="setCropperRatio(NaN)" data-ratio="free" class="ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-white text-slate-700 hover:bg-slate-200 border border-slate-200">Bebas</button>
                </div>

                <!-- Tools: Zoom & Rotate -->
                <div class="flex items-center gap-1.5 ml-auto">
                    <button type="button" onclick="cropperZoom(0.1)" title="Perbesar" class="p-1.5 rounded-lg bg-white hover:bg-slate-200 text-slate-700 border border-slate-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <button type="button" onclick="cropperZoom(-0.1)" title="Perkecil" class="p-1.5 rounded-lg bg-white hover:bg-slate-200 text-slate-700 border border-slate-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    </button>
                    <button type="button" onclick="cropperRotate(-90)" title="Putar Kiri 90°" class="p-1.5 rounded-lg bg-white hover:bg-slate-200 text-slate-700 border border-slate-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    </button>
                    <button type="button" onclick="cropperRotate(90)" title="Putar Kanan 90°" class="p-1.5 rounded-lg bg-white hover:bg-slate-200 text-slate-700 border border-slate-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"/></svg>
                    </button>
                    <button type="button" onclick="cropperReset()" title="Reset Potongan" class="px-2 py-1 rounded-lg bg-white hover:bg-slate-200 text-slate-700 border border-slate-200 text-[11px] font-bold">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeCropperModal(false)" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-bold text-xs uppercase tracking-wider">
                    Gunakan Asli Tanpa Crop
                </button>
                <button type="button" onclick="applyCropper()" class="px-6 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition-all">
                    Terapkan Crop Gambar
                </button>
            </div>
        </div>
    </div>

    <!-- Cropper.js JavaScript CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- Scripts -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const openBtn = document.getElementById('sidebar-open-btn');
        const closeBtn = document.getElementById('sidebar-close-btn');

        function toggleSidebar(open) {
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        if (openBtn) openBtn.addEventListener('click', () => toggleSidebar(true));
        if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
        if (backdrop) backdrop.addEventListener('click', () => toggleSidebar(false));

        // Global Cropper.js Controller
        let cropperInstance = null;
        let cropperActiveInput = null;
        let cropperPreviewTarget = null;
        let cropperActiveRatio = 16/9;

        function openImageCropper(file, targetInput, previewElementOrSelector, defaultRatio = 16/9) {
            if (!file || !file.type.startsWith('image/')) return;

            cropperActiveInput = targetInput;
            cropperPreviewTarget = typeof previewElementOrSelector === 'string' 
                ? document.querySelector(previewElementOrSelector) 
                : previewElementOrSelector;
            cropperActiveRatio = defaultRatio;

            const modal = document.getElementById('global-cropper-modal');
            const imgEl = document.getElementById('cropper-image');

            const reader = new FileReader();
            reader.onload = function(e) {
                imgEl.src = e.target.result;
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                if (cropperInstance) {
                    cropperInstance.destroy();
                }

                cropperInstance = new Cropper(imgEl, {
                    aspectRatio: cropperActiveRatio,
                    viewMode: 2,
                    dragMode: 'move',
                    autoCropArea: 0.95,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });

                highlightRatioButton(cropperActiveRatio);
            };
            reader.readAsDataURL(file);
        }

        function setCropperRatio(ratio) {
            cropperActiveRatio = ratio;
            if (cropperInstance) {
                cropperInstance.setAspectRatio(ratio);
            }
            highlightRatioButton(ratio);
        }

        function highlightRatioButton(ratio) {
            const buttons = document.querySelectorAll('#cropper-ratio-buttons .ratio-btn');
            buttons.forEach(btn => {
                const btnRatio = parseFloat(btn.dataset.ratio);
                const isMatch = (isNaN(ratio) && btn.dataset.ratio === 'free') || (Math.abs(btnRatio - ratio) < 0.05);
                if (isMatch) {
                    btn.className = 'ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-primary-900 text-white shadow-xs';
                } else {
                    btn.className = 'ratio-btn px-2.5 py-1 rounded-lg font-bold text-[11px] bg-white text-slate-700 hover:bg-slate-200 border border-slate-200';
                }
            });
        }

        function cropperZoom(delta) {
            if (cropperInstance) cropperInstance.zoom(delta);
        }

        function cropperRotate(deg) {
            if (cropperInstance) cropperInstance.rotate(deg);
        }

        function cropperReset() {
            if (cropperInstance) cropperInstance.reset();
        }

        function closeCropperModal(cancelled = true) {
            const modal = document.getElementById('global-cropper-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
        }

        function applyCropper() {
            if (!cropperInstance || !cropperActiveInput) {
                closeCropperModal();
                return;
            }

            const canvas = cropperInstance.getCroppedCanvas({
                maxWidth: 2400,
                maxHeight: 2400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!canvas) {
                closeCropperModal();
                return;
            }

            canvas.toBlob((blob) => {
                if (blob) {
                    const originalName = (cropperActiveInput.files && cropperActiveInput.files[0]) ? cropperActiveInput.files[0].name : 'cropped-image.jpg';
                    const croppedFile = new File([blob], originalName, { type: 'image/jpeg', lastModified: Date.now() });

                    // Gantikan isi file input menggunakan DataTransfer
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    cropperActiveInput.files = dataTransfer.files;

                    // Update live preview jika ada
                    if (cropperPreviewTarget) {
                        const previewUrl = URL.createObjectURL(blob);
                        if (cropperPreviewTarget.tagName === 'IMG') {
                            cropperPreviewTarget.src = previewUrl;
                            cropperPreviewTarget.classList.remove('hidden');
                        } else {
                            cropperPreviewTarget.style.backgroundImage = `url(${previewUrl})`;
                        }
                    }
                }
                closeCropperModal(false);
            }, 'image/jpeg', 0.92);
        }

        // Auto-attach ke input ber-class .cropper-auto
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('cropper-auto') && e.target.files && e.target.files[0]) {
                const ratioAttr = e.target.getAttribute('data-aspect-ratio');
                let ratio = 16/9;
                if (ratioAttr === '1:1' || ratioAttr === '1/1') ratio = 1;
                else if (ratioAttr === '4:5' || ratioAttr === '4/5') ratio = 4/5;
                else if (ratioAttr === '16:7' || ratioAttr === '16/7') ratio = 16/7;
                else if (ratioAttr === 'free' || ratioAttr === 'auto') ratio = NaN;

                const previewSelector = e.target.getAttribute('data-preview');
                openImageCropper(e.target.files[0], e.target, previewSelector, ratio);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
