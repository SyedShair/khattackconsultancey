<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Null vacancy_id = a general application submitted when no
            // vacancy was open (name, email, phone, resume only).
            $table->foreignId('vacancy_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('resume'); // storage path (private disk)
            $table->longText('cover_letter')->nullable();

            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'])
                  ->default('pending');

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};