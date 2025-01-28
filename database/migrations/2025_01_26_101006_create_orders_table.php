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
            $table->string('customer_name', 225);
            $table->string('table_no', 5);
            $table->date('order_date');
            $table->time('order_time');
            $table->enum('status', ['ordered', 'ready', 'paid'])->default('ordered');
            $table->integer('total')->unsigned();
            $table->unsignedBigInteger('waiter_id');
            $table->unsignedBigInteger('cashier_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('waiter_id')->references('id')->on('users');
            $table->foreign('cashier_id')->references('id')->on('users');

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
