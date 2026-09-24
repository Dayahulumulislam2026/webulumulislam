<?php

use App\Models\Institution;
use App\Models\Statistic;

if (!function_exists('generate_whatsapp_link')) {
    function generate_whatsapp_link(?string $phone, ?string $message = null): string
    {
        if (empty($phone)) {
            $phone = '628111111111';
        }

        // Clean phone number
        $cleanPhone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        } elseif (!str_starts_with($cleanPhone, '62') && strlen($cleanPhone) > 0) {
            $cleanPhone = '62' . $cleanPhone;
        }

        $url = 'https://wa.me/' . $cleanPhone;
        if (!empty($message)) {
            $url .= '?text=' . urlencode($message);
        }

        return $url;
    }
}

if (!function_exists('get_aggregated_education_stats')) {
    function get_aggregated_education_stats(): array
    {
        $smp = Institution::where('type', 'smp')->first();
        $sma = Institution::where('type', 'sma')->first();

        $smpId = $smp?->id;
        $smaId = $sma?->id;

        $stats = Statistic::whereIn('institution_id', array_filter([$smpId, $smaId]))->get();

        $smpMale = $stats->where('institution_id', $smpId)->where('metric', 'students_male')->first()?->value ?? 0;
        $smpFemale = $stats->where('institution_id', $smpId)->where('metric', 'students_female')->first()?->value ?? 0;
        $smpAlumni = $stats->where('institution_id', $smpId)->where('metric', 'total_alumni')->first()?->value ?? 0;

        $smaMale = $stats->where('institution_id', $smaId)->where('metric', 'students_male')->first()?->value ?? 0;
        $smaFemale = $stats->where('institution_id', $smaId)->where('metric', 'students_female')->first()?->value ?? 0;
        $smaAlumni = $stats->where('institution_id', $smaId)->where('metric', 'total_alumni')->first()?->value ?? 0;

        $smpStudents = $smpMale + $smpFemale;
        $smaStudents = $smaMale + $smaFemale;
        $totalStudents = $smpStudents + $smaStudents;
        $totalAlumni = $smpAlumni + $smaAlumni;

        // If initial stats in DB are 0, provide clean base numbers for presentation
        $displaySmp = $smpStudents > 0 ? $smpStudents : 320;
        $displaySma = $smaStudents > 0 ? $smaStudents : 280;

        $siteStatSantri = site_setting('site_stat_santri_aktif');
        $siteStatAsatidz = site_setting('site_stat_asatidz');
        $siteStatAlumni = site_setting('site_stat_alumni');

        $displayStudents = ($siteStatSantri !== null && is_numeric($siteStatSantri)) ? (int) $siteStatSantri : ($totalStudents > 0 ? $totalStudents : ($displaySmp + $displaySma));
        $displayAlumni = ($siteStatAlumni !== null && is_numeric($siteStatAlumni)) ? (int) $siteStatAlumni : ($totalAlumni > 0 ? $totalAlumni : 1450);
        $displayAsatidz = ($siteStatAsatidz !== null && is_numeric($siteStatAsatidz)) ? (int) $siteStatAsatidz : 54;
        $displayPrestasi = 128;

        return [
            // Standard aggregated snake_case keys
            'total_santri' => $displayStudents,
            'total_alumni' => $displayAlumni,
            'total_asatidz' => $displayAsatidz,
            'total_prestasi' => $displayPrestasi,
            'total_smp' => $displaySmp,
            'total_sma' => $displaySma,
            'total_pesantren' => $displayStudents,

            // Raw & camelCase keys
            'smpMale' => $smpMale,
            'smpFemale' => $smpFemale,
            'smpStudents' => $smpStudents,
            'smpAlumni' => $smpAlumni,
            'smaMale' => $smaMale,
            'smaFemale' => $smaFemale,
            'smaStudents' => $smaStudents,
            'smaAlumni' => $smaAlumni,
            'totalStudents' => $displayStudents,
            'totalAlumni' => $displayAlumni,
        ];
    }
}

if (!function_exists('site_setting')) {
    function site_setting(string $key, ?string $default = null): ?string
    {
        try {
            return \App\Models\SiteSetting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

