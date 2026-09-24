<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\InstitutionProgram;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class IkadaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Master Institusi IKADA UI
        $ikada = Institution::updateOrCreate(
            ['type' => 'ikada'],
            [
                'name' => 'IKADA UI (Ikatan Alumni Dayah Ulumul Islam)',
                'slug' => 'ikada',
                'short_description' => 'Wadah Sinergi, Silaturahmi, dan Pengabdian Alumni Pondok Pesantren Dayah Terpadu Ulumul Islam.',
                'description' => "Ikatan Alumni Dayah Ulumul Islam (IKADA UI) merupakan wadah berhimpun seluruh alumni lintas angkatan SMP, SMA, dan Dayah Terpadu Ulumul Islam.\n\nIKADA UI berdiri sebagai jembatan silaturahmi, pertukaran peluang karir dan akademik, serta kontribusi nyata dalam memajukan almamater, memperkuat ukhuwah Islamiyah, dan mengabdi untuk kemaslahatan ummat.",
                'vision' => 'Menjadi ikatan alumni yang solid, profesional, berdaya saing global, dan senantiasa berpegang teguh pada nilai-nilai keislaman serta keilmuan almamater.',
                'mission' => [
                    'Mempererat tali silaturahmi dan jaringan profesional antaralumni di seluruh penjuru nusantara dan dunia.',
                    'Mendukung kemajuan almamater Ulumul Islam melalui beasiswa, mentoring santri, dan penguatan sarana pendidikan.',
                    'Mengembangkan potensi ekonomi, karir, dan keilmuan alumni melalui sinergi dan kolaborasi strategis.',
                    'Mendedikasikan ilmu dan keahlian alumni untuk dakwah Islamiyah dan pengabdian masyarakat secara berkelanjutan.',
                ],
                'phone' => '628555555555',
                'whatsapp' => '628555555555',
                'address' => 'Gedung Sekretariat IKADA UI, Kompleks Dayah Terpadu Ulumul Islam, Aceh',
            ]
        );

        // 2. Statistik Total Alumni IKADA
        Statistic::updateOrCreate(
            ['institution_id' => $ikada->id, 'metric' => 'total_alumni'],
            ['value' => 1250]
        );

        // 3. Program Kerja / Program Unggulan IKADA UI
        $programs = [
            [
                'title' => 'Bursa Karir & Inkubator Usaha Alumni',
                'badge' => 'Karir & Bisnis',
                'description' => 'Jejaring informasi lowongan kerja, peluang magang, kemitraan bisnis, dan pelatihan kewirausahaan bagi para alumni.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Beasiswa Santri Berprestasi IKADA',
                'badge' => 'Sosial & Filantropi',
                'description' => 'Program bantuan biaya pendidikan dan asrama bagi santri yatim, dhuafa, dan penghafal Al-Quran yang bersumber dari donasi alumni.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Mentoring Masuk PTN & Kampus Luar Negeri',
                'badge' => 'Pendidikan',
                'description' => 'Bimbingan berkala dari alumni yang menempuh studi di PTN unggulan dan universitas di Timur Tengah, Eropa, maupun Asia.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Reuni Akbar & Silaturahmi Nasional Tahunan',
                'badge' => 'Ukhuwah Alumni',
                'description' => 'Musyawarah besar, temu kangen seluruh angkatan kelulusan, dan pengajian akbar tahunan di komplek Dayah Ulumul Islam.',
                'sort_order' => 4,
            ],
        ];

        foreach ($programs as $prog) {
            InstitutionProgram::updateOrCreate(
                [
                    'institution_id' => $ikada->id,
                    'title' => $prog['title'],
                ],
                [
                    'badge' => $prog['badge'],
                    'description' => $prog['description'],
                    'sort_order' => $prog['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        // 4. Akun Khusus Admin IKADA (Hanya 1 Akun)
        User::updateOrCreate(
            ['email' => 'ikada@ulumulislam.com'],
            [
                'name' => 'Admin IKADA UI',
                'password' => Hash::make('password123'),
                'role' => 'admin_ikada',
                'is_active' => true,
            ]
        );
    }
}
