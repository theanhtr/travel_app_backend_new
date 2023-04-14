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
        Schema::create('reviews', function (Blueprint $table) {
            $table -> id();
            $table -> string('comment') -> nullable();
            $table -> integer('star_rating');
            $table -> boolean('can_update');
            $table -> boolean('user_private');
            $table -> integer('count_like');
            $table -> integer('count_dislike');
            $table -> boolean('is_block');
            $table -> foreignId('order_id') -> constrained('orders');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
