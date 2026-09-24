@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Dashboard')
@section('page_subtitle', 'Selamat datang di pusat kendali sistem informasi Ulumul Islam')

@section('content')
<div class="space-y-8">
    <!-- Welcome Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-primary-950 via-primary-900 to-primary-950 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-accent-gold text-xs font-bold uppercase tracking-wider">
                Hak Akses: {{ auth()->user()->role_badge }}
            </div>
            <h2 class="text-xl sm:text-2xl font-black">Ahlan wa Sahlan, {{ auth()->user()->name }}!</h2>
            <p class="text-xs text-primary-100/90 font-medium max-w-xl">
                Seluruh pembaruan data yang Anda masukkan pada panel ini akan langsung tersinkronisasi secara real-time ke halaman publik website.
            </p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.news.create') }}" class="px-4 py-2.5 rounded-xl bg-accent-gold hover:bg-accent-gold-hover text-primary-950 font-black text-xs uppercase tracking-wider transition-all shadow-md">
                + Tulis Berita
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider border border-white/20 transition-all">
                + Upload Media
            </a>
        </div>
    </div>

    <!-- Metric Counts Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-border-main shadow-xs space-y-2">
            <div class="flex items-center justify-between text-text-sub">
                <span class="text-xs font-bold uppercase tracking-wider">Santri Aktif</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
            </div>
            <p class="text-2xl font-black text-slate-900">{{ number_format($stats['total_santri']) }}</p>
            <p class="text-[11px] text-slate-500 font-medium">SMP: {{ $stats['total_smp'] }} | SMA: {{ $stats['total_sma'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-border-main shadow-xs space-y-2">
            <div class="flex items-center justify-between text-text-sub">
                <span class="text-xs font-bold uppercase tracking-wider">Total Berita</span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </span>
            </div>
            <p class="text-2xl font-black text-slate-900">{{ number_format($counts['news']) }}</p>
            <a href="{{ route('admin.news.index') }}" class="text-[11px] text-primary-900 font-bold hover:underline">Kelola Berita &rarr;</a>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-border-main shadow-xs space-y-2">
            <div class="flex items-center justify-between text-text-sub">
                <span class="text-xs font-bold uppercase tracking-wider">Album Galeri</span>
                <span class="p-2 rounded-xl bg-purple-50 text-purple-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <p class="text-2xl font-black text-slate-900">{{ number_format($counts['albums']) }}</p>
            <p class="text-[11px] text-slate-500 font-medium">{{ $counts['media'] }} Foto & Video</p>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-border-main shadow-xs space-y-2">
            <div class="flex items-center justify-between text-text-sub">
                <span class="text-xs font-bold uppercase tracking-wider">Total Alumni</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                </span>
            </div>
            <p class="text-2xl font-black text-slate-900">{{ number_format($stats['total_alumni']) }}</p>
            <a href="{{ route('admin.alumni.index') }}" class="text-[11px] text-primary-900 font-bold hover:underline">Kelola Alumni &rarr;</a>
        </div>
    </div>

    <!-- Recent Tables (Berita Terbaru & Pengumuman Terbaru) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Berita Terbaru -->
        <div class="bg-white rounded-3xl p-6 border border-border-main shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider">Berita Terbaru</h3>
                <a href="{{ route('admin.news.index') }}" class="text-xs font-bold text-primary-900 hover:text-accent-gold">Lihat Semua</a>
            </div>

            @if($recentNews->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($recentNews as $item)
                <div class="py-3 flex items-center justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-900 truncate">{{ $item->title }}</p>
                        <span class="text-[10px] text-slate-400">{{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }} | Unit: {{ strtoupper($item->scope) }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $item->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ $item->status }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-slate-500 py-4 text-center">Belum ada berita yang ditambahkan.</p>
            @endif
        </div>

        <!-- Pengumuman Terbaru -->
        <div class="bg-white rounded-3xl p-6 border border-border-main shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider">Pengumuman Terbaru</h3>
                <a href="{{ route('admin.announcements.index') }}" class="text-xs font-bold text-primary-900 hover:text-accent-gold">Lihat Semua</a>
            </div>

            @if($recentAnnouncements->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($recentAnnouncements as $ann)
                <div class="py-3 flex items-center justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-900 truncate">{{ $ann->title }}</p>
                        <span class="text-[10px] text-slate-400">Prioritas: {{ strtoupper($ann->priority) }} | {{ $ann->published_at ? $ann->published_at->format('d/m/Y') : '-' }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $ann->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ $ann->status }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-slate-500 py-4 text-center">Belum ada pengumuman yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
