@extends('layouts.admin')

@section('title', 'Pengaturan Website & SEO')
@section('page_title', 'Pengaturan Global Situs & SEO')
@section('page_subtitle', 'Kelola kontak terpusat, template WhatsApp, Hero Banner beranda, dan optimasi SEO')

@section('content')
<div class="max-w-5xl space-y-8">
    <div class="bg-white rounded-3xl border border-border-main shadow-xs p-6 sm:p-10 space-y-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-10 text-xs font-medium">
            @csrf

            <!-- 1. Kontak & WhatsApp -->
            <div class="space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">KOMUNIKASI TERPUSAT</span>
                    <h3 class="font-black text-base text-slate-900">Kontak & Template WhatsApp</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Nomor kontak dan format pesan otomatis saat calon santri atau masyarakat menghubungi via WhatsApp.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / Hotline Utama (Format: 628xxx) <span class="text-red-500">*</span></label>
                        <input type="text" name="site_phone" value="{{ old('site_phone', $settings['site_phone']) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap Pesantren <span class="text-red-500">*</span></label>
                        <input type="text" name="site_address" value="{{ old('site_address', $settings['site_address']) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template WhatsApp Umum (Beranda & Footer)</label>
                    <textarea name="whatsapp_template_general" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('whatsapp_template_general', $settings['whatsapp_template_general']) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template Pertanyaan Yayasan</label>
                        <textarea name="whatsapp_template_yayasan" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('whatsapp_template_yayasan', $settings['whatsapp_template_yayasan']) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template Konsultasi Dayah Terpadu</label>
                        <textarea name="whatsapp_template_dayah" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('whatsapp_template_dayah', $settings['whatsapp_template_dayah']) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template Pendaftaran SMP</label>
                        <textarea name="whatsapp_template_smp" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('whatsapp_template_smp', $settings['whatsapp_template_smp']) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template Pendaftaran SMA</label>
                        <textarea name="whatsapp_template_sma" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('whatsapp_template_sma', $settings['whatsapp_template_sma']) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Template Kontak IKADA UI (Ikatan Alumni)</label>
                        <textarea name="whatsapp_template_ikada" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('whatsapp_template_ikada', $settings['whatsapp_template_ikada']) }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Embed Google Maps URL / Iframe Link</label>
                    <input type="text" name="site_gmaps" value="{{ old('site_gmaps', $settings['site_gmaps']) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="https://maps.google.com/...">
                </div>
            </div>

            <!-- 2. Hero Banner Beranda Dinamis -->
            <div class="space-y-6 pt-8 border-t border-slate-100">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">VISUAL BERANDA</span>
                    <h3 class="font-black text-base text-slate-900">Hero Section Beranda</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kustomisasi gambar latar belakang, judul sambutan, dan subjudul pada bagian teratas beranda.</p>
                </div>

                <div class="space-y-3">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider">Gambar Background Hero Beranda (Rasio 16:7 / 1920x800)</label>
                    <div class="h-36 w-full rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 overflow-hidden relative flex items-center justify-center">
                        @if($settings['home_hero_image'])
                        <img id="hero-preview-img" src="{{ $settings['home_hero_image'] }}" alt="Hero Background Preview" class="w-full h-full object-cover">
                        @else
                        <div id="hero-preview-placeholder" class="text-slate-400 text-xs font-semibold flex items-center gap-2">
                            <span>🌄 Belum ada gambar kustom (menggunakan latar grafis gradasi default)</span>
                        </div>
                        <img id="hero-preview-img" src="" alt="Hero Preview" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload File Gambar:</label>
                            <input type="file" name="home_hero_image" id="hero-image-input" accept="image/png,image/jpeg,image/webp" class="cropper-auto block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-900 file:text-white hover:file:bg-primary-950 cursor-pointer" data-aspect-ratio="16/7" data-preview="#hero-preview-img">
                            <span class="text-[9px] text-accent-gold font-bold">Rasio Ideal 16:7 (1920x840 px) • Didukung Pemotong Gambar</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Atau Gunakan URL Gambar Eksternal:</label>
                            <input type="url" name="home_hero_image_url" value="{{ old('home_hero_image_url', str_starts_with($settings['home_hero_image'], 'http') ? $settings['home_hero_image'] : '') }}" placeholder="https://..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Utama Hero Beranda</label>
                        <input type="text" name="home_hero_title" value="{{ old('home_hero_title', $settings['home_hero_title']) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subjudul / Deskripsi Hero</label>
                        <textarea name="home_hero_subtitle" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('home_hero_subtitle', $settings['home_hero_subtitle']) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 3. Statistik Ringkasan Beranda -->
            <div class="space-y-6 pt-8 border-t border-slate-100">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">ANGKA & PENCAPAIAN</span>
                    <h3 class="font-black text-base text-slate-900">Statistik Utama Beranda</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola angka ringkasan santri aktif, ustadz/pengajar, dan alumni yang tampil pada section statistik beranda publik.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Santri Aktif (SMP & SMA)</label>
                        <input type="number" name="site_stat_santri_aktif" value="{{ old('site_stat_santri_aktif', $settings['site_stat_santri_aktif']) }}" min="0" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 font-bold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ustadz & Pengajar</label>
                        <input type="number" name="site_stat_asatidz" value="{{ old('site_stat_asatidz', $settings['site_stat_asatidz']) }}" min="0" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 font-bold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alumni Tersebar</label>
                        <input type="number" name="site_stat_alumni" value="{{ old('site_stat_alumni', $settings['site_stat_alumni']) }}" min="0" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800 font-bold">
                    </div>
                </div>
            </div>

            <!-- 4. Optimasi SEO & Meta Tag -->
            <div class="space-y-6 pt-8 border-t border-slate-100">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-accent-gold">SEARCH ENGINE OPTIMIZATION</span>
                    <h3 class="font-black text-base text-slate-900">Modul SEO & Media Sosial</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Optimalkan peringkat pencarian di Google dan tampilan link preview saat dibagikan ke WhatsApp & media sosial.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Default Meta Title (Judul Tab Browser & Google Search)</label>
                        <input type="text" name="site_meta_title" value="{{ old('site_meta_title', $settings['site_meta_title']) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Default Meta Description (Ringkasan Cuplikan Mesin Pencari)</label>
                        <textarea name="site_meta_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800">{{ old('site_meta_description', $settings['site_meta_description']) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Keywords (Kata Kunci Pencarian - Pisahkan dengan Koma)</label>
                        <input type="text" name="site_meta_keywords" value="{{ old('site_meta_keywords', $settings['site_meta_keywords']) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="dayah, pesantren, smp ulumul islam, sma ulumul islam, aceh">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Google Site Verification Code (HTML Tag)</label>
                        <input type="text" name="google_site_verification" value="{{ old('google_site_verification', $settings['google_site_verification']) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Contoh: aBcDeF123456789">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Google Analytics Tracking ID (G-XXXXXXXXXX)</label>
                        <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id']) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-primary-800" placeholder="Contoh: G-XXXXXXXXXX">
                    </div>

                    <div class="sm:col-span-2 space-y-3">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider">Default OpenGraph Image (Gambar Pratinjau Share WA & Sosmed)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload File:</label>
                                <input type="file" name="site_og_image" accept="image/png,image/jpeg,image/webp" class="cropper-auto block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-900 file:text-white hover:file:bg-primary-950 cursor-pointer" data-aspect-ratio="16/9">
                                <span class="text-[9px] text-slate-400">Rasio 16:9 • Didukung Pemotong Gambar</span>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Atau Gunakan URL:</label>
                                <input type="url" name="site_og_image_url" value="{{ old('site_og_image_url', str_starts_with($settings['site_og_image'], 'http') ? $settings['site_og_image'] : '') }}" placeholder="https://..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-8 py-3.5 rounded-xl bg-primary-900 hover:bg-primary-950 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Seluruh Pengaturan Situs & SEO
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const heroInput = document.getElementById('hero-image-input');
    const heroPreview = document.getElementById('hero-preview-img');
    const heroPlaceholder = document.getElementById('hero-preview-placeholder');
    if (heroInput && heroPreview) {
        heroInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    heroPreview.src = evt.target.result;
                    heroPreview.classList.remove('hidden');
                    if (heroPlaceholder) heroPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endpush
@endsection
