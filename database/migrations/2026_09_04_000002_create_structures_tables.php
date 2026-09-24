<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('structure_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->onDelete('cascade');
            $table->string('position_name');
            $table->integer('sort_order')->default(1); // Level 1 to 4
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('structure_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained('structure_positions')->onDelete('cascade');
            $table->string('name');
            $table->string('period')->default('2024 - 2029');
            $table->string('photo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('structure_members');
        Schema::dropIfExists('structure_positions');
    }
};
