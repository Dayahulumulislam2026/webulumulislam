<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UlumulIslamTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Uji semua rute publik utama
     */
    public function test_public_pages_load_successfully(): void
    {
        $routes = [
            '/',
            '/ikada',
            '/struktur-organisasi',
            '/struktur-organisasi?unit=foundation',
            '/struktur-organisasi?unit=dayah',
            '/struktur-organisasi?unit=smp',
            '/struktur-organisasi?unit=sma',
            '/struktur-organisasi?unit=ikada',
            '/tentang-kami',
            '/dayah',
            '/smp',
            '/sma',
            '/berita',
            '/galeri',
            '/pendaftaran',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Uji rute admin panel dengan login Super Admin
     */
    public function test_admin_pages_load_successfully_as_superadmin(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $this->markTestSkipped('Superadmin user not found in database.');
        }

        $adminRoutes = [
            '/admin/institusi?tab=foundation',
            '/admin/institusi?tab=dayah',
            '/admin/institusi?tab=smp',
            '/admin/institusi?tab=sma',
            '/admin/institusi?tab=ikada',
            '/admin/struktur?tab=foundation',
            '/admin/struktur?tab=ikada',
            '/admin/alumni',
            '/admin/galeri',
            '/admin/pendaftaran',
            '/admin/users',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->actingAs($admin)->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Uji rute admin IKADA
     */
    public function test_admin_ikada_access(): void
    {
        $ikadaUser = User::where('role', 'admin_ikada')->first();
        if (!$ikadaUser) {
            $this->markTestSkipped('Admin IKADA user not found.');
        }

        // Admin IKADA dapat mengakses profil institusi IKADA
        $response = $this->actingAs($ikadaUser)->get('/admin/institusi');
        $response->assertStatus(200);

        // Admin IKADA dapat mengakses struktur IKADA
        $response = $this->actingAs($ikadaUser)->get('/admin/struktur?tab=ikada');
        $response->assertStatus(200);
    }

    /**
     * Uji Alumni Multi-Placement & Pin Beranda
     */
    public function test_alumni_multi_placement_and_pin_home(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $this->markTestSkipped('Superadmin user not found in database.');
        }

        $response = $this->actingAs($admin)->post('/admin/alumni', [
            'name' => 'Fulan Testing Alumni',
            'graduation_levels' => ['smp', 'sma'],
            'display_units' => ['smp', 'sma', 'dayah', 'foundation'],
            'career_type' => 'academic',
            'position_or_program' => 'Mahasiswa Kedokteran',
            'institution_or_company' => 'Universitas Syiah Kuala',
            'short_description' => 'Alumni teladan berprestasi tinggi.',
            'status' => 'published',
            'is_home_pinned' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $alumni = \App\Models\Alumni::where('name', 'Fulan Testing Alumni')->first();
        $this->assertNotNull($alumni);
        $this->assertTrue($alumni->is_home_pinned);
        $this->assertTrue($alumni->hasGraduationLevel('smp'));
        $this->assertTrue($alumni->hasGraduationLevel('sma'));
        $this->assertTrue($alumni->displaysInUnit('dayah'));
        $this->assertTrue($alumni->displaysInUnit('foundation'));

        // Toggle pin home
        $toggleResponse = $this->actingAs($admin)->post("/admin/alumni/{$alumni->id}/toggle-pin-home");
        $toggleResponse->assertRedirect();
        $this->assertFalse($alumni->fresh()->is_home_pinned);

        // Cleanup
        $alumni->delete();
    }

    /**
     * Uji Kustomisasi Alur Pendaftaran (PSB Steps)
     */
    public function test_admission_steps_customization(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $this->markTestSkipped('Superadmin user not found in database.');
        }

        $smp = \App\Models\Institution::where('type', 'smp')->firstOrFail();

        $customSteps = [
            [
                'title' => 'Pengisian Formulir Digital',
                'description' => 'Mengisi formulir melalui link pendaftaran resmi.',
                'icon' => 'document',
            ],
            [
                'title' => 'Ujian Tahfidz & Akademik',
                'description' => 'Ujian hafalan Al-Qur\'an minimal 1 juz.',
                'icon' => 'academic',
            ],
            [
                'title' => 'Pengumuman Hasil Seleksi',
                'description' => 'Hasil seleksi diumumkan via portal.',
                'icon' => 'megaphone',
            ],
        ];

        $response = $this->actingAs($admin)->post('/admin/pendaftaran', [
            'institution_id' => $smp->id,
            'is_open' => 1,
            'requirements' => 'Persyaratan Uji PSB',
            'steps' => $customSteps,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $setting = \App\Models\AdmissionSetting::where('institution_id', $smp->id)->first();
        $this->assertNotNull($setting);
        $this->assertCount(3, $setting->steps);
        $this->assertEquals('Pengisian Formulir Digital', $setting->steps[0]['title']);

        // Check public page renders the step
        $publicRes = $this->get('/pendaftaran');
        $publicRes->assertStatus(200);
        $publicRes->assertSee('Pengisian Formulir Digital');
    }

    /**
     * Uji Pengaturan Statistik Beranda (Santri Aktif, Asatidz, Alumni)
     */
    public function test_home_statistics_and_site_settings(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $this->markTestSkipped('Superadmin user not found in database.');
        }

        $response = $this->actingAs($admin)->post('/admin/pengaturan', [
            'site_phone' => '628123456789',
            'site_address' => 'Aceh Utara',
            'site_stat_santri_aktif' => '750',
            'site_stat_asatidz' => '65',
            'site_stat_alumni' => '1800',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals('750', \App\Models\SiteSetting::get('site_stat_santri_aktif'));
        $this->assertEquals('65', \App\Models\SiteSetting::get('site_stat_asatidz'));
        $this->assertEquals('1800', \App\Models\SiteSetting::get('site_stat_alumni'));

        $stats = get_aggregated_education_stats();
        $this->assertEquals(750, $stats['total_santri']);
        $this->assertEquals(65, $stats['total_asatidz']);
        $this->assertEquals(1800, $stats['total_alumni']);

        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('750');
        $homeRes->assertSee('65');
        $homeRes->assertSee('1,800');
        $homeRes->assertDontSee('Prestasi Santri');
    }

    /**
     * Uji Pengaturan Statistik IKADA UI
     */
    public function test_admin_ikada_statistics_update(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $ikada = \App\Models\Institution::where('type', 'ikada')->firstOrFail();

        $response = $this->actingAs($admin)->put("/admin/institusi/{$ikada->id}", [
            'name' => 'Ikatan Alumni Dayah Ulumul Islam (IKADA UI)',
            'total_alumni' => 1350,
            'total_angkatan' => 18,
            'total_ptn' => 90,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $ikadaRes = $this->get('/ikada');
        $ikadaRes->assertStatus(200);
        $ikadaRes->assertSee('1,350');
        $ikadaRes->assertSee('18');
        $ikadaRes->assertSee('90+');
    }

    /**
     * Uji Unggah Video Galeri (Mendukung beragam ekstensi video hingga 150MB)
     */
    public function test_gallery_video_upload_support(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $album = \App\Models\GalleryAlbum::first();
        if (!$album) {
            $album = \App\Models\GalleryAlbum::create([
                'title' => 'Album Test Video',
                'slug' => 'album-test-video',
                'is_active' => true,
            ]);
        }

        // Test upload video dummy dengan format webm / mp4 / mkv
        $fakeVideo = \Illuminate\Http\UploadedFile::fake()->create('kegiatan_santri.webm', 2048, 'video/webm');

        $response = $this->actingAs($admin)->post(route('admin.gallery.media.upload', $album->id), [
            'type' => 'video',
            'title' => 'Video Dokumentasi Pesantren',
            'file' => $fakeVideo,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $media = \App\Models\GalleryMedia::where('album_id', $album->id)->where('type', 'video')->latest('id')->first();
        $this->assertNotNull($media);
        $this->assertEquals('Video Dokumentasi Pesantren', $media->title);

        // Cleanup
        $media->delete();
    }
}
