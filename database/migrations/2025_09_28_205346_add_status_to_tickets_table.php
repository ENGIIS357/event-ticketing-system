<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['available', 'reserved', 'confirmed', 'cancelled', 'pending'])
                  ->default('available')
                  ->after('price');
            
            // إذا ناقص أي أعمدة أخرى
            $table->string('ticket_number')->unique()->after('id');
            $table->enum('type', ['regular', 'vip', 'premium'])->default('regular')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['status', 'ticket_number', 'type']);
        });
    }
};