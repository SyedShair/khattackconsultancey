<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('query')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('last_visitor_message_at')->nullable();
            $table->timestamp('last_admin_read_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_session_id')->constrained()->cascadeOnDelete();
            $table->enum('sender', ['visitor', 'admin', 'ai'])->default('visitor');
            $table->text('message');
            $table->timestamps();

            $table->index('chat_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_sessions');
    }
};
