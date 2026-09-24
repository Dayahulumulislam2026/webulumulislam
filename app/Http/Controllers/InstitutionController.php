<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\GalleryAlbum;
use App\Models\GalleryMedia;
use App\Models\Institution;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Statistic;
use App\Models\StructurePosition;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    public function smp(): View
    {
        $institution = Institution::with('statistics')->where('type', 'smp')->firstOrFail();

        $stats = get_aggregated_education_stats();
        $topStructureMembers = $this->getTopStructureMembers($institution, 5);
        $alumni = $this->getFeaturedOrRecentAlumni('smp', 13);
        $galleryPhotos = $this->getLatestGalleryPhotos($institution->id, 5);

        $latestNews = News::where('status', 'published')
            ->where('scope', 'smp')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $waTemplate = SiteSetting::get('whatsapp_template_smp', 'Assalamualaikum. Saya ingin bertanya mengenai pendaftaran SMP Ulumul Islam.');
        $waLink = generate_whatsapp_link($institution->whatsapp, $waTemplate);

        return view('institutions.smp', compact(
            'institution',
            'stats',
            'topStructureMembers',
            'galleryPhotos',
            'alumni',
            'latestNews',
            'waLink'
        ));
    }

    public function sma(): View
    {
        $institution = Institution::with('statistics')->where('type', 'sma')->firstOrFail();

        $stats = get_aggregated_education_stats();
        $topStructureMembers = $this->getTopStructureMembers($institution, 5);
        $alumni = $this->getFeaturedOrRecentAlumni('sma', 13);
        $galleryPhotos = $this->getLatestGalleryPhotos($institution->id, 5);

        $latestNews = News::where('status', 'published')
            ->where('scope', 'sma')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $waTemplate = SiteSetting::get('whatsapp_template_sma', 'Assalamualaikum. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.');
        $waLink = generate_whatsapp_link($institution->whatsapp, $waTemplate);

        return view('institutions.sma', compact(
            'institution',
            'stats',
            'topStructureMembers',
            'galleryPhotos',
            'alumni',
            'latestNews',
            'waLink'
        ));
    }

    public function dayah(): View
    {
        $institution = Institution::where('type', 'dayah')->firstOrFail();

        $stats = get_aggregated_education_stats();
        $topStructureMembers = $this->getTopStructureMembers($institution, 5);
        $alumni = $this->getFeaturedOrRecentAlumni('dayah', 13);
        $galleryPhotos = $this->getLatestGalleryPhotos($institution->id, 5);

        $latestNews = News::where('status', 'published')
            ->where('scope', 'dayah')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $waTemplate = SiteSetting::get('whatsapp_template_dayah', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Dayah Terpadu Ulumul Islam.');
        $waLink = generate_whatsapp_link($institution->whatsapp, $waTemplate);

        return view('institutions.dayah', compact(
            'institution',
            'stats',
            'topStructureMembers',
            'galleryPhotos',
            'alumni',
            'latestNews',
            'waLink'
        ));
    }

    public function ikada(): View
    {
        $institution = Institution::where('type', 'ikada')->firstOrFail();

        $topStructureMembers = $this->getTopStructureMembers($institution, 5);

        $totalAlumni = Statistic::where('institution_id', $institution->id)
            ->where('metric', 'total_alumni')
            ->first()?->value ?? 1250;

        $totalAngkatan = Statistic::where('institution_id', $institution->id)
            ->where('metric', 'total_angkatan')
            ->first()?->value ?? 15;

        $totalPtn = Statistic::where('institution_id', $institution->id)
            ->where('metric', 'total_ptn')
            ->first()?->value ?? 85;

        $stats = [
            'total_alumni' => $totalAlumni,
            'total_angkatan' => $totalAngkatan,
            'total_ptn' => $totalPtn,
        ];

        $alumni = $this->getFeaturedOrRecentAlumni(null, 13);
        $galleryPhotos = $this->getLatestGalleryPhotos($institution->id, 5);

        $latestNews = News::where('status', 'published')
            ->where('scope', 'ikada')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $waTemplate = SiteSetting::get('whatsapp_template_ikada', 'Assalamualaikum. Saya ingin bertanya mengenai IKADA UI (Ikatan Alumni Dayah Ulumul Islam).');
        $waLink = generate_whatsapp_link($institution->whatsapp, $waTemplate);

        return view('institutions.ikada', compact(
            'institution',
            'stats',
            'topStructureMembers',
            'galleryPhotos',
            'alumni',
            'latestNews',
            'waLink'
        ));
    }

    public function tentangKami(): View
    {
        $foundation = Institution::where('type', 'foundation')->firstOrFail();

        $smp = Institution::where('type', 'smp')->first();
        $sma = Institution::where('type', 'sma')->first();
        $dayah = Institution::where('type', 'dayah')->first();

        $topStructureMembers = $this->getTopStructureMembers($foundation, 5);
        $galleryPhotos = $this->getLatestGalleryPhotos($foundation->id, 5);

        $latestNews = News::where('status', 'published')
            ->where('scope', 'foundation')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $settings = [
            'phone' => SiteSetting::get('site_phone', $foundation->phone),
            'address' => SiteSetting::get('site_address', $foundation->address),
            'gmaps' => SiteSetting::get('site_gmaps', ''),
            'wa_link' => generate_whatsapp_link($foundation->whatsapp, 'Assalamualaikum. Saya ingin bertanya mengenai Yayasan Ulumul Islam.'),
        ];

        return view('institutions.tentang-kami', compact(
            'foundation',
            'smp',
            'sma',
            'dayah',
            'topStructureMembers',
            'galleryPhotos',
            'latestNews',
            'settings'
        ));
    }

    public function structure(Request $request): View
    {
        $selectedUnit = $request->query('unit', 'foundation');

        $institutions = Institution::with([
            'structurePositions' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            },
            'structurePositions.members' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }
        ])->whereIn('type', ['foundation', 'dayah', 'smp', 'sma', 'ikada'])->get()->keyBy('type');

        $activeInstitution = $institutions->get($selectedUnit) ?? $institutions->first();

        $positions = $activeInstitution ? $activeInstitution->structurePositions : collect();
        $leaders = $positions->where('category', 'leader');
        $vices = $positions->where('category', 'vice');
        $divisions = $positions->where('category', 'division');

        return view('structure.index', compact('institutions', 'selectedUnit', 'activeInstitution', 'leaders', 'vices', 'divisions'));
    }

    private function getTopStructureMembers(Institution $institution, int $limit = 6)
    {
        $positions = StructurePosition::with(['members' => function ($q) {
            $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
        }])
            ->where('institution_id', $institution->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $topList = collect();
        foreach ($positions as $pos) {
            // Pick ONLY the primary leader / ketua of each position (skip regular members)
            $leaderMember = null;

            // 1. First priority: explicitly marked as 'head'
            $leaderMember = $pos->members->firstWhere('member_role', 'head');

            // 2. If none marked as 'head', take the first member whose title doesn't start with 'Anggota'
            if (!$leaderMember && $pos->members->isNotEmpty()) {
                $first = $pos->members->first();
                if (!preg_match('/^anggota/i', trim($first->title ?: ''))) {
                    $leaderMember = $first;
                }
            }

            if ($leaderMember) {
                $topList->push([
                    'member' => $leaderMember,
                    'position' => $pos,
                    'category' => $pos->category,
                ]);
                if ($topList->count() >= $limit) {
                    break;
                }
            }
        }

        return $topList;
    }


    private function getFeaturedOrRecentAlumni(?string $level = null, int $limit = 13)
    {
        $query = Alumni::where('status', 'published');
        if ($level) {
            $query->where(function ($q) use ($level) {
                $q->where('display_units', 'like', "%{$level}%")
                  ->orWhere('graduation_levels', 'like', "%{$level}%");
            });
        }

        $pinned = (clone $query)->where(function ($q) use ($level) {
            $q->where('is_home_pinned', true)
              ->orWhereHas('featured', function ($fq) use ($level) {
                  if ($level) {
                      $fq->where('placement', $level);
                  }
              });
        })->orderByDesc('created_at')->take($limit)->get();

        if ($pinned->count() < $limit) {
            $needed = $limit - $pinned->count();
            $pinnedIds = $pinned->pluck('id')->toArray();
            $recent = (clone $query)->whereNotIn('id', $pinnedIds)->orderByDesc('created_at')->take($needed)->get();
            return $pinned->concat($recent);
        }

        return $pinned;
    }

    private function getLatestGalleryPhotos(int $institutionId, int $limit = 5)
    {
        return GalleryMedia::where('type', 'image')
            ->whereHas('album', function ($q) use ($institutionId) {
                $q->where('institution_id', $institutionId)->where('is_active', true);
            })
            ->with('album')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }
}
