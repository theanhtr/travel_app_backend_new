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
        Schema::create('like_reviews', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_like');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('review_id')->constrained('reviews');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like_reviews');
    }
};
