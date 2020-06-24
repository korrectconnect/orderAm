<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('country')->nullable();
            $table->text('address')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('plate_number')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->string('location_assigned')->nullable();
            $table->text('location_description')->nullable();
            $table->string('image')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('riders');
    }
}
