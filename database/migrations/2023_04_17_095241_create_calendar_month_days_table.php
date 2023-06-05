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
        Schema::create('calendar_month_days', function (Blueprint $table) {
            $table->id();

            $table->foreignId('calendar_month_id')->constrained('calendar_months')->onDelete('cascade');

            $table->date('date');

            $table->integer('day');

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
        Schema::dropIfExists('calendar_month_days');
    }
};
