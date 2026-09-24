<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\StructureMember;
use App\Models\StructurePosition;
use Illuminate\Database\Seeder;

class DayahStructureSeeder extends Seeder
{
    public function run(): void
    {
        $dayah = Institution::where('type', 'dayah')->first();

        if (!$dayah) {
            return;
        }

        // Hapus struktur Dayah lama jika ada
        $existingPositions = StructurePosition::where('institution_id', $dayah->id)->get();
        foreach ($existingPositions as $pos) {
            StructureMember::where('position_id', $pos->id)->delete();
            $pos->delete();
        }

        $period = '2024 - 2029';

        // 1. Pimpinan Dayah (Leader)
        $pimpinan = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'leader',
            'position_name' => 'Pimpinan Dayah',
            'sort_order' => 1,
            'is_pinned' => true,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pimpinan->id,
            'name' => 'TGK. H. BAIHAQI YAHYA, S.HI',
            'member_role' => 'leader',
            'title' => 'Pimpinan Dayah',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. Wakil Pimpinan Dayah (Vice)
        $wakilPimpinan = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'vice',
            'position_name' => 'Wakil Pimpinan Dayah',
            'sort_order' => 2,
            'is_pinned' => true,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $wakilPimpinan->id,
            'name' => 'TGK. H. IBNU HAJAR YAHYA, S.AG',
            'member_role' => 'vice',
            'title' => 'Wakil Pimpinan Dayah',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 3. Pamong (BPH / Vice)
        $pamong = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'vice',
            'position_name' => 'Pamong',
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pamong->id,
            'name' => 'TGK. KAUSAR, M.PD',
            'member_role' => 'head',
            'title' => 'Ketua Pamong',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pamong->id,
            'name' => 'TGK. H. TARMIZI, S.AG',
            'member_role' => 'vice',
            'title' => 'Wakil Pamong',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 4. Bendahara (BPH / Vice)
        $bendahara = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'vice',
            'position_name' => 'Bendahara',
            'sort_order' => 4,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bendahara->id,
            'name' => 'TGK. H. TARMIZI, S.AG',
            'member_role' => 'head',
            'title' => 'Ketua Bendahara',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bendahara->id,
            'name' => 'TGK. KAUSAR, M.PD',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bendahara->id,
            'name' => 'TGK. ABDULLAH, S.P',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 5. Sekretaris (BPH / Vice)
        $sekretaris = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'vice',
            'position_name' => 'Sekretaris',
            'sort_order' => 5,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $sekretaris->id,
            'name' => 'TGK. HASBIANI, S.HI',
            'member_role' => 'head',
            'title' => 'Ketua Sekretaris',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $sekretaris->id,
            'name' => 'TGK. YUSRIZAL, S.E',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $sekretaris->id,
            'name' => 'TGK. WAHYUNI, S.PdI',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 6. Bagian Ekstrakurikuler
        $ekskul = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Ekstrakurikuler',
            'sort_order' => 6,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ekskul->id,
            'name' => 'TGK. ABDULLAH, S.PdI',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ekskul->id,
            'name' => 'TGK. WAHYUNI, S.PdI',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ekskul->id,
            'name' => 'Ustzh. MUTIA FADHILLAH',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 7. Bagian Kesehatan
        $kesehatan = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Kesehatan',
            'sort_order' => 7,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kesehatan->id,
            'name' => 'TGK. YUSRIZAL, S.E',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kesehatan->id,
            'name' => 'TGK. MUHARDI, S.Ag',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kesehatan->id,
            'name' => 'TGK. M. LUTFI, S.FU',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kesehatan->id,
            'name' => 'Ustzh. MUSYIRA',
            'member_role' => 'member',
            'title' => 'Anggota III',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 8. Bagian Asrama
        $asrama = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Asrama',
            'sort_order' => 8,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $asrama->id,
            'name' => 'TGK. KHAIRIZAL, S.FU',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $asrama->id,
            'name' => 'TGK. WAHYUNI, S.PdI',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 9. Bagian Uqubah
        $uqubah = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Uqubah',
            'sort_order' => 9,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $uqubah->id,
            'name' => 'TGK. ASBAHANI',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $uqubah->id,
            'name' => 'TGK. MAULANA, S.FU',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 10. Bagian Mahkamah
        $mahkamah = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Mahkamah',
            'sort_order' => 10,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $mahkamah->id,
            'name' => 'TGK. WAHYUNI, S.PdI',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $mahkamah->id,
            'name' => 'TGK. YUSRIZAL, S.E',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $mahkamah->id,
            'name' => 'TGK. ABDULLAH, S.PdI',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 11. Bagian Pendidikan
        $pendidikan = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Pendidikan',
            'sort_order' => 11,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pendidikan->id,
            'name' => 'TGK. MUHARDI, S.Ag',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pendidikan->id,
            'name' => 'TGK. MUTTAQIN, S.PdI',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $pendidikan->id,
            'name' => 'TGK. KHAIRIZAL, S.FU',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 12. Bagian Keamanan
        $keamanan = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Keamanan',
            'sort_order' => 12,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $keamanan->id,
            'name' => 'TGK. MUSLEM, S.Ud',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $keamanan->id,
            'name' => 'TGK. MUTTAQIN, S.PdI',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $keamanan->id,
            'name' => 'TGK. KAUSAR, M.Pd',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $keamanan->id,
            'name' => 'TGK. YUSRIZAL, S.E',
            'member_role' => 'member',
            'title' => 'Anggota III',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 13. Bagian Listrik & Air
        $listrikAir = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Listrik & Air',
            'sort_order' => 13,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $listrikAir->id,
            'name' => 'TGK. ASBAHANI',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $listrikAir->id,
            'name' => 'TGK. MUSLEM, S.Ud',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $listrikAir->id,
            'name' => 'TGK. LUTFI, S.FU',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 14. Bagian Inventaris
        $inventaris = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Inventaris',
            'sort_order' => 14,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $inventaris->id,
            'name' => 'TGK. ISRAHUDDIN, S.PdI',
            'member_role' => 'head',
            'title' => 'Ketua / Pengelola',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 15. Bagian Ibadah
        $ibadah = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Ibadah',
            'sort_order' => 15,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ibadah->id,
            'name' => 'TGK. RIDWAN, S.Ag',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ibadah->id,
            'name' => 'TGK. MAULANA, S.Ag',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ibadah->id,
            'name' => 'TGK. M. LUTFI, S.FU',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ibadah->id,
            'name' => 'TGK. M. NUR, S.Ag',
            'member_role' => 'member',
            'title' => 'Anggota III',
            'period' => $period,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 16. Bagian Kebersihan
        $kebersihan = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Kebersihan',
            'sort_order' => 16,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kebersihan->id,
            'name' => 'TGK. ISRAHUDDIN, S.PdI',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kebersihan->id,
            'name' => 'TGK. MAULANA, S.Ag',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $kebersihan->id,
            'name' => 'TGK. KHAIRIZAL, S.FU',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 17. Bagian Humas & Perizinan
        $humas = StructurePosition::create([
            'institution_id' => $dayah->id,
            'category' => 'division',
            'position_name' => 'Bagian Humas & Perizinan',
            'sort_order' => 17,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'TGK. M. NUR, S.Ag',
            'member_role' => 'head',
            'title' => 'Ketua',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'TGK. RIDWAN, S.Ag',
            'member_role' => 'member',
            'title' => 'Anggota I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'TGK. KHAIRIZAL, S.FU',
            'member_role' => 'member',
            'title' => 'Anggota II',
            'period' => $period,
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}
