<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\InstitutionProgram;
use Illuminate\Database\Seeder;

class RichInstitutionContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. YAYASAN
        $yayasan = Institution::where('type', 'foundation')->first();
        if ($yayasan) {
            $yayasan->update([
                'name' => 'Yayasan Ulumul Islam',
                'short_description' => 'Mendedikasikan Diri untuk Melahirkan Generasi Rabbani yang Menguasai Ilmu Agama dan Pengetahuan Umum.',
                'description' => "Yayasan Pendidikan dan Pondok Pesantren Dayah Terpadu Ulumul Islam didirikan dengan tekad mulia untuk menyediakan wadah pembinaan generasi muda Islam yang komprehensif, mengintegrasikan sistem pendidikan formal berkualitas dengan nilai-nilai luhur kepesantrenan.\n\nBerdiri di atas landasan keikhlasan dan pengabdian, yayasan menaungi tiga pilar pendidikan utama: SMP Ulumul Islam, SMA Ulumul Islam, dan Pondok Pesantren Dayah Terpadu. Melalui kurikulum terintegrasi, sarana prasarana modern, serta bimbingan asatidz yang berkompeten, kami berkomitmen mencetak kader ulama dan cendekiawan muslim yang berakhlakul karimah, berwawasan global, dan siap berkontribusi nyata bagi agama, bangsa, dan ummat.",
                'vision' => 'Terwujudnya lembaga pendidikan Islam terpadu yang unggul dan terkemuka dalam mencetak generasi Rabbani yang berilmu amaliyah, beramal ilmiah, dan berakhlakul karimah.',
                'mission' => [
                    'Menyelenggarakan pendidikan formal tingkat SMP dan SMA yang unggul, inovatif, dan berstandar nasional.',
                    'Menyelenggarakan pembinaan kepesantrenan terpadu (Dayah) berbasis kitab turots dan tahfidzul Quran.',
                    'Membina karakter, adab, dan kemandirian santri berlandaskan nilai-nilai Al-Quran dan As-Sunnah.',
                    'Membekali santri dengan penguasaan bahasa internasional (Arab dan Inggris) serta literasi sains dan teknologi.',
                    'Menjalin sinergi erat dengan masyarakat dan perguruan tinggi dalam pengembangan dakwah dan pendidikan Islam.',
                ],
                'phone' => '08111111111',
                'whatsapp' => '628111111111',
                'address' => 'Jl. Ulumul Islam No. 1, Uteunkot, Muara Dua, Lhokseumawe, Aceh',
            ]);

            // Seed Programs for Foundation
            InstitutionProgram::where('institution_id', $yayasan->id)->delete();
            $yayasanPrograms = [
                [
                    'title' => 'Integrasi Tri-Pilar Pendidikan',
                    'badge' => 'Sistem Terpadu',
                    'description' => 'Memadukan harmonis kurikulum nasional Kemendikbudristek, kurikulum Dayah Salafiyah, dan asrama 24 jam.',
                    'icon' => 'academic',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Pengkaderan Ulama & Cendekiawan',
                    'badge' => 'Visi Utama',
                    'description' => 'Mempersiapkan generasi yang kuat aqidah, faqih dalam agama, serta menguasai sains dan kepemimpinan ummat.',
                    'icon' => 'book',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Beasiswa Santri Berprestasi',
                    'badge' => 'Dukungan Pendidikan',
                    'description' => 'Program apresiasi dan keringanan biaya bagi santri berprestasi tahfidz Quran dan olimpiade sains.',
                    'icon' => 'award',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Pengembangan Sarana Modern',
                    'badge' => 'Infrastruktur',
                    'description' => 'Penyediaan sarana belajar multimedia, laboratorium sains & bahasa, serta lingkungan asri berbasis green campus.',
                    'icon' => 'building',
                    'sort_order' => 4,
                ],
            ];
            foreach ($yayasanPrograms as $prog) {
                InstitutionProgram::create(array_merge($prog, ['institution_id' => $yayasan->id, 'is_active' => true]));
            }
        }

        // 2. DAYAH TERPADU
        $dayah = Institution::where('type', 'dayah')->first();
        if ($dayah) {
            $dayah->update([
                'name' => 'Dayah Terpadu Ulumul Islam',
                'short_description' => 'Pusat Pengkaderan Ulama Amilin, Pembinaan Akhlakul Karimah, dan Pendalaman Kitab Kuning serta Bahasa Internasional.',
                'description' => "Dayah Terpadu Ulumul Islam merupakan pondok pesantren modern berorientasi salafiyah yang mendidik santri secara intensif 24 jam. Dengan pendekatan terpadu, santri dibimbing mengkaji kitab-kitab muktabarah para ulama terdahulu (turots), menghafal Al-Quran dengan tajwid yang mutqin, serta membiasakan percakapan bahasa Arab dan Inggris dalam keseharian.\n\nDidukung lingkungan yang asri, disiplin islami yang terukur, dan keteladanan para asatidz/mursyid yang mukim bersama santri, Dayah Terpadu Ulumul Islam menanamkan kemandirian, kepemimpinan, serta kepekaan sosial tinggi agar santri menjadi pelita di tengah ummat.",
                'vision' => 'Melahirkan ulama amilin dan pemimpin muslim yang kokoh dalam aqidah, mendalam dalam ilmu syariah, berakhlak mulia, dan tanggap terhadap tantangan zaman.',
                'mission' => [
                    'Menyelenggarakan kajian kitab turots (kuning) secara berjenjang dan bersanad dalam bidang nahwu, sharaf, fiqh, tauhid, tafsir, dan hadits.',
                    'Membina program Tahfidzul Quran dengan target hafalan mutqin dan bersertifikasi.',
                    'Menciptakan lingkungan berbahasa asing aktif (Bi\'ah Lughawiyyah) bahasa Arab dan bahasa Inggris 24 jam.',
                    'Menanamkan pembiasaan ibadah yaumiyah, shalat berjamaah, qiyamul lail, dan adab thalabul ilmi.',
                    'Melatih jiwa kepemimpinan, kemandirian, dan retorika dakwah santri melalui organisasi santri dan kegiatan muhadharah.',
                ],
                'phone' => '08111111111',
                'whatsapp' => '628111111111',
                'address' => 'Komplek Dayah Terpadu Ulumul Islam, Aceh',
            ]);

            // Seed Programs for Dayah
            InstitutionProgram::where('institution_id', $dayah->id)->delete();
            $dayahPrograms = [
                [
                    'title' => 'Dirasah Islamiyah & Kitab Turots',
                    'badge' => 'Salafiyah',
                    'description' => 'Pengkajian sistematis kitab kuning muktabarah bersanad dalam cabang ilmu alat, fiqh madzhab Syafi\'i, aqidah, dan tasawuf.',
                    'icon' => 'book',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Tahfidzul Quran Mutqin',
                    'badge' => 'Al-Quran',
                    'description' => 'Bimbingan intensif hafalan Al-Quran dengan metode talaqqi, tahsin bersanad, dan muraja\'ah teratur setiap waktu subuh dan maghrib.',
                    'icon' => 'quran',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Bi\'ah Lughawiyyah (Bilingual 24 Jam)',
                    'badge' => 'Bahasa Aktif',
                    'description' => 'Penerapan disiplin bahasa Arab dan Inggris dalam interaksi harian santri untuk membangun kepercayaan diri komunikasi global.',
                    'icon' => 'globe',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Muhadharah & Khitabah 3 Bahasa',
                    'badge' => 'Retorika Dakwah',
                    'description' => 'Latihan pidato dan public speaking berkala dalam bahasa Arab, Inggris, dan Indonesia untuk melatih mental kepemimpinan santri.',
                    'icon' => 'mic',
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Pengasuhan & Adab Nabawiyyah 24 Jam',
                    'badge' => 'Karakter',
                    'description' => 'Pendampingan penuh oleh asatidz mukim asrama untuk memastikan shalat berjamaah 5 waktu di masjid, puasa sunnah, dan adab islami.',
                    'icon' => 'heart',
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Seni Bela Diri & Olahraga Sunnah',
                    'badge' => 'Minat & Bakat',
                    'description' => 'Pengembangan fisik santri melalui latihan bela diri Tapak Suci, seni panahan, futsal, bulutangkis, dan kepanduan Pramuka.',
                    'icon' => 'shield',
                    'sort_order' => 6,
                ],
            ];
            foreach ($dayahPrograms as $prog) {
                InstitutionProgram::create(array_merge($prog, ['institution_id' => $dayah->id, 'is_active' => true]));
            }
        }

        // 3. SMP ULUMUL ISLAM
        $smp = Institution::where('type', 'smp')->first();
        if ($smp) {
            $smp->update([
                'name' => 'SMP Ulumul Islam',
                'short_description' => 'Membina Generasi Unggul, Mandiri, dan Berakhlakul Karimah Berlandaskan Al-Quran dan Sunnah.',
                'description' => "Sekolah Menengah Pertama (SMP) Ulumul Islam adalah institusi pendidikan formal terakreditasi yang memadukan keunggulan Kurikulum Nasional Kemendikbudristek dengan nilai-nilai luhur pesantren. Santri dididik dalam ekosistem belajar yang ramah, islami, dan kompetitif.\n\nDengan fokus pada penguatan dasar akademik, penguasaan literasi sains dan teknologi, serta penanaman adab dan tahfidz Al-Quran, SMP Ulumul Islam menyiapkan lulusan yang tidak hanya berprestasi tinggi dalam ujian akademik dan olimpiade sains, tetapi juga memiliki kepribadian santun, taat beribadah, dan siap melanjutkan ke jenjang menengah atas favorit.",
                'vision' => 'Terwujudnya SMP Islam terpadu yang unggul dalam prestasi akademik dan non-akademik, berkarakter Qurani, berwawasan lingkungan, dan berdaya saing tinggi.',
                'mission' => [
                    'Menyelenggarakan pembelajaran kurikulum nasional secara kontekstual, aktif, dan berbasis teknologi informasi.',
                    'Mengintegrasikan pendidikan karakter pesantren dalam setiap mata pelajaran dan pembiasaan adab harian.',
                    'Melaksanakan bimbingan Tahfidz Al-Quran dengan target minimal 3 hingga 5 juz selama masa studi.',
                    'Mengembangkan bakat, minat, dan potensi santri melalui bimbingan olimpiade sains (OSN) dan ekstrakurikuler terpadu.',
                    'Mewujudkan lingkungan sekolah yang bersih, asri, nyaman, dan berbudaya islami.',
                ],
                'phone' => '08111111111',
                'whatsapp' => '628111111111',
                'address' => 'Komplek Pendidikan SMP Ulumul Islam, Aceh',
            ]);

            // Seed Programs for SMP
            InstitutionProgram::where('institution_id', $smp->id)->delete();
            $smpPrograms = [
                [
                    'title' => 'Kurikulum Nasional Terintegrasi Pesantren',
                    'badge' => 'Akademik Unggul',
                    'description' => 'Harmonisasi kurikulum Kemendikbudristek dengan penguatan materi agama islam, fiqh ibadah, dan sirah nabawiyah.',
                    'icon' => 'academic',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Tahfidz Al-Quran Juz 30 & Pilihan',
                    'badge' => 'Al-Quran',
                    'description' => 'Target hafalan mutqin minimal 3-5 juz dengan bimbingan mualim bersertifikat dan setoran harian.',
                    'icon' => 'quran',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Laboratorium Komputer & Literasi IT',
                    'badge' => 'Teknologi',
                    'description' => 'Pembekalan keterampilan komputer dasar, aplikasi perkantoran, dan pemanfaatan teknologi digital secara positif.',
                    'icon' => 'computer',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Kelas Pengayaan Sains & Matematika (OSN)',
                    'badge' => 'Prestasi',
                    'description' => 'Bimbingan khusus santri berbakat untuk mengikuti Olimpiade Sains Nasional (IPA, Matematika, IPS) dan lomba cerdas cermat.',
                    'icon' => 'flask',
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Pembiasaan Adab & Shalat Berjamaah',
                    'badge' => 'Karakter',
                    'description' => 'Penanaman adab kepada guru, orang tua, teman, shalat dhuha bersama, dan shalat fardhu berjamaah di masjid.',
                    'icon' => 'heart',
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Ekstrakurikuler Seni, Silat & Pramuka',
                    'badge' => 'Pengembangan Diri',
                    'description' => 'Wadah pembentukan disiplin, kepemimpinan, dan kreativitas melalui Pramuka Gudep Pesantren, Tapak Suci, dan Kaligrafi.',
                    'icon' => 'star',
                    'sort_order' => 6,
                ],
            ];
            foreach ($smpPrograms as $prog) {
                InstitutionProgram::create(array_merge($prog, ['institution_id' => $smp->id, 'is_active' => true]));
            }
        }

        // 4. SMA ULUMUL ISLAM
        $sma = Institution::where('type', 'sma')->first();
        if ($sma) {
            $sma->update([
                'name' => 'SMA Ulumul Islam',
                'short_description' => 'Membina Generasi Intelektual Muslim Unggul, Berwawasan Global, dan Siap Bersaing di Perguruan Tinggi Terkemuka.',
                'description' => "Sekolah Menengah Atas (SMA) Ulumul Islam dirancang untuk mengantarkan santri menuju gerbang perguruan tinggi favorit dan kepemimpinan masa depan. Dengan kurikulum terpadu peminatan Matematika & Ilmu Alam (MIPA) serta Ilmu-Ilmu Sosial (IPS), santri dibekali kematangan berpikir kritis, kemampuan riset ilmiah, serta penguasaan bahasa asing yang fasih.\n\nDidukung program bimbingan intensif UTBK-SNBT, kelas persiapan beasiswa luar negeri (Timur Tengah, Turki, Eropa, dan Asia Tenggara), serta penguatan tahfidz lanjutan, SMA Ulumul Islam membuktikan tradisi kelulusan santri yang diterima di berbagai PTN terkemuka dan universitas internasional.",
                'vision' => 'Menjadi SMA Islam unggulan berstandar nasional dan global yang melahirkan lulusan berintelektual tinggi, menguasai sains dan teknologi, berwawasan kebangsaan, dan berjiwa qurani.',
                'mission' => [
                    'Menyelenggarakan proses pembelajaran berkualitas tinggi dengan pemanfaatan teknologi informasi dan laboratorium sains modern.',
                    'Melaksanakan bimbingan intensif persiapan Seleksi Nasional Masuk Perguruan Tinggi Negeri (SNBP, SNBT, Jalur Mandiri, dan Kedinasan).',
                    'Mempersiapkan santri untuk seleksi beasiswa kuliah ke Timur Tengah (Al-Azhar Mesir, Madinah, Maroko) dan universitas luar negeri.',
                    'Membina program Riset dan Karya Tulis Ilmiah Remaja (KIR) berbasis nilai keislaman dan kebutuhan masyarakat.',
                    'Memperkokoh kepribadian santri dengan akhlak mulia, kemandirian kepemimpinan, dan kecintaan pada tanah air.',
                ],
                'phone' => '08111111111',
                'whatsapp' => '628111111111',
                'address' => 'Komplek Pendidikan SMA Ulumul Islam, Aceh',
            ]);

            // Seed Programs for SMA
            InstitutionProgram::where('institution_id', $sma->id)->delete();
            $smaPrograms = [
                [
                    'title' => 'Program Sukses PTN & Kedinasan (SNBT/SNBP)',
                    'badge' => 'Akademik Lanjutan',
                    'description' => 'Bimbingan intensif tes skolastik, pemantapan materi UTBK, try out berkala, dan konsultasi peminatan jurusan universitas.',
                    'icon' => 'academic',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Kelas Persiapan Studi Timur Tengah & Luar Negeri',
                    'badge' => 'Go International',
                    'description' => 'Pembekalan seleksi Kemenag untuk studi ke Universitas Al-Azhar Kairo Mesir, universitas di Timur Tengah, dan beasiswa internasional.',
                    'icon' => 'globe',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Laboratorium Sains Terpadu & Riset Ilmiah (KIR)',
                    'badge' => 'Riset & Sains',
                    'description' => 'Praktikum fisika, kimia, biologi, serta pelatihan penulisan karya ilmiah santri yang diikutsertakan dalam kompetisi nasional.',
                    'icon' => 'flask',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Tahfidz Al-Quran Lanjutan & Mutqin',
                    'badge' => 'Al-Quran',
                    'description' => 'Program penyempurnaan hafalan dan muraja\'ah terstruktur bagi santri untuk menjaga hafalan Al-Quran hingga kelulusan.',
                    'icon' => 'quran',
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Pengembangan Bahasa Internasional & TOEFL/TOAFL',
                    'badge' => 'Bahasa Asing',
                    'description' => 'Pelatihan tes kemampuan bahasa Inggris (TOEFL/IELTS preparation) dan bahasa Arab (TOAFL) bersertifikat.',
                    'icon' => 'certificate',
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Organisasi Santri & Kepemimpinan (ISPI)',
                    'badge' => 'Leadership',
                    'description' => 'Latihan kepemimpinan nyata melalui kepengurusan organisasi santri, manajemen kepanitiaan acara, dan bakti sosial masyarakat.',
                    'icon' => 'award',
                    'sort_order' => 6,
                ],
            ];
            foreach ($smaPrograms as $prog) {
                InstitutionProgram::create(array_merge($prog, ['institution_id' => $sma->id, 'is_active' => true]));
            }
        }
    }
}
