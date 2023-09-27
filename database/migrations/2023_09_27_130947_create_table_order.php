<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderedBy');
            $table->string('orderedFrom');
            $table->integer('productId');
            $table->boolean('isCompleted');
            $table->decimal('totalPrice');
            $table->date('pickUpDate');
            $table->date('dropDate');
            $table->time('pickUpTime');
            $table->time('dropTime');
            $table->string('pickUpLocation');
            $table->string('dropLocation');
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