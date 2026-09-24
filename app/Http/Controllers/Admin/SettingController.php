<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            // Kontak & WhatsApp
            'site_phone' => SiteSetting::get('site_phone', '628111111111'),
            'site_address' => SiteSetting::get('site_address', 'Jl. Ulumul Islam No. 1, Aceh'),
            'site_gmaps' => SiteSetting::get('site_gmaps', ''),
            'whatsapp_template_general' => SiteSetting::get('whatsapp_template_general', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Dayah Terpadu Ulumul Islam.'),
            'whatsapp_template_smp' => SiteSetting::get('whatsapp_template_smp', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMP Ulumul Islam.'),
            'whatsapp_template_sma' => SiteSetting::get('whatsapp_template_sma', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.'),
            'whatsapp_template_yayasan' => SiteSetting::get('whatsapp_template_yayasan', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Yayasan Ulumul Islam.'),
            'whatsapp_template_dayah' => SiteSetting::get('whatsapp_template_dayah', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Dayah Terpadu Ulumul Islam.'),
            'whatsapp_template_ikada' => SiteSetting::get('whatsapp_template_ikada', 'Assalamualaikum. Saya ingin bertanya mengenai IKADA UI (Ikatan Alumni Dayah Ulumul Islam).'),

            // Hero Beranda
            'home_hero_image' => SiteSetting::get('home_hero_image', ''),
            'home_hero_title' => SiteSetting::get('home_hero_title', 'Mencetak Generasi Qurani, Cerdas & Berakhlak Mulia'),
            'home_hero_subtitle' => SiteSetting::get('home_hero_subtitle', 'Pondok Pesantren Dayah Terpadu Ulumul Islam memadukan kurikulum pendidikan nasional (SMP & SMA) dengan tradisi kepesantrenan salafiyah modern.'),

            // Statistik Beranda Utama
            'site_stat_santri_aktif' => SiteSetting::get('site_stat_santri_aktif', '600'),
            'site_stat_asatidz' => SiteSetting::get('site_stat_asatidz', '54'),
            'site_stat_alumni' => SiteSetting::get('site_stat_alumni', '1450'),

            // SEO & Meta Tags
            'site_meta_title' => SiteSetting::get('site_meta_title', 'Ulumul Islam - Yayasan & Pondok Pesantren Dayah Terpadu'),
            'site_meta_description' => SiteSetting::get('site_meta_description', 'Pondok Pesantren Dayah Terpadu Ulumul Islam, mengintegrasikan SMP, SMA, dan pengajian kitab kuning.'),
            'site_meta_keywords' => SiteSetting::get('site_meta_keywords', 'dayah, pesantren, smp ulumul islam, sma ulumul islam, dayah terpadu, aceh, tahfidz'),
            'site_og_image' => SiteSetting::get('site_og_image', ''),
            'google_site_verification' => SiteSetting::get('google_site_verification', ''),
            'google_analytics_id' => SiteSetting::get('google_analytics_id', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $keys = [
            'site_phone',
            'site_address',
            'site_gmaps',
            'whatsapp_template_general',
            'whatsapp_template_smp',
            'whatsapp_template_sma',
            'whatsapp_template_yayasan',
            'whatsapp_template_dayah',
            'whatsapp_template_ikada',
            'home_hero_title',
            'home_hero_subtitle',
            'site_stat_santri_aktif',
            'site_stat_asatidz',
            'site_stat_alumni',
            'site_meta_title',
            'site_meta_description',
            'site_meta_keywords',
            'google_site_verification',
            'google_analytics_id',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        // Handle upload hero image beranda
        if ($request->hasFile('home_hero_image')) {
            $oldHero = SiteSetting::get('home_hero_image');
            if ($oldHero && str_starts_with($oldHero, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldHero));
            }
            $path = $request->file('home_hero_image')->store('settings/hero', 'public');
            SiteSetting::set('home_hero_image', '/storage/' . $path);
        } elseif ($request->filled('home_hero_image_url')) {
            SiteSetting::set('home_hero_image', $request->input('home_hero_image_url'));
        }

        // Handle upload OG Image SEO
        if ($request->hasFile('site_og_image')) {
            $oldOg = SiteSetting::get('site_og_image');
            if ($oldOg && str_starts_with($oldOg, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldOg));
            }
            $path = $request->file('site_og_image')->store('settings/seo', 'public');
            SiteSetting::set('site_og_image', '/storage/' . $path);
        } elseif ($request->filled('site_og_image_url')) {
            SiteSetting::set('site_og_image', $request->input('site_og_image_url'));
        }

        AuditLog::log('update', 'site_setting', null, "Memperbarui konfigurasi situs global, WhatsApp, hero banner, dan SEO.");

        return back()->with('success', "Pengaturan website (Kontak, Hero Banner, & SEO) berhasil disimpan.");
    }
}
