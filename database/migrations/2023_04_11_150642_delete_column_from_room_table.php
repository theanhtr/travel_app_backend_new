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
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('check_in_date');
            $table->dropColumn('check_out_date');
            $table->dropColumn('availablity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->boolean('availablity');
            $table->timestamp('check_in_date')->nullable();
            $table->timestamp('check_out_date')->nullable();
        });
    }
};
