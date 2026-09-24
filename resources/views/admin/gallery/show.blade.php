@extends('layouts.admin')

@section('title', 'Kelola Media - ' . $album->title)
@section('page_title', 'Kelola Media Album')
@section('page_subtitle', $album->title)

@section('content')
<div class="space-y-8">
    <!-- Album Header Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-border-main shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-900 text-[10px] font-black uppercase tracking-wider border border-primary-100">
                    {{ $album->institution->name ?? 'Yayasan' }}
                </span>
                <span class="text-xs text-slate-400 font-medium">📷 {{ $album->photos->count() }} Foto &bull; 🎥 {{ $album->videos->count() }} Video</span>
            </div>
            <h2 class="text-xl font-black text-slate-900">{{ $album->title }}</h2>
            <p class="text-xs text-slate-500 max-w-2xl">{{ $album->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('gallery.show', $album->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-primary-900 bg-primary-50 hover:bg-primary-100 transition-colors border border-primary-200">
                Lihat di Web
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 rounded-xl border border-border-main text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                &larr; Kembali ke Daftar Album
            </a>
        </div>
    </div>

    <!-- Upload Media Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-border-main shadow-xs space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider">Unggah Foto atau Video Baru</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Mendukung unggah video beresolusi tinggi hingga <strong>150MB</strong> dan foto hingga <strong>10MB</strong>.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.gallery.media.upload', $album->id) }}" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Media</label>
                    <select id="upload-media-type" name="type" required onchange="handleTypeChange(this.value)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="image">📷 Foto / Gambar (Maks. 10MB)</option>
                        <option value="video">🎥 Video Dokumentasi (Maks. 150MB)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Media (Opsional)</label>
                    <input type="text" name="title" placeholder="Contoh: Sambutan Pembukaan..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Berkas</label>
                    <input id="media-file-input" type="file" name="file" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-900 file:font-bold">
                    <p id="file-size-hint" class="text-[10px] text-slate-400 mt-1 font-medium"></p>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Keterangan Media (Opsional)</label>
                <textarea name="description" rows="2" placeholder="Keterangan singkat momen ini..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800"></textarea>
            </div>

            <div class="pt-2 flex items-center justify-between">
                <span id="upload-status-text" class="text-xs font-semibold text-slate-500 hidden">
                    ⏳ Sedang mengunggah berkas, mohon tunggu...
                </span>
                <button id="upload-submit-btn" type="submit" class="ml-auto px-6 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Unggah Media ke Album</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Media Items in Album -->
    <div class="space-y-8">
        <!-- Section 1: Photos -->
        <div class="space-y-4">
            <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span>📷 Daftar Foto ({{ $album->photos->count() }})</span>
            </h3>

            @if($album->photos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($album->photos as $photo)
                <div class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="aspect-video bg-slate-100 relative overflow-hidden">
                            <img src="{{ $photo->file_url }}" alt="{{ $photo->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <h4 class="font-bold text-xs text-slate-900 line-clamp-1">{{ $photo->title ?: 'Foto Dokumentasi' }}</h4>
                            <p class="text-[11px] text-slate-500 line-clamp-2">{{ $photo->description ?: 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] text-slate-400">{{ $photo->file_size_formatted }}</span>
                        <div class="flex items-center gap-1">
                            <button onclick="openEditMediaModal({{ json_encode($photo) }})" class="p-1 rounded text-slate-500 hover:text-slate-900" title="Edit Judul & Deskripsi">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.gallery.media.destroy', $photo->id) }}" class="inline" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded text-red-500 hover:text-red-700" title="Hapus Foto">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-slate-400 italic bg-white p-6 rounded-2xl border border-border-main text-center">Belum ada foto yang diunggah.</p>
            @endif
        </div>

        <!-- Section 2: Videos -->
        <div class="space-y-4">
            <h3 class="font-black text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span>🎥 Daftar Video Dokumentasi ({{ $album->videos->count() }})</span>
            </h3>

            @if($album->videos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($album->videos as $video)
                <div class="bg-white rounded-3xl p-5 border border-border-main shadow-xs space-y-4">
                    <div class="aspect-video bg-black rounded-2xl overflow-hidden">
                        <video controls preload="metadata" class="w-full h-full object-cover">
                            <source src="{{ $video->file_url }}">
                        </video>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-xs text-slate-900">{{ $video->title ?: 'Video Dokumentasi' }}</h4>
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold">
                                {{ $video->file_size_formatted }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">{{ $video->description ?: 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                        <button onclick="openEditMediaModal({{ json_encode($video) }})" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 text-xs font-bold">
                            Edit Judul / Deskripsi
                        </button>
                        <form method="POST" action="{{ route('admin.gallery.media.destroy', $video->id) }}" class="inline" onsubmit="return confirm('Hapus video ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-red-600 hover:bg-red-50 text-xs font-bold">
                                Hapus Video
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-slate-400 italic bg-white p-6 rounded-2xl border border-border-main text-center">Belum ada video yang diunggah.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Edit Media (Judul & Deskripsi) -->
<div id="edit-media-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Info Media</h3>
        <form id="edit-media-form" method="POST" action="" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Media</label>
                <input type="text" id="edit-media-title" name="title" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi / Keterangan</label>
                <textarea id="edit-media-desc" name="description" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-media-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function handleTypeChange(val) {
        const input = document.getElementById('media-file-input');
        const hint = document.getElementById('file-size-hint');
        hint.textContent = '';
        if (val === 'video') {
            input.accept = 'video/*, .mp4, .mov, .avi, .webm, .mkv, .3gp, .wmv, .flv, .m4v, .ts, .ogg, .ogv, .mpeg, .mpg, .vob';
        } else {
            input.accept = 'image/jpeg,image/png,image/webp,image/svg+xml,image/*';
        }
    }

    const fileInput = document.getElementById('media-file-input');
    const sizeHint = document.getElementById('file-size-hint');
    const uploadForm = fileInput ? fileInput.closest('form') : null;

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                sizeHint.textContent = '';
                return;
            }

            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            const type = document.getElementById('upload-media-type').value;
            const maxMB = type === 'video' ? 150 : 10;

            if (file.size > maxMB * 1024 * 1024) {
                sizeHint.innerHTML = `<span class="text-red-600 font-bold">⚠️ Ukuran berkas (${sizeMB} MB) melebihi batas maksimum ${maxMB} MB!</span>`;
                alert(`Ukuran berkas (${sizeMB} MB) melebihi batas maksimal ${maxMB} MB. Silakan pilih berkas yang lebih kecil.`);
                fileInput.value = '';
            } else {
                sizeHint.innerHTML = `<span class="text-emerald-700 font-medium">✓ Berkas dipilih: ${file.name} (${sizeMB} MB)</span>`;
            }
        });
    }

    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            const btn = document.getElementById('upload-submit-btn');
            const status = document.getElementById('upload-status-text');
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            }
            if (status) {
                status.classList.remove('hidden');
            }
        });
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    function openEditMediaModal(media) {
        document.getElementById('edit-media-form').action = `/admin/galeri/media/${media.id}`;
        document.getElementById('edit-media-title').value = media.title || '';
        document.getElementById('edit-media-desc').value = media.description || '';
        openModal('edit-media-modal');
    }
</script>
@endpush
@endsection
