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
        Schema::create('comparative_market_analyses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('title')->default('Untitled');
            $table->string('subject_property_address', 191)->nullable();
            $table->string('property_address_1', 191)->nullable();
            $table->string('property_address_2', 191)->nullable();
            $table->string('property_address_3', 191)->nullable();
            $table->string('property_address_4', 191)->nullable();

            $table->string('subject_property_include_analysis', 191)->nullable();
            $table->string('property_include_analysis_1', 191)->nullable();
            $table->string('property_include_analysis_2', 191)->nullable();
            $table->string('property_include_analysis_3', 191)->nullable();
            $table->string('property_include_analysis_4', 191)->nullable();

            $table->string('subject_property_style', 191)->nullable();
            $table->string('property_style_1', 191)->nullable();
            $table->string('property_style_2', 191)->nullable();
            $table->string('property_style_3', 191)->nullable();
            $table->string('property_style_4', 191)->nullable();

            $table->string('subject_property_square_footage', 191)->nullable();
            $table->string('property_square_footage_1', 191)->nullable();
            $table->string('property_square_footage_2', 191)->nullable();
            $table->string('property_square_footage_3', 191)->nullable();
            $table->string('property_square_footage_4', 191)->nullable();

            $table->string('subject_property_beds', 191)->nullable();
            $table->string('property_beds_1', 191)->nullable();
            $table->string('property_beds_2', 191)->nullable();
            $table->string('property_beds_3', 191)->nullable();
            $table->string('property_beds_4', 191)->nullable();

            $table->string('subject_property_baths', 191)->nullable();
            $table->string('property_baths_1', 191)->nullable();
            $table->string('property_baths_2', 191)->nullable();
            $table->string('property_baths_3', 191)->nullable();
            $table->string('property_baths_4', 191)->nullable();

            $table->string('subject_property_lot_size', 191)->nullable();
            $table->string('property_lot_size_1', 191)->nullable();
            $table->string('property_lot_size_2', 191)->nullable();
            $table->string('property_lot_size_3', 191)->nullable();
            $table->string('property_lot_size_4', 191)->nullable();

            $table->string('subject_property_year_built', 191)->nullable();
            $table->string('property_year_built_1', 191)->nullable();
            $table->string('property_year_built_2', 191)->nullable();
            $table->string('property_year_built_3', 191)->nullable();
            $table->string('property_year_built_4', 191)->nullable();

            $table->string('subject_property_garage', 191)->nullable();
            $table->string('property_garage_1', 191)->nullable();
            $table->string('property_garage_2', 191)->nullable();
            $table->string('property_garage_3', 191)->nullable();
            $table->string('property_garage_4', 191)->nullable();

            $table->string('subject_property_pool', 191)->nullable();
            $table->string('property_pool_1', 191)->nullable();
            $table->string('property_pool_2', 191)->nullable();
            $table->string('property_pool_3', 191)->nullable();
            $table->string('property_pool_4', 191)->nullable();

            $table->string('subject_property_proximity', 191)->nullable();
            $table->string('property_proximity_1', 191)->nullable();
            $table->string('property_proximity_2', 191)->nullable();
            $table->string('property_proximity_3', 191)->nullable();
            $table->string('property_proximity_4', 191)->nullable();

            $table->string('subject_property_date_sold', 191)->nullable();
            $table->string('property_date_sold_1', 191)->nullable();
            $table->string('property_date_sold_2', 191)->nullable();
            $table->string('property_date_sold_3', 191)->nullable();
            $table->string('property_date_sold_4', 191)->nullable();

            $table->string('subject_property_last_sold_price', 191)->nullable();
            $table->string('property_last_sold_price_1', 191)->nullable();
            $table->string('property_last_sold_price_2', 191)->nullable();
            $table->string('property_last_sold_price_3', 191)->nullable();
            $table->string('property_last_sold_price_4', 191)->nullable();

            $table->string('subject_property_second_last_sold_price', 191)->nullable();
            $table->string('property_second_last_sold_price_1', 191)->nullable();
            $table->string('property_second_last_sold_price_2', 191)->nullable();
            $table->string('property_second_last_sold_price_3', 191)->nullable();
            $table->string('property_second_last_sold_price_4', 191)->nullable();

            $table->string('subject_property_second_curb_appeal', 191)->nullable();
            $table->string('property_second_curb_appeal_1', 191)->nullable();
            $table->string('property_second_curb_appeal_2', 191)->nullable();
            $table->string('property_second_curb_appeal_3', 191)->nullable();
            $table->string('property_second_curb_appeal_4', 191)->nullable();

            $table->string('subject_property_curb_appeal', 3)->nullable();
            $table->string('property_curb_appeal_1', 3)->nullable();
            $table->string('property_curb_appeal_2', 3)->nullable();
            $table->string('property_curb_appeal_3', 3)->nullable();
            $table->string('property_curb_appeal_4', 3)->nullable();

            $table->string('subject_property_interior', 3)->nullable();
            $table->string('property_interior_1', 3)->nullable();
            $table->string('property_interior_2', 3)->nullable();
            $table->string('property_interior_3', 3)->nullable();
            $table->string('property_interior_4', 3)->nullable();

            $table->string('subject_property_fixtures', 3)->nullable();
            $table->string('property_fixtures_1', 3)->nullable();
            $table->string('property_fixtures_2', 3)->nullable();
            $table->string('property_fixtures_3', 3)->nullable();
            $table->string('property_fixtures_4', 3)->nullable();

            $table->string('square_footage', 11)->nullable();
            $table->string('min_square_footage', 11)->nullable();
            $table->string('max_square_footage', 11)->nullable();
            $table->string('property_age', 11)->nullable();
            $table->string('min_year_built', 11)->nullable();
            $table->string('max_year_built', 11)->nullable();
            $table->string('proximity_to_subject', 11)->nullable();
            $table->string('max_days_since_sale', 11)->nullable();
            $table->string('avg_sale_price', 11)->nullable();
            $table->string('lowest_sqft', 11)->nullable();
            $table->string('average_sqft', 11)->nullable();
            $table->string('highest_sqft', 11)->nullable();
            $table->string('range', 11)->nullable();
            $table->string('suggested_sqft', 11)->nullable();
            $table->string('subject_property_sqft', 11)->nullable();
            $table->string('subject_property_sqft_x', 11)->nullable();

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
        Schema::dropIfExists('comparative_market_analyses');
    }
};
