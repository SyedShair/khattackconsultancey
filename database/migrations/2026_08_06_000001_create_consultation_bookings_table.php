<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('query')->nullable();
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['confirmed', 'cancelled', 'completed'])->default('confirmed');
            $table->timestamps();

            $table->index(['booking_date', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_bookings');
    }
};
