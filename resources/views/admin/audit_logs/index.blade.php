@extends('layouts.admin')

@section('title', 'Log Aktivitas (Audit)')
@section('page_title', 'Log Aktivitas Sistem (Audit Trail)')
@section('page_subtitle', 'Catatan riwayat perubahan data, aksi pengelola, dan keamanan sistem')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-black text-slate-900">Riwayat Aktivitas ({{ $logs->total() }})</h2>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-black uppercase tracking-wider border-b border-border-main">
                    <tr>
                        <th class="py-4 px-6">Waktu & Tanggal</th>
                        <th class="py-4 px-6">Pengelola / Akun</th>
                        <th class="py-4 px-6">Aksi</th>
                        <th class="py-4 px-6">Objek Data</th>
                        <th class="py-4 px-6">Rincian Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($log->user)
                            <span class="font-bold text-slate-900">{{ $log->user->name }}</span>
                            <span class="block text-[10px] text-slate-400 font-mono">{{ $log->user->email }}</span>
                            @else
                            <span class="text-slate-400 italic">Sistem Otomatis</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $badgeClass = match($log->action) {
                                    'create', 'upload' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'update', 'toggle_pin', 'toggle_pin_home', 'update_stat' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'delete' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $badgeClass }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-mono text-[11px] text-slate-600">
                            {{ $log->entity_type }} #{{ $log->entity_id ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-slate-800">
                            {{ $log->description }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">Belum ada riwayat aktivitas yang tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-border-main">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
