<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\FeaturedAlumni;
use App\Models\Institution;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $foundation = Institution::where('type', 'foundation')->first();
        $smp = Institution::where('type', 'smp')->first();
        $sma = Institution::where('type', 'sma')->first();
        $dayah = Institution::where('type', 'dayah')->first();

        $stats = get_aggregated_education_stats();

        $oneMonthAgo = now()->subDays(30);
        $announcements = Announcement::where('status', 'published')
            ->where('created_at', '>=', $oneMonthAgo)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $news = News::where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $pinnedHomeAlumni = Alumni::where('status', 'published')
            ->where(function ($q) {
                $q->where('is_home_pinned', true)
                  ->orWhereHas('featured', function ($fq) {
                      $fq->where('placement', 'home');
                  });
            })
            ->orderByDesc('created_at')
            ->take(7)
            ->get();

        if ($pinnedHomeAlumni->count() < 7) {
            $needed = 7 - $pinnedHomeAlumni->count();
            $pinnedIds = $pinnedHomeAlumni->pluck('id')->toArray();
            $recent = Alumni::where('status', 'published')
                ->whereNotIn('id', $pinnedIds)
                ->orderByDesc('created_at')
                ->take($needed)
                ->get();
            $featuredAlumni = $pinnedHomeAlumni->concat($recent);
        } else {
            $featuredAlumni = $pinnedHomeAlumni;
        }

        $settings = [
            'phone' => SiteSetting::get('site_phone', '628111111111'),
            'address' => SiteSetting::get('site_address', 'Jl. Ulumul Islam No. 1, Aceh'),
            'gmaps' => SiteSetting::get('site_gmaps', ''),
            'wa_general' => SiteSetting::get('whatsapp_template_general', SiteSetting::get('whatsapp_template_yayasan', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Ulumul Islam.')),
            'home_hero_image' => SiteSetting::get('home_hero_image', ''),
        ];

        return view('home', compact(
            'foundation',
            'smp',
            'sma',
            'dayah',
            'stats',
            'announcements',
            'news',
            'featuredAlumni',
            'settings'
        ));
    }

    public function sitemap(): \Illuminate\Http\Response
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/tentang-kami'), 'priority' => '0.9', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/dayah'), 'priority' => '0.9', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/smp'), 'priority' => '0.9', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/sma'), 'priority' => '0.9', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/ikada'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/struktur-organisasi'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/pendaftaran'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/berita'), 'priority' => '0.8', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
            ['loc' => url('/galeri'), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
        ];

        $news = News::where('status', 'published')->orderByDesc('created_at')->get();
        foreach ($news as $item) {
            $urls[] = [
                'loc' => route('news.show', $item->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => ($item->updated_at ?? $item->created_at)->toAtomString(),
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
