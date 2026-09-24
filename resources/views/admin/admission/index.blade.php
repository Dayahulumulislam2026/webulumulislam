@extends('layouts.admin')

@section('title', 'Penerimaan Santri Baru')
@section('page_title', 'Pengaturan Penerimaan Santri')
@section('page_subtitle', 'Kelola status buka/tutup, syarat berkas, jadwal, dan template WhatsApp')

@section('content')
<div class="space-y-8">
    <!-- Unit Selector Tabs -->
    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-border-main pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.admission.index', ['tab' => 'smp']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'smp' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                📚 Pendaftaran SMP
            </a>
            <a href="{{ route('admin.admission.index', ['tab' => 'sma']) }}" class="px-5 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all {{ $tab === 'sma' ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-border-main' }}">
                🎓 Pendaftaran SMA
            </a>
        </div>

        <a href="{{ route('admission') }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-primary-900 bg-primary-50 hover:bg-primary-100 transition-colors border border-primary-200 inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Lihat Halaman Publik PSB
        </a>
    </div>

    @if($currentInstitution)
    <!-- Admission Form Card -->
    <div class="bg-white rounded-3xl border border-border-main shadow-xs p-6 sm:p-10 space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">PSB {{ strtoupper($currentInstitution->name) }}</span>
                <h2 class="text-xl font-black text-slate-900">Konfigurasi Jalur Pendaftaran</h2>
            </div>
            <div>
                @if($admission && $admission->is_open)
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase tracking-wider inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    STATUS: DIBUKA
                </span>
                @else
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-black uppercase tracking-wider">
                    STATUS: DITUTUP
                </span>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.admission.update') }}" class="space-y-6 text-xs font-medium">
            @csrf
            <input type="hidden" name="institution_id" value="{{ $currentInstitution->id }}">

            <!-- Status Toggle Switch -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Buka Status Pendaftaran Online</h3>
                    <p class="text-[11px] text-slate-500">Jika dicentang, badge status pada halaman publik akan berubah menjadi "DIBUKA" dan tombol pendaftaran aktif.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_open" value="1" {{ old('is_open', $admission?->is_open) ? 'checked' : '' }} class="w-5 h-5 rounded text-primary-900 border-slate-300">
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Persyaratan Pendaftaran</label>
                    <textarea name="requirements" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="1. Beragama Islam&#10;2. Lulusan SD/MI Sederajat&#10;3. Berkelakuan baik...">{{ old('requirements', $admission?->requirements) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Dokumen yang Diperlukan</label>
                    <textarea name="required_documents" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="1. Fotokopi Ijazah / SKL&#10;2. Fotokopi Akta Kelahiran&#10;3. Fotokopi Kartu Keluarga...">{{ old('required_documents', $admission?->required_documents) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jadwal & Gelombang Seleksi</label>
                    <textarea name="schedule_information" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Gelombang 1: 01 Januari - 28 Februari&#10;Ujian Seleksi: 05 Maret...">{{ old('schedule_information', $admission?->schedule_information) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Informasi Tambahan / Biaya</label>
                    <textarea name="additional_information" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Informasi seragam, asrama, dll...">{{ old('additional_information', $admission?->additional_information) }}</textarea>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template Pesan WhatsApp Pendaftaran</label>
                <textarea name="whatsapp_template" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 font-mono text-xs" placeholder="Assalamualaikum. Saya ingin mendaftarkan calon santri baru...">{{ old('whatsapp_template', $admission?->whatsapp_template) }}</textarea>
                <span class="text-[10px] text-slate-400">Pesan ini akan otomatis terisi saat calon santri/wali mengklik tombol pendaftaran via WhatsApp.</span>
            </div>

            <!-- Alur & Tahapan Pendaftaran (PSB Steps) -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">Tahapan & Alur PSB</span>
                        <h3 class="text-sm font-black text-slate-900">Kustomisasi Urutan & Isi Alur Pendaftaran</h3>
                        <p class="text-[11px] text-slate-500">Atur tahapan proses pendaftaran yang akan tampil di halaman utama pendaftaran untuk jenjang {{ strtoupper($currentInstitution->name) }}.</p>
                    </div>
                    <button type="button" onclick="addStepItem()" class="px-4 py-2 rounded-xl bg-primary-50 text-primary-900 hover:bg-primary-100 border border-primary-200 text-xs font-bold transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Tahapan
                    </button>
                </div>

                <div id="steps-container" class="space-y-3">
                    @php
                        $stepsList = $admission ? $admission->formatted_steps : (new \App\Models\AdmissionSetting)->formatted_steps;
                    @endphp
                    @foreach($stepsList as $index => $step)
                    <div class="step-card bg-slate-50 border border-slate-200 rounded-2xl p-4 transition-all hover:border-slate-300">
                        <div class="flex items-center justify-between gap-3 mb-3 border-b border-slate-200/80 pb-2">
                            <div class="flex items-center gap-2">
                                <span class="step-badge w-6 h-6 rounded-full bg-primary-900 text-white font-black text-[11px] flex items-center justify-center">{{ $index + 1 }}</span>
                                <span class="text-xs font-bold text-slate-800">Tahap <span class="step-number-text">{{ $index + 1 }}</span></span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="moveStepUp(this)" class="p-1 rounded hover:bg-white text-slate-500 hover:text-slate-900 transition-colors" title="Geser ke Atas">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                                </button>
                                <button type="button" onclick="moveStepDown(this)" class="p-1 rounded hover:bg-white text-slate-500 hover:text-slate-900 transition-colors" title="Geser ke Bawah">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <button type="button" onclick="removeStepItem(this)" class="p-1 rounded hover:bg-rose-100 text-rose-500 hover:text-rose-700 transition-colors ml-1" title="Hapus Tahap">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <div class="sm:col-span-8">
                                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Judul Tahapan</label>
                                <input type="text" name="steps[{{ $index }}][title]" value="{{ $step['title'] ?? '' }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-primary-800 bg-white" placeholder="Contoh: Pendaftaran Awal">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Ikon / Simbol</label>
                                <select name="steps[{{ $index }}][icon]" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-primary-800 bg-white">
                                    <option value="document" {{ ($step['icon'] ?? '') == 'document' ? 'selected' : '' }}>📄 Formulir / Berkas</option>
                                    <option value="academic" {{ ($step['icon'] ?? '') == 'academic' ? 'selected' : '' }}>🎓 Ujian / Tes Seleksi</option>
                                    <option value="megaphone" {{ ($step['icon'] ?? '') == 'megaphone' ? 'selected' : '' }}>📢 Pengumuman Hasil</option>
                                    <option value="check" {{ ($step['icon'] ?? '') == 'check' ? 'selected' : '' }}>✅ Daftar Ulang / Diterima</option>
                                    <option value="user" {{ ($step['icon'] ?? '') == 'user' ? 'selected' : '' }}>👥 Wawancara Santri & Wali</option>
                                    <option value="payment" {{ ($step['icon'] ?? '') == 'payment' ? 'selected' : '' }}>💳 Pembayaran & Administrasi</option>
                                    <option value="mosque" {{ ($step['icon'] ?? '') == 'mosque' ? 'selected' : '' }}>🕌 Asrama / Masuk Dayah</option>
                                    <option value="phone" {{ ($step['icon'] ?? '') == 'phone' ? 'selected' : '' }}>📱 Verifikasi WhatsApp</option>
                                </select>
                            </div>
                            <div class="sm:col-span-12">
                                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Deskripsi / Penjelasan Singkat</label>
                                <textarea name="steps[{{ $index }}][description]" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-primary-800 bg-white" placeholder="Jelaskan apa yang harus dilakukan santri/wali pada tahapan ini...">{{ $step['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all">
                    Simpan Pengaturan Pendaftaran
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

<template id="step-item-template">
    <div class="step-card bg-slate-50 border border-slate-200 rounded-2xl p-4 transition-all hover:border-slate-300">
        <div class="flex items-center justify-between gap-3 mb-3 border-b border-slate-200/80 pb-2">
            <div class="flex items-center gap-2">
                <span class="step-badge w-6 h-6 rounded-full bg-primary-900 text-white font-black text-[11px] flex items-center justify-center">1</span>
                <span class="text-xs font-bold text-slate-800">Tahap <span class="step-number-text">1</span></span>
            </div>
            <div class="flex items-center gap-1">
                <button type="button" onclick="moveStepUp(this)" class="p-1 rounded hover:bg-white text-slate-500 hover:text-slate-900 transition-colors" title="Geser ke Atas">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                </button>
                <button type="button" onclick="moveStepDown(this)" class="p-1 rounded hover:bg-white text-slate-500 hover:text-slate-900 transition-colors" title="Geser ke Bawah">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <button type="button" onclick="removeStepItem(this)" class="p-1 rounded hover:bg-rose-100 text-rose-500 hover:text-rose-700 transition-colors ml-1" title="Hapus Tahap">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Judul Tahapan</label>
                <input type="text" data-name="title" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-primary-800 bg-white" placeholder="Contoh: Pendaftaran Awal">
            </div>
            <div class="sm:col-span-4">
                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Ikon / Simbol</label>
                <select data-name="icon" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-primary-800 bg-white">
                    <option value="document">📄 Formulir / Berkas</option>
                    <option value="academic">🎓 Ujian / Tes Seleksi</option>
                    <option value="megaphone">📢 Pengumuman Hasil</option>
                    <option value="check">✅ Daftar Ulang / Diterima</option>
                    <option value="user">👥 Wawancara Santri & Wali</option>
                    <option value="payment">💳 Pembayaran & Administrasi</option>
                    <option value="mosque">🕌 Asrama / Masuk Dayah</option>
                    <option value="phone">📱 Verifikasi WhatsApp</option>
                </select>
            </div>
            <div class="sm:col-span-12">
                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Deskripsi / Penjelasan Singkat</label>
                <textarea data-name="description" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-primary-800 bg-white" placeholder="Jelaskan apa yang harus dilakukan santri/wali pada tahapan ini..."></textarea>
            </div>
        </div>
    </div>
</template>

<script>
function reindexSteps() {
    const container = document.getElementById('steps-container');
    const cards = container.querySelectorAll('.step-card');
    cards.forEach((card, idx) => {
        const num = idx + 1;
        card.querySelector('.step-badge').innerText = num;
        card.querySelector('.step-number-text').innerText = num;
        
        const titleInput = card.querySelector('input[name*="[title]"], input[data-name="title"]');
        if (titleInput) {
            titleInput.name = `steps[${idx}][title]`;
        }
        
        const iconSelect = card.querySelector('select[name*="[icon]"], select[data-name="icon"]');
        if (iconSelect) {
            iconSelect.name = `steps[${idx}][icon]`;
        }
        
        const descTextarea = card.querySelector('textarea[name*="[description]"], textarea[data-name="description"]');
        if (descTextarea) {
            descTextarea.name = `steps[${idx}][description]`;
        }
    });
}

function addStepItem() {
    const container = document.getElementById('steps-container');
    const template = document.getElementById('step-item-template');
    const clone = template.content.cloneNode(true);
    container.appendChild(clone);
    reindexSteps();
}

function removeStepItem(btn) {
    const container = document.getElementById('steps-container');
    const cards = container.querySelectorAll('.step-card');
    if (cards.length <= 1) {
        alert('Minimal harus ada 1 tahapan pendaftaran.');
        return;
    }
    const card = btn.closest('.step-card');
    card.remove();
    reindexSteps();
}

function moveStepUp(btn) {
    const card = btn.closest('.step-card');
    const prev = card.previousElementSibling;
    if (prev && prev.classList.contains('step-card')) {
        card.parentNode.insertBefore(card, prev);
        reindexSteps();
    }
}

function moveStepDown(btn) {
    const card = btn.closest('.step-card');
    const next = card.nextElementSibling;
    if (next && next.classList.contains('step-card')) {
        card.parentNode.insertBefore(next, card);
        reindexSteps();
    }
}
</script>
@endsection
