<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')
			->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('cart_id')->unsigned();
			$table->foreign('cart_id')->references('id')
			->on('carts')->onUpdate('cascade')->onDelete('cascade');
            $table->text('address')->nullable();
            $table->enum('status',['pending','completed','cancelled'])->default('pending');
            $table->decimal('total',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
