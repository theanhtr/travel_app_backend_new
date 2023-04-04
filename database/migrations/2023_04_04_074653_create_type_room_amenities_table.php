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
        Schema::create('type_room_amenity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amenity_id')->constrained('amenities');
            $table->foreignId('type_room_id')->constrained('type_rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_room_amenities');
    }
};
