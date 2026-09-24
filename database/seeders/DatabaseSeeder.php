<?php

namespace Database\Seeders;

use App\Models\AdmissionSetting;
use App\Models\Institution;
use App\Models\SiteSetting;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Super Admin Utama
        User::updateOrCreate(
            ['email' => 'ulumulislam2026@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('digitalisasiulumulislamv01'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        // 2. Data Master Institusi
        $foundation = Institution::updateOrCreate(
            ['type' => 'foundation'],
            [
                'name' => 'Yayasan Ulumul Islam',
                'slug' => 'yayasan',
                'short_description' => 'Yayasan Pendidikan dan Pondok Pesantren Terpadu Ulumul Islam.',
                'description' => 'Yayasan Ulumul Islam berdiri sebagai mercusuar pendidikan Islam terpadu, menyatukan keilmuan modern dengan ketaqwaan akhlakul karimah.',
                'vision' => 'Mewujudkan generasi Rabbani yang berilmu, beramal, dan bertaqwa.',
                'mission' => [
                    'Menyelenggarakan pendidikan formal tingkat SMP dan SMA yang terintegrasi.',
                    'Menyelenggarakan pembinaan kepesantrenan terpadu (Dayah).',
                    'Membina karakter santri berakhlak mulia berbasis Al-Quran.',
                ],
                'phone' => '628111111111',
                'whatsapp' => '628111111111',
                'address' => 'Jl. Ulumul Islam No. 1, Aceh',
            ]
        );

        $smp = Institution::updateOrCreate(
            ['type' => 'smp'],
            [
                'name' => 'SMP Ulumul Islam',
                'slug' => 'smp',
                'short_description' => 'Sekolah Menengah Pertama berbasis riset sains terpadu dan tahfidz Quran.',
                'description' => 'SMP Ulumul Islam mengintegrasikan kurikulum nasional Kemendikbudristek dengan kurikulum kepesantrenan.',
                'vision' => 'Unggul dalam prestasi sains, berakhlak mulia, dan berwawasan global berlandaskan nilai-nilai Islam.',
                'mission' => [
                    'Menyelenggarakan proses pembelajaran aktif, kreatif, dan inovatif berbasis sains dan teknologi.',
                    'Membina pembiasaan ibadah praktis dan adab harian islami.',
                    'Mengembangkan program tahfidz Quran dengan target minimal 3 juz.',
                    'Mengasah bakat santri melalui ragam kegiatan ekstrakurikuler kepemimpinan dan kebahasaan.',
                ],
                'phone' => '628222222222',
                'whatsapp' => '628222222222',
                'address' => 'Jl. Ulumul Islam No. 1, Aceh',
            ]
        );

        $sma = Institution::updateOrCreate(
            ['type' => 'sma'],
            [
                'name' => 'SMA Ulumul Islam',
                'slug' => 'sma',
                'short_description' => 'Sekolah Menengah Atas terakreditasi A dengan program sains riset dan persiapan universitas unggulan.',
                'description' => 'SMA Ulumul Islam didirikan untuk memberikan kelanjutan pendidikan menengah atas yang berkualitas tinggi.',
                'vision' => 'Menjadi SMA sains dan keislaman percontohan nasional dalam pembentukan intelektual Rabbani.',
                'mission' => [
                    'Menyelenggarakan pembelajaran berbasis riset sains, teknologi, dan kewirausahaan sosial.',
                    'Meningkatkan pencapaian hafalan Al-Quran minimal 5 juz sebelum kelulusan.',
                    'Membimbing program akselerasi persiapan ujian masuk perguruan tinggi negeri (PTN) & luar negeri.',
                    'Menanamkan karakter kepemimpinan transformatif islami.',
                ],
                'phone' => '628333333333',
                'whatsapp' => '628333333333',
                'address' => 'Jl. Ulumul Islam No. 1, Aceh',
            ]
        );

        $dayah = Institution::updateOrCreate(
            ['type' => 'dayah'],
            [
                'name' => 'Dayah Terpadu Ulumul Islam',
                'slug' => 'dayah',
                'short_description' => 'Pesantren terpadu modern yang mengintegrasikan kajian kitab salafiyah dengan penguasaan bahasa asing.',
                'description' => 'Dayah Terpadu Ulumul Islam menyelenggarakan pendidikan kepesantrenan dengan sistem asrama penuh (boarding school).',
                'vision' => 'Menjadi pusat kajian keislaman dan pembinaan generasi Rabbani yang unggul secara akhlak dan keilmuan pesantren.',
                'mission' => [
                    'Menyelenggarakan kajian intensif kitab-kitab kuning standar pesantren.',
                    'Mengembangkan sistem asrama berkarakter mandiri, aman, dan ukhuwah.',
                    'Membiasakan bahasa Arab dan Inggris sebagai bahasa pengantar di asrama.',
                    'Menghidupkan amalan-amalan sunnah dan adab islami dalam kehidupan sehari-hari.',
                ],
                'phone' => '628444444444',
                'whatsapp' => '628444444444',
                'address' => 'Jl. Ulumul Islam No. 1, Aceh',
            ]
        );

        $ikada = Institution::updateOrCreate(
            ['type' => 'ikada'],
            [
                'name' => 'IKADA UI (Ikatan Alumni Dayah Ulumul Islam)',
                'slug' => 'ikada',
                'short_description' => 'Wadah silaturahmi, jejaring sinergi, dan kontribusi seluruh alumni Dayah Terpadu Ulumul Islam.',
                'description' => 'IKADA UI adalah organisasi resmi alumni Yayasan & Dayah Terpadu Ulumul Islam.',
                'vision' => 'Mempererat ukhuwah islamiyah dan mengoptimalkan potensi alumni untuk kemaslahatan ummat dan almamater.',
                'mission' => [
                    'Membangun jejaring komunikasi dan database alumni yang solid dan terintegrasi.',
                    'Mendukung program pengembangan dan kemajuan almamater Dayah Terpadu Ulumul Islam.',
                    'Menyelenggarakan kegiatan sosial, pendidikan, dan dakwah.',
                ],
                'phone' => '628555555555',
                'whatsapp' => '628555555555',
                'address' => 'Jl. Ulumul Islam No. 1, Aceh',
            ]
        );

        User::updateOrCreate(
            ['email' => 'alumni.ulumulislam@gmail.com'],
            [
                'name' => 'Admin IKADA',
                'password' => Hash::make('ikadaulumulislam2026'),
                'role' => 'admin_ikada',
                'is_active' => true,
            ]
        );

        // 3. Statistik Awal SMP & SMA
        Statistic::updateOrCreate(['institution_id' => $smp->id, 'metric' => 'students_male'], ['value' => 0]);
        Statistic::updateOrCreate(['institution_id' => $smp->id, 'metric' => 'students_female'], ['value' => 0]);
        Statistic::updateOrCreate(['institution_id' => $smp->id, 'metric' => 'total_alumni'], ['value' => 0]);

        Statistic::updateOrCreate(['institution_id' => $sma->id, 'metric' => 'students_male'], ['value' => 0]);
        Statistic::updateOrCreate(['institution_id' => $sma->id, 'metric' => 'students_female'], ['value' => 0]);
        Statistic::updateOrCreate(['institution_id' => $sma->id, 'metric' => 'total_alumni'], ['value' => 0]);

        // 4. Setelan Pendaftaran Santri Baru
        AdmissionSetting::updateOrCreate(
            ['institution_id' => $smp->id],
            [
                'is_open' => false,
                'requirements' => "1. Beragama Islam dan memiliki tekad belajar sungguh-sungguh.\n2. Lulus Sekolah Dasar (SD/MI) atau sederajat.\n3. Membawa fotokopi rapor kelas 4 s.d. kelas 6.\n4. Sehat jasmani dan rohani serta bebas dari penyakit menular.\n5. Bersedia tinggal di asrama (boarding school) selama menempuh pendidikan.",
                'required_documents' => "1. Fotokopi Ijazah / Surat Keterangan Lulus (3 lembar legalisir)\n2. Fotokopi Kartu Keluarga (KK) & Akta Kelahiran (3 lembar)\n3. Pas foto berwarna ukuran 3x4 (4 lembar) dan 2x3 (2 lembar)\n4. Surat keterangan sehat dari dokter / puskesmas\n5. Fotokopi NISN (Nomor Induk Siswa Nasional)",
                'schedule_information' => "Gelombang I:\n- Pendaftaran: 01 Februari - 15 Maret\n- Ujian Masuk & Wawancara: 20 Maret\n- Pengumuman Kelulusan: 25 Maret",
                'additional_information' => 'Pendaftaran dilakukan secara langsung atau dapat melakukan konfirmasi terlebih dahulu melalui WhatsApp panitia penerimaan.',
                'whatsapp_template' => 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMP Ulumul Islam.',
            ]
        );

        AdmissionSetting::updateOrCreate(
            ['institution_id' => $sma->id],
            [
                'is_open' => false,
                'requirements' => "1. Beragama Islam dan berakhlak mulia.\n2. Lulus SMP/MTs atau sederajat.\n3. Memiliki komitmen menghafal Al-Quran dan fokus akademik sains.\n4. Bersedia tinggal di asrama penuh dan mematuhi tata tertib pesantren.",
                'required_documents' => "1. Fotokopi Ijazah / SKL SMP/MTs (3 lembar legalisir)\n2. Fotokopi Kartu Keluarga (KK) & Akta Kelahiran (3 lembar)\n3. Pas foto berwarna ukuran 3x4 (4 lembar)\n4. Surat Keterangan Berkelakuan Baik dari sekolah asal\n5. Sertifikat prestasi akademik / tahfidz (jika ada)",
                'schedule_information' => "Gelombang I:\n- Pendaftaran: 01 Februari - 15 Maret\n- Ujian Potensi Akademik & Baca Quran: 20 Maret\n- Pengumuman Kelulusan: 25 Maret",
                'additional_information' => 'Tersedia beasiswa bagi santri yang memiliki hafalan Al-Quran minimal 5 Juz atau juara olimpiade sains tingkat provinsi.',
                'whatsapp_template' => 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.',
            ]
        );

        // 5. Pengaturan Situs Global
        SiteSetting::set('site_phone', '628111111111');
        SiteSetting::set('site_address', 'Jl. Ulumul Islam No. 1, Aceh');
        SiteSetting::set('site_gmaps', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15886.123456789!2d97.123456!3d5.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMDcnMjQuNCJOIDk3wrAwNyc0My4yIkU!5e0!3m2!1sid!2sid!4v1600000000000!5m2!1sid!2sid');
        SiteSetting::set('whatsapp_template_smp', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMP Ulumul Islam.');
        SiteSetting::set('whatsapp_template_sma', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.');
        SiteSetting::set('whatsapp_template_yayasan', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Yayasan Ulumul Islam.');
        SiteSetting::set('whatsapp_template_dayah', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Dayah Terpadu Ulumul Islam.');

        // 6. Struktur Kepengurusan Resmi Dayah
        $this->call(DayahStructureSeeder::class);
    }
}
