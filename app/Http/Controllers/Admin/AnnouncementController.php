<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::orderByDesc('created_at')->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'scope' => ['required', 'in:foundation,smp,sma,dayah,global'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:published_at'],
        ]);

        $slug = Str::slug($request->title);
        $count = Announcement::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'slug' => $slug,
            'scope' => $request->scope,
            'summary' => $request->summary ?: Str::limit(strip_tags($request->content), 120),
            'content' => $request->content,
            'image_path' => $imagePath ? '/storage/' . $imagePath : null,
            'status' => $request->status,
            'published_at' => $request->published_at ?: ($request->status === 'published' ? now() : null),
            'expires_at' => $request->expires_at ?: ($request->status === 'published' ? now()->addDays(30) : null),
        ]);

        AuditLog::log('create', 'announcement', $announcement->id, "Membuat pengumuman: {$announcement->title}.");

        return back()->with('success', "Pengumuman \"{$announcement->title}\" berhasil dibuat.");
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'scope' => ['required', 'in:foundation,smp,sma,dayah,global'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $data = [
            'title' => $request->title,
            'scope' => $request->scope,
            'summary' => $request->summary ?: Str::limit(strip_tags($request->content), 120),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->published_at ?: ($request->status === 'published' ? now() : null),
            'expires_at' => $request->expires_at,
        ];

        if ($request->hasFile('image')) {
            if ($announcement->image_path && str_starts_with($announcement->image_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $announcement->image_path));
            }
            $path = $request->file('image')->store('announcements', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $announcement->update($data);

        AuditLog::log('update', 'announcement', $announcement->id, "Memperbarui pengumuman: {$announcement->title}.");

        return back()->with('success', "Pengumuman \"{$announcement->title}\" berhasil diperbarui.");
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $title = $announcement->title;
        if ($announcement->image_path && str_starts_with($announcement->image_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $announcement->image_path));
        }
        $announcement->delete();

        AuditLog::log('delete', 'announcement', $announcement->id, "Menghapus pengumuman: {$title}.");

        return back()->with('success', "Pengumuman \"{$title}\" berhasil dihapus.");
    }
}
