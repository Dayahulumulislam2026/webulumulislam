@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->excerpt ?: Str::limit(strip_tags($article->content), 150))
@section('og_image', $article->thumbnail_url ? asset($article->thumbnail_url) : asset('logo.png'))
@section('og_type', 'article')

@section('content')
<article class="py-12 bg-bg-warm min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-primary-900">Beranda</a>
            <span>/</span>
            <a href="{{ route('news.index') }}" class="hover:text-primary-900">Berita</a>
            <span>/</span>
            <span class="text-slate-900 font-bold truncate max-w-xs">{{ $article->title }}</span>
        </nav>

        <!-- Article Container -->
        <div class="bg-white p-6 sm:p-10 rounded-3xl border border-border-main shadow-xs space-y-6">
            <!-- Article Header -->
            <header class="space-y-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-900 border border-primary-100 text-[10px] font-black uppercase tracking-wider">
                        {{ $article->institution_badge }}
                    </span>
                    <span class="text-xs text-text-sub font-medium">
                        {{ $article->published_at ? $article->published_at->translatedFormat('l, d F Y') : '' }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center gap-3 pt-3 border-t border-slate-100 text-xs text-slate-600">
                    <div class="w-8 h-8 rounded-full bg-primary-900 text-white font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr($article->author_name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $article->author_name ?? 'Admin Ulumul Islam' }}</p>
                        <span class="text-[11px] text-slate-400">Kontributor Warta Ulumul Islam</span>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($article->featured_image)
                <div class="pt-4 overflow-hidden rounded-2xl">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full max-h-[500px] object-cover rounded-2xl shadow-sm cursor-pointer hover:opacity-95 transition-opacity" onclick="openLightbox('{{ $article->featured_image }}', '{{ $article->title }}')">
                </div>
                @endif
            </header>

            <!-- Article Body Content -->
            <div class="prose max-w-none text-slate-800 text-sm leading-relaxed space-y-4 font-medium whitespace-pre-line border-t border-slate-100 pt-6">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Galeri Foto Pendukung Berita (Jika Ada) -->
            @if(is_array($article->gallery_images) && count($article->gallery_images) > 0)
            <div class="pt-6 border-t border-slate-100 space-y-3">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">Galeri Foto Dokumentasi Terkait</h3>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($article->gallery_images as $idx => $img)
                    <div class="relative rounded-2xl overflow-hidden group aspect-4/3 bg-slate-100 border border-slate-200 cursor-pointer shadow-xs hover:shadow-md transition-all" onclick="openLightbox('{{ $img }}', 'Foto Dokumentasi #{{ $idx + 1 }}')">
                        <img src="{{ $img }}" alt="Foto Dokumentasi {{ $idx + 1 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="p-2 rounded-full bg-white/80 text-slate-900 shadow-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Social Media Share Bar -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-slate-50 p-4 sm:p-5 rounded-2xl">
                <div>
                    <span class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Bagikan Berita Ini:</span>
                    <p class="text-[11px] text-slate-500 font-medium">Sebarkan informasi positif ke keluarga & kerabat</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    @php
                        $shareUrl = urlencode(url()->current());
                        $shareTitle = urlencode($article->title . ' - Ulumul Islam');
                    @endphp
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%0A{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-xs">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.08-.117-.162-.252-.224-.15-.075-.875-.43-1.012-.482-.137-.052-.236-.08-.335.08-.098.158-.383.48-.47.58-.086.1-.173.111-.322.036-.15-.075-.628-.23-1.198-.737-.442-.392-.74-875-.826-1.025-.087-.15-.01-.23.065-.304.068-.067.15-.175.224-.263.076-.087.1-.15.15-.25.05-.1.026-.188-.013-.263-.038-.075-.335-.805-.46-1.103-.122-.294-.246-.254-.337-.258-.088-.004-.19-.004-.29-.004-.1 0-.263.037-.4.188-.138.15-.525.513-.525 1.25s.537 1.45.612 1.55c.075.1 1.057 1.613 2.562 2.26 1.157.498 1.636.577 2.224.488.3-.045.923-.377 1.053-.74.13-.364.13-.676.09-.74zM12 2C6.477 2 2 6.477 2 12c0 2.01.597 3.885 1.62 5.46L2.05 22.05l4.74-1.25c1.517.86 3.256 1.35 5.21 1.35 5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        WA
                    </a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-xs">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <!-- X / Twitter -->
                    <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-xs">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        X
                    </a>
                    <!-- Copy Link -->
                    <button type="button" onclick="copyNewsLink()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-200 text-slate-800 font-bold text-xs uppercase tracking-wider border border-slate-300 transition-colors shadow-xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Salin Tautan
                    </button>
                </div>
            </div>
        </div>

        <!-- Related News -->
        @if($relatedNews->count() > 0)
        <div class="space-y-6 pt-4">
            <h3 class="text-lg font-black text-primary-950">Berita Terkait Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedNews as $rel)
                <a href="{{ route('news.show', $rel->slug) }}" class="bg-white p-5 rounded-2xl border border-border-main shadow-xs hover:shadow-md transition-all space-y-2 block">
                    <span class="text-[10px] font-bold text-accent-gold uppercase tracking-wider">
                        {{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : '' }}
                    </span>
                    <h4 class="font-bold text-xs text-slate-900 line-clamp-2 leading-snug">{{ $rel->title }}</h4>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="pt-4 text-center">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider border border-border-main transition-colors shadow-xs">
                &larr; Kembali ke Semua Berita
            </a>
        </div>
    </div>
</article>

<!-- Lightbox Modal Foto -->
<div id="image-lightbox-modal" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center p-4 backdrop-blur-xs" onclick="closeLightbox()">
    <div class="max-w-4xl max-h-[90vh] flex flex-col items-center gap-3" onclick="event.stopPropagation()">
        <div class="w-full flex justify-between items-center text-white px-2">
            <span id="lightbox-caption" class="text-xs font-bold truncate"></span>
            <button type="button" onclick="closeLightbox()" class="p-1 rounded-lg hover:bg-white/20 text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
    </div>
</div>

<!-- Toast Notification Salin Link -->
<div id="copy-toast" class="fixed bottom-6 right-6 z-50 bg-primary-950 text-white px-5 py-3 rounded-2xl shadow-2xl border border-primary-800 text-xs font-bold flex items-center gap-3 transition-transform duration-300 transform translate-y-32">
    <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <span>Tautan berita berhasil disalin ke papan klip!</span>
</div>

@push('scripts')
<script>
    function openLightbox(src, caption) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-caption').textContent = caption || '';
        const modal = document.getElementById('image-lightbox-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeLightbox() {
        const modal = document.getElementById('image-lightbox-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function copyNewsLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const toast = document.getElementById('copy-toast');
            toast.classList.remove('translate-y-32');
            setTimeout(() => {
                toast.classList.add('translate-y-32');
            }, 2500);
        });
    }
</script>
@endpush
@endsection

