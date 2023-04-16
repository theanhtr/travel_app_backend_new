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
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->foreignId('type_room_id')->constrained('type_rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'hotel_id', 'type_room_id']);
            $table->dropColumn(['user_id', 'hotel_id', 'type_room_id']);
        });
    }
};
