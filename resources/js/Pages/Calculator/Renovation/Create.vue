<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['renovations','count'],
    data() {
        return {
            form: useForm({
                id: '',
                //title: '',
                enable_new_flooring: false,
                new_flooring_qty: 0,
                new_flooring_price: 0,

                enable_hardwood_refinishing: false,
                hardwood_refinishing_qty: 0,
                hardwood_refinishing_price: 0,
                enable_new_carpet_and_padding: false,
                new_carpet_and_padding_qty: 0,
                new_carpet_and_padding_price: 0,
                enable_drywall_patch: false,
                drywall_patch_qty: 0,
                drywall_patch_price: 0,
                enable_plumber_work: false,
                plumber_work_qty: 0,
                plumber_work_price: 0,
                enable_electrician_work: false,
                electrician_work_qty: 0,
                electrician_work_price: 0,
                enable_carpenter_work: false,
                carpenter_work_qty: 0,
                carpenter_work_price: 0,
                enable_interior_paint: false,
                interior_paint_qty: 0,
                interior_paint_price: 0,
                enable_insulation: false,
                insulation_qty: 0,
                insulation_price: 0,
                enable_furance: false,
                furance_qty: 0,
                furance_price: 0,
                enable_hvac: false,
                hvac_qty: 0,
                hvac_price: 0,
                enable_water_heater: false,
                water_heater_qty: 0,
                water_heater_price: 0,
                enable_boiler: false,
                boiler_qty: 0,
                boiler_price: 0,
                enable_refrigerator: false,
                refrigerator_qty: 0,
                refrigerator_price: 0,
                enable_oven: false,
                oven_qty: 0,
                oven_price: 0,
                enable_dishwasher: false,
                dishwasher_qty: 0,
                dishwasher_price: 0,
                enable_microwave: false,
                microwave_qty: 0,
                microwave_price: 0,
                enable_kitchen_cabinet_and_hardware: false,
                kitchen_cabinet_and_hardware_qty: 0,
                kitchen_cabinet_and_hardware_price: 0,
                enable_kitchen_countertops: false,
                kitchen_countertops_qty: 0,
                kitchen_countertops_price: 0,
                enable_kitchen_backsplash: false,
                kitchen_backsplash_qty: 0,
                kitchen_backsplash_price: 0,
                enable_garbage_disposal: false,
                garbage_disposal_qty: 0,
                garbage_disposal_price: 0,
                enable_bathroom_vanity: false,
                bathroom_vanity_qty: 0,
                bathroom_vanity_price: 0,
                enable_toilet: false,
                toilet_qty: 0,
                toilet_price: 0,
                enable_tub_reglazing: false,
                tub_reglazing_qty: 0,
                tub_reglazing_price: 0,
                enable_shower_tile: false,
                shower_tile_qty: 0,
                shower_tile_price: 0,
                enable_mold_remediation: false,
                mold_remediation_qty: 0,
                mold_remediation_price: 0,
                enable_electrical_fixture: false,
                electrical_fixture_qty: 0,
                electrical_fixture_price: 0,
                enable_water_fixture: false,
                water_fixture_qty: 0,
                water_fixture_price: 0,
                enable_doors: false,
                doors_qty: 0,
                doors_price: 0,
                enable_roof_asphalt: false,
                roof_asphalt_qty: 0,
                roof_asphalt_price: 0,
                enable_chimney_repair: false,
                chimney_repair_qty: 0,
                chimney_repair_price: 0,
                enable_gutters: false,
                gutters_qty: 0,
                gutters_price: 0,
                enable_siding: false,
                siding_qty: 0,
                siding_price: 0,
                enable_paint: false,
                paint_qty: 0,
                paint_price: 0,
                enable_windows: false,
                windows_qty: 0,
                windows_price: 0,
                enable_deck: false,
                deck_qty: 0,
                deck_price: 0,
                enable_shed_repair: false,
                shed_repair_qty: 0,
                shed_repair_price: 0,
                enable_seal_coat: false,
                seal_coat_qty: 0,
                seal_coat_price: 0,
                enable_garage_door: false,
                garage_door_qty: 0,
                garage_door_price: 0,
                enable_pool_or_spa_repair: false,
                pool_or_spa_repair_qty: 0,
                pool_or_spa_repair_price: 0,
                enable_fencing: false,
                fencing_qty: 0,
                fencing_price: 0,
                enable_dumpster_rental: false,
                dumpster_rental_qty: 0,
                dumpster_rental_price: 0,
                enable_foundation_repair: false,
                foundation_repair_qty: 0,
                foundation_repair_price: 0,
                enable_drainage: false,
                drainage_qty: 0,
                drainage_price: 0,
                enable_port_o_potty_rental: false,
                port_o_potty_rental_qty: 0,
                port_o_potty_rental_price: 0,
                enable_yard_cleanup: false,
                yard_cleanup_qty: 0,
                yard_cleanup_price: 0,
                enable_tree_removing: false,
                tree_removing_qty: 0,
                tree_removing_price: 0,
                enable_new_grass_sod: false,
                new_grass_sod_qty: 0,
                new_grass_sod_price: 0,
                enable_new_plants: false,
                new_plants_qty: 0,
                new_plants_price: 0,
                enable_hardscape: false,
                hardscape_qty: 0,
                hardscape_price: 0,
                enable_mulch: false,
                mulch_qty: 0,
                mulch_price: 0,
                enable_fire_pit: false,
                fire_pit_qty: 0,
                fire_pit_price: 0,
                enable_patio: false,
                patio_qty: 0,
                patio_price: 0,
            }),
            buttons: this.renovations,
            controller: null
        }
    },
    methods: {

        saveOrUpdate() {

            if(!this.form.processing) {

                this.form.processing = true;

                if(this.controller) this.controller.abort()
                this.controller = new AbortController()

                if (this.form.id) {

                    axios.post(route('users.calculator.renovation.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
                        .then(r => r.data)
                        .then(() => {

                            this.form.processing = false;
                        })
                } else {

                    const self = this;
                    axios.post(route('users.calculator.renovation.store'), {...this.form}, {signal: this.controller.signal})
                        .then(r => r.data)
                        .then(data => {

                            self.form.id = data.id
                            this.form.processing = false
                            this.buttons = data.renovations
                            window.history.replaceState({}, '', route('users.calculator.renovation.edit', {id: data.id}))
                        })
                }
            }
        }
    },
    watch: {
        "form.enable_new_flooring"() { this.saveOrUpdate() },
        "form.enable_hardwood_refinishing"() { this.saveOrUpdate() },
        "form.enable_new_carpet_and_padding"() { this.saveOrUpdate() },
        "form.enable_drywall_patch"() { this.saveOrUpdate() },
        "form.enable_plumber_work"() { this.saveOrUpdate() },
        "form.enable_electrician_work"() { this.saveOrUpdate() },
        "form.enable_carpenter_work"() { this.saveOrUpdate() },
        "form.enable_interior_paint"() { this.saveOrUpdate() },
        "form.enable_insulation"() { this.saveOrUpdate() },
        "form.enable_furance"() { this.saveOrUpdate() },
        "form.enable_hvac"() { this.saveOrUpdate() },
        "form.enable_water_heater"() { this.saveOrUpdate() },
        "form.enable_boiler"() { this.saveOrUpdate() },
        "form.enable_refrigerator"() { this.saveOrUpdate() },
        "form.enable_oven"() { this.saveOrUpdate() },
        "form.enable_dishwasher"() { this.saveOrUpdate() },
        "form.enable_microwave"() { this.saveOrUpdate() },
        "form.enable_kitchen_cabinet_and_hardware"() { this.saveOrUpdate() },
        "form.enable_kitchen_countertops"() { this.saveOrUpdate() },
        "form.enable_kitchen_backsplash"() { this.saveOrUpdate() },
        "form.enable_garbage_disposal"() { this.saveOrUpdate() },
        "form.enable_bathroom_vanity"() { this.saveOrUpdate() },
        "form.enable_toilet"() { this.saveOrUpdate() },
        "form.enable_tub_reglazing"() { this.saveOrUpdate() },
        "form.enable_shower_tile"() { this.saveOrUpdate() },
        "form.enable_mold_remediation"() { this.saveOrUpdate() },
        "form.enable_electrical_fixture"() { this.saveOrUpdate() },
        "form.enable_water_fixture"() { this.saveOrUpdate() },
        "form.enable_doors"() { this.saveOrUpdate() },
        "form.enable_roof_asphalt"() { this.saveOrUpdate() },
        "form.enable_chimney_repair"() { this.saveOrUpdate() },
        "form.enable_gutters"() { this.saveOrUpdate() },
        "form.enable_siding"() { this.saveOrUpdate() },
        "form.enable_paint"() { this.saveOrUpdate() },
        "form.enable_windows"() { this.saveOrUpdate() },
        "form.enable_deck"() { this.saveOrUpdate() },
        "form.enable_shed_repair"() { this.saveOrUpdate() },
        "form.enable_seal_coat"() { this.saveOrUpdate() },
        "form.enable_garage_door"() { this.saveOrUpdate() },
        "form.enable_pool_or_spa_repair"() { this.saveOrUpdate() },
        "form.enable_fencing"() { this.saveOrUpdate() },
        "form.enable_dumpster_rental"() { this.saveOrUpdate() },
        "form.enable_foundation_repair"() { this.saveOrUpdate() },
        "form.enable_drainage"() { this.saveOrUpdate() },
        "form.enable_port_o_potty_rental"() { this.saveOrUpdate() },
        "form.enable_yard_cleanup"() { this.saveOrUpdate() },
        "form.enable_tree_removing"() { this.saveOrUpdate() },
        "form.enable_new_grass_sod"() { this.saveOrUpdate() },
        "form.enable_new_plants"() { this.saveOrUpdate() },
        "form.enable_hardscape"() { this.saveOrUpdate() },
        "form.enable_mulch"() { this.saveOrUpdate() },
        "form.enable_fire_pit"() { this.saveOrUpdate() },
        "form.enable_patio"() { this.saveOrUpdate() },
        "form.new_flooring_qty"(newValue) {

            this.form.new_flooring_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_flooring_price"(newValue) {

            this.form.new_flooring_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.hardwood_refinishing_qty"(newValue) {

            this.form.hardwood_refinishing_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.hardwood_refinishing_price"(newValue) {

            this.form.hardwood_refinishing_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_carpet_and_padding_qty"(newValue) {

            this.form.new_carpet_and_padding_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_carpet_and_padding_price"(newValue) {

            this.form.new_carpet_and_padding_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.drywall_patch_qty"(newValue) {

            this.form.drywall_patch_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.drywall_patch_price"(newValue) {

            this.form.drywall_patch_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.plumber_work_qty"(newValue) {

            this.form.plumber_work_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.plumber_work_price"(newValue) {

            this.form.plumber_work_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.electrician_work_qty"(newValue) {

            this.form.electrician_work_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.electrician_work_price"(newValue) {

            this.form.electrician_work_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.carpenter_work_qty"(newValue) {

            this.form.carpenter_work_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.carpenter_work_price"(newValue) {

            this.form.carpenter_work_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.interior_paint_qty"(newValue) {

            this.form.interior_paint_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.interior_paint_price"(newValue) {

            this.form.interior_paint_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.insulation_qty"(newValue) {

            this.form.insulation_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.insulation_price"(newValue) {

            this.form.insulation_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.furance_qty"(newValue) {

            this.form.furance_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.furance_price"(newValue) {

            this.form.furance_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.hvac_qty"(newValue) {

            this.form.hvac_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.hvac_price"(newValue) {

            this.form.hvac_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.water_heater_qty"(newValue) {

            this.form.water_heater_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.water_heater_price"(newValue) {

            this.form.water_heater_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.boiler_qty"(newValue) {

            this.form.boiler_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.boiler_price"(newValue) {

            this.form.boiler_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.refrigerator_qty"(newValue) {

            this.form.refrigerator_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.refrigerator_price"(newValue) {

            this.form.refrigerator_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.oven_qty"(newValue) {

            this.form.oven_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.oven_price"(newValue) {

            this.form.oven_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.dishwasher_qty"(newValue) {

            this.form.dishwasher_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.dishwasher_price"(newValue) {

            this.form.dishwasher_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.microwave_qty"(newValue) {

            this.form.microwave_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.microwave_price"(newValue) {

            this.form.microwave_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.kitchen_cabinet_and_hardware_qty"(newValue) {

            this.form.kitchen_cabinet_and_hardware_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.kitchen_cabinet_and_hardware_price"(newValue) {

            this.form.kitchen_cabinet_and_hardware_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.kitchen_countertops_qty"(newValue) {

            this.form.kitchen_countertops_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.kitchen_countertops_price"(newValue) {

            this.form.kitchen_countertops_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.kitchen_backsplash_qty"(newValue) {

            this.form.kitchen_backsplash_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.kitchen_backsplash_price"(newValue) {

            this.form.kitchen_backsplash_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.garbage_disposal_qty"(newValue) {

            this.form.garbage_disposal_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.garbage_disposal_price"(newValue) {

            this.form.garbage_disposal_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.bathroom_vanity_qty"(newValue) {

            this.form.bathroom_vanity_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.bathroom_vanity_price"(newValue) {

            this.form.bathroom_vanity_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.toilet_qty"(newValue) {

            this.form.toilet_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.toilet_price"(newValue) {

            this.form.toilet_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.tub_reglazing_qty"(newValue) {

            this.form.tub_reglazing_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.tub_reglazing_price"(newValue) {

            this.form.tub_reglazing_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.shower_tile_qty"(newValue) {

            this.form.shower_tile_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.shower_tile_price"(newValue) {

            this.form.shower_tile_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.mold_remediation_qty"(newValue) {

            this.form.mold_remediation_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.mold_remediation_price"(newValue) {

            this.form.mold_remediation_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.electrical_fixture_qty"(newValue) {

            this.form.electrical_fixture_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.electrical_fixture_price"(newValue) {

            this.form.electrical_fixture_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.water_fixture_qty"(newValue) {

            this.form.water_fixture_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.water_fixture_price"(newValue) {

            this.form.water_fixture_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.doors_qty"(newValue) {

            this.form.doors_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.doors_price"(newValue) {

            this.form.doors_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.roof_asphalt_qty"(newValue) {

            this.form.roof_asphalt_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.roof_asphalt_price"(newValue) {

            this.form.roof_asphalt_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.chimney_repair_qty"(newValue) {

            this.form.chimney_repair_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.chimney_repair_price"(newValue) {

            this.form.chimney_repair_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.gutters_qty"(newValue) {

            this.form.gutters_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.gutters_price"(newValue) {

            this.form.gutters_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.siding_qty"(newValue) {

            this.form.siding_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.siding_price"(newValue) {

            this.form.siding_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.paint_qty"(newValue) {

            this.form.paint_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.paint_price"(newValue) {

            this.form.paint_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.windows_qty"(newValue) {

            this.form.windows_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.windows_price"(newValue) {

            this.form.windows_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.deck_qty"(newValue) {

            this.form.deck_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.deck_price"(newValue) {

            this.form.deck_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.shed_repair_qty"(newValue) {

            this.form.shed_repair_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.shed_repair_price"(newValue) {

            this.form.shed_repair_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.seal_coat_qty"(newValue) {

            this.form.seal_coat_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.seal_coat_price"(newValue) {

            this.form.seal_coat_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.garage_door_qty"(newValue) {

            this.form.garage_door_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.garage_door_price"(newValue) {

            this.form.garage_door_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.pool_or_spa_repair_qty"(newValue) {

            this.form.pool_or_spa_repair_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.pool_or_spa_repair_price"(newValue) {

            this.form.pool_or_spa_repair_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.fencing_qty"(newValue) {

            this.form.fencing_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.fencing_price"(newValue) {

            this.form.fencing_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.dumpster_rental_qty"(newValue) {

            this.form.dumpster_rental_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.dumpster_rental_price"(newValue) {

            this.form.dumpster_rental_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.foundation_repair_qty"(newValue) {

            this.form.foundation_repair_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.foundation_repair_price"(newValue) {

            this.form.foundation_repair_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.drainage_qty"(newValue) {

            this.form.drainage_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.drainage_price"(newValue) {

            this.form.drainage_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.port_o_potty_rental_qty"(newValue) {

            this.form.port_o_potty_rental_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.port_o_potty_rental_price"(newValue) {

            this.form.port_o_potty_rental_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.yard_cleanup_qty"(newValue) {

            this.form.yard_cleanup_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.yard_cleanup_price"(newValue) {

            this.form.yard_cleanup_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.tree_removing_qty"(newValue) {

            this.form.tree_removing_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.tree_removing_price"(newValue) {

            this.form.tree_removing_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_grass_sod_qty"(newValue) {

            this.form.new_grass_sod_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_grass_sod_price"(newValue) {

            this.form.new_grass_sod_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_plants_qty"(newValue) {

            this.form.new_plants_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.new_plants_price"(newValue) {

            this.form.new_plants_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.hardscape_qty"(newValue) {

            this.form.hardscape_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.hardscape_price"(newValue) {

            this.form.hardscape_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.mulch_qty"(newValue) {

            this.form.mulch_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.mulch_price"(newValue) {

            this.form.mulch_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.fire_pit_qty"(newValue) {

            this.form.fire_pit_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.fire_pit_price"(newValue) {

            this.form.fire_pit_price = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.patio_qty"(newValue) {

            this.form.patio_qty = add_commas(newValue)
            this.saveOrUpdate()
        },

        "form.patio_price"(newValue) {

            this.form.patio_price = add_commas(newValue)
            this.saveOrUpdate()
        },
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <Head>
        <title>Renovation Calculator</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Renovation Calculator">
        <meta property="og:description" content="Try Out Our Renovation Calculator">
        <meta property="og:image" content="/images/renovation_project_estimator.png">
        <meta property="og:url" content="{{route('users.calculator.renovation')}}">
    </Head>
    <AuthenticatedLayout>
        <template #pageHeading>
            <Buttons :renovations="buttons" />
        </template>

        <Form :form="form" :count="count"/>

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>
