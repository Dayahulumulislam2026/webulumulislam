<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('graduation_levels'); // e.g. "smp", "sma", "dayah" or "smp,sma"
            $table->string('career_type')->default('student'); // student, professional, entrepreneur, scholar
            $table->string('position_or_program');
            $table->string('institution_or_company');
            $table->text('short_description');
            $table->string('photo_path')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });

        Schema::create('featured_alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni')->onDelete('cascade');
            $table->enum('placement', ['home', 'unit'])->default('unit');
            $table->integer('sort_order')->default(10);
            $table->timestamps();

            $table->unique(['alumni_id', 'placement']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_alumni');
        Schema::dropIfExists('alumni');
    }
};
