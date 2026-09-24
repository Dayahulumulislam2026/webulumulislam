<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['foundation', 'smp', 'sma', 'dayah'])->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('vision')->nullable();
            $table->json('mission')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->onDelete('cascade');
            $table->string('metric'); // students_male, students_female, total_alumni
            $table->integer('value')->default(0);
            $table->timestamps();

            $table->unique(['institution_id', 'metric']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
        Schema::dropIfExists('institutions');
    }
};
