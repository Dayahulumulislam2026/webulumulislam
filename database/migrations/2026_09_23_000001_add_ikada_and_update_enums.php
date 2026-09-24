<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi kolom type di tabel institutions untuk mendukung unit 'ikada'
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });

        // 2. Modifikasi kolom role di tabel users untuk mendukung 'admin_ikada'
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('admin')->change();
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('admin')->change();
        });
    }
};
