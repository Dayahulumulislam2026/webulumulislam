@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita & Artikel')
@section('page_subtitle', 'Perbarui konten warta atau informasi berita')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-3xl border border-border-main shadow-xs p-6 sm:p-10 space-y-6">
        <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data" class="space-y-6 text-xs font-medium">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Berita</label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori / Unit Terkait</label>
                    <select name="scope" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="global" {{ $news->scope === 'global' ? 'selected' : '' }}>Umum / Semua Unit</option>
                        <option value="foundation" {{ $news->scope === 'foundation' ? 'selected' : '' }}>Yayasan</option>
                        <option value="smp" {{ $news->scope === 'smp' ? 'selected' : '' }}>SMP Ulumul Islam</option>
                        <option value="sma" {{ $news->scope === 'sma' ? 'selected' : '' }}>SMA Ulumul Islam</option>
                        <option value="dayah" {{ $news->scope === 'dayah' ? 'selected' : '' }}>Dayah Terpadu</option>
                        <option value="ikada" {{ $news->scope === 'ikada' ? 'selected' : '' }}>IKADA UI (Alumni)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="published" {{ $news->status === 'published' ? 'selected' : '' }}>Tayang (Published)</option>
                        <option value="draft" {{ $news->status === 'draft' ? 'selected' : '' }}>Simpan Draft</option>
                        <option value="archived" {{ $news->status === 'archived' ? 'selected' : '' }}>Arsipkan</option>
                    </select>
                </div>
            </div>

            <!-- Featured Image with Cropper -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider">Gambar Sampul Utama (Featured Image)</label>
                    <span class="text-[10px] text-accent-gold font-bold uppercase">Rasio 16:9 • Didukung Pemotong Gambar</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    @if($news->thumbnail_path)
                    <div class="flex items-center gap-4 p-2 rounded-xl bg-white border border-slate-200">
                        <img id="edit-thumb-preview" src="{{ $news->thumbnail_path }}" alt="Sampul Berita" class="w-28 h-16 rounded-lg object-cover border border-slate-300">
                        <div>
                            <p class="text-xs font-bold text-slate-800">Gambar Sampul Saat Ini</p>
                            <span class="text-[11px] text-slate-400">Pilih file baru di bawah jika ingin mengganti dan memotong ulang.</span>
                        </div>
                    </div>
                    @else
                    <div id="edit-thumb-preview-box" class="hidden rounded-xl overflow-hidden max-h-48 border border-slate-300">
                        <img id="edit-thumb-preview" src="" alt="Preview Sampul" class="w-full h-48 object-cover">
                    </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-primary-900 file:text-white file:font-bold hover:file:bg-primary-950 transition-all cursor-pointer" data-aspect-ratio="16/9" data-preview="#edit-thumb-preview">
                </div>
            </div>

            <!-- Multi-Image Gallery Management -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider">Foto Tambahan / Galeri Dokumentasi (Maks. 5 Foto)</label>
                    <span class="text-[10px] text-slate-400 font-bold">Kelola dokumentasi pendukung</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                    @if(is_array($news->gallery_images) && count($news->gallery_images) > 0)
                    <div>
                        <span class="block text-[11px] font-bold text-slate-600 mb-2">Foto Dokumentasi Tersimpan (Centang untuk Menghapus):</span>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            @foreach($news->gallery_images as $idx => $imgPath)
                            <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-white p-1.5 shadow-xs space-y-1.5">
                                <img src="{{ $imgPath }}" alt="Dokumentasi {{ $idx + 1 }}" class="w-full h-20 object-cover rounded-lg">
                                <label class="flex items-center justify-center gap-1.5 text-[10px] font-bold text-red-600 cursor-pointer hover:text-red-800">
                                    <input type="checkbox" name="remove_gallery_images[]" value="{{ $imgPath }}" class="rounded text-red-600 focus:ring-red-500">
                                    Hapus
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @php
                        $currentCount = is_array($news->gallery_images) ? count($news->gallery_images) : 0;
                        $availableSlots = max(0, 5 - $currentCount);
                    @endphp

                    @if($availableSlots > 0)
                    <div class="space-y-2 pt-2 {{ $currentCount > 0 ? 'border-t border-slate-200' : '' }}">
                        <span class="block text-[11px] font-bold text-slate-700">Tambah Foto Dokumentasi Baru (Tersedia {{ $availableSlots }} Slot):</span>
                        <input type="file" id="news-gallery-input" name="gallery_images[]" accept="image/*" multiple class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-700 file:text-white file:font-bold hover:file:bg-emerald-800 transition-all cursor-pointer" onchange="previewGalleryImages(this, {{ $availableSlots }})">
                        <div id="gallery-preview-container" class="grid grid-cols-2 sm:grid-cols-5 gap-3 hidden pt-2"></div>
                    </div>
                    @else
                    <p class="text-xs text-amber-700 font-bold bg-amber-50 p-2.5 rounded-xl border border-amber-200">
                        Galeri sudah mencapai batas maksimum (5 foto). Hapus foto lama di atas jika ingin mengunggah foto pengganti.
                    </p>
                    @endif
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Singkat (Excerpt)</label>
                <textarea name="excerpt" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('excerpt', $news->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Konten Berita Lengkap</label>
                <textarea name="content" rows="12" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 leading-relaxed font-sans text-xs">{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-bold uppercase tracking-wider">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all">
                    Perbarui Berita
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewGalleryImages(input, maxSlots) {
        const container = document.getElementById('gallery-preview-container');
        container.innerHTML = '';
        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            const files = Array.from(input.files).slice(0, maxSlots);
            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative rounded-xl overflow-hidden border border-slate-300 h-24 bg-slate-200 group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-black/60 text-white text-[9px] font-bold">Baru #${idx + 1}</span>
                    `;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush

@endsection
