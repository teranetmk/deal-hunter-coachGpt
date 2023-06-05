<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['renovations', 'renovation'],
    data() {
        return {
            form: useForm({
                id: this.renovation.id,
                //title: this.renovation.title,
                enable_new_flooring: this.renovation.enable_new_flooring === "1",
                new_flooring_qty: this.renovation.new_flooring_qty,
                new_flooring_price: this.renovation.new_flooring_price,

                enable_hardwood_refinishing: this.renovation.enable_hardwood_refinishing === "1",
                hardwood_refinishing_qty: this.renovation.hardwood_refinishing_qty,
                hardwood_refinishing_price: this.renovation.hardwood_refinishing_price,
                enable_new_carpet_and_padding: this.renovation.enable_new_carpet_and_padding === "1",
                new_carpet_and_padding_qty: this.renovation.new_carpet_and_padding_qty,
                new_carpet_and_padding_price: this.renovation.new_carpet_and_padding_price,
                enable_drywall_patch: this.renovation.enable_drywall_patch === "1",
                drywall_patch_qty: this.renovation.drywall_patch_qty,
                drywall_patch_price: this.renovation.drywall_patch_price,
                enable_plumber_work: this.renovation.enable_plumber_work === "1",
                plumber_work_qty: this.renovation.plumber_work_qty,
                plumber_work_price: this.renovation.plumber_work_price,
                enable_electrician_work: this.renovation.enable_electrician_work === "1",
                electrician_work_qty: this.renovation.electrician_work_qty,
                electrician_work_price: this.renovation.electrician_work_price,
                enable_carpenter_work: this.renovation.enable_carpenter_work === "1",
                carpenter_work_qty: this.renovation.carpenter_work_qty,
                carpenter_work_price: this.renovation.carpenter_work_price,
                enable_interior_paint: this.renovation.enable_interior_paint === "1",
                interior_paint_qty: this.renovation.interior_paint_qty,
                interior_paint_price: this.renovation.interior_paint_price,
                enable_insulation: this.renovation.enable_insulation === "1",
                insulation_qty: this.renovation.insulation_qty,
                insulation_price: this.renovation.insulation_price,
                enable_furance: this.renovation.enable_furance === "1",
                furance_qty: this.renovation.furance_qty,
                furance_price: this.renovation.furance_price,
                enable_hvac: this.renovation.enable_hvac === "1",
                hvac_qty: this.renovation.hvac_qty,
                hvac_price: this.renovation.hvac_price,
                enable_water_heater: this.renovation.enable_water_heater === "1",
                water_heater_qty: this.renovation.water_heater_qty,
                water_heater_price: this.renovation.water_heater_price,
                enable_boiler: this.renovation.enable_boiler === "1",
                boiler_qty: this.renovation.boiler_qty,
                boiler_price: this.renovation.boiler_price,
                enable_refrigerator: this.renovation.enable_refrigerator === "1",
                refrigerator_qty: this.renovation.refrigerator_qty,
                refrigerator_price: this.renovation.refrigerator_price,
                enable_oven: this.renovation.enable_oven === "1",
                oven_qty: this.renovation.oven_qty,
                oven_price: this.renovation.oven_price,
                enable_dishwasher: this.renovation.enable_dishwasher === "1",
                dishwasher_qty: this.renovation.dishwasher_qty,
                dishwasher_price: this.renovation.dishwasher_price,
                enable_microwave: this.renovation.enable_microwave === "1",
                microwave_qty: this.renovation.microwave_qty,
                microwave_price: this.renovation.microwave_price,
                enable_kitchen_cabinet_and_hardware: this.renovation.enable_kitchen_cabinet_and_hardware === "1",
                kitchen_cabinet_and_hardware_qty: this.renovation.kitchen_cabinet_and_hardware_qty,
                kitchen_cabinet_and_hardware_price: this.renovation.kitchen_cabinet_and_hardware_price,
                enable_kitchen_countertops: this.renovation.enable_kitchen_countertops === "1",
                kitchen_countertops_qty: this.renovation.kitchen_countertops_qty,
                kitchen_countertops_price: this.renovation.kitchen_countertops_price,
                enable_kitchen_backsplash: this.renovation.enable_kitchen_backsplash === "1",
                kitchen_backsplash_qty: this.renovation.kitchen_backsplash_qty,
                kitchen_backsplash_price: this.renovation.kitchen_backsplash_price,
                enable_garbage_disposal: this.renovation.enable_garbage_disposal === "1",
                garbage_disposal_qty: this.renovation.garbage_disposal_qty,
                garbage_disposal_price: this.renovation.garbage_disposal_price,
                enable_bathroom_vanity: this.renovation.enable_bathroom_vanity === "1",
                bathroom_vanity_qty: this.renovation.bathroom_vanity_qty,
                bathroom_vanity_price: this.renovation.bathroom_vanity_price,
                enable_toilet: this.renovation.enable_toilet === "1",
                toilet_qty: this.renovation.toilet_qty,
                toilet_price: this.renovation.toilet_price,
                enable_tub_reglazing: this.renovation.enable_tub_reglazing === "1",
                tub_reglazing_qty: this.renovation.tub_reglazing_qty,
                tub_reglazing_price: this.renovation.tub_reglazing_price,
                enable_shower_tile: this.renovation.enable_shower_tile === "1",
                shower_tile_qty: this.renovation.shower_tile_qty,
                shower_tile_price: this.renovation.shower_tile_price,
                enable_mold_remediation: this.renovation.enable_mold_remediation === "1",
                mold_remediation_qty: this.renovation.mold_remediation_qty,
                mold_remediation_price: this.renovation.mold_remediation_price,
                enable_electrical_fixture: this.renovation.enable_electrical_fixture === "1",
                electrical_fixture_qty: this.renovation.electrical_fixture_qty,
                electrical_fixture_price: this.renovation.electrical_fixture_price,
                enable_water_fixture: this.renovation.enable_water_fixture === "1",
                water_fixture_qty: this.renovation.water_fixture_qty,
                water_fixture_price: this.renovation.water_fixture_price,
                enable_doors: this.renovation.enable_doors === "1",
                doors_qty: this.renovation.doors_qty,
                doors_price: this.renovation.doors_price,
                enable_roof_asphalt: this.renovation.enable_roof_asphalt === "1",
                roof_asphalt_qty: this.renovation.roof_asphalt_qty,
                roof_asphalt_price: this.renovation.roof_asphalt_price,
                enable_chimney_repair: this.renovation.enable_chimney_repair === "1",
                chimney_repair_qty: this.renovation.chimney_repair_qty,
                chimney_repair_price: this.renovation.chimney_repair_price,
                enable_gutters: this.renovation.enable_gutters === "1",
                gutters_qty: this.renovation.gutters_qty,
                gutters_price: this.renovation.gutters_price,
                enable_siding: this.renovation.enable_siding === "1",
                siding_qty: this.renovation.siding_qty,
                siding_price: this.renovation.siding_price,
                enable_paint: this.renovation.enable_paint === "1",
                paint_qty: this.renovation.paint_qty,
                paint_price: this.renovation.paint_price,
                enable_windows: this.renovation.enable_windows === "1",
                windows_qty: this.renovation.windows_qty,
                windows_price: this.renovation.windows_price,
                enable_deck: this.renovation.enable_deck === "1",
                deck_qty: this.renovation.deck_qty,
                deck_price: this.renovation.deck_price,
                enable_shed_repair: this.renovation.enable_shed_repair === "1",
                shed_repair_qty: this.renovation.shed_repair_qty,
                shed_repair_price: this.renovation.shed_repair_price,
                enable_seal_coat: this.renovation.enable_seal_coat === "1",
                seal_coat_qty: this.renovation.seal_coat_qty,
                seal_coat_price: this.renovation.seal_coat_price,
                enable_garage_door: this.renovation.enable_garage_door === "1",
                garage_door_qty: this.renovation.garage_door_qty,
                garage_door_price: this.renovation.garage_door_price,
                enable_pool_or_spa_repair: this.renovation.enable_pool_or_spa_repair === "1",
                pool_or_spa_repair_qty: this.renovation.pool_or_spa_repair_qty,
                pool_or_spa_repair_price: this.renovation.pool_or_spa_repair_price,
                enable_fencing: this.renovation.enable_fencing === "1",
                fencing_qty: this.renovation.fencing_qty,
                fencing_price: this.renovation.fencing_price,
                enable_dumpster_rental: this.renovation.enable_dumpster_rental === "1",
                dumpster_rental_qty: this.renovation.dumpster_rental_qty,
                dumpster_rental_price: this.renovation.dumpster_rental_price,
                enable_foundation_repair: this.renovation.enable_foundation_repair === "1",
                foundation_repair_qty: this.renovation.foundation_repair_qty,
                foundation_repair_price: this.renovation.foundation_repair_price,
                enable_drainage: this.renovation.enable_drainage === "1",
                drainage_qty: this.renovation.drainage_qty,
                drainage_price: this.renovation.drainage_price,
                enable_port_o_potty_rental: this.renovation.enable_port_o_potty_rental === "1",
                port_o_potty_rental_qty: this.renovation.port_o_potty_rental_qty,
                port_o_potty_rental_price: this.renovation.port_o_potty_rental_price,
                enable_yard_cleanup: this.renovation.enable_yard_cleanup === "1",
                yard_cleanup_qty: this.renovation.yard_cleanup_qty,
                yard_cleanup_price: this.renovation.yard_cleanup_price,
                enable_tree_removing: this.renovation.enable_tree_removing === "1",
                tree_removing_qty: this.renovation.tree_removing_qty,
                tree_removing_price: this.renovation.tree_removing_price,
                enable_new_grass_sod: this.renovation.enable_new_grass_sod === "1",
                new_grass_sod_qty: this.renovation.new_grass_sod_qty,
                new_grass_sod_price: this.renovation.new_grass_sod_price,
                enable_new_plants: this.renovation.enable_new_plants === "1",
                new_plants_qty: this.renovation.new_plants_qty,
                new_plants_price: this.renovation.new_plants_price,
                enable_hardscape: this.renovation.enable_hardscape === "1",
                hardscape_qty: this.renovation.hardscape_qty,
                hardscape_price: this.renovation.hardscape_price,
                enable_mulch: this.renovation.enable_mulch === "1",
                mulch_qty: this.renovation.mulch_qty,
                mulch_price: this.renovation.mulch_price,
                enable_fire_pit: this.renovation.enable_fire_pit === "1",
                fire_pit_qty: this.renovation.fire_pit_qty,
                fire_pit_price: this.renovation.fire_pit_price,
                enable_patio: this.renovation.enable_patio === "1",
                patio_qty: this.renovation.patio_qty,
                patio_price: this.renovation.patio_price,
            }),
            controller: null
        }
    },
    methods: {

        update() {

            if(this.controller) this.controller.abort()
            this.controller = new AbortController()

            axios.post(route('users.calculator.renovation.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
        }
    },
    watch: {
        "form.enable_new_flooring"() { this.update() },
        "form.enable_hardwood_refinishing"() { this.update() },
        "form.enable_new_carpet_and_padding"() { this.update() },
        "form.enable_drywall_patch"() { this.update() },
        "form.enable_plumber_work"() { this.update() },
        "form.enable_electrician_work"() { this.update() },
        "form.enable_carpenter_work"() { this.update() },
        "form.enable_interior_paint"() { this.update() },
        "form.enable_insulation"() { this.update() },
        "form.enable_furance"() { this.update() },
        "form.enable_hvac"() { this.update() },
        "form.enable_water_heater"() { this.update() },
        "form.enable_boiler"() { this.update() },
        "form.enable_refrigerator"() { this.update() },
        "form.enable_oven"() { this.update() },
        "form.enable_dishwasher"() { this.update() },
        "form.enable_microwave"() { this.update() },
        "form.enable_kitchen_cabinet_and_hardware"() { this.update() },
        "form.enable_kitchen_countertops"() { this.update() },
        "form.enable_kitchen_backsplash"() { this.update() },
        "form.enable_garbage_disposal"() { this.update() },
        "form.enable_bathroom_vanity"() { this.update() },
        "form.enable_toilet"() { this.update() },
        "form.enable_tub_reglazing"() { this.update() },
        "form.enable_shower_tile"() { this.update() },
        "form.enable_mold_remediation"() { this.update() },
        "form.enable_electrical_fixture"() { this.update() },
        "form.enable_water_fixture"() { this.update() },
        "form.enable_doors"() { this.update() },
        "form.enable_roof_asphalt"() { this.update() },
        "form.enable_chimney_repair"() { this.update() },
        "form.enable_gutters"() { this.update() },
        "form.enable_siding"() { this.update() },
        "form.enable_paint"() { this.update() },
        "form.enable_windows"() { this.update() },
        "form.enable_deck"() { this.update() },
        "form.enable_shed_repair"() { this.update() },
        "form.enable_seal_coat"() { this.update() },
        "form.enable_garage_door"() { this.update() },
        "form.enable_pool_or_spa_repair"() { this.update() },
        "form.enable_fencing"() { this.update() },
        "form.enable_dumpster_rental"() { this.update() },
        "form.enable_foundation_repair"() { this.update() },
        "form.enable_drainage"() { this.update() },
        "form.enable_port_o_potty_rental"() { this.update() },
        "form.enable_yard_cleanup"() { this.update() },
        "form.enable_tree_removing"() { this.update() },
        "form.enable_new_grass_sod"() { this.update() },
        "form.enable_new_plants"() { this.update() },
        "form.enable_hardscape"() { this.update() },
        "form.enable_mulch"() { this.update() },
        "form.enable_fire_pit"() { this.update() },
        "form.enable_patio"() { this.update() },
        "form.new_flooring_qty"(newValue) {

            this.form.new_flooring_qty = add_commas(newValue)
            this.update()
        },

        "form.new_flooring_price"(newValue) {

            this.form.new_flooring_price = add_commas(newValue)
            this.update()
        },

        "form.hardwood_refinishing_qty"(newValue) {

            this.form.hardwood_refinishing_qty = add_commas(newValue)
            this.update()
        },

        "form.hardwood_refinishing_price"(newValue) {

            this.form.hardwood_refinishing_price = add_commas(newValue)
            this.update()
        },

        "form.new_carpet_and_padding_qty"(newValue) {

            this.form.new_carpet_and_padding_qty = add_commas(newValue)
            this.update()
        },

        "form.new_carpet_and_padding_price"(newValue) {

            this.form.new_carpet_and_padding_price = add_commas(newValue)
            this.update()
        },

        "form.drywall_patch_qty"(newValue) {

            this.form.drywall_patch_qty = add_commas(newValue)
            this.update()
        },

        "form.drywall_patch_price"(newValue) {

            this.form.drywall_patch_price = add_commas(newValue)
            this.update()
        },

        "form.plumber_work_qty"(newValue) {

            this.form.plumber_work_qty = add_commas(newValue)
            this.update()
        },

        "form.plumber_work_price"(newValue) {

            this.form.plumber_work_price = add_commas(newValue)
            this.update()
        },

        "form.electrician_work_qty"(newValue) {

            this.form.electrician_work_qty = add_commas(newValue)
            this.update()
        },

        "form.electrician_work_price"(newValue) {

            this.form.electrician_work_price = add_commas(newValue)
            this.update()
        },

        "form.carpenter_work_qty"(newValue) {

            this.form.carpenter_work_qty = add_commas(newValue)
            this.update()
        },

        "form.carpenter_work_price"(newValue) {

            this.form.carpenter_work_price = add_commas(newValue)
            this.update()
        },

        "form.interior_paint_qty"(newValue) {

            this.form.interior_paint_qty = add_commas(newValue)
            this.update()
        },

        "form.interior_paint_price"(newValue) {

            this.form.interior_paint_price = add_commas(newValue)
            this.update()
        },

        "form.insulation_qty"(newValue) {

            this.form.insulation_qty = add_commas(newValue)
            this.update()
        },

        "form.insulation_price"(newValue) {

            this.form.insulation_price = add_commas(newValue)
            this.update()
        },

        "form.furance_qty"(newValue) {

            this.form.furance_qty = add_commas(newValue)
            this.update()
        },

        "form.furance_price"(newValue) {

            this.form.furance_price = add_commas(newValue)
            this.update()
        },

        "form.hvac_qty"(newValue) {

            this.form.hvac_qty = add_commas(newValue)
            this.update()
        },

        "form.hvac_price"(newValue) {

            this.form.hvac_price = add_commas(newValue)
            this.update()
        },

        "form.water_heater_qty"(newValue) {

            this.form.water_heater_qty = add_commas(newValue)
            this.update()
        },

        "form.water_heater_price"(newValue) {

            this.form.water_heater_price = add_commas(newValue)
            this.update()
        },

        "form.boiler_qty"(newValue) {

            this.form.boiler_qty = add_commas(newValue)
            this.update()
        },

        "form.boiler_price"(newValue) {

            this.form.boiler_price = add_commas(newValue)
            this.update()
        },

        "form.refrigerator_qty"(newValue) {

            this.form.refrigerator_qty = add_commas(newValue)
            this.update()
        },

        "form.refrigerator_price"(newValue) {

            this.form.refrigerator_price = add_commas(newValue)
            this.update()
        },

        "form.oven_qty"(newValue) {

            this.form.oven_qty = add_commas(newValue)
            this.update()
        },

        "form.oven_price"(newValue) {

            this.form.oven_price = add_commas(newValue)
            this.update()
        },

        "form.dishwasher_qty"(newValue) {

            this.form.dishwasher_qty = add_commas(newValue)
            this.update()
        },

        "form.dishwasher_price"(newValue) {

            this.form.dishwasher_price = add_commas(newValue)
            this.update()
        },

        "form.microwave_qty"(newValue) {

            this.form.microwave_qty = add_commas(newValue)
            this.update()
        },

        "form.microwave_price"(newValue) {

            this.form.microwave_price = add_commas(newValue)
            this.update()
        },

        "form.kitchen_cabinet_and_hardware_qty"(newValue) {

            this.form.kitchen_cabinet_and_hardware_qty = add_commas(newValue)
            this.update()
        },

        "form.kitchen_cabinet_and_hardware_price"(newValue) {

            this.form.kitchen_cabinet_and_hardware_price = add_commas(newValue)
            this.update()
        },

        "form.kitchen_countertops_qty"(newValue) {

            this.form.kitchen_countertops_qty = add_commas(newValue)
            this.update()
        },

        "form.kitchen_countertops_price"(newValue) {

            this.form.kitchen_countertops_price = add_commas(newValue)
            this.update()
        },

        "form.kitchen_backsplash_qty"(newValue) {

            this.form.kitchen_backsplash_qty = add_commas(newValue)
            this.update()
        },

        "form.kitchen_backsplash_price"(newValue) {

            this.form.kitchen_backsplash_price = add_commas(newValue)
            this.update()
        },

        "form.garbage_disposal_qty"(newValue) {

            this.form.garbage_disposal_qty = add_commas(newValue)
            this.update()
        },

        "form.garbage_disposal_price"(newValue) {

            this.form.garbage_disposal_price = add_commas(newValue)
            this.update()
        },

        "form.bathroom_vanity_qty"(newValue) {

            this.form.bathroom_vanity_qty = add_commas(newValue)
            this.update()
        },

        "form.bathroom_vanity_price"(newValue) {

            this.form.bathroom_vanity_price = add_commas(newValue)
            this.update()
        },

        "form.toilet_qty"(newValue) {

            this.form.toilet_qty = add_commas(newValue)
            this.update()
        },

        "form.toilet_price"(newValue) {

            this.form.toilet_price = add_commas(newValue)
            this.update()
        },

        "form.tub_reglazing_qty"(newValue) {

            this.form.tub_reglazing_qty = add_commas(newValue)
            this.update()
        },

        "form.tub_reglazing_price"(newValue) {

            this.form.tub_reglazing_price = add_commas(newValue)
            this.update()
        },

        "form.shower_tile_qty"(newValue) {

            this.form.shower_tile_qty = add_commas(newValue)
            this.update()
        },

        "form.shower_tile_price"(newValue) {

            this.form.shower_tile_price = add_commas(newValue)
            this.update()
        },

        "form.mold_remediation_qty"(newValue) {

            this.form.mold_remediation_qty = add_commas(newValue)
            this.update()
        },

        "form.mold_remediation_price"(newValue) {

            this.form.mold_remediation_price = add_commas(newValue)
            this.update()
        },

        "form.electrical_fixture_qty"(newValue) {

            this.form.electrical_fixture_qty = add_commas(newValue)
            this.update()
        },

        "form.electrical_fixture_price"(newValue) {

            this.form.electrical_fixture_price = add_commas(newValue)
            this.update()
        },

        "form.water_fixture_qty"(newValue) {

            this.form.water_fixture_qty = add_commas(newValue)
            this.update()
        },

        "form.water_fixture_price"(newValue) {

            this.form.water_fixture_price = add_commas(newValue)
            this.update()
        },

        "form.doors_qty"(newValue) {

            this.form.doors_qty = add_commas(newValue)
            this.update()
        },

        "form.doors_price"(newValue) {

            this.form.doors_price = add_commas(newValue)
            this.update()
        },

        "form.roof_asphalt_qty"(newValue) {

            this.form.roof_asphalt_qty = add_commas(newValue)
            this.update()
        },

        "form.roof_asphalt_price"(newValue) {

            this.form.roof_asphalt_price = add_commas(newValue)
            this.update()
        },

        "form.chimney_repair_qty"(newValue) {

            this.form.chimney_repair_qty = add_commas(newValue)
            this.update()
        },

        "form.chimney_repair_price"(newValue) {

            this.form.chimney_repair_price = add_commas(newValue)
            this.update()
        },

        "form.gutters_qty"(newValue) {

            this.form.gutters_qty = add_commas(newValue)
            this.update()
        },

        "form.gutters_price"(newValue) {

            this.form.gutters_price = add_commas(newValue)
            this.update()
        },

        "form.siding_qty"(newValue) {

            this.form.siding_qty = add_commas(newValue)
            this.update()
        },

        "form.siding_price"(newValue) {

            this.form.siding_price = add_commas(newValue)
            this.update()
        },

        "form.paint_qty"(newValue) {

            this.form.paint_qty = add_commas(newValue)
            this.update()
        },

        "form.paint_price"(newValue) {

            this.form.paint_price = add_commas(newValue)
            this.update()
        },

        "form.windows_qty"(newValue) {

            this.form.windows_qty = add_commas(newValue)
            this.update()
        },

        "form.windows_price"(newValue) {

            this.form.windows_price = add_commas(newValue)
            this.update()
        },

        "form.deck_qty"(newValue) {

            this.form.deck_qty = add_commas(newValue)
            this.update()
        },

        "form.deck_price"(newValue) {

            this.form.deck_price = add_commas(newValue)
            this.update()
        },

        "form.shed_repair_qty"(newValue) {

            this.form.shed_repair_qty = add_commas(newValue)
            this.update()
        },

        "form.shed_repair_price"(newValue) {

            this.form.shed_repair_price = add_commas(newValue)
            this.update()
        },

        "form.seal_coat_qty"(newValue) {

            this.form.seal_coat_qty = add_commas(newValue)
            this.update()
        },

        "form.seal_coat_price"(newValue) {

            this.form.seal_coat_price = add_commas(newValue)
            this.update()
        },

        "form.garage_door_qty"(newValue) {

            this.form.garage_door_qty = add_commas(newValue)
            this.update()
        },

        "form.garage_door_price"(newValue) {

            this.form.garage_door_price = add_commas(newValue)
            this.update()
        },

        "form.pool_or_spa_repair_qty"(newValue) {

            this.form.pool_or_spa_repair_qty = add_commas(newValue)
            this.update()
        },

        "form.pool_or_spa_repair_price"(newValue) {

            this.form.pool_or_spa_repair_price = add_commas(newValue)
            this.update()
        },

        "form.fencing_qty"(newValue) {

            this.form.fencing_qty = add_commas(newValue)
            this.update()
        },

        "form.fencing_price"(newValue) {

            this.form.fencing_price = add_commas(newValue)
            this.update()
        },

        "form.dumpster_rental_qty"(newValue) {

            this.form.dumpster_rental_qty = add_commas(newValue)
            this.update()
        },

        "form.dumpster_rental_price"(newValue) {

            this.form.dumpster_rental_price = add_commas(newValue)
            this.update()
        },

        "form.foundation_repair_qty"(newValue) {

            this.form.foundation_repair_qty = add_commas(newValue)
            this.update()
        },

        "form.foundation_repair_price"(newValue) {

            this.form.foundation_repair_price = add_commas(newValue)
            this.update()
        },

        "form.drainage_qty"(newValue) {

            this.form.drainage_qty = add_commas(newValue)
            this.update()
        },

        "form.drainage_price"(newValue) {

            this.form.drainage_price = add_commas(newValue)
            this.update()
        },

        "form.port_o_potty_rental_qty"(newValue) {

            this.form.port_o_potty_rental_qty = add_commas(newValue)
            this.update()
        },

        "form.port_o_potty_rental_price"(newValue) {

            this.form.port_o_potty_rental_price = add_commas(newValue)
            this.update()
        },

        "form.yard_cleanup_qty"(newValue) {

            this.form.yard_cleanup_qty = add_commas(newValue)
            this.update()
        },

        "form.yard_cleanup_price"(newValue) {

            this.form.yard_cleanup_price = add_commas(newValue)
            this.update()
        },

        "form.tree_removing_qty"(newValue) {

            this.form.tree_removing_qty = add_commas(newValue)
            this.update()
        },

        "form.tree_removing_price"(newValue) {

            this.form.tree_removing_price = add_commas(newValue)
            this.update()
        },

        "form.new_grass_sod_qty"(newValue) {

            this.form.new_grass_sod_qty = add_commas(newValue)
            this.update()
        },

        "form.new_grass_sod_price"(newValue) {

            this.form.new_grass_sod_price = add_commas(newValue)
            this.update()
        },

        "form.new_plants_qty"(newValue) {

            this.form.new_plants_qty = add_commas(newValue)
            this.update()
        },

        "form.new_plants_price"(newValue) {

            this.form.new_plants_price = add_commas(newValue)
            this.update()
        },

        "form.hardscape_qty"(newValue) {

            this.form.hardscape_qty = add_commas(newValue)
            this.update()
        },

        "form.hardscape_price"(newValue) {

            this.form.hardscape_price = add_commas(newValue)
            this.update()
        },

        "form.mulch_qty"(newValue) {

            this.form.mulch_qty = add_commas(newValue)
            this.update()
        },

        "form.mulch_price"(newValue) {

            this.form.mulch_price = add_commas(newValue)
            this.update()
        },

        "form.fire_pit_qty"(newValue) {

            this.form.fire_pit_qty = add_commas(newValue)
            this.update()
        },

        "form.fire_pit_price"(newValue) {

            this.form.fire_pit_price = add_commas(newValue)
            this.update()
        },

        "form.patio_qty"(newValue) {

            this.form.patio_qty = add_commas(newValue)
            this.update()
        },

        "form.patio_price"(newValue) {

            this.form.patio_price = add_commas(newValue)
            this.update()
        },
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Max Allowable Offer (MAO) Calculator" />
        <template #pageHeading>
            <Buttons :renovations="renovations" />
        </template>

        <Form :form="form" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>
