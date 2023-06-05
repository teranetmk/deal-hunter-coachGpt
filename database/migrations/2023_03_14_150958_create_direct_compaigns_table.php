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
        Schema::create('direct_compaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamp('date_sent')->nullable();
            $table->integer('sent_count')->nullable();
            $table->integer('accept')->default(0)->nullable();
            $table->integer('deny')->default(0)->nullable();
            $table->integer('counter_count')->default(0)->nullable();
            $table->integer('total_count')->default(0)->nullable();
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
        Schema::dropIfExists('direct_compaigns');
    }
};
