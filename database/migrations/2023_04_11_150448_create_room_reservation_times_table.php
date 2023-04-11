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
        Schema::create('room_reservation_times', function (Blueprint $table) {
            $table->id();
            $table->timestamp('check_in_date')->nullable();
            $table->timestamp('check_out_date')->nullable();
            $table->foreignId('room_id')->constrained('rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_reservation_times');
    }
};
