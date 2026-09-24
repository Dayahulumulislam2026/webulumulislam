@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page_title', 'Manajemen Pengumuman')
@section('page_subtitle', 'Kelola informasi penting dan banner pengumuman aktif')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h2 class="text-base font-black text-slate-900">Daftar Pengumuman ({{ $announcements->total() }})</h2>
        <button onclick="openModal('add-ann-modal')" class="px-4 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Buat Pengumuman Baru
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-black uppercase tracking-wider border-b border-border-main">
                    <tr>
                        <th class="py-4 px-6">Brosur / Flyer</th>
                        <th class="py-4 px-6">Judul Pengumuman</th>
                        <th class="py-4 px-6">Unit / Sasaran</th>
                        <th class="py-4 px-6">Tanggal Tayang</th>
                        <th class="py-4 px-6">Kedaluwarsa</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($announcements as $ann)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-6 w-24">
                            @if($ann->image_path)
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shadow-xs">
                                <img src="{{ $ann->image_url }}" alt="Flyer" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="w-16 h-16 rounded-xl bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-slate-400 text-[10px] text-center p-1 font-bold">
                                Teks Saja
                            </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-900 text-sm">{{ $ann->title }}</p>
                            <p class="text-[11px] text-slate-400 line-clamp-1 font-normal">{{ $ann->summary }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-900 border border-amber-200">
                                {{ strtoupper($ann->scope) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ $ann->published_at ? $ann->published_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ $ann->expires_at ? $ann->expires_at->format('d/m/Y') : 'Permanen' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ann->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $ann->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <button onclick="openEditAnnModal({{ json_encode($ann) }})" class="p-1.5 rounded-lg text-primary-900 bg-primary-50 hover:bg-primary-100 transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $ann->id) }}" class="inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">Belum ada pengumuman yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-border-main">
            {{ $announcements->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Pengumuman -->
<div id="add-ann-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Buat Pengumuman Baru</h3>
        <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Brosur Resmi Penerimaan Santri Baru TA 2026/2027" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
            </div>

            <!-- Upload Flyer / Brosur -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                <label class="block font-bold text-slate-700">Unggah Gambar Flyer / Brosur (Opsional)</label>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-24 rounded-xl bg-white border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden shrink-0">
                        <img id="add-flyer-preview" src="" alt="Preview Flyer" class="w-full h-full object-cover hidden">
                        <span id="add-flyer-placeholder" class="text-[10px] text-slate-400 text-center font-bold px-1">Pratinjau Flyer</span>
                    </div>
                    <div class="flex-1 space-y-1">
                        <input type="file" name="image" id="add-flyer-input" accept="image/jpeg,image/png,image/webp" class="cropper-auto block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-900 file:text-white hover:file:bg-primary-950 cursor-pointer" data-aspect-ratio="4/5" data-preview="#add-flyer-preview">
                        <p class="text-[10px] text-slate-500">Format: JPG, PNG, WEBP (Maks. 10MB). Didukung pemotong gambar rasio 4:5 / Flyer.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Unit / Sasaran</label>
                    <select name="scope" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="global">Umum (Semua Unit)</option>
                        <option value="foundation">Yayasan</option>
                        <option value="smp">SMP</option>
                        <option value="sma">SMA</option>
                        <option value="dayah">Dayah</option>
                        <option value="ikada">IKADA UI (Alumni)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Publikasi</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="published">Tayang Sekarang</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai Tayang</label>
                    <input type="date" name="published_at" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Berakhir (Opsional)</label>
                    <input type="date" name="expires_at" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Isi / Rincian Pengumuman</label>
                <textarea name="content" rows="4" required placeholder="Tulis isi pengumuman lengkap..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-ann-modal')" class="px-4 py-2.5 rounded-xl text-slate-600 font-bold border border-slate-200 hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold shadow-md hover:shadow-lg transition-all">Simpan & Tayangkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pengumuman -->
<div id="edit-ann-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Pengumuman</h3>
        <form id="edit-ann-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" id="edit-ann-title" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
            </div>

            <!-- Upload & Ganti Flyer / Brosur -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                <label class="block font-bold text-slate-700">Gambar Flyer / Brosur Pengumuman</label>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-24 rounded-xl bg-white border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden shrink-0">
                        <img id="edit-flyer-preview" src="" alt="Preview Flyer" class="w-full h-full object-cover hidden">
                        <span id="edit-flyer-placeholder" class="text-[10px] text-slate-400 text-center font-bold px-1">Tanpa Gambar</span>
                    </div>
                    <div class="flex-1 space-y-1">
                        <input type="file" name="image" id="edit-flyer-input" accept="image/jpeg,image/png,image/webp" class="cropper-auto block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-900 file:text-white hover:file:bg-primary-950 cursor-pointer" data-aspect-ratio="4/5" data-preview="#edit-flyer-preview">
                        <p class="text-[10px] text-slate-500">Pilih gambar baru untuk mengganti gambar saat ini (Maks. 10MB).</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Unit / Sasaran</label>
                    <select id="edit-ann-scope" name="scope" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="global">Umum (Semua Unit)</option>
                        <option value="foundation">Yayasan</option>
                        <option value="smp">SMP</option>
                        <option value="sma">SMA</option>
                        <option value="dayah">Dayah</option>
                        <option value="ikada">IKADA UI (Alumni)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Publikasi</label>
                    <select id="edit-ann-status" name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                        <option value="published">Tayang Sekarang</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Arsipkan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai Tayang</label>
                    <input type="date" id="edit-ann-pub" name="published_at" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Berakhir</label>
                    <input type="date" id="edit-ann-exp" name="expires_at" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Isi Lengkap Pengumuman</label>
                <textarea id="edit-ann-content" name="content" rows="4" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-ann-modal')" class="px-4 py-2.5 rounded-xl text-slate-600 font-bold border border-slate-200 hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold shadow-md hover:shadow-lg transition-all">Perbarui Pengumuman</button>
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

    // Image previews
    const addFlyerInput = document.getElementById('add-flyer-input');
    const addFlyerPreview = document.getElementById('add-flyer-preview');
    const addFlyerPlaceholder = document.getElementById('add-flyer-placeholder');
    if (addFlyerInput && addFlyerPreview) {
        addFlyerInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    addFlyerPreview.src = evt.target.result;
                    addFlyerPreview.classList.remove('hidden');
                    if (addFlyerPlaceholder) addFlyerPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    const editFlyerInput = document.getElementById('edit-flyer-input');
    const editFlyerPreview = document.getElementById('edit-flyer-preview');
    const editFlyerPlaceholder = document.getElementById('edit-flyer-placeholder');
    if (editFlyerInput && editFlyerPreview) {
        editFlyerInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    editFlyerPreview.src = evt.target.result;
                    editFlyerPreview.classList.remove('hidden');
                    if (editFlyerPlaceholder) editFlyerPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    function openEditAnnModal(ann) {
        document.getElementById('edit-ann-form').action = `/admin/pengumuman/${ann.id}`;
        document.getElementById('edit-ann-title').value = ann.title;
        document.getElementById('edit-ann-scope').value = ann.scope;
        document.getElementById('edit-ann-status').value = ann.status;
        document.getElementById('edit-ann-pub').value = ann.published_at ? ann.published_at.substring(0, 10) : '';
        document.getElementById('edit-ann-exp').value = ann.expires_at ? ann.expires_at.substring(0, 10) : '';
        document.getElementById('edit-ann-content').value = ann.content;

        if (ann.image_path) {
            editFlyerPreview.src = ann.image_url || ann.image_path;
            editFlyerPreview.classList.remove('hidden');
            if (editFlyerPlaceholder) editFlyerPlaceholder.classList.add('hidden');
        } else {
            editFlyerPreview.src = '';
            editFlyerPreview.classList.add('hidden');
            if (editFlyerPlaceholder) editFlyerPlaceholder.classList.remove('hidden');
        }

        openModal('edit-ann-modal');
    }
</script>
@endpush
@endsection
