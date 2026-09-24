@extends('layouts.app')

@section('title', 'Galeri Foto & Video')
@section('description', 'Dokumentasi visual kegiatan, sarana prasarana, dan prestasi santri Yayasan Dayah Terpadu Ulumul Islam.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-primary-950 text-white py-16 lg:py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-purple-600/20 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-2xl mx-auto space-y-3 scroll-reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-accent-gold">Dokumentasi Multimedia</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Galeri Foto & Video</h1>
            <p class="text-xs sm:text-sm text-primary-100/90 font-medium">
                Koleksi dokumentasi kegiatan belajar mengajar, pembinaan asrama, dan momen berharga pesantren.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Album Grid -->
<section class="py-16 bg-bg-warm min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <!-- Filter Bar: Kategori Lembaga & Tahun -->
        <div class="bg-white p-4 sm:p-6 rounded-3xl border border-border-main shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 scroll-reveal">
            <!-- Filter Kategori / Unit -->
            <div class="flex flex-wrap items-center gap-2">
                @php
                    $unitOptions = [
                        'all' => 'Semua Album',
                        'foundation' => 'Yayasan',
                        'dayah' => 'Dayah Terpadu',
                        'smp' => 'SMP Ulumul Islam',
                        'sma' => 'SMA Ulumul Islam',
                        'ikada' => 'IKADA UI',
                    ];
                @endphp
                @foreach($unitOptions as $val => $label)
                <a href="{{ route('gallery.index', array_merge(request()->query(), ['unit' => $val])) }}"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ ($selectedUnit === $val || (empty($selectedUnit) && $val === 'all')) ? 'bg-primary-900 text-white shadow-md' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <!-- Filter Tahun Dropdown -->
            <div class="flex items-center gap-2 self-end md:self-auto shrink-0">
                <label for="gallery-year-filter" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun:</label>
                <select id="gallery-year-filter" onchange="filterGalleryByYear(this.value)" class="px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 bg-white focus:ring-2 focus:ring-primary-900">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $yr)
                    <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($albums->count() > 0)
        <!-- Grid Album -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($albums as $album)
            <a href="{{ route('gallery.show', $album->slug) }}" class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between scroll-reveal group">
                <div>
                    <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                        @if($album->cover_image)
                        <img src="{{ $album->cover_image }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-primary-950/10 text-primary-900 font-bold text-xs">
                            Album Ulumul Islam
                        </div>
                        @endif

                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-2.5 py-1 rounded-lg bg-primary-950/80 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider">
                                {{ $album->institution->name ?? 'Yayasan' }}
                            </span>
                        </div>

                        <div class="absolute bottom-3 right-3 flex items-center gap-1.5 px-3 py-1 rounded-lg bg-black/60 backdrop-blur-md text-white text-[11px] font-bold">
                            <span>📷 {{ $album->photos->count() }}</span>
                            <span class="text-white/40">|</span>
                            <span>🎥 {{ $album->videos->count() }}</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-2">
                        <h2 class="text-base font-black text-slate-900 leading-snug line-clamp-1 group-hover:text-primary-800 transition-colors">
                            {{ $album->title }}
                        </h2>
                        @if($album->description)
                        <p class="text-xs text-text-sub font-medium line-clamp-2 leading-relaxed">
                            {{ $album->description }}
                        </p>
                        @endif
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 flex items-center justify-between text-xs border-t border-slate-100">
                    <span class="text-slate-400 font-medium">Buka Album</span>
                    <span class="font-bold text-primary-900 group-hover:text-accent-gold transition-colors flex items-center gap-1">
                        Lihat Media &rarr;
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-8">
            {{ $albums->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white rounded-3xl border border-border-main p-8 space-y-3">
            <svg class="w-12 h-12 text-slate-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Album</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">Saat ini belum ada album galeri yang dipublikasikan pada unit ini.</p>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    function filterGalleryByYear(year) {
        const url = new URL(window.location.href);
        if (year) {
            url.searchParams.set('year', year);
        } else {
            url.searchParams.delete('year');
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
</script>
@endpush
@endsection
