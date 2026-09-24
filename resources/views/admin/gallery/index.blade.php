@extends('layouts.admin')

@section('title', 'Galeri (Foto & Video)')
@section('page_title', 'Manajemen Galeri')
@section('page_subtitle', 'Kelola album foto dan dokumentasi video (hingga 150MB)')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h2 class="text-base font-black text-slate-900">Daftar Album Galeri ({{ $albums->count() }})</h2>
        <button onclick="openModal('add-album-modal')" class="px-4 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Buat Album Baru
        </button>
    </div>

    <!-- Album Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($albums as $album)
        <div class="bg-white rounded-3xl overflow-hidden border border-border-main shadow-xs flex flex-col justify-between">
            <div>
                <div class="aspect-video w-full bg-slate-100 relative overflow-hidden">
                    @if($album->cover_path)
                    <img src="{{ $album->cover_path }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-primary-950/10 text-primary-900 font-bold text-xs">
                        Album Ulumul Islam
                    </div>
                    @endif

                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 rounded-lg bg-primary-950/80 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider">
                            {{ $album->institution->name ?? 'Yayasan' }}
                        </span>
                    </div>

                    <div class="absolute bottom-3 right-3 flex items-center gap-1.5 px-3 py-1 rounded-lg bg-black/70 backdrop-blur-md text-white text-[11px] font-bold">
                        <span>📷 {{ $album->photos->count() }}</span>
                        <span class="text-white/40">|</span>
                        <span>🎥 {{ $album->videos->count() }}</span>
                    </div>
                </div>

                <div class="p-5 space-y-2">
                    <h3 class="font-bold text-sm text-slate-900 line-clamp-1">{{ $album->title }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">{{ $album->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            <div class="p-5 pt-0 flex items-center justify-between gap-2 border-t border-slate-100 pt-4">
                <a href="{{ route('admin.gallery.show', $album->id) }}" class="px-4 py-2 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-colors">
                    Kelola Media &rarr;
                </a>
                <div class="flex items-center gap-1">
                    <button onclick="openEditAlbumModal({{ json_encode($album) }})" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100" title="Edit Album">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.gallery.albums.destroy', $album->id) }}" class="inline" onsubmit="return confirm('Hapus album ini beserta seluruh foto & videonya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-red-500 hover:bg-red-50" title="Hapus Album">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-border-main p-8 space-y-2">
            <p class="text-xs font-bold text-slate-600">Belum ada album galeri yang dibuat. Klik "+ Buat Album Baru" di atas.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Album -->
<div id="add-album-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Buat Album Galeri Baru</h3>
        <form method="POST" action="{{ route('admin.gallery.albums.store') }}" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Album</label>
                <input type="text" name="title" required placeholder="Contoh: Kegiatan Muhadharah Akbar Santri..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Unit Lembaga</label>
                <select name="institution_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                    <option value="">Yayasan / Umum</option>
                    @foreach($institutions as $inst)
                    <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Album</label>
                <textarea name="description" rows="3" placeholder="Keterangan singkat mengenai album kegiatan ini..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Gambar Sampul Album (Opsional)</label>
                <input type="file" name="cover" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="16/9">
                <span class="text-[9px] text-slate-400">Rasio 16:9 • Didukung Pemotong Gambar</span>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-album-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Simpan Album</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Album -->
<div id="edit-album-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Album Galeri</h3>
        <form id="edit-album-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Album</label>
                <input type="text" id="edit-album-title" name="title" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Unit Lembaga</label>
                <select id="edit-album-inst" name="institution_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                    <option value="">Yayasan / Umum</option>
                    @foreach($institutions as $inst)
                    <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Deskripsi Album</label>
                <textarea id="edit-album-desc" name="description" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Ganti Sampul (Opsional)</label>
                <input type="file" name="cover" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="16/9">
                <span class="text-[9px] text-slate-400">Rasio 16:9 • Didukung Pemotong Gambar</span>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-album-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    function openEditAlbumModal(album) {
        document.getElementById('edit-album-form').action = `/admin/galeri/album/${album.id}`;
        document.getElementById('edit-album-title').value = album.title;
        document.getElementById('edit-album-inst').value = album.institution_id || '';
        document.getElementById('edit-album-desc').value = album.description || '';
        openModal('edit-album-modal');
    }
</script>
@endpush
@endsection
