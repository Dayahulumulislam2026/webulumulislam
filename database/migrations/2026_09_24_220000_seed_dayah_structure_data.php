<?php

use Database\Seeders\DayahStructureSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Jalankan seeder struktur Dayah secara otomatis saat migrasi
        (new DayahStructureSeeder())->run();
    }

    public function down(): void
    {
        //
    }
};
