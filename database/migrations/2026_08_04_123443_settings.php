<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('AdminLTE');
            $table->string('logo')->nullable();
            $table->enum('theme', ['light', 'dark'])->default('light');
            $table->timestamps();
        });

        // Seed a single settings row so the app always has one to read/update.
        \DB::table('settings')->insert([
            'app_name'   => config('app.name', 'AdminLTE'),
            'logo'       => null,
            'theme'      => 'light',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};