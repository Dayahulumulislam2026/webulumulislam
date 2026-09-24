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

if (!function_exists('format_gmaps_embed_url')) {
    function format_gmaps_embed_url(?string $input): string
    {
        $input = trim((string) $input);

        // 1. If empty, generate embed URL based on configured site address or default
        if (empty($input)) {
            $address = site_setting('site_address', 'Dayah Terpadu Ulumul Islam Uteunkot Cunda Lhokseumawe Aceh');
            return 'https://maps.google.com/maps?q=' . urlencode($address) . '&hl=id&z=16&output=embed';
        }

        // 2. If user pasted an <iframe>...</iframe> tag, extract src attribute
        if (preg_match('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/i', $input, $matches)) {
            return html_entity_decode($matches[1]);
        }

        // 3. If input is already an embed URL (contains /embed or output=embed)
        if (str_contains($input, '/maps/embed') || str_contains($input, 'output=embed')) {
            return $input;
        }

        // 4. Cache key for resolved URL if external resolution is required
        $cacheKey = 'gmaps_embed_fmt_' . md5($input);
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400 * 30, function () use ($input) {
            $workingUrl = $input;

            // If shortlink (maps.app.goo.gl or goo.gl/maps), follow redirects to obtain expanded Google Maps URL
            if (preg_match('#(maps\.app\.goo\.gl|goo\.gl/maps)#i', $workingUrl)) {
                try {
                    $ch = curl_init($workingUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                    curl_exec($ch);
                    $effective = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                    curl_close($ch);
                    if ($effective && $effective !== $workingUrl) {
                        $workingUrl = $effective;
                    }
                } catch (\Throwable $e) {}
            }

            // Extract coordinates from !3d{lat}!4d{lng} (standard Google Maps Place URL)
            if (preg_match('/!3d([0-9.-]+)!4d([0-9.-]+)/', $workingUrl, $matches)) {
                $lat = $matches[1];
                $lng = $matches[2];
                return "https://maps.google.com/maps?q={$lat},{$lng}&hl=id&z=16&output=embed";
            }

            // Extract coordinates from @{lat},{lng}
            if (preg_match('#@([0-9.-]+),([0-9.-]+)#', $workingUrl, $matches)) {
                $lat = $matches[1];
                $lng = $matches[2];
                return "https://maps.google.com/maps?q={$lat},{$lng}&hl=id&z=16&output=embed";
            }

            // Extract place name from /maps/place/{NAME}/
            if (preg_match('#/maps/place/([^/@?]+)#i', $workingUrl, $matches)) {
                $place = urldecode($matches[1]);
                $place = str_replace('+', ' ', $place);
                return "https://maps.google.com/maps?q=" . urlencode($place) . "&hl=id&z=16&output=embed";
            }

            // If query q=... is present
            if (preg_match('/[?&]q=([^&]+)/i', $workingUrl, $matches)) {
                $query = urldecode($matches[1]);
                if (!str_starts_with($query, 'http')) {
                    return "https://maps.google.com/maps?q=" . urlencode($query) . "&hl=id&z=16&output=embed";
                }
            }

            // If it's a URL that couldn't be parsed, use the site address as fallback query
            if (str_starts_with($workingUrl, 'http://') || str_starts_with($workingUrl, 'https://')) {
                $address = site_setting('site_address', 'Dayah Terpadu Ulumul Islam Uteunkot Cunda Lhokseumawe Aceh');
                return "https://maps.google.com/maps?q=" . urlencode($address) . "&hl=id&z=16&output=embed";
            }

            // Otherwise treat input as search query/address
            return "https://maps.google.com/maps?q=" . urlencode($workingUrl) . "&hl=id&z=16&output=embed";
        });
    }
}

if (!function_exists('get_gmaps_direct_url')) {
    function get_gmaps_direct_url(?string $input): string
    {
        $input = trim((string) $input);

        if (empty($input)) {
            $address = site_setting('site_address', 'Dayah Terpadu Ulumul Islam Uteunkot Cunda Lhokseumawe Aceh');
            return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
        }

        // If user pasted iframe, extract src
        if (preg_match('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/i', $input, $matches)) {
            return html_entity_decode($matches[1]);
        }

        // If it's a URL (http / https), return directly
        if (str_starts_with($input, 'http://') || str_starts_with($input, 'https://')) {
            return $input;
        }

        return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($input);
    }
}



