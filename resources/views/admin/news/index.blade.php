@extends('layouts.admin')

@section('title', 'Berita & Warta')
@section('page_title', 'Manajemen Berita & Artikel')
@section('page_subtitle', 'Tulis dan publikasikan berita kegiatan, prestasi, dan warta lembaga')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h2 class="text-base font-black text-slate-900">Daftar Berita ({{ $news->total() }})</h2>
        <a href="{{ route('admin.news.create') }}" class="px-4 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Tulis Berita Baru
        </a>
    </div>

    <!-- News Table -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-black uppercase tracking-wider border-b border-border-main">
                    <tr>
                        <th class="py-4 px-6">Judul Berita</th>
                        <th class="py-4 px-6">Kategori / Unit</th>
                        <th class="py-4 px-6">Penulis</th>
                        <th class="py-4 px-6">Tanggal Tayang</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($news as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($item->thumbnail_path)
                                <img src="{{ $item->thumbnail_path }}" alt="" class="w-10 h-10 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                @else
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                    IMG
                                </div>
                                @endif
                                <div class="min-w-0 max-w-md">
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="font-bold text-slate-900 hover:text-primary-800 line-clamp-1">
                                        {{ $item->title }}
                                    </a>
                                    <p class="text-[11px] text-slate-400 line-clamp-1 font-normal">{{ $item->excerpt }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-primary-50 text-primary-900 border border-primary-100">
                                {{ strtoupper($item->scope) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-800">
                            {{ $item->author_name ?? 'Admin' }}
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ $item->published_at ? $item->published_at->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $item->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($item->status === 'draft' ? 'bg-slate-100 text-slate-600' : 'bg-amber-50 text-amber-700') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('news.show', $item->slug) }}" target="_blank" class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900" title="Lihat di Web">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="p-1.5 rounded-lg text-slate-600 hover:text-primary-900 hover:bg-slate-100 inline-block" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.news.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Hapus berita ini?')">
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
                        <td colspan="6" class="py-12 text-center text-slate-400">Belum ada berita yang ditulis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-border-main">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
