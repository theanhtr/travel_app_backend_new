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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('email_contact');
            $table->integer('phone_number_contact');
            $table->string('customer_note')->nullable();
            $table->double('total_price');
            $table->integer('amount_of_people');
            $table->timestamp('time_order');
            $table->integer('room_quantity')->nullable();
            $table->timestamp('check_in_date')->nullable();
            $table->timestamp('check_out_date')->nullable();
            $table->foreignId('order_status_id')->constrained('order_statuses');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('type_room_id')->nullable()->constrained('type_rooms');
            $table->foreignId('hotel_id')->nullable()->constrained('hotels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
