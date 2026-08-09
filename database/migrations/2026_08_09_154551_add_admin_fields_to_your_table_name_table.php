<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->string('assigned_admin_name')->nullable()->after('status');
            $table->timestamp('admin_typing_until')->nullable()->after('assigned_admin_name');
        });
    }

    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropColumn([
                'assigned_admin_name',
                'admin_typing_until',
            ]);
        });
    }
};