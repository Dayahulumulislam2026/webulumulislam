@extends('layouts.app')

@section('title', 'Berita & Informasi')
@section('description', 'Warta, Kegiatan, Prestasi, dan Informasi Terbaru Yayasan dan Dayah Terpadu Ulumul Islam.')

@section('content')
<!-- Header Banner -->
<section class="relative bg-primary-950 text-white py-14 lg:py-18 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-blue-600/20 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-2xl mx-auto space-y-3 scroll-reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-accent-gold">Warta & Publikasi</span>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Berita & Informasi</h1>
            <p class="text-xs sm:text-sm text-primary-100/90 font-medium">
                Ikuti perkembangan terkini seputar kegiatan belajar mengajar, prestasi santri, dan pengumuman resmi.
            </p>
        </div>
    </div>
</section>

<!-- Mini Kontainer Pengumuman (Max 10 Items, Berjejer 5 & Bisa Digeser) -->
@if(isset($announcements) && $announcements->count() > 0)
<section class="bg-gradient-to-r from-amber-500/10 via-primary-900/5 to-amber-500/10 border-b border-amber-500/20 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 mb-3">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-accent-gold animate-ping"></span>
                <span class="text-xs font-black uppercase tracking-wider text-accent-gold">Pengumuman & Pemberitahuan</span>
            </div>
            <span class="text-[11px] text-slate-500 font-medium hidden sm:inline">Geser & klik untuk rincian pengumuman</span>
        </div>

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
                    <span>Lihat Rincian</span>
                    <span>&rarr;</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Filter & News Grid -->
<section class="py-14 bg-bg-warm min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <!-- Filter Bar: Kategori Lembaga & Tahun -->
        <div class="bg-white p-4 sm:p-6 rounded-3xl border border-border-main shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 scroll-reveal">
            <!-- Filter Kategori / Unit -->
            <div class="flex flex-wrap items-center gap-2">
                @php
                    $unitOptions = [
                        'all' => 'Semua Berita',
                        'foundation' => 'Yayasan',
                        'dayah' => 'Dayah Terpadu',
                        'smp' => 'SMP Ulumul Islam',
                        'sma' => 'SMA Ulumul Islam',
                        'ikada' => 'IKADA UI',
                    ];
                @endphp
                @foreach($unitOptions as $val => $label)
                <a href="{{ route('news.index', array_merge(request()->query(), ['unit' => $val])) }}"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ ($selectedUnit === $val || (empty($selectedUnit) && $val === 'all')) ? 'bg-primary-900 text-white shadow-md' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <!-- Filter Tahun Dropdown -->
            <div class="flex items-center gap-2 self-end md:self-auto shrink-0">
                <label for="news-year-filter" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun:</label>
                <select id="news-year-filter" onchange="filterNewsByYear(this.value)" class="px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 bg-white focus:ring-2 focus:ring-primary-900">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $yr)
                    <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($news->count() > 0)
        <!-- Grid Berita (Kotak Persegi Panjang Vertikal yang Elegan) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($news as $item)
            <article class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between scroll-reveal group hover:-translate-y-1">
                <div>
                    <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                        @if($item->cover_image || $item->featured_image)
                        <img src="{{ $item->cover_image ?: $item->featured_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-primary-950/10 text-primary-900 font-bold text-xs">
                            Ulumul Islam News
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

        <!-- Pagination -->
        <div class="pt-8">
            {{ $news->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white rounded-3xl border border-border-main p-8 space-y-3">
            <svg class="w-12 h-12 text-slate-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Berita</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">Tidak ditemukan artikel berita pada kategori atau tahun yang dipilih.</p>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    function filterNewsByYear(year) {
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
