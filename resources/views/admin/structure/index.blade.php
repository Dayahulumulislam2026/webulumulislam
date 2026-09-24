@extends('layouts.admin')

@section('title', 'Struktur Organisasi & Divisi')
@section('page_title', 'Struktur Organisasi & Kepengurusan')
@section('page_subtitle', 'Kelola pimpinan utama, jajaran wakil, serta divisi dan penugasan staf')

@section('content')
<div class="space-y-8">
    <!-- Unit Selector Tabs -->
    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-border-main pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.structure.index', ['tab' => 'foundation']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'foundation' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🏛️ Yayasan
            </a>
            <a href="{{ route('admin.structure.index', ['tab' => 'dayah']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'dayah' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🕌 Dayah Terpadu
            </a>
            <a href="{{ route('admin.structure.index', ['tab' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'smp' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                📚 SMP
            </a>
            <a href="{{ route('admin.structure.index', ['tab' => 'sma']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'sma' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🎓 SMA
            </a>
            <a href="{{ route('admin.structure.index', ['tab' => 'ikada']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'ikada' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🤝 IKADA UI
            </a>
        </div>

        <div class="flex items-center gap-3">
            @if($tab === 'dayah')
            <form method="POST" action="{{ url('/admin/struktur/sync-dayah') }}" onsubmit="return confirm('Apakah Anda yakin ingin menyinkronkan seluruh susunan pengurus Dayah resmi sesuai bagan struktur?');">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    🔄 Sinkronkan Bagan Dayah
                </button>
            </form>
            @endif
            @if($tab === 'smp')
            <form method="POST" action="{{ url('/admin/struktur/sync-smp') }}" onsubmit="return confirm('Apakah Anda yakin ingin menyinkronkan seluruh susunan pengurus & dewan guru SMP Swasta Ulumul Islam resmi sesuai bagan struktur?');">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-cyan-700 hover:bg-cyan-800 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    🔄 Sinkronkan Bagan SMP
                </button>
            </form>
            @endif
            @if($tab === 'ikada')
            <form method="POST" action="{{ url('/admin/struktur/sync-ikada') }}" onsubmit="return confirm('Apakah Anda yakin ingin menyinkronkan seluruh susunan pengurus IKADA UI resmi sesuai bagan struktur?');">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    🔄 Sinkronkan Bagan IKADA
                </button>
            </form>
            @endif
            <button onclick="openAddPosModal('division')" class="px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Tambah Divisi / Bidang
            </button>
            <button onclick="openAddPosModal('leader')" class="px-4 py-2.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Tambah Posisi / Jabatan
            </button>
        </div>
    </div>

    <!-- 1. Section: Pimpinan Utama (Pinned Leader) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <div class="flex items-center gap-2">
                <span class="text-base font-black text-slate-900">👑 Pimpinan Utama</span>
                <span class="text-[11px] text-accent-gold font-bold uppercase">Kepala / Pimpinan Tertinggi</span>
            </div>
            <button onclick="openAddPosModal('leader')" class="text-xs font-bold text-primary-900 hover:underline">
                + Tambah Pimpinan
            </button>
        </div>

        @if($leaders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($leaders as $leadPos)
            <div class="bg-white rounded-3xl p-6 border-2 border-primary-900/40 shadow-sm space-y-4 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-primary-100 text-primary-950 font-black text-[10px] uppercase tracking-wider border border-primary-300">
                            {{ $leadPos->position_name }}
                        </span>
                        @if($leadPos->is_pinned)
                        <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-900 font-bold text-[10px] flex items-center gap-1">
                            ⭐ Pinned Utama
                        </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-1">
                        <form method="POST" action="{{ route('admin.structure.positions.toggle_pin', $leadPos->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-slate-100" title="{{ $leadPos->is_pinned ? 'Lepas Pin' : 'Sematkan (Pin)' }}">
                                <svg class="w-4 h-4 {{ $leadPos->is_pinned ? 'text-amber-500 fill-amber-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </button>
                        </form>
                        <button onclick="openEditPosModal({{ json_encode($leadPos) }})" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-100" title="Edit Posisi">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.structure.positions.destroy', $leadPos->id) }}" class="inline" onsubmit="return confirm('Hapus posisi {{ $leadPos->position_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50" title="Hapus Posisi">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                @forelse($leadPos->members as $member)
                <div class="flex items-center justify-between p-3.5 rounded-2xl bg-primary-50/50 border border-primary-100 gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        @if($member->photo_path)
                        <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-primary-900 shrink-0">
                        @else
                        <div class="w-14 h-14 rounded-2xl bg-primary-900 text-white font-black flex items-center justify-center text-sm shrink-0">
                            {{ strtoupper(substr($member->name, 0, 2)) }}
                        </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-sm text-slate-900 truncate">{{ $member->name }}</h4>
                            <p class="text-xs text-primary-950 font-bold mt-0.5">{{ $member->title ?: $leadPos->position_name }}</p>
                            <p class="text-[11px] text-slate-500 font-medium">Periode: {{ $member->period }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="openEditMemberModal({{ json_encode($member) }})" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.structure.members.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Hapus data pimpinan {{ $member->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200 space-y-2">
                    <p class="text-xs text-slate-500">Belum ada pejabat pimpinan utama yang dimasukkan.</p>
                    <button onclick="openAddMemberModal({{ $leadPos->id }}, '{{ addslashes($leadPos->position_name) }}', 'leader')" class="px-4 py-1.5 rounded-xl bg-primary-900 text-white font-bold text-xs uppercase">
                        + Isi Data Pimpinan
                    </button>
                </div>
                @endforelse
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-6 bg-white rounded-3xl border border-dashed border-border-main p-6 space-y-2">
            <p class="text-xs text-slate-500 font-medium">Belum ada Pimpinan Utama untuk unit ini.</p>
            <button onclick="openAddPosModal('leader')" class="px-4 py-2 rounded-xl bg-primary-900 text-white font-bold text-xs uppercase">
                + Tambah Pimpinan Utama
            </button>
        </div>
        @endif
    </div>

    <!-- 2. Section: Jajaran Wakil Pimpinan (Vice Leaders) -->
    <div class="space-y-4 pt-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <div class="flex items-center gap-2">
                <span class="text-base font-black text-slate-900">🛡️ Jajaran Wakil & Pimpinan Harian</span>
                <span class="text-[11px] text-slate-400 font-bold uppercase">Urutan Sorting Dapat Diatur</span>
            </div>
            <button onclick="openAddPosModal('vice')" class="text-xs font-bold text-primary-900 hover:underline">
                + Tambah Jabatan Wakil
            </button>
        </div>

        @if($vices->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($vices as $vicePos)
            <div class="bg-white rounded-3xl p-5 border border-border-main shadow-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 font-black flex items-center justify-center text-[10px]">
                            #{{ $vicePos->sort_order }}
                        </span>
                        <h4 class="font-extrabold text-xs text-slate-900">{{ $vicePos->position_name }}</h4>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="openAddMemberModal({{ $vicePos->id }}, '{{ addslashes($vicePos->position_name) }}', 'vice')" class="p-1 rounded text-emerald-700 hover:bg-emerald-50" title="Tambah Pengurus">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                        <button onclick="openEditPosModal({{ json_encode($vicePos) }})" class="p-1 rounded text-slate-500 hover:bg-slate-100" title="Edit Posisi">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.structure.positions.destroy', $vicePos->id) }}" class="inline" onsubmit="return confirm('Hapus jabatan {{ $vicePos->position_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 rounded text-red-500 hover:bg-red-50" title="Hapus">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                @forelse($vicePos->members as $member)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200/80 gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        @if($member->photo_path)
                        <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-xl object-cover border border-primary-900 shrink-0">
                        @else
                        <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-900 font-bold flex items-center justify-center text-xs shrink-0">
                            {{ strtoupper(substr($member->name, 0, 2)) }}
                        </div>
                        @endif
                        <div class="min-w-0">
                            <h5 class="font-bold text-xs text-slate-900 truncate">{{ $member->name }}</h5>
                            <p class="text-[10px] text-slate-500 truncate">{{ $member->title ?: $vicePos->position_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="openEditMemberModal({{ json_encode($member) }})" class="p-1 text-slate-500 hover:text-slate-800">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.structure.members.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Hapus {{ $member->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-red-500 hover:text-red-700">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-[11px] text-slate-400 italic">Belum ada pengurus di jabatan ini.</p>
                @endforelse
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-6 bg-white rounded-3xl border border-dashed border-border-main p-6 space-y-2">
            <p class="text-xs text-slate-500 font-medium">Belum ada Jajaran Wakil untuk unit ini.</p>
            <button onclick="openAddPosModal('vice')" class="px-4 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs uppercase">
                + Tambah Wakil Pimpinan
            </button>
        </div>
        @endif
    </div>

    <!-- 3. Section: Divisi / Bidang / Seksi Kustom (Custom Divisions) -->
    <div class="space-y-4 pt-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <div class="flex items-center gap-2">
                <span class="text-base font-black text-slate-900">📂 Divisi, Bidang & Seksi Kustom</span>
                <span class="text-[11px] text-slate-400 font-bold uppercase">Kepala Divisi & Anggota (Tupoksi)</span>
            </div>
            <button onclick="openAddPosModal('division')" class="text-xs font-bold text-emerald-800 hover:underline">
                + Tambah Divisi Baru
            </button>
        </div>

        @if($divisions->count() > 0)
        <div class="space-y-6">
            @foreach($divisions as $div)
            <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
                <!-- Division Header Bar -->
                <div class="p-5 bg-gradient-to-r from-slate-50 to-slate-100/60 border-b border-border-main flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs border border-emerald-200">
                            #{{ $div->sort_order }}
                        </span>
                        <div>
                            <h3 class="font-black text-sm text-slate-900">{{ $div->position_name }}</h3>
                            <p class="text-[11px] text-slate-500 font-medium">{{ $div->members->count() }} Anggota Pengurus / Staf</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button onclick="openAddMemberModal({{ $div->id }}, '{{ addslashes($div->position_name) }}', 'division')" class="px-3.5 py-1.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs uppercase tracking-wider transition-colors flex items-center gap-1.5 shadow-xs">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            + Tambah Anggota / Staf
                        </button>
                        <button onclick="openEditPosModal({{ json_encode($div) }})" class="p-2 rounded-xl text-slate-600 hover:bg-slate-200" title="Edit Nama Divisi">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.structure.positions.destroy', $div->id) }}" class="inline" onsubmit="return confirm('Hapus divisi {{ $div->position_name }} beserta seluruh anggotanya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl text-red-500 hover:bg-red-50" title="Hapus Divisi">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Division Members Grid -->
                <div class="p-5 sm:p-6">
                    @if($div->members->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($div->members as $member)
                        <div class="p-4 rounded-2xl border {{ $member->member_role === 'head' ? 'border-emerald-300 bg-emerald-50/40' : 'border-slate-200 bg-white' }} shadow-xs flex flex-col justify-between space-y-3">
                            <div class="flex items-start gap-3">
                                @if($member->photo_path)
                                <img src="{{ $member->photo_path }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-xl object-cover border border-primary-900 shrink-0">
                                @else
                                <div class="w-12 h-12 rounded-xl {{ $member->member_role === 'head' ? 'bg-emerald-800 text-white' : 'bg-primary-100 text-primary-900' }} font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <h4 class="font-bold text-xs text-slate-900 truncate">{{ $member->name }}</h4>
                                        @if($member->member_role === 'head')
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-600 text-white font-extrabold text-[9px] uppercase">
                                            Kepala Divisi
                                        </span>
                                        @endif
                                    </div>
                                    @if($member->title)
                                    <p class="text-[11px] font-semibold text-primary-900 mt-0.5">{{ $member->title }}</p>
                                    @endif
                                    @if($member->sub_role)
                                    <div class="mt-1.5 p-2 rounded-xl bg-slate-100/80 border border-slate-200 text-[11px] text-slate-700 leading-relaxed font-medium">
                                        <span class="font-bold text-[10px] text-slate-500 uppercase block">Bagian / Tugas:</span>
                                        {{ $member->sub_role }}
                                    </div>
                                    @endif
                                    <p class="text-[10px] text-slate-400 mt-1">Periode: {{ $member->period }}</p>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-1">
                                <button onclick="openEditMemberModal({{ json_encode($member) }})" class="p-1.5 rounded-lg text-slate-600 hover:bg-slate-100" title="Edit Anggota">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form method="POST" action="{{ route('admin.structure.members.destroy', $member->id) }}" class="inline" onsubmit="return confirm('Hapus {{ $member->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-6 bg-slate-50 rounded-2xl border border-dashed border-slate-200 space-y-2">
                        <p class="text-xs text-slate-500 font-medium">Belum ada anggota atau kepala divisi yang terdaftar pada divisi ini.</p>
                        <button onclick="openAddMemberModal({{ $div->id }}, '{{ addslashes($div->position_name) }}', 'division')" class="px-4 py-1.5 rounded-xl bg-emerald-700 text-white font-bold text-xs uppercase">
                            + Tambah Kepala / Anggota Divisi
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 bg-white rounded-3xl border border-dashed border-border-main p-8 space-y-2">
            <p class="text-xs text-slate-500 font-medium">Belum ada divisi atau bidang kustom untuk unit ini.</p>
            <button onclick="openAddPosModal('division')" class="px-5 py-2.5 rounded-xl bg-emerald-700 text-white font-bold text-xs uppercase">
                + Tambah Divisi Pertama
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Posisi / Divisi -->
<div id="add-pos-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 id="add-pos-modal-title" class="font-black text-sm uppercase tracking-wider text-slate-900">Tambah Posisi / Divisi</h3>
        <form method="POST" action="{{ route('admin.structure.positions.store') }}" class="space-y-4 text-xs font-medium">
            @csrf
            <input type="hidden" name="institution_id" value="{{ $currentInstitution->id }}">
            
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori Struktur</label>
                <select id="add-pos-category" name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                    <option value="leader">👑 Pimpinan Utama (Mudir / Ketua / Kepala Sekolah)</option>
                    <option value="vice">🛡️ Jajaran Wakil Pimpinan / Pimpinan Harian</option>
                    <option value="division">📂 Divisi / Bidang / Seksi Kustom</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Jabatan / Nama Divisi</label>
                <input type="text" name="position_name" required placeholder="Contoh: Mudir Dayah / Divisi Keasramaan" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Urut Tampil</label>
                    <input type="number" name="sort_order" value="1" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" class="rounded text-primary-900">
                        Pin Utama (⭐)
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-pos-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Posisi / Divisi -->
<div id="edit-pos-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Posisi / Divisi</h3>
        <form id="edit-pos-form" method="POST" action="" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori Struktur</label>
                <select id="edit-pos-category" name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                    <option value="leader">👑 Pimpinan Utama (Mudir / Ketua / Kepala Sekolah)</option>
                    <option value="vice">🛡️ Jajaran Wakil Pimpinan</option>
                    <option value="division">📂 Divisi / Bidang / Seksi Kustom</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Jabatan / Nama Divisi</label>
                <input type="text" id="edit-pos-name" name="position_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Urut</label>
                    <input type="number" id="edit-pos-order" name="sort_order" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-2 font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" id="edit-pos-pinned" name="is_pinned" value="1" class="rounded text-primary-900">
                        Pin Utama (⭐)
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-pos-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-900 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Anggota Pengurus / Staf -->
<div id="add-member-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Tambah Anggota Pengurus / Staf</h3>
        <p id="add-member-subtitle" class="text-xs text-slate-500 font-medium"></p>
        <form method="POST" action="{{ route('admin.structure.members.store') }}" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            <input type="hidden" id="add-member-pos-id" name="position_id" value="">
            
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap & Gelar</label>
                <input type="text" name="name" required placeholder="Contoh: Tgk. H. Abdullah, Lc., M.Ag" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Peran dalam Jabatan/Divisi</label>
                    <select id="add-member-role" name="member_role" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="head">⭐ Kepala / Koordinator Divisi</option>
                        <option value="member" selected>👤 Anggota / Staf</option>
                        <option value="leader">👑 Pimpinan Utama</option>
                        <option value="vice">🛡️ Wakil Pimpinan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Sebutan Jabatan (Opsional)</label>
                    <input type="text" name="title" placeholder="Contoh: Koordinator Asrama" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Penjelasan Bagian yang Dipegang / Tugas</label>
                <textarea name="sub_role" rows="2" placeholder="Contoh: Penanggung Jawab Asrama Putra Blok A & Pembina Bahasa Arab" class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Periode Jabatan</label>
                    <input type="text" name="period" required value="{{ date('Y') }} - Sekarang" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" value="0" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Foto Formal (Opsional)</label>
                <input type="file" name="photo" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="1:1">
                <span class="text-[9px] text-slate-400">Rasio 1:1 • Didukung Pemotong Gambar</span>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('add-member-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-700 text-white font-bold">Simpan Pengurus</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Anggota Pengurus -->
<div id="edit-member-modal" class="fixed inset-0 z-50 bg-black/60 hidden items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="font-black text-sm uppercase tracking-wider text-slate-900">Edit Data Pengurus / Staf</h3>
        <form id="edit-member-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4 text-xs font-medium">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap & Gelar</label>
                <input type="text" id="edit-member-name" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Peran dalam Posisi/Divisi</label>
                    <select id="edit-member-role" name="member_role" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                        <option value="head">⭐ Kepala / Koordinator Divisi</option>
                        <option value="member">👤 Anggota / Staf</option>
                        <option value="leader">👑 Pimpinan Utama</option>
                        <option value="vice">🛡️ Wakil Pimpinan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Sebutan Jabatan</label>
                    <input type="text" id="edit-member-title" name="title" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Penjelasan Bagian yang Dipegang / Tugas</label>
                <textarea id="edit-member-sub-role" name="sub_role" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Periode Jabatan</label>
                    <input type="text" id="edit-member-period" name="period" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Urutan</label>
                    <input type="number" id="edit-member-order" name="sort_order" min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-300">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Ganti Foto Formal (Opsional)</label>
                <input type="file" name="photo" accept="image/*" class="cropper-auto w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-900 cursor-pointer" data-aspect-ratio="1:1">
                <span class="text-[9px] text-slate-400">Rasio 1:1 • Didukung Pemotong Gambar</span>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-member-modal')" class="px-4 py-2 rounded-xl text-slate-600 font-bold">Batal</button>
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

    function openAddPosModal(category = 'leader') {
        document.getElementById('add-pos-category').value = category;
        const titleEl = document.getElementById('add-pos-modal-title');
        if (category === 'division') {
            titleEl.textContent = 'Tambah Divisi / Bidang Baru';
        } else if (category === 'vice') {
            titleEl.textContent = 'Tambah Jabatan Wakil Pimpinan';
        } else {
            titleEl.textContent = 'Tambah Posisi Pimpinan Utama';
        }
        openModal('add-pos-modal');
    }

    function openEditPosModal(pos) {
        document.getElementById('edit-pos-form').action = `/admin/struktur/posisi/${pos.id}`;
        document.getElementById('edit-pos-name').value = pos.position_name;
        document.getElementById('edit-pos-category').value = pos.category || 'division';
        document.getElementById('edit-pos-order').value = pos.sort_order || 1;
        document.getElementById('edit-pos-pinned').checked = !!pos.is_pinned;
        openModal('edit-pos-modal');
    }

    function openAddMemberModal(posId, posName, roleContext = 'member') {
        document.getElementById('add-member-pos-id').value = posId;
        document.getElementById('add-member-subtitle').textContent = `Posisi / Divisi: ${posName}`;
        const roleEl = document.getElementById('add-member-role');
        if (roleContext === 'leader') roleEl.value = 'leader';
        else if (roleContext === 'vice') roleEl.value = 'vice';
        else if (roleContext === 'division') roleEl.value = 'member';
        openModal('add-member-modal');
    }

    function openEditMemberModal(member) {
        document.getElementById('edit-member-form').action = `/admin/struktur/anggota/${member.id}`;
        document.getElementById('edit-member-name').value = member.name;
        document.getElementById('edit-member-role').value = member.member_role || 'member';
        document.getElementById('edit-member-title').value = member.title || '';
        document.getElementById('edit-member-sub-role').value = member.sub_role || '';
        document.getElementById('edit-member-period').value = member.period || '';
        document.getElementById('edit-member-order').value = member.sort_order || 0;
        openModal('edit-member-modal');
    }
</script>
@endpush
@endsection
