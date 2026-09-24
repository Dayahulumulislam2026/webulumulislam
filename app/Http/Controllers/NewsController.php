<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $selectedUnit = $request->query('unit', $request->query('scope', 'all'));
        $selectedYear = $request->query('year');

        $query = News::with('author')
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');

        if ($selectedUnit && $selectedUnit !== 'all') {
            if ($selectedUnit === 'foundation') {
                $query->whereIn('scope', ['foundation', 'global']);
            } else {
                $query->where('scope', $selectedUnit);
            }
        }

        if ($selectedYear && is_numeric($selectedYear)) {
            $query->whereYear('published_at', $selectedYear);
        }

        $news = $query->paginate(9)->withQueryString();

        // Distinct years for filter (cross-database compatible)
        $years = News::where('status', 'published')
            ->whereNotNull('published_at')
            ->pluck('published_at')
            ->map(function ($date) {
                return (int) date('Y', strtotime($date));
            })
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        if (empty($years)) {
            $years = [(int) date('Y')];
        }

        // Announcements (max 10, max 30 days old)
        $oneMonthAgo = now()->subDays(30);
        $announcements = \App\Models\Announcement::where('status', 'published')
            ->where('created_at', '>=', $oneMonthAgo)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('news.index', compact('news', 'selectedUnit', 'selectedYear', 'years', 'announcements'));
    }

    public function show(string $slug): View
    {
        $article = News::with('author')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $article->id)
            ->where('scope', $article->scope)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'relatedNews'));
    }
}
