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
}
