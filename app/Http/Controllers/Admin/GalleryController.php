<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\GalleryAlbum;
use App\Models\GalleryMedia;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $albums = GalleryAlbum::with(['institution', 'photos', 'videos'])
            ->orderBy('sort_order')
            ->get();
        $institutions = Institution::all();

        return view('admin.gallery.index', compact('albums', 'institutions'));
    }

    public function storeAlbum(Request $request): RedirectResponse
    {
        $request->validate([
            'institution_id' => ['nullable', 'exists:institutions,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $slug = Str::slug($request->title);
        $count = GalleryAlbum::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('gallery_covers', 'public');
        }

        $album = GalleryAlbum::create([
            'institution_id' => $request->institution_id,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'cover_path' => $coverPath ? '/storage/' . $coverPath : null,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        AuditLog::log('create', 'gallery_album', $album->id, "Membuat album galeri: {$album->title}.");

        return redirect()->route('admin.gallery.show', $album->id)->with('success', "Album \"{$album->title}\" berhasil dibuat. Silakan tambahkan foto dan video.");
    }

    public function show(GalleryAlbum $album): View
    {
        $album->load(['institution', 'photos', 'videos']);
        return view('admin.gallery.show', compact('album'));
    }

    public function updateAlbum(Request $request, GalleryAlbum $album): RedirectResponse
    {
        $request->validate([
            'institution_id' => ['nullable', 'exists:institutions,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'institution_id' => $request->institution_id,
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('cover')) {
            if ($album->cover_path && str_starts_with($album->cover_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $album->cover_path));
            }
            $path = $request->file('cover')->store('gallery_covers', 'public');
            $data['cover_path'] = '/storage/' . $path;
        }

        $album->update($data);

        AuditLog::log('update', 'gallery_album', $album->id, "Memperbarui album galeri: {$album->title}.");

        return back()->with('success', "Album \"{$album->title}\" berhasil diperbarui.");
    }

    public function destroyAlbum(GalleryAlbum $album): RedirectResponse
    {
        $title = $album->title;
        // Delete all files in album
        foreach ($album->media as $m) {
            if ($m->file_path && str_starts_with($m->file_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $m->file_path));
            }
        }
        if ($album->cover_path && str_starts_with($album->cover_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $album->cover_path));
        }

        $album->delete();

        AuditLog::log('delete', 'gallery_album', $album->id, "Menghapus album galeri: {$title}.");

        return redirect()->route('admin.gallery.index')->with('success', "Album \"{$title}\" beserta seluruh medianya berhasil dihapus.");
    }

    public function uploadMedia(Request $request, GalleryAlbum $album): RedirectResponse
    {
        $rules = [
            'type' => ['required', 'in:image,video'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];

        if ($request->input('type') === 'video') {
            @ini_set('max_execution_time', '300');
            @ini_set('max_input_time', '300');
            $rules['file'] = [
                'required',
                'file',
                'max:153600', // Maks 150MB
                function ($attribute, $value, $fail) {
                    if (!$value instanceof \Illuminate\Http\UploadedFile) {
                        return;
                    }
                    $ext = strtolower($value->getClientOriginalExtension());
                    $allowed = ['mp4', 'mov', 'avi', 'webm', 'mkv', '3gp', 'wmv', 'flv', 'm4v', 'ts', 'ogg', 'ogv', 'mpeg', 'mpg', 'vob', 'rm', 'rmvb', 'asf', 'divx', 'f4v'];
                    if (!in_array($ext, $allowed)) {
                        $fail('Format file video tidak didukung. Harap gunakan format video standar seperti MP4, MOV, AVI, WEBM, MKV, WMV, FLV, atau 3GP.');
                    }
                },
            ];
        } else {
            $rules['file'] = ['required', 'file', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240'];
        }

        $request->validate($rules);

        $type = $request->type;
        $file = $request->file('file');
        $folder = $type === 'video' ? 'gallery_videos' : 'gallery_images';
        $path = $file->store($folder, 'public');

        $media = GalleryMedia::create([
            'album_id' => $album->id,
            'type' => $type,
            'title' => $request->title ?: $file->getClientOriginalName(),
            'description' => $request->description,
            'file_path' => '/storage/' . $path,
            'file_size' => $file->getSize(),
            'sort_order' => 0,
        ]);

        // If album doesn't have a cover yet and this is an image, set it as cover
        if (!$album->cover_path && $type === 'image') {
            $album->update(['cover_path' => '/storage/' . $path]);
        }

        AuditLog::log('upload', 'gallery_media', $media->id, "Mengunggah {$type} baru \"{$media->title}\" ke album {$album->title}.");

        return back()->with('success', ucfirst($type) . " \"{$media->title}\" berhasil diunggah ke album.");
    }

    public function updateMedia(Request $request, GalleryMedia $medium): RedirectResponse
    {
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $medium->update([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->integer('sort_order', 0),
        ]);

        AuditLog::log('update', 'gallery_media', $medium->id, "Memperbarui info media: {$medium->title}.");

        return back()->with('success', "Informasi media \"{$medium->title}\" berhasil diperbarui.");
    }

    public function destroyMedia(GalleryMedia $medium): RedirectResponse
    {
        $title = $medium->title;
        if ($medium->file_path && str_starts_with($medium->file_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $medium->file_path));
        }
        $medium->delete();

        AuditLog::log('delete', 'gallery_media', $medium->id, "Menghapus media: {$title}.");

        return back()->with('success', "Media \"{$title}\" berhasil dihapus.");
    }
}
