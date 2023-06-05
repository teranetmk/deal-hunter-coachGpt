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
        Schema::create('calendar_month_day_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('calendar_month_day_id')->constrained('calendar_month_days')->onDelete('cascade');

            $table->string('title');
            $table->string('color');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('total_time');
            $table->text('description')->nullable();

            $table->date('date');

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
        Schema::dropIfExists('calendar_month_day_events');
    }
};
