<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $selectedUnit = $request->query('unit', 'all');
        $selectedYear = $request->query('year');

        $query = GalleryAlbum::with(['institution', 'photos', 'videos'])
            ->where('is_active', true)
            ->orderByDesc('created_at');

        if ($selectedUnit && $selectedUnit !== 'all') {
            $institution = Institution::where('type', $selectedUnit)->first();
            if ($institution) {
                $query->where('institution_id', $institution->id);
            }
        }

        if ($selectedYear && is_numeric($selectedYear)) {
            $query->whereYear('created_at', $selectedYear);
        }

        $albums = $query->paginate(12)->withQueryString();

        $years = GalleryAlbum::where('is_active', true)
            ->selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        if (empty($years)) {
            $years = [(int) date('Y')];
        }

        $institutions = Institution::all();

        return view('gallery.index', compact('albums', 'institutions', 'selectedUnit', 'selectedYear', 'years'));
    }

    public function show(string $slug): View
    {
        $album = GalleryAlbum::with(['institution', 'photos', 'videos'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $photos = $album->photos;
        $videos = $album->videos;

        return view('gallery.show', compact('album', 'photos', 'videos'));
    }
}
