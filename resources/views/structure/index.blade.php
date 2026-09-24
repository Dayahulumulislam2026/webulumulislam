@extends('layouts.app')

@section('title', 'Struktur Organisasi & Kepengurusan')
@section('description', 'Bagan struktur kepengurusan dan pimpinan di lingkungan Yayasan Dayah Terpadu Ulumul Islam.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-primary-950 text-white py-16 lg:py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-primary-800/30 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-2xl mx-auto space-y-3 scroll-reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-accent-gold">Tata Kelola Lembaga</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Struktur Organisasi</h1>
            <p class="text-xs sm:text-sm text-primary-100/90 font-medium">
                Susunan pimpinan, dewan pengurus, dan tenaga pendidik yang berdedikasi membimbing para santri.
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 bg-bg-warm min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- Unit Navigation Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2 scroll-reveal">
            @php
                $units = [
                    'foundation' => 'Yayasan Ulumul Islam',
                    'dayah' => 'Dayah Terpadu',
                    'smp' => 'SMP Ulumul Islam',
                    'sma' => 'SMA Ulumul Islam',
                    'ikada' => 'IKADA UI (Alumni)',
                ];
            @endphp
            @foreach($units as $uKey => $uLabel)
            <a href="{{ route('structure.public', ['unit' => $uKey]) }}"
               class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $selectedUnit === $uKey ? 'bg-primary-900 text-white shadow-lg shadow-primary-900/20' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                {{ $uLabel }}
            </a>
            @endforeach
        </div>

        @if($activeInstitution)
        <div class="space-y-12">
            <!-- Unit Intro Header -->
            <div class="text-center max-w-2xl mx-auto space-y-2 scroll-reveal">
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-primary-800">Tata Kelola & Kepengurusan</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $activeInstitution->name }}</h2>
                <p class="text-xs text-text-sub font-medium">Bagan hierarki pimpinan, jajaran wakil, serta koordinator dan divisi operasional.</p>
            </div>

            @php
                $hasContent = ($leaders && $leaders->count() > 0) || ($vices && $vices->count() > 0) || ($divisions && $divisions->count() > 0);
            @endphp

            @if($hasContent)
            <!-- 1. Pimpinan Utama (Leader Cards) -->
            @if($leaders && $leaders->count() > 0)
            <div class="space-y-6 scroll-reveal">
                <div class="text-center space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-accent-gold">Hierarki Pimpinan</span>
                    <h3 class="text-xl font-black text-slate-900">Pimpinan Utama</h3>
                </div>

                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($leaders as $pos)
                        @foreach($pos->members as $leader)
                        <div class="w-full max-w-sm bg-white rounded-3xl p-6 sm:p-8 border-2 {{ $pos->is_pinned ? 'border-primary-900 shadow-xl ring-4 ring-primary-900/10' : 'border-border-main shadow-md' }} text-center flex flex-col items-center space-y-4 hover:-translate-y-1 transition-transform">
                            <div class="relative w-32 h-32 rounded-3xl overflow-hidden bg-primary-950/5 ring-4 ring-white shadow-md">
                                @if($leader->photo_path)
                                <img src="{{ $leader->photo_path }}" alt="{{ $leader->name }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-primary-900 text-white font-black text-3xl">
                                    {{ substr($leader->name, 0, 1) }}
                                </div>
                                @endif
                                @if($pos->is_pinned)
                                <span class="absolute bottom-1 right-1 px-2.5 py-0.5 rounded-full bg-accent-gold text-primary-950 text-[9px] font-black uppercase shadow-xs">
                                    Pimpinan Inti
                                </span>
                                @endif
                            </div>

                            <div class="space-y-1">
                                <h4 class="text-base font-black text-slate-900 leading-snug">{{ $leader->name }}</h4>
                                <p class="text-xs font-bold text-primary-900 uppercase tracking-wider">{{ $leader->title ?: $pos->position_name }}</p>
                                @if($leader->sub_role)
                                <p class="text-[11px] text-slate-600 font-medium mt-1">{{ $leader->sub_role }}</p>
                                @endif
                                @if($leader->period)
                                <span class="inline-block mt-2 px-3 py-1 rounded-full bg-primary-50 border border-primary-200 text-primary-950 text-[10px] font-bold">
                                    Masa Khidmat: {{ $leader->period }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 2. Jajaran Wakil Pimpinan (Dibuat seperti tampilan Pimpinan Utama) -->
            @if($vices && $vices->count() > 0)
            <div class="space-y-6 pt-4 scroll-reveal">
                <div class="text-center space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Jajaran Struktural</span>
                    <h3 class="text-lg font-black text-slate-900">Jajaran Wakil & Pimpinan Harian</h3>
                </div>

                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($vices as $vPos)
                        @foreach($vPos->members as $vice)
                        <div class="w-full max-w-xs bg-white rounded-3xl p-6 border border-border-main shadow-md text-center flex flex-col items-center space-y-4 hover:-translate-y-1 transition-transform">
                            <div class="relative w-28 h-28 rounded-3xl overflow-hidden bg-slate-100 ring-4 ring-slate-50 shadow-sm">
                                @if($vice->photo_path)
                                <img src="{{ $vice->photo_path }}" alt="{{ $vice->name }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-800 text-white font-black text-2xl">
                                    {{ substr($vice->name, 0, 1) }}
                                </div>
                                @endif
                            </div>
                            <div class="space-y-1 w-full">
                                <h4 class="text-sm font-black text-slate-900 leading-snug">{{ $vice->name }}</h4>
                                <p class="text-xs font-bold text-primary-900 uppercase tracking-wider">{{ $vice->title ?: $vPos->position_name }}</p>
                                @if($vice->sub_role)
                                <p class="text-[11px] text-slate-600 font-medium mt-1">{{ $vice->sub_role }}</p>
                                @endif
                                @if($vice->period)
                                <span class="inline-block mt-2 px-3 py-1 rounded-full bg-slate-50 border border-slate-200 text-slate-700 text-[10px] font-semibold">
                                    Masa Khidmat: {{ $vice->period }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 3. Divisi / Bidang Kustom (Custom Divisions) -->
            @if($divisions && $divisions->count() > 0)
            <div class="space-y-8 pt-4 scroll-reveal">
                <div class="text-center space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800">Unit Pelaksana Teknis</span>
                    <h3 class="text-lg font-black text-slate-900">Divisi, Bidang & Penugasan Staf</h3>
                </div>

                <div class="space-y-6">
                    @foreach($divisions as $div)
                    <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
                        <div class="p-5 sm:p-6 bg-gradient-to-r from-emerald-50/70 to-slate-50 border-b border-border-main flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-xl bg-emerald-800 text-white font-black flex items-center justify-center text-xs">
                                    {{ $loop->iteration }}
                                </span>
                                <div>
                                    <h4 class="text-base font-black text-slate-900">{{ $div->position_name }}</h4>
                                    <p class="text-[11px] text-emerald-800 font-semibold">{{ $div->members->count() }} Anggota Pengurus</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($div->members->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($div->members as $member)
                                <div class="p-4 rounded-2xl border {{ $member->member_role === 'head' ? 'border-emerald-300 bg-emerald-50/40' : 'border-slate-200 bg-white' }} space-y-2.5">
                                    <div class="flex items-start gap-3">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                            @if($member->photo_path)
                                            <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                            @else
                                            <div class="w-full h-full flex items-center justify-center {{ $member->member_role === 'head' ? 'bg-emerald-800 text-white' : 'bg-primary-100 text-primary-900' }} font-bold text-xs">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <h5 class="font-bold text-xs text-slate-900 truncate">{{ $member->name }}</h5>
                                                @if($member->member_role === 'head')
                                                <span class="px-1.5 py-0.5 rounded bg-emerald-700 text-white font-extrabold text-[8px] uppercase">
                                                    Kepala
                                                </span>
                                                @endif
                                            </div>
                                            @if($member->title)
                                            <p class="text-[10px] font-semibold text-primary-900">{{ $member->title }}</p>
                                            @endif
                                            @if($member->sub_role)
                                            <div class="mt-1.5 p-2 rounded-xl bg-slate-100/90 border border-slate-200 text-[10px] text-slate-700 leading-relaxed font-medium">
                                                <span class="font-bold text-[9px] text-slate-500 uppercase block">Tupoksi / Tugas:</span>
                                                {{ $member->sub_role }}
                                            </div>
                                            @endif
                                            <p class="text-[9px] text-slate-400 mt-1">Periode: {{ $member->period }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-xs text-slate-400 italic text-center py-4">Belum ada staf atau anggota yang terdaftar pada divisi ini.</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="text-center py-16 bg-white rounded-3xl border border-border-main p-8 space-y-3">
                <svg class="w-12 h-12 text-slate-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-base font-bold text-slate-800">Struktur Belum Tersedia</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Informasi susunan kepengurusan unit ini sedang dalam proses pembaruan.</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Quick Back Link -->
        <div class="text-center pt-6">
            <a href="{{ url()->previous() ?: route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-primary-900 hover:text-accent-gold transition-colors">
                <span>&larr;</span> Kembali ke Halaman Sebelumnya
            </a>
        </div>
    </div>
</section>
@endsection
