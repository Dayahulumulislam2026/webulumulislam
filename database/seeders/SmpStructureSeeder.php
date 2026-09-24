<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\StructureMember;
use App\Models\StructurePosition;
use Illuminate\Database\Seeder;

class SmpStructureSeeder extends Seeder
{
    public function run(): void
    {
        $smp = Institution::where('type', 'smp')->first();

        if (!$smp) {
            return;
        }

        // Hapus struktur SMP lama jika ada
        $existingPositions = StructurePosition::where('institution_id', $smp->id)->get();
        foreach ($existingPositions as $pos) {
            StructureMember::where('position_id', $pos->id)->delete();
            $pos->delete();
        }

        $period = '2025/2026';

        // 1. Pimpinan Utama (Leader)
        $kepsek = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'leader',
            'position_name' => 'Kepala Sekolah',
            'sort_order' => 1,
            'is_pinned' => true,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kepsek->id,
            'name' => 'ILYAS, S.Pd',
            'member_role' => 'leader',
            'title' => 'Kepala Sekolah SMP Swasta Ulumul Islam',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. Jajaran Wakil & Pimpinan Harian (Vice)
        // 2.1 Wakil Kepala Sekolah
        $wakepsek = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'vice',
            'position_name' => 'Wakil Kepala Sekolah',
            'sort_order' => 2,
            'is_pinned' => true,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $wakepsek->id,
            'name' => 'Maulida, S.Pd',
            'member_role' => 'vice',
            'title' => 'Wakil Kepala Sekolah',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2.2 Tata Usaha (TU)
        $tu = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'vice',
            'position_name' => 'Tata Usaha (TU)',
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'Fakar Kurniawan, S.Th.I',
            'member_role' => 'head',
            'title' => 'Kepala Tata Usaha',
            'sub_role' => 'Petugas Pengolah Data',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'Asmawati, A.Md',
            'member_role' => 'member',
            'title' => 'Staf Tata Usaha',
            'sub_role' => 'Administrasi & Kepegawaian',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'Nur Masyitah, S.HI',
            'member_role' => 'member',
            'title' => 'Staf Tata Usaha',
            'sub_role' => 'PPTK / Pengadaan Barang & Arsip Naskah',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'Raedi Asral Mustafa, SE',
            'member_role' => 'member',
            'title' => 'Staf Tata Usaha',
            'sub_role' => 'Pengarsip Surat & Persuratan',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'Irdiana, S.Pd',
            'member_role' => 'member',
            'title' => 'Staf Pendukung',
            'sub_role' => 'Penata Taman & Lingkungan Sekolah',
            'period' => $period,
            'sort_order' => 5,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'MASRUL',
            'member_role' => 'member',
            'title' => 'Petugas Keamanan & Kebersihan',
            'sub_role' => 'Security & Petugas Kebersihan Kantor',
            'period' => $period,
            'sort_order' => 6,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $tu->id,
            'name' => 'MUHAMMAD NUR, S.Ag',
            'member_role' => 'member',
            'title' => 'Petugas Operasional',
            'sub_role' => 'Pesuruh & Penjaga Malam',
            'period' => $period,
            'sort_order' => 7,
            'is_active' => true,
        ]);

        // 2.3 Kurikulum
        $kurikulum = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'vice',
            'position_name' => 'Kurikulum',
            'sort_order' => 4,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kurikulum->id,
            'name' => 'Maulida, S.Pd',
            'member_role' => 'head',
            'title' => 'Kaur Kurikulum',
            'sub_role' => 'Pengembangan & Evaluasi Pembelajaran Akademik',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2.4 Kesiswaan & Ekstrakurikuler
        $kesiswaan = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'vice',
            'position_name' => 'Kesiswaan & Ekstrakurikuler',
            'sort_order' => 5,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kesiswaan->id,
            'name' => 'Aslina Sufi, S.Pd',
            'member_role' => 'head',
            'title' => 'Kaur Kesiswaan',
            'sub_role' => 'Pembina OSIS & Pembinaan Disiplin Santri',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kesiswaan->id,
            'name' => 'Safrina, S.Pd',
            'member_role' => 'member',
            'title' => 'Pembina Ekstrakurikuler',
            'sub_role' => 'Pembina Palang Merah Remaja (PMR)',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 2.5 Hubungan Masyarakat & Sarana Prasarana
        $humas = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'vice',
            'position_name' => 'Humas & Sarana Prasarana',
            'sort_order' => 6,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'M. Yusuf Ali',
            'member_role' => 'head',
            'title' => 'Koordinator Humas',
            'sub_role' => 'Komunikasi Eksternal & Hubungan Masyarakat',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'Nurul Fitri Fajri, S.Pd',
            'member_role' => 'member',
            'title' => 'Kaur Sarana & Prasarana',
            'sub_role' => 'Inventarisasi & Pemeliharaan Fasilitas Sekolah',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'Era Silvia, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Ketua BKS',
            'sub_role' => 'Badan Kerjasama Sekolah',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 3. Divisi / Unit Pelaksana Teknis (Division)
        // 3.1 Laboratorium (LAB)
        $lab = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'division',
            'position_name' => 'Laboratorium IPA & Kimia',
            'sort_order' => 7,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $lab->id,
            'name' => 'Asmani, S.Pd.I',
            'member_role' => 'head',
            'title' => 'Kepala Laboratorium',
            'sub_role' => 'Pengelolaan Fasilitas & Praktikum Riset',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $lab->id,
            'name' => 'Maulida, S.Pd',
            'member_role' => 'member',
            'title' => 'Penanggung Jawab Lab IPA',
            'sub_role' => 'Praktikum Sains & Biologi',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $lab->id,
            'name' => 'Nurlenayani, S.Pd',
            'member_role' => 'member',
            'title' => 'Penanggung Jawab Lab Kimia',
            'sub_role' => 'Praktikum Kimia & Sains Terpadu',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 3.2 Perpustakaan Sekolah
        $pustaka = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'division',
            'position_name' => 'Perpustakaan Sekolah',
            'sort_order' => 8,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pustaka->id,
            'name' => 'Asmani, S.Pd',
            'member_role' => 'head',
            'title' => 'Kepala Perpustakaan',
            'sub_role' => 'Manajemen Koleksi & Literasi Santri',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pustaka->id,
            'name' => 'Nur Masyitah, S.HI',
            'member_role' => 'member',
            'title' => 'Petugas Pustaka Pengelola',
            'sub_role' => 'Katalogisasi & Pengelolaan Buku',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pustaka->id,
            'name' => 'Irmayanti, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Petugas Sirkulasi',
            'sub_role' => 'Layanan Peminjaman & Pengembalian',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pustaka->id,
            'name' => 'Raedi Asral.M, SE',
            'member_role' => 'member',
            'title' => 'Petugas Layanan',
            'sub_role' => 'Pelayanan Anggota & Ruang Baca',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 3.3 Bimbingan Konseling (Guru BP / BK)
        $bk = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'division',
            'position_name' => 'Bimbingan & Konseling (BK)',
            'sort_order' => 9,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bk->id,
            'name' => 'Nurul Fitri Fajri, S.Pd',
            'member_role' => 'head',
            'title' => 'Koordinator Guru BP / BK',
            'sub_role' => 'Konseling Akademik & Perkembangan Karakter',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bk->id,
            'name' => 'Cut Putri Handayani, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru BP / BK',
            'sub_role' => 'Konseling Santri & Bimbingan Minat Bakat',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bk->id,
            'name' => 'Khairunnisa, S.Ag',
            'member_role' => 'member',
            'title' => 'Guru BP / BK',
            'sub_role' => 'Bimbingan Adab & Konseling Spiritual',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 3.4 UKS, Lingkungan Hidup & Pembina Kesenian
        $uks = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'division',
            'position_name' => 'UKS, Lingkungan & Pembina Kesenian',
            'sort_order' => 10,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $uks->id,
            'name' => 'K. RAHMI, S.Pd',
            'member_role' => 'head',
            'title' => 'Koordinator UKS & Kebersihan Lingkungan',
            'sub_role' => 'Kesehatan Sekolah & Sanitasi',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $uks->id,
            'name' => 'Desi A.D, S.Pd',
            'member_role' => 'member',
            'title' => 'Pembina Kesenian Kelas VII',
            'sub_role' => 'Kesenian & Kreativitas Santri',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $uks->id,
            'name' => 'Khairunnisa, S.Ag',
            'member_role' => 'member',
            'title' => 'Pembina Kesenian Kelas VIII',
            'sub_role' => 'Kesenian & Kreativitas Santri',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $uks->id,
            'name' => 'Irdiana, S.Pd',
            'member_role' => 'member',
            'title' => 'Pembina Kesenian Kelas IX',
            'sub_role' => 'Kesenian & Kreativitas Santri',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 3.5 Wali Kelas
        $waliKelas = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'division',
            'position_name' => 'Wali Kelas (Kelas VII, VIII, IX)',
            'sort_order' => 11,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Era Silvia, S.Pd.I',
            'member_role' => 'head',
            'title' => 'Wali Kelas VII-1',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Mursyidah, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas VII-2',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Fitriani, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas VII-3',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Linda Dewi, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas VII-4',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Asmani, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Wali Kelas VIII-1',
            'period' => $period,
            'sort_order' => 5,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Irdiana, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas VIII-2',
            'period' => $period,
            'sort_order' => 6,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Safrina, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Wali Kelas VIII-3',
            'period' => $period,
            'sort_order' => 7,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Nurul Fitri fajri, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Wali Kelas VIII-4',
            'period' => $period,
            'sort_order' => 8,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Erli Ermawati, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas IX-1',
            'period' => $period,
            'sort_order' => 9,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Maulida, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas IX-2',
            'period' => $period,
            'sort_order' => 10,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Nurlalina, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas IX-3',
            'period' => $period,
            'sort_order' => 11,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waliKelas->id,
            'name' => 'Khairurrahmi, S.Pd',
            'member_role' => 'member',
            'title' => 'Wali Kelas IX-4',
            'period' => $period,
            'sort_order' => 12,
            'is_active' => true,
        ]);

        // 3.6 Koordinator Guru Mata Pelajaran (Dewan Guru)
        $dewanGuru = StructurePosition::create([
            'institution_id' => $smp->id,
            'category' => 'division',
            'position_name' => 'Koordinator Guru Mata Pelajaran',
            'sort_order' => 12,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'MUHAMMAD NUR, S.Ag',
            'member_role' => 'head',
            'title' => 'Guru Pend. Agama Islam / Al-Quran Hadits',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Nasrina, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Bahasa Indonesia',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Fitriani, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Guru Fisika',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Shinta Bella, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru IPS',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Raedi Asral M, SE',
            'member_role' => 'member',
            'title' => 'Guru Penjaskes',
            'period' => $period,
            'sort_order' => 5,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Nurlenayani, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Penjaskes',
            'period' => $period,
            'sort_order' => 6,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Nazriani, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Prakarya',
            'period' => $period,
            'sort_order' => 7,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Desi Aulia.DH, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Informatika',
            'period' => $period,
            'sort_order' => 8,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Putri Meuliawati, S.Tr',
            'member_role' => 'member',
            'title' => 'Guru Informatika',
            'period' => $period,
            'sort_order' => 9,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Nurlalina, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Guru PKN',
            'period' => $period,
            'sort_order' => 10,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Erli Ermawati, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Matematika',
            'period' => $period,
            'sort_order' => 11,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Mursyidah, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Biologi',
            'period' => $period,
            'sort_order' => 12,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Safrina, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Guru Matematika',
            'period' => $period,
            'sort_order' => 13,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Fitriani, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Matematika',
            'period' => $period,
            'sort_order' => 14,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Nurul P. Fajri, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Bahasa Inggris',
            'period' => $period,
            'sort_order' => 15,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Aqlima Sufi, S.Pd',
            'member_role' => 'member',
            'title' => 'Guru Bahasa Inggris',
            'period' => $period,
            'sort_order' => 16,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $dewanGuru->id,
            'name' => 'Era Selvia, S.Pd.I',
            'member_role' => 'member',
            'title' => 'Guru PAI / Al-Quran Hadits',
            'period' => $period,
            'sort_order' => 17,
            'is_active' => true,
        ]);
    }
}
