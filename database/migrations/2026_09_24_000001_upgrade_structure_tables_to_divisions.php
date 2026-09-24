<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('structure_positions', function (Blueprint $table) {
            $table->string('category')->default('division')->after('institution_id'); // leader, vice, division
            $table->boolean('is_pinned')->default(false)->after('sort_order');
        });

        Schema::table('structure_members', function (Blueprint $table) {
            $table->string('member_role')->default('member')->after('name'); // leader, vice, head, member
            $table->string('title')->nullable()->after('member_role');
            $table->string('sub_role')->nullable()->after('title'); // Penjelasan bagian yang dipegang
            $table->integer('sort_order')->default(0)->after('period');
        });
    }

    public function down(): void
    {
        Schema::table('structure_members', function (Blueprint $table) {
            $table->dropColumn(['member_role', 'title', 'sub_role', 'sort_order']);
        });

        Schema::table('structure_positions', function (Blueprint $table) {
            $table->dropColumn(['category', 'is_pinned']);
        });
    }
};
