<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Main detail-page content (the big image + heading + paragraphs
            // at the top of the Service Details page)
            $table->string('detail_image')->nullable()->after('sort_order');
            $table->longText('content')->nullable()->after('detail_image');

            // "Implementation Planning" split section (image + heading + text)
            $table->string('planning_image')->nullable()->after('content');
            $table->string('planning_heading')->nullable()->after('planning_image');
            $table->longText('planning_text')->nullable()->after('planning_heading');

            // "Execution and Monitoring" section (heading + text, no image)
            $table->string('execution_heading')->nullable()->after('planning_text');
            $table->longText('execution_text')->nullable()->after('execution_heading');

            // Downloadable brochure files shown in the sidebar
            $table->string('brochure_pdf')->nullable()->after('execution_text');
            $table->string('brochure_doc')->nullable()->after('brochure_pdf');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'detail_image',
                'content',
                'planning_image',
                'planning_heading',
                'planning_text',
                'execution_heading',
                'execution_text',
                'brochure_pdf',
                'brochure_doc',
            ]);
        });
    }
};