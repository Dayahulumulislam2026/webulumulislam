@extends('layouts.app')

@section('title', $album->title . ' - Galeri')
@section('description', $album->description ?? 'Dokumentasi Album ' . $album->title)

@section('content')
<section class="py-12 bg-bg-warm min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-primary-900">Beranda</a>
            <span>/</span>
            <a href="{{ route('gallery.index') }}" class="hover:text-primary-900">Galeri</a>
            <span>/</span>
            <span class="text-slate-900 font-bold truncate max-w-xs">{{ $album->title }}</span>
        </nav>

        <!-- Album Header Card -->
        <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-main shadow-xs space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="space-y-2">
                    <span class="px-3 py-1 rounded-full bg-primary-100 text-primary-900 text-[10px] font-black uppercase tracking-wider">
                        {{ $album->institution->name ?? 'Yayasan' }}
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900">{{ $album->title }}</h1>
                </div>
                <a href="{{ route('gallery.index') }}" class="px-4 py-2 rounded-xl border border-border-main text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                    &larr; Semua Album
                </a>
            </div>

            @if($album->description)
            <p class="text-xs sm:text-sm text-text-sub font-medium leading-relaxed max-w-3xl">
                {{ $album->description }}
            </p>
            @endif

            <!-- Tab Switcher (Foto & Video Terpisah Sesuai Permintaan) -->
            <div class="pt-6 border-t border-slate-100 flex items-center gap-3">
                <button id="tab-btn-photos" onclick="switchTab('photos')" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-primary-900 text-white shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Foto ({{ $photos->count() }})
                </button>
                <button id="tab-btn-videos" onclick="switchTab('videos')" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-white text-slate-700 hover:bg-slate-100 border border-border-main flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Video Dokumentasi ({{ $videos->count() }})
                </button>
            </div>
        </div>

        <!-- TAB CONTENT 1: FOTO -->
        <div id="tab-content-photos" class="space-y-6">
            @if($photos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($photos as $photo)
                <div class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-xs group cursor-pointer" onclick="openLightbox('{{ $photo->file_url }}', '{{ addslashes($photo->title ?? '') }}', '{{ addslashes($photo->description ?? '') }}')">
                    <div class="aspect-video bg-slate-100 overflow-hidden relative">
                        <img src="{{ $photo->file_url }}" alt="{{ $photo->title ?? $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="p-3 bg-white/90 rounded-full text-slate-900 shadow-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </span>
                        </div>
                    </div>
                    @if($photo->title || $photo->description)
                    <div class="p-4 space-y-1">
                        @if($photo->title)
                        <h3 class="font-bold text-xs text-slate-900 line-clamp-1">{{ $photo->title }}</h3>
                        @endif
                        @if($photo->description)
                        <p class="text-[11px] text-text-sub font-medium line-clamp-2 leading-relaxed">{{ $photo->description }}</p>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white rounded-3xl border border-border-main p-8 space-y-2">
                <p class="text-xs font-bold text-slate-600">Belum ada foto di dalam album ini.</p>
            </div>
            @endif
        </div>

        <!-- TAB CONTENT 2: VIDEO -->
        <div id="tab-content-videos" class="hidden space-y-6">
            @if($videos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($videos as $video)
                <div class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-md space-y-4 p-5">
                    <div class="aspect-video bg-black rounded-2xl overflow-hidden relative shadow-inner">
                        <video controls preload="metadata" class="w-full h-full object-cover">
                            <source src="{{ $video->file_url }}" type="{{ $video->mime_type ?? 'video/mp4' }}">
                            Browser Anda tidak mendukung pemutar video HTML5.
                        </video>
                    </div>
                    <div class="space-y-1.5 px-1">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-black text-sm text-slate-900">{{ $video->title ?? 'Video Dokumentasi' }}</h3>
                            @if($video->file_size_formatted)
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold">
                                {{ $video->file_size_formatted }}
                            </span>
                            @endif
                        </div>
                        @if($video->description)
                        <p class="text-xs text-text-sub font-medium leading-relaxed">{{ $video->description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white rounded-3xl border border-border-main p-8 space-y-2">
                <p class="text-xs font-bold text-slate-600">Belum ada video dokumentasi di dalam album ini.</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Image Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 z-[100] bg-black/90 hidden items-center justify-center p-4 backdrop-blur-sm" onclick="closeLightbox()">
    <div class="relative max-w-5xl w-full bg-transparent text-white space-y-4" onclick="event.stopPropagation()">
        <button onclick="closeLightbox()" class="absolute -top-10 right-0 text-white/80 hover:text-white p-2 text-2xl font-bold">
            &times;
        </button>
        <div class="rounded-2xl overflow-hidden max-h-[75vh] flex items-center justify-center bg-black/40">
            <img id="lightbox-img" src="" alt="" class="max-h-[75vh] w-auto max-w-full object-contain mx-auto rounded-2xl">
        </div>
        <div class="bg-primary-950/90 backdrop-blur-md p-4 rounded-2xl border border-white/10 space-y-1 text-center">
            <h4 id="lightbox-title" class="font-bold text-sm text-white"></h4>
            <p id="lightbox-desc" class="text-xs text-primary-200/90"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tab) {
        const photosTab = document.getElementById('tab-content-photos');
        const videosTab = document.getElementById('tab-content-videos');
        const btnPhotos = document.getElementById('tab-btn-photos');
        const btnVideos = document.getElementById('tab-btn-videos');

        if (tab === 'photos') {
            photosTab.classList.remove('hidden');
            videosTab.classList.add('hidden');
            btnPhotos.className = "px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-primary-900 text-white shadow-md flex items-center gap-2";
            btnVideos.className = "px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-white text-slate-700 hover:bg-slate-100 border border-border-main flex items-center gap-2";
        } else {
            photosTab.classList.add('hidden');
            videosTab.classList.remove('hidden');
            btnVideos.className = "px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-primary-900 text-white shadow-md flex items-center gap-2";
            btnPhotos.className = "px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all bg-white text-slate-700 hover:bg-slate-100 border border-border-main flex items-center gap-2";
        }
    }

    function openLightbox(url, title, desc) {
        document.getElementById('lightbox-img').src = url;
        document.getElementById('lightbox-title').textContent = title || '';
        document.getElementById('lightbox-desc').textContent = desc || '';
        document.getElementById('lightbox-modal').classList.remove('hidden');
        document.getElementById('lightbox-modal').classList.add('flex');
    }

    function closeLightbox() {
        document.getElementById('lightbox-modal').classList.add('hidden');
        document.getElementById('lightbox-modal').classList.remove('flex');
    }
</script>
@endpush
@endsection
