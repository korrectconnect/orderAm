<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('order_no')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('rider_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('address')->nullable();
            $table->string('payment_mode')->nullable();
            $table->decimal('delivery_charge')->nullable();
            $table->decimal('vendor_charge')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('tax')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('delivery_time')->nullable();
            $table->decimal('balance')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('cancelled')->nullable();
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
        Schema::dropIfExists('order');
    }
}
