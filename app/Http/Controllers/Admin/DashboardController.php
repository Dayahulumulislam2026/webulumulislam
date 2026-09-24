<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\GalleryAlbum;
use App\Models\GalleryMedia;
use App\Models\News;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = get_aggregated_education_stats();

        $counts = [
            'news' => News::count(),
            'announcements' => Announcement::count(),
            'albums' => GalleryAlbum::count(),
            'media' => GalleryMedia::count(),
            'alumni' => Alumni::count(),
            'admins' => User::count(),
        ];

        $recentNews = News::orderByDesc('created_at')->take(5)->get();
        $recentAnnouncements = Announcement::orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'counts', 'recentNews', 'recentAnnouncements'));
    }
}
