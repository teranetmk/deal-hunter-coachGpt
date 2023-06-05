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
        Schema::create('instant_offers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->text('address');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('offer_price')->nullable();
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
        Schema::dropIfExists('instant_offers');
    }
};
