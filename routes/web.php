<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\AdmissionController as AdminAdmissionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\InstitutionController as AdminInstitutionController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\StructureController as AdminStructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/smp', [InstitutionController::class, 'smp'])->name('smp');
Route::get('/sma', [InstitutionController::class, 'sma'])->name('sma');
Route::get('/dayah', [InstitutionController::class, 'dayah'])->name('dayah');
Route::get('/ikada', [InstitutionController::class, 'ikada'])->name('ikada');
Route::get('/tentang-kami', [InstitutionController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/struktur-organisasi', [InstitutionController::class, 'structure'])->name('structure.public');
Route::get('/pendaftaran', [AdmissionController::class, 'index'])->name('admission');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    // 1. Dashboard Overview (Semua Role)
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // 2. Modul Konten & Operasional (Semua Role: Super Admin, Co-Super Admin, Admin Biasa, Admin IKADA)
    // 2a. Berita & Warta (Explicit parameter binding for 'news' to prevent {beritum} bug)
    Route::resource('/berita', AdminNewsController::class)->parameters(['berita' => 'news'])->names([
        'index' => 'news.index',
        'create' => 'news.create',
        'store' => 'news.store',
        'edit' => 'news.edit',
        'update' => 'news.update',
        'destroy' => 'news.destroy',
    ]);

    // 2b. Pengumuman (Flyer & Text)
    Route::resource('/pengumuman', AdminAnnouncementController::class)->parameters(['pengumuman' => 'announcement'])->only(['index', 'store', 'update', 'destroy'])->names([
        'index' => 'announcements.index',
        'store' => 'announcements.store',
        'update' => 'announcements.update',
        'destroy' => 'announcements.destroy',
    ]);

    // 2c. Galeri (Foto & Video hingga 150MB, Judul & Deskripsi)
    Route::get('/galeri', [AdminGalleryController::class, 'index'])->name('gallery.index');
    Route::post('/galeri/album', [AdminGalleryController::class, 'storeAlbum'])->name('gallery.albums.store');
    Route::get('/galeri/album/{album}', [AdminGalleryController::class, 'show'])->name('gallery.show');
    Route::put('/galeri/album/{album}', [AdminGalleryController::class, 'updateAlbum'])->name('gallery.albums.update');
    Route::delete('/galeri/album/{album}', [AdminGalleryController::class, 'destroyAlbum'])->name('gallery.albums.destroy');
    Route::post('/galeri/album/{album}/upload', [AdminGalleryController::class, 'uploadMedia'])->name('gallery.media.upload');
    Route::put('/galeri/media/{medium}', [AdminGalleryController::class, 'updateMedia'])->name('gallery.media.update');
    Route::delete('/galeri/media/{medium}', [AdminGalleryController::class, 'destroyMedia'])->name('gallery.media.destroy');

    // 2d. Pendaftaran PSB (Buka/Tutup, Syarat, Dokumen, Jadwal, WA)
    Route::get('/pendaftaran', [AdminAdmissionController::class, 'index'])->name('admission.index');
    Route::post('/pendaftaran', [AdminAdmissionController::class, 'update'])->name('admission.update');

    // 2e. Alumni & Prestasi
    Route::get('/alumni', [AdminAlumniController::class, 'index'])->name('alumni.index');
    Route::post('/alumni', [AdminAlumniController::class, 'store'])->name('alumni.store');
    Route::put('/alumni/{alumnus}', [AdminAlumniController::class, 'update'])->name('alumni.update');
    Route::delete('/alumni/{alumnus}', [AdminAlumniController::class, 'destroy'])->name('alumni.destroy');
    Route::post('/alumni/{alumnus}/toggle-pin-unit', [AdminAlumniController::class, 'togglePinUnit'])->name('alumni.toggle_pin_unit');
    Route::post('/alumni/{alumnus}/toggle-pin-home', [AdminAlumniController::class, 'togglePinHome'])->name('alumni.toggle_pin_home');
    Route::post('/alumni/update-total-alumni', [AdminAlumniController::class, 'updateTotalAlumni'])->name('alumni.update_total');

    // 2f. Profil Institusi & Media (Logo/Banner) (Super Admin, Co-Super Admin, & Admin IKADA)
    Route::get('/institusi', [AdminInstitutionController::class, 'index'])->name('institutions.index');
    Route::put('/institusi/{institution}', [AdminInstitutionController::class, 'update'])->name('institutions.update');

    // 2g. Struktur Kepengurusan & Divisi (Super Admin, Co-Super Admin, & Admin IKADA)
    Route::get('/struktur', [AdminStructureController::class, 'index'])->name('structure.index');
    Route::post('/struktur/posisi', [AdminStructureController::class, 'storePosition'])->name('structure.positions.store');
    Route::put('/struktur/posisi/{position}', [AdminStructureController::class, 'updatePosition'])->name('structure.positions.update');
    Route::delete('/struktur/posisi/{position}', [AdminStructureController::class, 'destroyPosition'])->name('structure.positions.destroy');
    Route::post('/struktur/posisi/{position}/toggle-pin', [AdminStructureController::class, 'togglePin'])->name('structure.positions.toggle_pin');
    Route::post('/struktur/sync-dayah', [AdminStructureController::class, 'syncDayah'])->name('structure.sync_dayah');
    Route::get('/struktur/sync-dayah', [AdminStructureController::class, 'syncDayah'])->name('structure.sync_dayah_get');
    Route::post('/struktur/anggota', [AdminStructureController::class, 'storeMember'])->name('structure.members.store');
    Route::put('/struktur/anggota/{member}', [AdminStructureController::class, 'updateMember'])->name('structure.members.update');
    Route::delete('/struktur/anggota/{member}', [AdminStructureController::class, 'destroyMember'])->name('structure.members.destroy');

    // 3. Modul Sistem & Otoritas Khusus (KHUSUS Super Admin & Co-Super Admin; Tersembunyi dari Admin Biasa & Admin IKADA)
    Route::middleware('super_or_co_admin')->group(function () {
        // Pengaturan Global Situs
        Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/pengaturan', [AdminSettingController::class, 'update'])->name('settings.update');


        // Manajemen Pengguna & Audit Logs
        Route::resource('/users', AdminUserController::class)->only(['index', 'store', 'update', 'destroy'])->names([
            'index' => 'users.index',
            'store' => 'users.store',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);
        Route::get('/audit-logs', [AdminAuditLogController::class, 'index'])->name('audit_logs.index');
    });
});
