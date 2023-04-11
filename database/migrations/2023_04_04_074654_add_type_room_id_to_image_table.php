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
        Schema::table('images', function (Blueprint $table) {
            $table->foreignId('type_room_id')->nullable()->constrained('type_rooms');
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign(['type_room_id']);
            $table->dropColumn('type_room_id');
        });
    }
};