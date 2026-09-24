<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $news = News::with('author')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'scope' => ['required', 'in:foundation,smp,sma,dayah,ikada,global'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $slug = Str::slug($request->title);
        $count = News::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('news', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach (array_slice($request->file('gallery_images'), 0, 5) as $img) {
                $path = $img->store('news/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
        }

        $news = News::create([
            'author_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'scope' => $request->scope,
            'excerpt' => $request->excerpt ?: Str::limit(strip_tags($request->content), 150),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
            'thumbnail_path' => $thumbnailPath ? '/storage/' . $thumbnailPath : null,
            'gallery_images' => !empty($galleryPaths) ? $galleryPaths : null,
        ]);

        AuditLog::log('create', 'news', $news->id, "Menulis berita baru: {$news->title}.");

        return redirect()->route('admin.news.index')->with('success', "Berita \"{$news->title}\" berhasil disimpan.");
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'scope' => ['required', 'in:foundation,smp,sma,dayah,ikada,global'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $data = [
            'title' => $request->title,
            'scope' => $request->scope,
            'excerpt' => $request->excerpt ?: Str::limit(strip_tags($request->content), 150),
            'content' => $request->content,
            'status' => $request->status,
        ];

        if ($request->status === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail_path && str_starts_with($news->thumbnail_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $news->thumbnail_path));
            }
            $path = $request->file('thumbnail')->store('news', 'public');
            $data['thumbnail_path'] = '/storage/' . $path;
        }

        // Handle existing gallery and removal
        $existingGallery = is_array($news->gallery_images) ? $news->gallery_images : [];
        if ($request->has('remove_gallery_images')) {
            foreach ($request->input('remove_gallery_images') as $removedPath) {
                if (str_starts_with($removedPath, '/storage/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $removedPath));
                }
                $existingGallery = array_values(array_filter($existingGallery, fn($p) => $p !== $removedPath));
            }
        }

        // Handle new gallery uploads (max 5 in total)
        if ($request->hasFile('gallery_images')) {
            $remainingSlots = max(0, 5 - count($existingGallery));
            foreach (array_slice($request->file('gallery_images'), 0, $remainingSlots) as $img) {
                $path = $img->store('news/gallery', 'public');
                $existingGallery[] = '/storage/' . $path;
            }
        }
        $data['gallery_images'] = !empty($existingGallery) ? $existingGallery : null;

        $news->update($data);

        AuditLog::log('update', 'news', $news->id, "Memperbarui berita: {$news->title}.");

        return redirect()->route('admin.news.index')->with('success', "Berita \"{$news->title}\" berhasil diperbarui.");
    }

    public function destroy(News $news): RedirectResponse
    {
        $title = $news->title;
        if ($news->thumbnail_path && str_starts_with($news->thumbnail_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $news->thumbnail_path));
        }

        if (is_array($news->gallery_images)) {
            foreach ($news->gallery_images as $galPath) {
                if (str_starts_with($galPath, '/storage/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $galPath));
                }
            }
        }

        $news->delete();

        AuditLog::log('delete', 'news', $news->id, "Menghapus berita: {$title}.");

        return redirect()->route('admin.news.index')->with('success', "Berita \"{$title}\" berhasil dihapus.");
    }
}
