<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\StructureMember;
use App\Models\StructurePosition;
use Illuminate\Database\Seeder;

class IkadaStructureSeeder extends Seeder
{
    public function run(): void
    {
        $ikada = Institution::where('type', 'ikada')->first();

        if (!$ikada) {
            $ikada = Institution::create([
                'type' => 'ikada',
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
            ]);
        }

        // Hapus struktur IKADA lama jika ada
        $existingPositions = StructurePosition::where('institution_id', $ikada->id)->get();
        foreach ($existingPositions as $pos) {
            StructureMember::where('position_id', $pos->id)->delete();
            $pos->delete();
        }

        $period = '2024 - 2029';

        // 1. Pimpinan Utama (Leader)
        $ketum = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'leader',
            'position_name' => 'Ketua Umum',
            'sort_order' => 1,
            'is_pinned' => true,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $ketum->id,
            'name' => 'Zamakh Syari',
            'member_role' => 'leader',
            'title' => 'Ketua Umum IKADA UI',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. Jajaran Wakil & Pimpinan Harian (Vice)
        // 2.1 Wakil Ketua Umum
        $waketum = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'vice',
            'position_name' => 'Wakil Ketua Umum',
            'sort_order' => 2,
            'is_pinned' => true,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waketum->id,
            'name' => 'Miswandi',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua Umum I',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $waketum->id,
            'name' => 'Syahrul Zikri',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua Umum II',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 2.2 Sekretaris Umum
        $sekretaris = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'vice',
            'position_name' => 'Sekretaris Umum',
            'sort_order' => 3,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $sekretaris->id,
            'name' => 'Hafidh Aiman',
            'member_role' => 'head',
            'title' => 'Sekretaris Umum',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $sekretaris->id,
            'name' => 'Marlisa',
            'member_role' => 'member',
            'title' => 'Wakil Sekretaris Umum I',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 2.3 Bendahara Umum
        $bendahara = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'vice',
            'position_name' => 'Bendahara Umum',
            'sort_order' => 4,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bendahara->id,
            'name' => 'Muhammad Yasir',
            'member_role' => 'head',
            'title' => 'Bendahara Umum',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $bendahara->id,
            'name' => 'Dara Syaril Fadhilah',
            'member_role' => 'member',
            'title' => 'Wakil Bendahara Umum',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 3. Divisi / Bidang Operasional (Division)
        // 3.1 Devisi Humas
        $humas = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'division',
            'position_name' => 'Devisi Humas (Hubungan Masyarakat)',
            'sort_order' => 5,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'Muhammad Lutfi',
            'member_role' => 'head',
            'title' => 'Ketua Devisi Humas',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $humas->id,
            'name' => 'Mustagh firah',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua Devisi Humas',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $humasMembers = [
            'Ahmad Miftahul Huda',
            'Muhammad Danil',
            'Saiful Fuzari',
            'M. Afdhal',
            'Arif Fadillah',
            'Budiman',
            'Irhamna 4',
            'Irhamna 5',
            'Ahmad Siraj',
            'Khazinul Alum',
            'Sharaki',
            'Muhammad',
            'Muammar Khairunnas',
            'Fadlurrahman',
            'Muhammad Hafiz',
            'Rizki Wahyudi',
            'M. Surya Zuhdi',
            'Musyira',
            'Raudhatul Jannah',
        ];
        $hSort = 3;
        foreach ($humasMembers as $hName) {
            StructureMember::create([
                'position_id' => $humas->id,
                'name' => $hName,
                'member_role' => 'member',
                'title' => 'Anggota Devisi Humas',
                'period' => $period,
                'sort_order' => $hSort++,
                'is_active' => true,
            ]);
        }

        // 3.2 Devisi Intelejen dan Data Sektor Alumni
        $intelData = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'division',
            'position_name' => 'Devisi Intelejen & Data Sektor Alumni',
            'sort_order' => 6,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $intelData->id,
            'name' => 'Idha Mahendra',
            'member_role' => 'head',
            'title' => 'Ketua Devisi Intelejen & Data',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $intelData->id,
            'name' => 'Fathur Rifqi',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua Devisi Intelejen & Data',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $intelMembers = [
            'Amrin Mukmin',
            'M. Fadil',
            'Ikhsan Aulia',
            'Muhammad Zuraihan',
            'Aulia Fahmi',
            'Muharrir Rajudin',
            'Abdan Syakura',
            'Sarah Nabila',
            'Yulida Siska',
            'Muhammad Arif',
            'M. Zarul Hakiki',
            'Asyura Mulia',
            'Bella Khairunnisa',
        ];
        $iSort = 3;
        foreach ($intelMembers as $iName) {
            StructureMember::create([
                'position_id' => $intelData->id,
                'name' => $iName,
                'member_role' => 'member',
                'title' => 'Anggota Devisi Intelejen & Data',
                'period' => $period,
                'sort_order' => $iSort++,
                'is_active' => true,
            ]);
        }

        // 3.3 Devisi Media dan Informasi
        $mediaInfo = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'division',
            'position_name' => 'Devisi Media & Informasi',
            'sort_order' => 7,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $mediaInfo->id,
            'name' => 'Muzakir',
            'member_role' => 'head',
            'title' => 'Ketua Devisi Media & Informasi',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $mediaInfo->id,
            'name' => 'Narisah Syamsyuri',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua Devisi Media & Informasi',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $mediaMembers = [
            'Saryulis',
            'M. Zuhdi',
            'Muhammad Ichsan',
            'Mujiburridha',
            'Ali Imran',
            'Farid Wajdi Rizaka',
            'Ramadhan',
            'Abizar Al Rifari',
            'Nurul Aflika',
            'Pratiwi',
            'Zahra Ikwana',
        ];
        $mSort = 3;
        foreach ($mediaMembers as $mName) {
            StructureMember::create([
                'position_id' => $mediaInfo->id,
                'name' => $mName,
                'member_role' => 'member',
                'title' => 'Anggota Devisi Media & Informasi',
                'period' => $period,
                'sort_order' => $mSort++,
                'is_active' => true,
            ]);
        }

        // 3.4 Devisi Koordinasi Umum Wanita
        $wanita = StructurePosition::create([
            'institution_id' => $ikada->id,
            'category' => 'division',
            'position_name' => 'Devisi Koordinasi Umum Wanita',
            'sort_order' => 8,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $wanita->id,
            'name' => 'Nurul Izati',
            'member_role' => 'head',
            'title' => 'Ketua Devisi Koordinasi Umum Wanita',
            'period' => $period,
            'sort_order' => 1,
            'is_active' => true,
        ]);
        StructureMember::create([
            'position_id' => $wanita->id,
            'name' => 'Fajar Khairani',
            'member_role' => 'vice',
            'title' => 'Wakil Ketua Devisi Koordinasi Umum Wanita',
            'period' => $period,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $wanitaMembers = [
            'Muzkiati',
            'Kumaira',
            'Masyitah',
            'Susi Milawati',
            'Nurhaliza',
        ];
        $wSort = 3;
        foreach ($wanitaMembers as $wName) {
            StructureMember::create([
                'position_id' => $wanita->id,
                'name' => $wName,
                'member_role' => 'member',
                'title' => 'Anggota Devisi Koordinasi Umum Wanita',
                'period' => $period,
                'sort_order' => $wSort++,
                'is_active' => true,
            ]);
        }
    }
}
