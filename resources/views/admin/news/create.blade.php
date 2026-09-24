@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')
@section('page_title', 'Tulis Berita Baru')
@section('page_subtitle', 'Publikasikan warta, artikel, atau kegiatan lembaga')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-3xl border border-border-main shadow-xs p-6 sm:p-10 space-y-6">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-6 text-xs font-medium">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Berita</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Pembukaan Masa Orientasi Santri Baru Tahun Ajaran..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori / Unit Terkait</label>
                    <select name="scope" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="global">Umum / Semua Unit</option>
                        <option value="foundation">Yayasan</option>
                        <option value="smp">SMP Ulumul Islam</option>
                        <option value="sma">SMA Ulumul Islam</option>
                        <option value="dayah">Dayah Terpadu</option>
                        <option value="ikada">IKADA UI (Alumni)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="published">Tayang Sekarang (Published)</option>
                        <option value="draft">Simpan Draft</option>
                        <option value="archived">Arsipkan</option>
                    </select>
                </div>
            </div>

            <!-- Featured Image with Cropper -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider">Gambar Sampul Utama (Featured Image)</label>
                    <span class="text-[10px] text-accent-gold font-bold uppercase">Rasio Ideal: 16:9 • Didukung Pemotong Gambar</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div id="create-thumb-preview-box" class="hidden rounded-xl overflow-hidden max-h-48 border border-slate-300">
                        <img id="create-thumb-preview" src="" alt="Preview Sampul" class="w-full h-48 object-cover">
                    </div>
                    <input type="file" name="thumbnail" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-primary-900 file:text-white file:font-bold hover:file:bg-primary-950 transition-all cursor-pointer" data-aspect-ratio="16/9" data-preview="#create-thumb-preview">
                </div>
            </div>

            <!-- Multi-Image Gallery (Foto Dokumentasi Pendukung) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider">Foto Tambahan / Galeri Dokumentasi Berita (Maks. 5 Foto)</label>
                    <span class="text-[10px] text-slate-400 font-bold">Format: JPG, PNG, WEBP (Maks 5MB/foto)</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <input type="file" id="news-gallery-input" name="gallery_images[]" accept="image/*" multiple class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-700 file:text-white file:font-bold hover:file:bg-emerald-800 transition-all cursor-pointer" onchange="previewGalleryImages(this)">
                    <div id="gallery-preview-container" class="grid grid-cols-2 sm:grid-cols-5 gap-3 hidden pt-2"></div>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Singkat (Excerpt)</label>
                <textarea name="excerpt" rows="2" placeholder="Ringkasan 1-2 kalimat untuk preview di kartu berita..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Konten Berita Lengkap</label>
                <textarea name="content" rows="12" required placeholder="Tulis isi berita lengkap di sini..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 leading-relaxed font-sans text-xs">{{ old('content') }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-bold uppercase tracking-wider">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all">
                    Simpan & Publikasikan Berita
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewGalleryImages(input) {
        const container = document.getElementById('gallery-preview-container');
        container.innerHTML = '';
        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            const files = Array.from(input.files).slice(0, 5);
            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative rounded-xl overflow-hidden border border-slate-300 h-24 bg-slate-200 group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-black/60 text-white text-[9px] font-bold">#${idx + 1}</span>
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
