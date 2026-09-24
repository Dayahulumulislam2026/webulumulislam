<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institution_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->onDelete('cascade');
            $table->string('title');
            $table->string('badge')->nullable(); // e.g. 'Program Unggulan', 'Tahfidz', 'Bahasa', 'Sains'
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // e.g. 'book', 'quran', 'globe', 'flask', 'award'
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_programs');
    }
};
