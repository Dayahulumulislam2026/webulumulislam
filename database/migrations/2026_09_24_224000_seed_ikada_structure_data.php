<?php

use Database\Seeders\IkadaStructureSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Jalankan seeder struktur IKADA UI secara otomatis saat migrasi
        (new IkadaStructureSeeder())->run();
    }

    public function down(): void
    {
        //
    }
};
