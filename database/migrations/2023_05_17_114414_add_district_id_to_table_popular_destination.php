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
        Schema::table('popular_destinations', function (Blueprint $table) {
            $table->foreignId('district_id')->nullable()->constrained('districts');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('district_id');
            $table->dropColumn('district_id');
        });
    }
};
