<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_buyers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('email');
            $table->string('contact_no')->nullable();
            $table->float('min_price_range');
            $table->float('max_price_range');
            $table->float('min_profit_deal');
            $table->string('state');
            $table->string('city');
            $table->string('zip');
            $table->string('property_type');
            $table->integer('beds');
            $table->integer('baths');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('cash_buyers');
    }
};
