<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admission_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->onDelete('cascade');
            $table->boolean('is_open')->default(false);
            $table->longText('requirements')->nullable();
            $table->longText('required_documents')->nullable();
            $table->longText('schedule_information')->nullable();
            $table->text('additional_information')->nullable();
            $table->text('whatsapp_template')->nullable();
            $table->timestamps();

            $table->unique('institution_id');
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key')->unique();
            $table->longText('setting_value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('admission_settings');
    }
};
