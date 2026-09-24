<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\FeaturedAlumni;
use App\Models\GalleryAlbum;
use App\Models\GalleryMedia;
use App\Models\Institution;
use App\Models\News;
use App\Models\StructureMember;
use App\Models\StructurePosition;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $authorId = $admin?->id;

        $institutions = Institution::all()->keyBy('type');

        // ==========================================
        // 1. BERITA DUMMY PER UNIT (5 TIAP UNIT)
        // ==========================================
        $newsData = [
            'foundation' => [
                [
                    'title' => 'Rapat Kerja Tahunan Yayasan Ulumul Islam Menyongsong Transformasi Digital Pendidikan',
                    'excerpt' => 'Yayasan Ulumul Islam menggelar rapat kerja tahunan guna memperkuat kurikulum terpadu dan penguatan sarana teknologi informasi.',
                    'content' => '<p>Yayasan Dayah Terpadu Ulumul Islam menyelenggarakan Rapat Kerja Tahunan yang dihadiri oleh seluruh jajaran dewan pembina, pengurus harian, mudir ma\'had, serta kepala sekolah jenjang SMP dan SMA. Raker kali ini berfokus pada digitalisasi manajemen pesantren dan peningkatan standar kompetensi tenaga pengajar.</p><p>Ketua Yayasan menegaskan komitmen untuk terus meningkatkan mutu pembinaan akhlak dan integrasi keilmuan agama dengan sains kontemporer.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Kunjungan Silaturahmi Majelis Ulama dan Tokoh Masyarakat ke Komplek Pesantren',
                    'excerpt' => 'Silaturahmi tokoh ulama mempererat sinergi dakwah dan pendidikan kepesantrenan di lingkungan masyarakat luas.',
                    'content' => '<p>Komplek Pesantren Terpadu Ulumul Islam menerima kunjungan kehormatan dari para alim ulama dan tokoh masyarakat. Pertemuan ini mendiskusikan penguatan nilai-nilai moderasi beragama serta peran pesantren dalam mencetak kader ulama masa depan.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Pembangunan Gedung Asrama Baru dan Pusat Kajian Kitab Kuning Resmi Dimulai',
                    'excerpt' => 'Peletakan batu pertama menandai dimulainya ekspansi fasilitas asrama demi daya tampung santri yang kian bertambah.',
                    'content' => '<p>Sebagai respon atas tingginya minat masyarakat menyekolahkan putra-putrinya di Ulumul Islam, yayasan secara resmi memulai pembangunan gedung asrama baru 3 lantai yang dilengkapi ruang kajian turots modern.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Peringatan Milad Yayasan: Tabligh Akbar & Doa Bersama untuk Kemaslahatan Ummat',
                    'excerpt' => 'Ratusan jamaah dan wali santri hadir memeriahkan tabligh akbar dalam rangka milad berdirinya yayasan.',
                    'content' => '<p>Peringatan hari jadi Yayasan Ulumul Islam berlangsung khidmat dengan digelarnya tabligh akbar dan khotmil Quran oleh para santri dan asatidz.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Penandatanganan MoU Beasiswa Pendidikan Bersama Mitra Lembaga Filantropi',
                    'excerpt' => 'Program beasiswa penuh dibuka untuk santri berprestasi dan santri yatim dhuafa berpotensi tinggi.',
                    'content' => '<p>Yayasan Ulumul Islam menandatangani nota kesepahaman program beasiswa terpadu bersama lembaga mitra demi menjamin akses pendidikan berkualitas bagi seluruh lapisan generasi muslim.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            'dayah' => [
                [
                    'title' => 'Wisuda Tahfidz Al-Qur\'an Santri Dayah Terpadu Angkatan Ke-14',
                    'excerpt' => 'Sebanyak puluhan santri mukim berhasil menyelesaikan setoran hafalan mutqin 30 Juz dan kitab matan tajwid.',
                    'content' => '<p>Dayah Terpadu Ulumul Islam menggelar wisuda tahfidz Al-Qur\'an tahunan dengan haru dan penuh keberkahan. Program karantina tahfidz intensif terbukti efektif mendongkrak capaian mutqin para santri.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1584697964190-705b89368d43?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Kajian Rutin Ba\'da Subuh: Bedah Kitab Fathul Qorib Bersama Mudir Ma\'had',
                    'excerpt' => 'Halaqah pengkajian kitab fiqh klasik konsisten membina pemahaman syariat yang mendalam bagi seluruh santriwan.',
                    'content' => '<p>Kegiatan mudzakarah dan muthala\'ah kitab turots senantiasa menjadi ruh keilmuan di pondok pesantren. Kajian rutin subuh mengasah nalar fiqh dan penguasaan gramatika bahasa Arab.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1532012164546-f432f2e3edd7?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Pekan Olahraga dan Seni Antar Asrama Santri (POSAS) Resmi Dibuka',
                    'excerpt' => 'Ajang tahunan unjuk bakat pidato 3 bahasa, seni kaligrafi islami, panahan, dan futsal santri.',
                    'content' => '<p>POSAS menjadi panggung pembuktian kreativitas dan sportivitas santri. Acara dibuka dengan defile meriah masing-masing konsulat kamar santri.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Penguatan Bahasa Arab & Inggris Melalui Program Language Immersion Camp',
                    'excerpt' => 'Bilingual environment 24 jam dilatih intensif untuk meningkatkan kefasihan public speaking santri.',
                    'content' => '<p>Disiplin berbahasa resmi Arab dan Inggris terus diperkuat melalui simulasi debat internasional, drama musikal berbahasa asing, dan muhadharah mingguan.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Santri Dayah Ulumul Islam Raih Juara Umum Musabaqah Qira\'atil Kutub (MQK) Tingkat Provinsi',
                    'excerpt' => 'Prestasi membanggakan ditorehkan santri pada cabang Nahwu, Fiqh, dan Tafsir kitab kuning.',
                    'content' => '<p>Kafilah Dayah Ulumul Islam berhasil menyabet predikat Juara Umum pada perhelatan MQK tingkat provinsi setelah mendominasi babak final berbagai majelis cabang lomba.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            'smp' => [
                [
                    'title' => 'Siswa SMP Ulumul Islam Raih Medali Emas Olimpiade Sains Nasional (OSN) Tingkat Kabupaten',
                    'excerpt' => 'Dua santri SMP berhasil mengukir prestasi gemilang pada bidang Matematika dan IPA Terpadu.',
                    'content' => '<p>Prestasi membanggakan kembali dipersembahkan oleh delegasi SMP Ulumul Islam dalam ajang OSN. Pembinaan intensif di laboratorium sains sekolah membuahkan hasil memuaskan.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Pelatihan Literasi Digital & Pemrograman Robotik Dasar untuk Santri Kelas VIII',
                    'excerpt' => 'Mempersiapkan santri melek teknologi masa depan melalui workshop coding dan perakitan robot mini.',
                    'content' => '<p>Lab Komputer SMP Ulumul Islam dipadati santri yang antusias merancang sirkuit mikrokontroler dan algoritma dasar robotik.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Pelantikan Pengurus Organisasi Santri SMP (OSIS) Periode 2026/2027',
                    'excerpt' => 'Prosesi serah terima jabatan ketua OSIS berlangsung khidmat disaksikan seluruh dewan guru.',
                    'content' => '<p>Kepala Sekolah SMP Ulumul Islam secara resmi melantik jajaran kepengurusan OSIS baru. Diharapkan kepengurusan ini menjadi teladan kepemimpinan berakhlak mulia.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Gelar Karya P5: Kolaborasi Seni Kaligrafi dan Pemanfaatan Daur Ulang Ramah Lingkungan',
                    'excerpt' => 'Projek Penguatan Profil Pelajar Pancasila menampilkan karya kreatif santri berbasis kearifan lokal.',
                    'content' => '<p>Pameran karya siswa SMP Ulumul Islam memukau para pengunjung dengan instalasi seni kaligrafi islami yang memanfaatkan bahan ramah lingkungan.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Simulasi Asesmen Nasional Berbasis Komputer (ANBK) Berjalan Tertib dan Lancar',
                    'excerpt' => 'Kesiapan infrastruktur server dan jaringan lab komputer memastikan kelancaran evaluasi mutu pendidikan.',
                    'content' => '<p>Pelaksanaan gladi bersih ANBK di SMP Ulumul Islam berlangsung tanpa kendala teknis dengan tingkat kehadiran siswa 100%.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            'sma' => [
                [
                    'title' => 'Alhamdulillah, 85% Lulusan SMA Ulumul Islam Lolos Masuk PTN Favorit dan Al-Azhar Kairo',
                    'excerpt' => 'Prestasi kelulusan santri menembus ITB, UGM, UI, USK, serta universitas terkemuka di Timur Tengah.',
                    'content' => '<p>Hasil seleksi SNBP, SNBT, dan ujian beasiswa Kementerian Agama mencatatkan rekor kelulusan santri SMA Ulumul Islam ke kampus-kampus idaman nasional maupun internasional.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Karya Tulis Ilmiah Santri SMA Raih Juara 1 Lomba Riset Sains Remaja Tingkat Nasional',
                    'excerpt' => 'Inovasi pengolahan ekstrak tanaman herbal lokal untuk antiseptik alami diakui dewan juri universitas.',
                    'content' => '<p>Tim peneliti muda SMA Ulumul Islam berhasil mempresentasikan paper ilmiah di hadapan akademisi terkemuka dan meraih trofi emas.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Career Expo & Campus Fair: Membedah Peluang Beasiswa dan Pilihan Jurusan Masa Depan',
                    'excerpt' => 'Puluhan stand perguruan tinggi dan alumni inspiratif hadir memandu santri kelas XII.',
                    'content' => '<p>Kegiatan tahunan Campus Fair SMA Ulumul Islam memberikan wawasan komprehensif mengenai strategi memilih program studi dan beasiswa kuliah.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Bimbingan Intensif UTBK-SNBT Sukses Tingkatkan Skor Tryout Santri',
                    'excerpt' => 'Program drill soal dan klinik pemecahan masalah penalaran matematika dan literasi bahasa.',
                    'content' => '<p>Karantina belajar intensif kelas XII dilaksanakan dengan modul soal terstandar dan bimbingan langsung dari tentor berpengalaman.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Regu Pramuka Penegak SMA Ulumul Islam Boyong Piala Bergilir Kemah Bakti Pesantren',
                    'excerpt' => 'Ketangkasan pionering, navigasi darat, dan kepemimpinan santri membuahkan hasil terbaik.',
                    'content' => '<p>Ambalan Pramuka SMA Ulumul Islam menjuarai berbagai mata lomba kepanduan dalam kemah bakti gabungan se-Aceh.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1506869640319-fe1a24fd76dc?w=800&auto=format&fit=crop&q=80',
                ],
            ],
            'ikada' => [
                [
                    'title' => 'Reuni Akbar & Temu Kangen Nasional IKADA UI Dihadiri Ratusan Alumni Lintas Angkatan',
                    'excerpt' => 'Momen hangat mempererat ukhuwah alumni dan peresmian program dana abadi beasiswa almamater.',
                    'content' => '<p>Ikatan Alumni Dayah Ulumul Islam (IKADA UI) sukses menyelenggarakan Reuni Akbar. Forum ini menyepakati pembentukan yayasan wakaf alumni untuk membantu santri berprestasi.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'IKADA UI Salurkan Bantuan Kemanusiaan & Bakti Sosial untuk Masyarakat Sekitar Dayah',
                    'excerpt' => 'Aksi nyata kepedulian sosial alumni mencakup pemeriksaan kesehatan gratis dan paket sembako berkah.',
                    'content' => '<p>Pengurus IKADA UI turun langsung mendistribusikan ratusan paket sembako dan menggelar layanan cek kesehatan cuma-cuma bersama dokter alumni.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Webinar Karir & Mentoring Beasiswa Luar Negeri Bersama Alumni Sukses',
                    'excerpt' => 'Alumni yang menempuh studi S2/S3 di Eropa dan Timur Tengah berbagi tips lolos beasiswa internasional.',
                    'content' => '<p>Webinar IKADA Career Hub disambut antusias oleh santri dan alumni muda yang ingin melanjutkan studi master ke luar negeri.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Peresmian Forum Bisnis & Inkubator Wirausaha Santri Alumni Ulumul Islam',
                    'excerpt' => 'Sinergi ekonomi dan jejaring kemitraan bisnis alumni guna mencetak santripreneur mandiri.',
                    'content' => '<p>IKADA Business Network diresmikan sebagai wadah mentoring bisnis, investasi bersama, dan pendampingan UMKM rintisan alumni.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&auto=format&fit=crop&q=80',
                ],
                [
                    'title' => 'Peluncuran Buku Antologi Jejak Langkah Santri: Memoar Inspiratif Alumni Ulumul Islam',
                    'excerpt' => 'Kumpulan kisah nyata perjuangan, suka duka mondok, dan rahasia sukses berkiprah di masyarakat.',
                    'content' => '<p>Buku karya alumni resmi diluncurkan dan dipersembahkan sebagai dedikasi literasi bagi kemajuan almamater tercinta.</p>',
                    'thumbnail_path' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&auto=format&fit=crop&q=80',
                ],
            ],
        ];

        foreach ($newsData as $scope => $articles) {
            foreach ($articles as $art) {
                News::updateOrCreate(
                    ['slug' => Str::slug($art['title'])],
                    [
                        'author_id' => $authorId,
                        'title' => $art['title'],
                        'scope' => $scope,
                        'excerpt' => $art['excerpt'],
                        'content' => $art['content'],
                        'thumbnail_path' => $art['thumbnail_path'],
                        'gallery_images' => [
                            'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800&auto=format&fit=crop&q=80',
                            'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800&auto=format&fit=crop&q=80',
                        ],
                        'status' => 'published',
                        'published_at' => now()->subDays(rand(1, 15)),
                    ]
                );
            }
        }

        // ==========================================
        // 2. PENGUMUMAN DUMMY (AKTIF < 30 HARI)
        // ==========================================
        $announcements = [
            [
                'title' => 'Penerimaan Santri Baru (PSB) Tahun Ajaran 2026/2027 Resmi Dibuka',
                'summary' => 'Pendaftaran online dan offline untuk jenjang SMP, SMA, dan Dayah Terpadu telah dibuka mulai tanggal 1 Oktober.',
                'content' => 'Pendaftaran Santri Baru (PSB) Yayasan Dayah Terpadu Ulumul Islam telah resmi dibuka. Calon wali santri dapat mengisi formulir pendaftaran secara online melalui website resmi atau hadir langsung di sekretariat panitia PSB komplek pesantren.',
                'image_path' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Jadwal Ujian Tengah Semester Ganjil dan Evaluasi Hafalan Tahfidz',
                'summary' => 'Diberitahukan kepada seluruh santri bahwa UTS dan tasmi\' hafalan akan dilaksanakan pada pekan kedua bulan ini.',
                'content' => 'Pelaksanaan evaluasi pembelajaran ganjil mencakup ujian kurikulum kementerian serta ujian lisan kitab kuning dan tasmi\' Al-Qur\'an.',
                'image_path' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Undangan Pertemuan Wali Santri dan Laporan Perkembangan Akademik',
                'summary' => 'Pertemuan silaturahmi wali santri dan penyerahan buku raport perkembangan adab santri.',
                'content' => 'Diharapkan kehadiran seluruh bapak/ibu wali santri dalam musyawarah bersama pimpinan dan wali asrama.',
                'image_path' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Informasi Libur Semester & Ketentuan Kepulangan Santri',
                'summary' => 'Tata tertib perizinan pulang santri dan jadwal kembali mukim ke asrama tepat waktu.',
                'content' => 'Seluruh santri wajib mematuhi protokol kepulangan dan melapor kepada pengasuhan asrama saat tiba kembali.',
                'image_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Pengumuman Seleksi Beasiswa Tahfidz 30 Juz Kemenag',
                'summary' => 'Pendaftaran seleksi beasiswa santri berprestasi dibuka hingga akhir pekan ini.',
                'content' => 'Bagi santri yang memenuhi kriteria setoran hafalan minimal 10 juz dapat mendaftarkan diri ke bagian kurikulum tahfidz.',
                'image_path' => 'https://images.unsplash.com/photo-1584697964190-705b89368d43?w=800&auto=format&fit=crop&q=80',
            ],
        ];

        foreach ($announcements as $ann) {
            Announcement::updateOrCreate(
                ['slug' => Str::slug($ann['title'])],
                [
                    'title' => $ann['title'],
                    'summary' => $ann['summary'],
                    'content' => $ann['content'],
                    'image_path' => $ann['image_path'],
                    'scope' => 'global',
                    'status' => 'published',
                    'published_at' => now()->subDays(rand(1, 10)),
                    'expires_at' => now()->addDays(20),
                    'created_at' => now()->subDays(rand(1, 10)),
                ]
            );
        }

        // ==========================================
        // 3. STRUKTUR KEPENGURUSAN DEKANAT & DIVISI PER UNIT
        // ==========================================
        $structures = [
            'foundation' => [
                'leaders' => [
                    [
                        'name' => 'Ketua Dewan Pembina Yayasan',
                        'is_pinned' => true,
                        'members' => [
                            ['name' => 'Tgk. H. Muhammad Nasir, Lc., MA', 'title' => 'Ketua Dewan Pembina', 'sub_role' => 'Pengarah Utama Kebijakan & Visi Pesantren', 'period' => '2024 - 2029', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80', 'role' => 'leader'],
                        ]
                    ],
                    [
                        'name' => 'Ketua Umum Pengurus Yayasan',
                        'is_pinned' => true,
                        'members' => [
                            ['name' => 'Drs. H. Abdullah Usman, M.Pd', 'title' => 'Ketua Umum Yayasan', 'sub_role' => 'Penanggung Jawab Eksekutif Operasional Lembaga', 'period' => '2024 - 2029', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80', 'role' => 'leader'],
                        ]
                    ],
                ],
                'vices' => [
                    [
                        'name' => 'Sekretaris Jenderal Yayasan',
                        'members' => [
                            ['name' => 'Ust. Rahmat Hidayat, S.Sos.I', 'title' => 'Sekretaris Umum', 'sub_role' => 'Administrasi, Tata Persuratan & Legalitas', 'period' => '2024 - 2029', 'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ],
                    [
                        'name' => 'Bendahara Umum Yayasan',
                        'members' => [
                            ['name' => 'H. Syukri Ismail, SE', 'title' => 'Bendahara Yayasan', 'sub_role' => 'Pengelolaan Finansial & Anggaran Pembangunan', 'period' => '2024 - 2029', 'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ],
                ],
                'divisions' => [
                    [
                        'name' => 'Divisi Sarana & Prasarana Kampus',
                        'members' => [
                            ['name' => 'Ir. Zulfikar, MT', 'title' => 'Kepala Divisi Sarpras', 'sub_role' => 'Pengembangan Fisik Gedung & Maintenance Aset', 'period' => '2024 - 2029', 'photo' => null, 'role' => 'head'],
                            ['name' => 'M. Yusuf, ST', 'title' => 'Staf Teknis Lapangan', 'sub_role' => 'Pemeliharaan Instalasi Listrik & Air Asrama', 'period' => '2024 - 2029', 'photo' => null, 'role' => 'member'],
                        ]
                    ],
                    [
                        'name' => 'Divisi Hubungan Masyarakat & Kemitraan',
                        'members' => [
                            ['name' => 'Ust. Fauzi Harun, S.I.Kom', 'title' => 'Koordinator Humas', 'sub_role' => 'Relasi Media, Komunikasi Instansi & Publikasi', 'period' => '2024 - 2029', 'photo' => null, 'role' => 'head'],
                        ]
                    ],
                ]
            ],
            'dayah' => [
                'leaders' => [
                    [
                        'name' => 'Mudir Ma\'had / Pimpinan Dayah',
                        'is_pinned' => true,
                        'members' => [
                            ['name' => 'Tgk. H. Zulkifli Ahmad, S.Pd.I', 'title' => 'Pimpinan Dayah Terpadu', 'sub_role' => 'Pengasuh Utama Santri & Pembina Kurikulum Turots', 'period' => '2023 - 2028', 'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80', 'role' => 'leader'],
                        ]
                    ]
                ],
                'vices' => [
                    [
                        'name' => 'Wakil Mudir Bidang Pengasuhan & Kedisiplinan',
                        'members' => [
                            ['name' => 'Ust. Fakhrurrazi, Lc', 'title' => 'Wakil Mudir Pengasuhan', 'sub_role' => 'Ketertiban Sunnah Santri, Asrama & Perizinan', 'period' => '2023 - 2028', 'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ],
                    [
                        'name' => 'Wakil Mudir Bidang Pengajaran & Kurikulum Kitab',
                        'members' => [
                            ['name' => 'Tgk. Muslem Syafi\'i, S.Th.I', 'title' => 'Wakil Mudir Akademik Kitab', 'sub_role' => 'Jadwal Pengajian, Kitab Kuning & Sorogan', 'period' => '2023 - 2028', 'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ]
                ],
                'divisions' => [
                    [
                        'name' => 'Divisi Tahfidz Al-Qur\'an Mutqin',
                        'members' => [
                            ['name' => 'Ust. Muhammad Hafiz, Al-Hafidz', 'title' => 'Kepala Divisi Tahfidz', 'sub_role' => 'Koordinator Halaqah Tahfidz & Wisuda 30 Juz', 'period' => '2023 - 2028', 'photo' => 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=400&auto=format&fit=crop&q=80', 'role' => 'head'],
                            ['name' => 'Ust. Salman Al-Farisi', 'title' => 'Musyrif Halaqah Putra', 'sub_role' => 'Pembina Setoran Tahfidz Ba\'da Maghrib', 'period' => '2023 - 2028', 'photo' => null, 'role' => 'member'],
                        ]
                    ],
                    [
                        'name' => 'Divisi Pembinaan Bahasa Arab & Inggris',
                        'members' => [
                            ['name' => 'Ust. Munawir, S.Pd.I', 'title' => 'Koordinator Language Center', 'sub_role' => 'Disiplin Bilingual 24 Jam & Muhadharah', 'period' => '2023 - 2028', 'photo' => null, 'role' => 'head'],
                        ]
                    ]
                ]
            ],
            'smp' => [
                'leaders' => [
                    [
                        'name' => 'Kepala Sekolah SMP Ulumul Islam',
                        'is_pinned' => true,
                        'members' => [
                            ['name' => 'Drs. Ridwan Mahmud, M.Pd', 'title' => 'Kepala Sekolah', 'sub_role' => 'Manajemen Akademik & Kemitraan Dinas Pendidikan', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&auto=format&fit=crop&q=80', 'role' => 'leader'],
                        ]
                    ]
                ],
                'vices' => [
                    [
                        'name' => 'Wakil Kepala Bidang Kurikulum',
                        'members' => [
                            ['name' => 'Sri Wahyuni, S.Pd., M.Si', 'title' => 'Wakasek Kurikulum', 'sub_role' => 'Perangkat Pembelajaran & Supervisi Guru', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ],
                    [
                        'name' => 'Wakil Kepala Bidang Kesiswaan',
                        'members' => [
                            ['name' => 'Ust. Mahfud Sidiq, S.Pd', 'title' => 'Wakasek Kesiswaan', 'sub_role' => 'Pembinaan Karakter, OSIS & Ekstrakurikuler', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ]
                ],
                'divisions' => [
                    [
                        'name' => 'Divisi Laboratorium Komputer & Robotik',
                        'members' => [
                            ['name' => 'Teuku Fadhil, S.Kom', 'title' => 'Kepala Lab IT', 'sub_role' => 'Pengelolaan Lab Komputer & Klub Coding Santri', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format&fit=crop&q=80', 'role' => 'head'],
                        ]
                    ]
                ]
            ],
            'sma' => [
                'leaders' => [
                    [
                        'name' => 'Kepala Sekolah SMA Ulumul Islam',
                        'is_pinned' => true,
                        'members' => [
                            ['name' => 'H. Mukhlis Ibrahim, M.Ag', 'title' => 'Kepala Sekolah SMA', 'sub_role' => 'Penanggung Jawab Kurikulum Terpadu & Sukses PTN', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80', 'role' => 'leader'],
                        ]
                    ]
                ],
                'vices' => [
                    [
                        'name' => 'Wakil Kepala Bidang Kurikulum & PTN',
                        'members' => [
                            ['name' => 'Cut Nurul Hasanah, S.Si., M.Pd', 'title' => 'Wakasek Kurikulum', 'sub_role' => 'Intensif SNBT, UTBK & Bimbingan Belajar', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ],
                    [
                        'name' => 'Wakil Kepala Bidang Kesiswaan & Asrama',
                        'members' => [
                            ['name' => 'Ust. Hendra Saputra, S.Pd.I', 'title' => 'Wakasek Kesiswaan', 'sub_role' => 'Kedisiplinan, OSIS & Ekstrakurikuler Pilihan', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ]
                ],
                'divisions' => [
                    [
                        'name' => 'Divisi Bimbingan Konseling & Karir Alumni',
                        'members' => [
                            ['name' => 'Dr. Ilham Maulana, M.Sc', 'title' => 'Koordinator Riset & PTN', 'sub_role' => 'Pemetaan Minat Bakat & Persiapan Beasiswa Luar Negeri', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&auto=format&fit=crop&q=80', 'role' => 'head'],
                        ]
                    ]
                ]
            ],
            'ikada' => [
                'leaders' => [
                    [
                        'name' => 'Ketua Umum IKADA UI',
                        'is_pinned' => true,
                        'members' => [
                            ['name' => 'Tgk. Khairul Umam, S.Pd.I', 'title' => 'Ketua Umum IKADA Pusat', 'sub_role' => 'Memimpin Koordinasi Nasional Alumni Lintas Generasi', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80', 'role' => 'leader'],
                        ]
                    ]
                ],
                'vices' => [
                    [
                        'name' => 'Sekretaris Jenderal IKADA UI',
                        'members' => [
                            ['name' => 'Ahmad Farhan, S.Kom., M.T', 'title' => 'Sekretaris Jenderal', 'sub_role' => 'Digitalisasi Database Alumni & Kesekretariatan', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ],
                    [
                        'name' => 'Bendahara Umum IKADA UI',
                        'members' => [
                            ['name' => 'dr. Nabila Zahra, Sp.A', 'title' => 'Bendahara Umum', 'sub_role' => 'Penggalangan Dana Abadi & Filantropi Alumni', 'period' => '2024 - 2028', 'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&auto=format&fit=crop&q=80', 'role' => 'vice'],
                        ]
                    ]
                ],
                'divisions' => [
                    [
                        'name' => 'Divisi Pengabdian Ummat & Bakti Sosial',
                        'members' => [
                            ['name' => 'Ust. Syarifuddin, Lc', 'title' => 'Koordinator Baksos', 'sub_role' => 'Program Khidmat Santri & Bantuan Bencana', 'period' => '2024 - 2028', 'photo' => null, 'role' => 'head'],
                        ]
                    ],
                    [
                        'name' => 'Divisi Pemberdayaan Karir & Ekonomi Alumni',
                        'members' => [
                            ['name' => 'M. Rizki Ramadhan, SE', 'title' => 'Koordinator Bisnis Alumni', 'sub_role' => 'Jejaring Bisnis, Inkubasi Usaha & Info Loker', 'period' => '2024 - 2028', 'photo' => null, 'role' => 'head'],
                        ]
                    ]
                ]
            ]
        ];

        foreach ($structures as $instType => $sections) {
            $inst = $institutions->get($instType);
            if (!$inst) continue;

            $sort = 1;
            foreach (['leaders' => 'leader', 'vices' => 'vice', 'divisions' => 'division'] as $secKey => $cat) {
                if (!isset($sections[$secKey])) continue;

                foreach ($sections[$secKey] as $posItem) {
                    $pos = StructurePosition::updateOrCreate(
                        [
                            'institution_id' => $inst->id,
                            'position_name' => $posItem['name'],
                        ],
                        [
                            'category' => $cat,
                            'is_pinned' => $posItem['is_pinned'] ?? false,
                            'sort_order' => $sort++,
                            'is_active' => true,
                        ]
                    );

                    foreach ($posItem['members'] as $mIndex => $mItem) {
                        StructureMember::updateOrCreate(
                            [
                                'position_id' => $pos->id,
                                'name' => $mItem['name'],
                            ],
                            [
                                'member_role' => $mItem['role'] ?? 'member',
                                'title' => $mItem['title'] ?? null,
                                'sub_role' => $mItem['sub_role'] ?? null,
                                'period' => $mItem['period'] ?? '2024 - Sekarang',
                                'photo_path' => $mItem['photo'] ?? null,
                                'sort_order' => $mIndex,
                                'is_active' => true,
                            ]
                        );
                    }
                }
            }
        }

        // ==========================================
        // 4. ALUMNI DUMMY PER UNIT (5 TIAP UNIT & PINNED)
        // ==========================================
        $alumniData = [
            [
                'name' => 'Dr. Muhammad Al-Fatih, Lc., MA',
                'graduation_levels' => 'dayah,sma',
                'career_type' => 'Akademisi & Dosen',
                'position_or_program' => 'Dosen Dirasah Islamiyah',
                'institution_or_company' => 'Universitas Al-Azhar Kairo / UIN',
                'short_description' => 'Mendalami kajian fiqh perbandingan mazhab dan mengabdi di berbagai forum dakwah internasional.',
                'photo_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Ahmad Farhan, S.Kom., M.T',
                'graduation_levels' => 'smp,sma',
                'career_type' => 'Software Engineer & Tech Lead',
                'position_or_program' => 'Lead Cloud Architect',
                'institution_or_company' => 'Perusahaan Teknologi Multinasional',
                'short_description' => 'Pernah menjuarai olimpiade sains SMP Ulumul Islam dan kini memimpin riset komputasi awan.',
                'photo_path' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'dr. Nabila Zahra, Sp.A',
                'graduation_levels' => 'smp,sma',
                'career_type' => 'Dokter Spesialis Anak',
                'position_or_program' => 'Spesialis Kesehatan Anak',
                'institution_or_company' => 'RSUD dr. Zainoel Abidin',
                'short_description' => 'Lulusan berprestasi yang aktif membagikan edukasi kesehatan ibu dan anak berlandaskan nilai Islam.',
                'photo_path' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Tgk. Khairul Umam, S.Pd.I',
                'graduation_levels' => 'dayah',
                'career_type' => 'Pimpinan Lembaga Pendidikan',
                'position_or_program' => 'Mudir Pesantren Tahfidz',
                'institution_or_company' => 'Yayasan Bina Ummah',
                'short_description' => 'Kader ulama muda yang membina ratusan santri penghafal Quran bersanad di berbagai daerah.',
                'photo_path' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Rizki Pratama, S.E., M.B.A',
                'graduation_levels' => 'smp,dayah',
                'career_type' => 'Praktisi Keuangan Syariah',
                'position_or_program' => 'Senior Sharia Risk Analyst',
                'institution_or_company' => 'Bank Syariah Indonesia (BSI)',
                'short_description' => 'Mengembangkan instrumen keuangan syariah dan berkontribusi dalam penguatan ekonomi umat.',
                'photo_path' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        foreach ($alumniData as $index => $item) {
            $alum = Alumni::updateOrCreate(
                ['name' => $item['name']],
                [
                    'graduation_levels' => $item['graduation_levels'],
                    'career_type' => $item['career_type'],
                    'position_or_program' => $item['position_or_program'],
                    'institution_or_company' => $item['institution_or_company'],
                    'short_description' => $item['short_description'],
                    'photo_path' => $item['photo_path'],
                    'status' => 'published',
                ]
            );

            FeaturedAlumni::updateOrCreate(
                ['alumni_id' => $alum->id],
                [
                    'placement' => 'home',
                    'sort_order' => $index + 1,
                ]
            );
        }

        // ==========================================
        // 5. GALERI ALBUM & FOTO PER UNIT
        // ==========================================
        $galleryData = [
            'foundation' => [
                'title' => 'Dokumentasi Fasilitas & Lingkungan Yayasan Ulumul Islam',
                'desc' => 'Foto sarana prasarana terpadu dan landscape komplek pesantren.',
                'photos' => [
                    ['title' => 'Komplek Utama Yayasan', 'url' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Gedung Rektorat & Administrasi', 'url' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Pusat Layanan Terpadu', 'url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Masjid Jami\' Kampus', 'url' => 'https://images.unsplash.com/photo-1584697964190-705b89368d43?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Ruang Aula Serbaguna', 'url' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800&auto=format&fit=crop&q=80'],
                ],
            ],
            'dayah' => [
                'title' => 'Dokumentasi Kehidupan Santri & Pengajian Dayah',
                'desc' => 'Aktivitas mudzakarah kitab kuning, shalat berjamaah, dan tahfidz.',
                'photos' => [
                    ['title' => 'Halaqah Pengajian Kitab Kuning', 'url' => 'https://images.unsplash.com/photo-1532012164546-f432f2e3edd7?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Halaqah Tahfidz Al-Quran', 'url' => 'https://images.unsplash.com/photo-1584697964190-705b89368d43?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Shalat Berjamaah di Masjid', 'url' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Makan Bersama di Asrama', 'url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Latihan Pidato 3 Bahasa', 'url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&auto=format&fit=crop&q=80'],
                ],
            ],
            'smp' => [
                'title' => 'Aktivitas Belajar & Praktikum Siswa SMP',
                'desc' => 'Dokumentasi praktikum sains, lab komputer, dan pembelajaran interaktif SMP.',
                'photos' => [
                    ['title' => 'Praktikum Laboratorium IPA', 'url' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Ujian Berbasis Komputer di Lab', 'url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Suasana Belajar di Kelas', 'url' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Ekskul Robotik Siswa', 'url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Pameran Karya Seni Siswa', 'url' => 'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=800&auto=format&fit=crop&q=80'],
                ],
            ],
            'sma' => [
                'title' => 'Dokumentasi Prestasi & Riset Santri SMA',
                'desc' => 'Kegiatan bimbingan olimpiade sains, seminar kampus, dan riset SMA.',
                'photos' => [
                    ['title' => 'Laboratorium Kimia & Fisika SMA', 'url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Sosialisasi Masuk Perguruan Tinggi', 'url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Simulasi UTBK Mandiri', 'url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Presentasi Karya Tulis Ilmiah', 'url' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Wisuda Kelulusan Santri SMA', 'url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&auto=format&fit=crop&q=80'],
                ],
            ],
            'ikada' => [
                'title' => 'Dokumentasi Silaturahmi & Bakti Sosial IKADA UI',
                'desc' => 'Momen reuni akbar, temu kangen, dan kegiatan pengabdian masyarakat.',
                'photos' => [
                    ['title' => 'Reuni Akbar Lintas Angkatan', 'url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Bakti Sosial & Cek Kesehatan Gratis', 'url' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Forum Bisnis Alumni', 'url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Kunjungan Alumni ke Dayah', 'url' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=80'],
                    ['title' => 'Peluncuran Buku Antologi Alumni', 'url' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&auto=format&fit=crop&q=80'],
                ],
            ],
        ];

        foreach ($galleryData as $instType => $albumInfo) {
            $inst = $institutions->get($instType);
            if (!$inst) continue;

            $album = GalleryAlbum::updateOrCreate(
                ['slug' => Str::slug($albumInfo['title'])],
                [
                    'institution_id' => $inst->id,
                    'title' => $albumInfo['title'],
                    'description' => $albumInfo['desc'],
                    'cover_path' => $albumInfo['photos'][0]['url'],
                    'sort_order' => 1,
                    'is_active' => true,
                ]
            );

            foreach ($albumInfo['photos'] as $idx => $ph) {
                GalleryMedia::updateOrCreate(
                    [
                        'album_id' => $album->id,
                        'title' => $ph['title'],
                    ],
                    [
                        'type' => 'image',
                        'file_path' => $ph['url'],
                        'file_size' => 1024 * 1024,
                        'sort_order' => $idx + 1,
                    ]
                );
            }
        }
    }
}
