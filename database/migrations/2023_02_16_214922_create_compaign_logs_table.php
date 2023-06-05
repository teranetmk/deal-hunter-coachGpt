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
        Schema::create('compaign_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compaign_id');
            $table->unsignedBigInteger('list_id');
            $table->unsignedBigInteger('property_id');
            $table->string("compaign_board_id")->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('compaign_logs');
    }
};
