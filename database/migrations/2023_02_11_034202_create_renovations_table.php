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
        Schema::create('renovations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('title', 191)->default('Untitled');

            $table->boolean('enable_new_flooring')->default(0);
            $table->string('new_flooring_qty', 10)->default(0);
            $table->string('new_flooring_price', 10)->default(0);

            $table->boolean('enable_hardwood_refinishing')->default(0);
            $table->string('hardwood_refinishing_qty', 10)->default(0);
            $table->string('hardwood_refinishing_price', 10)->default(0);

            $table->boolean('enable_new_carpet_and_padding')->default(0);
            $table->string('new_carpet_and_padding_qty', 10)->default(0);
            $table->string('new_carpet_and_padding_price', 10)->default(0);

            $table->boolean('enable_drywall_patch')->default(0);
            $table->string('drywall_patch_qty', 10)->default(0);
            $table->string('drywall_patch_price', 10)->default(0);

            $table->boolean('enable_plumber_work')->default(0);
            $table->string('plumber_work_qty', 10)->default(0);
            $table->string('plumber_work_price', 10)->default(0);

            $table->boolean('enable_electrician_work')->default(0);
            $table->string('electrician_work_qty', 10)->default(0);
            $table->string('electrician_work_price', 10)->default(0);

            $table->boolean('enable_carpenter_work')->default(0);
            $table->string('carpenter_work_qty', 10)->default(0);
            $table->string('carpenter_work_price', 10)->default(0);

            $table->boolean('enable_interior_paint')->default(0);
            $table->string('interior_paint_qty', 10)->default(0);
            $table->string('interior_paint_price', 10)->default(0);

            $table->boolean('enable_insulation')->default(0);
            $table->string('insulation_qty', 10)->default(0);
            $table->string('insulation_price', 10)->default(0);

            $table->boolean('enable_furance')->default(0);
            $table->string('furance_qty', 10)->default(0);
            $table->string('furance_price', 10)->default(0);

            $table->boolean('enable_hvac')->default(0);
            $table->string('hvac_qty', 10)->default(0);
            $table->string('hvac_price', 10)->default(0);

            $table->boolean('enable_water_heater')->default(0);
            $table->string('water_heater_qty', 10)->default(0);
            $table->string('water_heater_price', 10)->default(0);

            $table->boolean('enable_boiler')->default(0);
            $table->string('boiler_qty', 10)->default(0);
            $table->string('boiler_price', 10)->default(0);

            $table->boolean('enable_refrigerator')->default(0);
            $table->string('refrigerator_qty', 10)->default(0);
            $table->string('refrigerator_price', 10)->default(0);

            $table->boolean('enable_oven')->default(0);
            $table->string('oven_qty', 10)->default(0);
            $table->string('oven_price', 10)->default(0);

            $table->boolean('enable_dishwasher')->default(0);
            $table->string('dishwasher_qty', 10)->default(0);
            $table->string('dishwasher_price', 10)->default(0);

            $table->boolean('enable_microwave')->default(0);
            $table->string('microwave_qty', 10)->default(0);
            $table->string('microwave_price', 10)->default(0);

            $table->boolean('enable_kitchen_cabinet_and_hardware')->default(0);
            $table->string('kitchen_cabinet_and_hardware_qty', 10)->default(0);
            $table->string('kitchen_cabinet_and_hardware_price', 10)->default(0);

            $table->boolean('enable_kitchen_countertops')->default(0);
            $table->string('kitchen_countertops_qty', 10)->default(0);
            $table->string('kitchen_countertops_price', 10)->default(0);

            $table->boolean('enable_kitchen_backsplash')->default(0);
            $table->string('kitchen_backsplash_qty', 10)->default(0);
            $table->string('kitchen_backsplash_price', 10)->default(0);

            $table->boolean('enable_garbage_disposal')->default(0);
            $table->string('garbage_disposal_qty', 10)->default(0);
            $table->string('garbage_disposal_price', 10)->default(0);

            $table->boolean('enable_bathroom_vanity')->default(0);
            $table->string('bathroom_vanity_qty', 10)->default(0);
            $table->string('bathroom_vanity_price', 10)->default(0);

            $table->boolean('enable_toilet')->default(0);
            $table->string('toilet_qty', 10)->default(0);
            $table->string('toilet_price', 10)->default(0);

            $table->boolean('enable_tub_reglazing')->default(0);
            $table->string('tub_reglazing_qty', 10)->default(0);
            $table->string('tub_reglazing_price', 10)->default(0);

            $table->boolean('enable_shower_tile')->default(0);
            $table->string('shower_tile_qty', 10)->default(0);
            $table->string('shower_tile_price', 10)->default(0);

            $table->boolean('enable_mold_remediation')->default(0);
            $table->string('mold_remediation_qty', 10)->default(0);
            $table->string('mold_remediation_price', 10)->default(0);

            $table->boolean('enable_electrical_fixture')->default(0);
            $table->string('electrical_fixture_qty', 10)->default(0);
            $table->string('electrical_fixture_price', 10)->default(0);

            $table->boolean('enable_water_fixture')->default(0);
            $table->string('water_fixture_qty', 10)->default(0);
            $table->string('water_fixture_price', 10)->default(0);

            $table->boolean('enable_doors')->default(0);
            $table->string('doors_qty', 10)->default(0);
            $table->string('doors_price', 10)->default(0);

            $table->boolean('enable_roof_asphalt')->default(0);
            $table->string('roof_asphalt_qty', 10)->default(0);
            $table->string('roof_asphalt_price', 10)->default(0);

            $table->boolean('enable_chimney_repair')->default(0);
            $table->string('chimney_repair_qty', 10)->default(0);
            $table->string('chimney_repair_price', 10)->default(0);

            $table->boolean('enable_gutters')->default(0);
            $table->string('gutters_qty', 10)->default(0);
            $table->string('gutters_price', 10)->default(0);

            $table->boolean('enable_siding')->default(0);
            $table->string('siding_qty', 10)->default(0);
            $table->string('siding_price', 10)->default(0);

            $table->boolean('enable_paint')->default(0);
            $table->string('paint_qty', 10)->default(0);
            $table->string('paint_price', 10)->default(0);

            $table->boolean('enable_windows')->default(0);
            $table->string('windows_qty', 10)->default(0);
            $table->string('windows_price', 10)->default(0);

            $table->boolean('enable_deck')->default(0);
            $table->string('deck_qty', 10)->default(0);
            $table->string('deck_price', 10)->default(0);

            $table->boolean('enable_shed_repair')->default(0);
            $table->string('shed_repair_qty', 10)->default(0);
            $table->string('shed_repair_price', 10)->default(0);

            $table->boolean('enable_seal_coat')->default(0);
            $table->string('seal_coat_qty', 10)->default(0);
            $table->string('seal_coat_price', 10)->default(0);

            $table->boolean('enable_garage_door')->default(0);
            $table->string('garage_door_qty', 10)->default(0);
            $table->string('garage_door_price', 10)->default(0);

            $table->boolean('enable_pool_or_spa_repair')->default(0);
            $table->string('pool_or_spa_repair_qty', 10)->default(0);
            $table->string('pool_or_spa_repair_price', 10)->default(0);

            $table->boolean('enable_fencing')->default(0);
            $table->string('fencing_qty', 10)->default(0);
            $table->string('fencing_price', 10)->default(0);

            $table->boolean('enable_dumpster_rental')->default(0);
            $table->string('dumpster_rental_qty', 10)->default(0);
            $table->string('dumpster_rental_price', 10)->default(0);

            $table->boolean('enable_foundation_repair')->default(0);
            $table->string('foundation_repair_qty', 10)->default(0);
            $table->string('foundation_repair_price', 10)->default(0);

            $table->boolean('enable_drainage')->default(0);
            $table->string('drainage_qty', 10)->default(0);
            $table->string('drainage_price', 10)->default(0);

            $table->boolean('enable_port_o_potty_rental')->default(0);
            $table->string('port_o_potty_rental_qty', 10)->default(0);
            $table->string('port_o_potty_rental_price', 10)->default(0);

            $table->boolean('enable_yard_cleanup')->default(0);
            $table->string('yard_cleanup_qty', 10)->default(0);
            $table->string('yard_cleanup_price', 10)->default(0);

            $table->boolean('enable_tree_removing')->default(0);
            $table->string('tree_removing_qty', 10)->default(0);
            $table->string('tree_removing_price', 10)->default(0);

            $table->boolean('enable_new_grass_sod')->default(0);
            $table->string('new_grass_sod_qty', 10)->default(0);
            $table->string('new_grass_sod_price', 10)->default(0);

            $table->boolean('enable_new_plants')->default(0);
            $table->string('new_plants_qty', 10)->default(0);
            $table->string('new_plants_price', 10)->default(0);

            $table->boolean('enable_hardscape')->default(0);
            $table->string('hardscape_qty', 10)->default(0);
            $table->string('hardscape_price', 10)->default(0);

            $table->boolean('enable_mulch')->default(0);
            $table->string('mulch_qty', 10)->default(0);
            $table->string('mulch_price', 10)->default(0);

            $table->boolean('enable_fire_pit')->default(0);
            $table->string('fire_pit_qty', 10)->default(0);
            $table->string('fire_pit_price', 10)->default(0);

            $table->boolean('enable_patio')->default(0);
            $table->string('patio_qty', 10)->default(0);
            $table->string('patio_price', 10)->default(0);

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
        Schema::dropIfExists('renovations');
    }
};
