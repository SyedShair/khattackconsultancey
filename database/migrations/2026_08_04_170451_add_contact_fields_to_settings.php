<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('address')->nullable()->after('theme');
            $table->string('phone', 30)->nullable()->after('address');
            $table->string('email')->nullable()->after('phone');
            $table->text('map_url')->nullable()->after('email');
            $table->json('opening_hours')->nullable()->after('map_url');
        });

        $defaultHours = [
            'mon' => ['open' => '09:00', 'close' => '17:00', 'closed' => false],
            'tue' => ['open' => '09:00', 'close' => '17:00', 'closed' => false],
            'wed' => ['open' => '09:00', 'close' => '17:00', 'closed' => false],
            'thu' => ['open' => '09:00', 'close' => '17:00', 'closed' => false],
            'fri' => ['open' => '09:00', 'close' => '17:00', 'closed' => false],
            'sat' => ['open' => null, 'close' => null, 'closed' => true],
            'sun' => ['open' => null, 'close' => null, 'closed' => true],
        ];

        // Backfill the existing settings row(s) with sensible defaults.
        DB::table('settings')->update([
            'opening_hours' => json_encode($defaultHours),
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone', 'email', 'map_url', 'opening_hours']);
        });
    }
};