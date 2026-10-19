<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Main course image
        if (Schema::hasTable('courses') && ! Schema::hasColumn('courses', 'image')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('image')->nullable();
            });
        }

        // Sub-course image
        if (Schema::hasTable('course_items') && ! Schema::hasColumn('course_items', 'image')) {
            Schema::table('course_items', function (Blueprint $table) {
                $table->string('image')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('courses', 'image')) {
            Schema::table('courses', fn (Blueprint $t) => $t->dropColumn('image'));
        }
        if (Schema::hasColumn('course_items', 'image')) {
            Schema::table('course_items', fn (Blueprint $t) => $t->dropColumn('image'));
        }
    }
};