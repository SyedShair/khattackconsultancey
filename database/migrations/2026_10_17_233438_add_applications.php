<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // All nullable: existing rows and general (no-vacancy) applications
            // don't collect these fields.
            $table->string('current_location', 150)->nullable()->after('phone');

            $table->string('highest_qualification', 30)->nullable()->after('current_location');
            $table->string('years_experience', 20)->nullable()->after('highest_qualification');

            $table->boolean('right_to_work')->nullable()->after('years_experience');
            $table->boolean('requires_sponsorship')->nullable()->after('right_to_work');

            // "Why do you consider yourself suitable?" (max 150 words)
            $table->text('suitability')->nullable()->after('cover_letter');

            $table->boolean('declaration_accepted')->default(false)->after('suitability');
            $table->timestamp('declaration_accepted_at')->nullable()->after('declaration_accepted');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'current_location',
                'highest_qualification',
                'years_experience',
                'right_to_work',
                'requires_sponsorship',
                'suitability',
                'declaration_accepted',
                'declaration_accepted_at',
            ]);
        });
    }
};