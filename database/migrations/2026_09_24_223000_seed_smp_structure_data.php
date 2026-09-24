<?php

use Database\Seeders\SmpStructureSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Jalankan seeder struktur SMP secara otomatis saat migrasi
        (new SmpStructureSeeder())->run();
    }

    public function down(): void
    {
        //
    }
};
