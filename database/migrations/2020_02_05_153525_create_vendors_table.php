<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('area')->nullable();
            $table->string('country')->nullable();
            $table->int('zip')->nullable();
            $table->string('type')->nullable();
            $table->decimal('opening')->nullable();
            $table->decimal('closing')->nullable();
            $table->decimal('delivery_charge')->nullable();
            $table->decimal('vendor_charge')->nullable();
            $table->decimal('tax')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
