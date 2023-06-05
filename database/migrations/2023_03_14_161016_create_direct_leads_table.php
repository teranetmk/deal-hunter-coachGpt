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
        Schema::create('direct_leads', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('com_id');
            // $table->unsignedBigInteger('prop_id');

            // $table->integer('accept')->nullable();
            // $table->integer('deny')->nullable();
            // $table->integer('counter')->nullable();
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
        Schema::dropIfExists('direct_leads');
    }
};
