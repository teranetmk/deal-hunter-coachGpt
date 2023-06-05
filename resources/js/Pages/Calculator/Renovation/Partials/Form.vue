<script>
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "primevue/checkbox";
import GraphPie from 'vue-graph/src/components/pie'

export default {
    components: {TextInput, Checkbox, GraphPie},
    props: ['form','count'],
    data() {
        return {
            names: ["Interior","Exterior", "Landscaping"],
            sharing_count: 0
        }
    },
    methods: {
        async saveCount() {
            await axios.post(route('contracts.add.share.count'), {type: 'calculator_renovation'});
            this.sharing_count += 1;
        },
        add_commas(...params) { return window.add_commas(...params)},
        remove_commas(...params) { return window.remove_commas(...params)},
    },
    mounted: function () {
        let vm = this;

        vm.$nextTick(function () {
            this.sharing_count = vm.count;
        });
    },
    computed: {
        interior_total() {

            let total = 0;
            if(this.form.enable_new_flooring) {total+= remove_commas(this.form.new_flooring_qty) * remove_commas(this.form.new_flooring_price)}

            if(this.form.enable_hardwood_refinishing) {total+= remove_commas(this.form.hardwood_refinishing_qty) * remove_commas(this.form.hardwood_refinishing_price)}

            if(this.form.enable_new_carpet_and_padding) {total+= remove_commas(this.form.new_carpet_and_padding_qty) * remove_commas(this.form.new_carpet_and_padding_price)}

            if(this.form.enable_drywall_patch) {total+= remove_commas(this.form.drywall_patch_qty) * remove_commas(this.form.drywall_patch_price)}

            if(this.form.enable_plumber_work) {total+= remove_commas(this.form.plumber_work_qty) * remove_commas(this.form.plumber_work_price)}

            if(this.form.enable_electrician_work) {total+= remove_commas(this.form.electrician_work_qty) * remove_commas(this.form.electrician_work_price)}

            if(this.form.enable_carpenter_work) {total+= remove_commas(this.form.carpenter_work_qty) * remove_commas(this.form.carpenter_work_price)}

            if(this.form.enable_interior_paint) {total+= remove_commas(this.form.interior_paint_qty) * remove_commas(this.form.interior_paint_price)}

            if(this.form.enable_insulation) {total+= remove_commas(this.form.insulation_qty) * remove_commas(this.form.insulation_price)}

            if(this.form.enable_furance) {total+= remove_commas(this.form.furance_qty) * remove_commas(this.form.furance_price)}

            if(this.form.enable_hvac) {total+= remove_commas(this.form.hvac_qty) * remove_commas(this.form.hvac_price)}

            if(this.form.enable_water_heater) {total+= remove_commas(this.form.water_heater_qty) * remove_commas(this.form.water_heater_price)}

            if(this.form.enable_boiler) {total+= remove_commas(this.form.boiler_qty) * remove_commas(this.form.boiler_price)}

            if(this.form.enable_refrigerator) {total+= remove_commas(this.form.refrigerator_qty) * remove_commas(this.form.refrigerator_price)}

            if(this.form.enable_oven) {total+= remove_commas(this.form.oven_qty) * remove_commas(this.form.oven_price)}

            if(this.form.enable_dishwasher) {total+= remove_commas(this.form.dishwasher_qty) * remove_commas(this.form.dishwasher_price)}

            if(this.form.enable_microwave) {total+= remove_commas(this.form.microwave_qty) * remove_commas(this.form.microwave_price)}

            if(this.form.enable_kitchen_cabinet_and_hardware) {total+= remove_commas(this.form.kitchen_cabinet_and_hardware_qty) * remove_commas(this.form.kitchen_cabinet_and_hardware_price)}

            if(this.form.enable_kitchen_countertops) {total+= remove_commas(this.form.kitchen_countertops_qty) * remove_commas(this.form.kitchen_countertops_price)}

            if(this.form.enable_kitchen_backsplash) {total+= remove_commas(this.form.kitchen_backsplash_qty) * remove_commas(this.form.kitchen_backsplash_price)}

            if(this.form.enable_garbage_disposal) {total+= remove_commas(this.form.garbage_disposal_qty) * remove_commas(this.form.garbage_disposal_price)}

            if(this.form.enable_bathroom_vanity) {total+= remove_commas(this.form.bathroom_vanity_qty) * remove_commas(this.form.bathroom_vanity_price)}

            if(this.form.enable_toilet) {total+= remove_commas(this.form.toilet_qty) * remove_commas(this.form.toilet_price)}

            if(this.form.enable_tub_reglazing) {total+= remove_commas(this.form.tub_reglazing_qty) * remove_commas(this.form.tub_reglazing_price)}

            if(this.form.enable_shower_tile) {total+= remove_commas(this.form.shower_tile_qty) * remove_commas(this.form.shower_tile_price)}

            if(this.form.enable_mold_remediation) {total+= remove_commas(this.form.mold_remediation_qty) * remove_commas(this.form.mold_remediation_price)}

            if(this.form.enable_electrical_fixture) {total+= remove_commas(this.form.electrical_fixture_qty) * remove_commas(this.form.electrical_fixture_price)}

            if(this.form.enable_water_fixture) {total+= remove_commas(this.form.water_fixture_qty) * remove_commas(this.form.water_fixture_price)}

            if(this.form.enable_doors) {total+= remove_commas(this.form.doors_qty) * remove_commas(this.form.doors_price)}

            return total
        },
        exterior_total() {

            let total = 0;


            if(this.form.enable_roof_asphalt) {total += remove_commas(this.form.roof_asphalt_qty) * remove_commas(this.form.roof_asphalt_price);}

            if(this.form.enable_chimney_repair) {total += remove_commas(this.form.chimney_repair_qty) * remove_commas(this.form.chimney_repair_price);}

            if(this.form.enable_gutters) {total += remove_commas(this.form.gutters_qty) * remove_commas(this.form.gutters_price);}

            if(this.form.enable_siding) {total += remove_commas(this.form.siding_qty) * remove_commas(this.form.siding_price);}

            if(this.form.enable_paint) {total += remove_commas(this.form.paint_qty) * remove_commas(this.form.paint_price);}

            if(this.form.enable_windows) {total += remove_commas(this.form.windows_qty) * remove_commas(this.form.windows_price);}

            if(this.form.enable_deck) {total += remove_commas(this.form.deck_qty) * remove_commas(this.form.deck_price);}

            if(this.form.enable_shed_repair) {total += remove_commas(this.form.shed_repair_qty) * remove_commas(this.form.shed_repair_price);}

            if(this.form.enable_seal_coat) {total += remove_commas(this.form.seal_coat_qty) * remove_commas(this.form.seal_coat_price);}

            if(this.form.enable_garage_door) {total += remove_commas(this.form.garage_door_qty) * remove_commas(this.form.garage_door_price);}

            if(this.form.enable_pool_or_spa_repair) {total += remove_commas(this.form.pool_or_spa_repair_qty) * remove_commas(this.form.pool_or_spa_repair_price);}

            if(this.form.enable_fencing) {total += remove_commas(this.form.fencing_qty) * remove_commas(this.form.fencing_price);}

            if(this.form.enable_dumpster_rental) {total += remove_commas(this.form.dumpster_rental_qty) * remove_commas(this.form.dumpster_rental_price);}

            if(this.form.enable_foundation_repair) {total += remove_commas(this.form.foundation_repair_qty) * remove_commas(this.form.foundation_repair_price);}

            if(this.form.enable_drainage) {total += remove_commas(this.form.drainage_qty) * remove_commas(this.form.drainage_price);}

            if(this.form.enable_port_o_potty_rental) {total += remove_commas(this.form.port_o_potty_rental_qty) * remove_commas(this.form.port_o_potty_rental_price);}

            return total;
        },
        landscaping_total() {

            let total = 0;

            if(this.form.enable_yard_cleanup) {total += remove_commas(this.form.yard_cleanup_qty) * remove_commas(this.form.yard_cleanup_price);}

            if(this.form.enable_tree_removing) {total += remove_commas(this.form.tree_removing_qty) * remove_commas(this.form.tree_removing_price);}

            if(this.form.enable_new_grass_sod) {total += remove_commas(this.form.new_grass_sod_qty) * remove_commas(this.form.new_grass_sod_price);}

            if(this.form.enable_new_plants) {total += remove_commas(this.form.new_plants_qty) * remove_commas(this.form.new_plants_price);}

            if(this.form.enable_hardscape) {total += remove_commas(this.form.hardscape_qty) * remove_commas(this.form.hardscape_price);}

            if(this.form.enable_mulch) {total += remove_commas(this.form.mulch_qty) * remove_commas(this.form.mulch_price);}

            if(this.form.enable_fire_pit) {total += remove_commas(this.form.fire_pit_qty) * remove_commas(this.form.fire_pit_price);}

            if(this.form.enable_patio) {total += remove_commas(this.form.patio_qty) * remove_commas(this.form.patio_price);}


            return total;
        },
        interior_percentage() { return Math.round(remove_commas(this.interior_total) / (remove_commas(this.interior_total) + remove_commas(this.exterior_total) + remove_commas(this.landscaping_total)) * 100); },
        exterior_percentage() { return Math.round(remove_commas(this.exterior_total) / (remove_commas(this.interior_total) + remove_commas(this.exterior_total) + remove_commas(this.landscaping_total)) * 100); },
        landscaping_percentage() { return Math.round(remove_commas(this.landscaping_total) / (remove_commas(this.interior_total) + remove_commas(this.exterior_total) + remove_commas(this.landscaping_total)) * 100); },
        values() {

            return [
                this.interior_total,
                this.exterior_total,
                this.landscaping_total
            ];
        }
    }
}
</script>

<template>
        <div>
            <div class="col-12">
                <div class="row align-items-center">
                    <div class="col text-left">
                        <div class="u_frm_hdng">
                            <i class="text-xl pi pi-calculator"></i>
                            Renovation Calculator
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <ShareNetwork
                                @close="saveCount"
                                network="facebook"
                                url="http://dealhunter.ai/calculator/renovation"
                                title="Renovation Calculators"
                                description="Try Out Our Renovation Calculator"
                                quote="Try Out Our Renovation Calculator"
                                hashtags="calculators"
                            >
                                <Button class="rounded-3 u_hdr_btn me-3">
                                    <!-- Facebook Icon Start -->
                                    <svg width="11" height="21" viewBox="0 0 11 21" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7 12H9.5L10.5 8H7V6C7 4.97 7 4 9 4H10.5V0.64C10.174 0.597 8.943 0.5 7.643 0.5C4.928 0.5 3 2.157 3 5.2V8H0V12H3V20.5H7V12Z"
                                            fill="white" />
                                    </svg> &nbsp;
                                    <!-- Facebook Icon End -->
                                    Share With Real Estate Friends!
                                </Button>

                            </ShareNetwork>
                            <p class="u_fb_like border-1 rounded w-fit-content p-2">
                                {{this.sharing_count}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card p-0">
                        <div class="card-header">
                            <h2 class="card-title text-2xl"> INTERIOR</h2>
                        </div>

                        <div class="card-body">
                            <table class="w-100" cellpadding="10">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">Select</th>
                                        <th>Description</th>
                                        <th><h3>Price Installed</h3></th>
                                        <th>&nbsp;</th>
                                        <th><h3>Quantity</h3></th>
                                        <th><h3>Total Cost</h3></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_new_flooring" />
                                        </td>
                                        <td class="col-md-4">New Flooring (per sqft)</td>
                                        <td>
                                            <InputText class="w-full text-right" :disabled="!form.enable_new_flooring" style="border-radius: 1rem !important;" v-model="form.new_flooring_price" />
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_new_flooring" v-model="form.new_flooring_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_new_flooring" class="pi pi-dollar"></i> {{(form.enable_new_flooring ? add_commas(remove_commas(form.new_flooring_qty)*remove_commas(form.new_flooring_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_hardwood_refinishing" />
                                        </td>
                                        <td class="col-md-4">Hardwood Refinishing (per sqft)</td>
                                        <td>
                                            <InputText class="w-full text-right" :disabled="!form.enable_hardwood_refinishing" style="border-radius: 1rem !important;" v-model="form.hardwood_refinishing_price" />
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_hardwood_refinishing" v-model="form.hardwood_refinishing_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_hardwood_refinishing" class="pi pi-dollar"></i> {{(form.enable_hardwood_refinishing ? add_commas(remove_commas(form.hardwood_refinishing_qty)*remove_commas(form.hardwood_refinishing_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_new_carpet_and_padding" />
                                        </td>
                                        <td class="col-md-4">New Carpet & Padding (per sqft)</td>
                                        <td>
                                            <InputText class="w-full text-right" :disabled="!form.enable_new_carpet_and_padding" style="border-radius: 1rem !important;" v-model="form.new_carpet_and_padding_price" />
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_new_carpet_and_padding" v-model="form.new_carpet_and_padding_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_new_carpet_and_padding" class="pi pi-dollar"></i> {{(form.enable_new_carpet_and_padding ? add_commas(remove_commas(form.new_carpet_and_padding_qty)*remove_commas(form.new_carpet_and_padding_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_drywall_patch" />
                                        </td>
                                        <td class="col-md-4">Drywall patch/repair (per sqft)</td>
                                        <td>
                                            <InputText class="w-full text-right" :disabled="!form.enable_drywall_patch" style="border-radius: 1rem !important;" v-model="form.drywall_patch_price" />
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_drywall_patch" v-model="form.drywall_patch_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_drywall_patch" class="pi pi-dollar"></i> {{(form.enable_drywall_patch ? add_commas(remove_commas(form.drywall_patch_qty)*remove_commas(form.drywall_patch_price)) : '-')}} </td>
                                    </tr>


                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_plumber_work" />
                                        </td>
                                        <td class="col-md-4">Plumber's scope of work</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_plumber_work" style="border-radius: 1rem !important;" v-model="form.plumber_work_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_plumber_work" v-model="form.plumber_work_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_plumber_work" class="pi pi-dollar"></i> {{(form.enable_plumber_work ? add_commas(remove_commas(form.plumber_work_qty)*remove_commas(form.plumber_work_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_electrician_work" />
                                        </td>
                                        <td class="col-md-4">Electrician's scope of work</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_electrician_work" style="border-radius: 1rem !important;" v-model="form.electrician_work_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_electrician_work" v-model="form.electrician_work_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_electrician_work" class="pi pi-dollar"></i> {{(form.enable_electrician_work ? add_commas(remove_commas(form.electrician_work_qty)*remove_commas(form.electrician_work_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_carpenter_work" />
                                        </td>
                                        <td class="col-md-4">Carpenter's scope of work</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_carpenter_work" style="border-radius: 1rem !important;" v-model="form.carpenter_work_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_carpenter_work" v-model="form.carpenter_work_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_carpenter_work" class="pi pi-dollar"></i> {{(form.enable_carpenter_work ? add_commas(remove_commas(form.carpenter_work_qty)*remove_commas(form.carpenter_work_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_interior_paint" />
                                        </td>
                                        <td class="col-md-4">Interior Paint (per sqft)</td>
                                        <td>
                                            <InputText class="w-full text-right" :disabled="!form.enable_interior_paint" style="border-radius: 1rem !important;" v-model="form.interior_paint_price" />
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_interior_paint" v-model="form.interior_paint_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_interior_paint" class="pi pi-dollar"></i> {{(form.enable_interior_paint ? add_commas(remove_commas(form.interior_paint_qty)*remove_commas(form.interior_paint_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_insulation" />
                                        </td>
                                        <td class="col-md-4">Insulation</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_insulation" style="border-radius: 1rem !important;" v-model="form.insulation_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_insulation" v-model="form.insulation_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_insulation" class="pi pi-dollar"></i> {{(form.enable_insulation ? add_commas(remove_commas(form.insulation_qty)*remove_commas(form.insulation_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_furance" />
                                        </td>
                                        <td class="col-md-4">Furnace</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_furance" style="border-radius: 1rem !important;" v-model="form.furance_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_furance" v-model="form.furance_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_furance" class="pi pi-dollar"></i> {{(form.enable_furance ? add_commas(remove_commas(form.furance_qty)*remove_commas(form.furance_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_hvac" />
                                        </td>
                                        <td class="col-md-4">HVAC</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_hvac" style="border-radius: 1rem !important;" v-model="form.hvac_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_hvac" v-model="form.hvac_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_hvac" class="pi pi-dollar"></i> {{(form.enable_hvac ? add_commas(remove_commas(form.hvac_qty)*remove_commas(form.hvac_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_water_heater" />
                                        </td>
                                        <td class="col-md-4">Water Heater</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_water_heater" style="border-radius: 1rem !important;" v-model="form.water_heater_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_water_heater" v-model="form.water_heater_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_water_heater" class="pi pi-dollar"></i> {{(form.enable_water_heater ? add_commas(remove_commas(form.water_heater_qty)*remove_commas(form.water_heater_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_boiler" />
                                        </td>
                                        <td class="col-md-4">Boiler</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_boiler" style="border-radius: 1rem !important;" v-model="form.boiler_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_boiler" v-model="form.boiler_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_boiler" class="pi pi-dollar"></i> {{(form.enable_boiler ? add_commas(remove_commas(form.boiler_qty)*remove_commas(form.boiler_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_refrigerator" />
                                        </td>
                                        <td class="col-md-4">Refrigerator</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_refrigerator" style="border-radius: 1rem !important;" v-model="form.refrigerator_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_refrigerator" v-model="form.refrigerator_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_refrigerator" class="pi pi-dollar"></i> {{(form.enable_refrigerator ? add_commas(remove_commas(form.refrigerator_qty)*remove_commas(form.refrigerator_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_oven" />
                                        </td>
                                        <td class="col-md-4">Oven / Range</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_oven" style="border-radius: 1rem !important;" v-model="form.oven_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_oven" v-model="form.oven_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_oven" class="pi pi-dollar"></i> {{(form.enable_oven ? add_commas(remove_commas(form.oven_qty)*remove_commas(form.oven_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_dishwasher" />
                                        </td>
                                        <td class="col-md-4">Dishwasher</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_dishwasher" style="border-radius: 1rem !important;" v-model="form.dishwasher_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_dishwasher" v-model="form.dishwasher_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_dishwasher" class="pi pi-dollar"></i> {{(form.enable_dishwasher ? add_commas(remove_commas(form.dishwasher_qty)*remove_commas(form.dishwasher_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_microwave" />
                                        </td>
                                        <td class="col-md-4">Microwave / Hood</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_microwave" style="border-radius: 1rem !important;" v-model="form.microwave_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_microwave" v-model="form.microwave_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_microwave" class="pi pi-dollar"></i> {{(form.enable_microwave ? add_commas(remove_commas(form.microwave_qty)*remove_commas(form.microwave_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_kitchen_cabinet_and_hardware" />
                                        </td>
                                        <td class="col-md-4">Kitchen Cabinets & hardware</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_kitchen_cabinet_and_hardware" style="border-radius: 1rem !important;" v-model="form.kitchen_cabinet_and_hardware_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_kitchen_cabinet_and_hardware" v-model="form.kitchen_cabinet_and_hardware_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_kitchen_cabinet_and_hardware" class="pi pi-dollar"></i> {{(form.enable_kitchen_cabinet_and_hardware ? add_commas(remove_commas(form.kitchen_cabinet_and_hardware_qty)*remove_commas(form.kitchen_cabinet_and_hardware_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_kitchen_countertops" />
                                        </td>
                                        <td class="col-md-4">Kitchen Countertops</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_kitchen_countertops" style="border-radius: 1rem !important;" v-model="form.kitchen_countertops_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_kitchen_countertops" v-model="form.kitchen_countertops_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_kitchen_countertops" class="pi pi-dollar"></i> {{(form.enable_kitchen_countertops ? add_commas(remove_commas(form.kitchen_countertops_qty)*remove_commas(form.kitchen_countertops_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_kitchen_backsplash" />
                                        </td>
                                        <td class="col-md-4">Kitchen Backsplash</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_kitchen_backsplash" style="border-radius: 1rem !important;" v-model="form.kitchen_backsplash_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_kitchen_backsplash" v-model="form.kitchen_backsplash_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_kitchen_backsplash" class="pi pi-dollar"></i> {{(form.enable_kitchen_backsplash ? add_commas(remove_commas(form.kitchen_backsplash_qty)*remove_commas(form.kitchen_backsplash_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_garbage_disposal" />
                                        </td>
                                        <td class="col-md-4">Garbage disposal</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_garbage_disposal" style="border-radius: 1rem !important;" v-model="form.garbage_disposal_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_garbage_disposal" v-model="form.garbage_disposal_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_garbage_disposal" class="pi pi-dollar"></i> {{(form.enable_garbage_disposal ? add_commas(remove_commas(form.garbage_disposal_qty)*remove_commas(form.garbage_disposal_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_bathroom_vanity" />
                                        </td>
                                        <td class="col-md-4">Bathroom Vanity</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_bathroom_vanity" style="border-radius: 1rem !important;" v-model="form.bathroom_vanity_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_bathroom_vanity" v-model="form.bathroom_vanity_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_bathroom_vanity" class="pi pi-dollar"></i> {{(form.enable_bathroom_vanity ? add_commas(remove_commas(form.bathroom_vanity_qty)*remove_commas(form.bathroom_vanity_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_toilet" />
                                        </td>
                                        <td class="col-md-4">Toilet</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_toilet" style="border-radius: 1rem !important;" v-model="form.toilet_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_toilet" v-model="form.toilet_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_toilet" class="pi pi-dollar"></i> {{(form.enable_toilet ? add_commas(remove_commas(form.toilet_qty)*remove_commas(form.toilet_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_tub_reglazing" />
                                        </td>
                                        <td class="col-md-4">Tub Reglazing</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_tub_reglazing" style="border-radius: 1rem !important;" v-model="form.tub_reglazing_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_tub_reglazing" v-model="form.tub_reglazing_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_tub_reglazing" class="pi pi-dollar"></i> {{(form.enable_tub_reglazing ? add_commas(remove_commas(form.tub_reglazing_qty)*remove_commas(form.tub_reglazing_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_shower_tile" />
                                        </td>
                                        <td class="col-md-4">Shower Tile / Insert</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_shower_tile" style="border-radius: 1rem !important;" v-model="form.shower_tile_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_shower_tile" v-model="form.shower_tile_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_shower_tile" class="pi pi-dollar"></i> {{(form.enable_shower_tile ? add_commas(remove_commas(form.shower_tile_qty)*remove_commas(form.shower_tile_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="false" v-model="form.enable_mold_remediation" />
                                        </td>
                                        <td class="col-md-4">Mold remediation</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_mold_remediation" style="border-radius: 1rem !important;" v-model="form.mold_remediation_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_mold_remediation" v-model="form.mold_remediation_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_mold_remediation" class="pi pi-dollar"></i> {{(form.enable_mold_remediation ? add_commas(remove_commas(form.mold_remediation_qty)*remove_commas(form.mold_remediation_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_electrical_fixture" />
                                        </td>
                                        <td class="col-md-4">Fixtures: electrical</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_electrical_fixture" style="border-radius: 1rem !important;" v-model="form.electrical_fixture_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_electrical_fixture" v-model="form.electrical_fixture_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_electrical_fixture" class="pi pi-dollar"></i> {{(form.enable_electrical_fixture ? add_commas(remove_commas(form.electrical_fixture_qty)*remove_commas(form.electrical_fixture_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_water_fixture" />
                                        </td>
                                        <td class="col-md-4">Fixtures: water</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_water_fixture" style="border-radius: 1rem !important;" v-model="form.water_fixture_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_water_fixture" v-model="form.water_fixture_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_water_fixture" class="pi pi-dollar"></i> {{(form.enable_water_fixture ? add_commas(remove_commas(form.water_fixture_qty)*remove_commas(form.water_fixture_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_doors" />
                                        </td>
                                        <td class="col-md-4">Doors / Sliders</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_doors" style="border-radius: 1rem !important;" v-model="form.doors_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_doors" v-model="form.doors_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_doors" class="pi pi-dollar"></i> {{(form.enable_doors ? add_commas(remove_commas(form.doors_qty)*remove_commas(form.doors_price)) : '-')}} </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="card-footer" style="background: none;">
                                <div class="row">
                                    <div class="col-md-10"><strong class="text-lg">Total</strong></div>
                                    <div class="col-md-2 text-center"><i class="pi pi-dollar"></i>{{Number(interior_total).toLocaleString()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card p-0">
                        <div class="card-header">
                            <h2 class="card-title text-2xl"> EXTERIOR</h2>
                        </div>

                        <div class="card-body">
                            <table class="w-100" cellpadding="10">
                                <thead>
                                <tr>
                                    <th style="width: 10px;">Select</th>
                                    <th>Description</th>
                                    <th><h3>Price Installed</h3></th>
                                    <th>&nbsp;</th>
                                    <th><h3>Quantity</h3></th>
                                    <th><h3>Total Cost</h3></th>
                                </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_roof_asphalt" />
                                        </td>
                                        <td class="col-md-4">Roof: Asphalt</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_roof_asphalt" style="border-radius: 1rem !important;" v-model="form.roof_asphalt_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_roof_asphalt" v-model="form.roof_asphalt_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_roof_asphalt" class="pi pi-dollar"></i> {{(form.enable_roof_asphalt ? add_commas(remove_commas(form.roof_asphalt_qty)*remove_commas(form.roof_asphalt_price)) : '-')}} </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_chimney_repair" />
                                        </td>
                                        <td class="col-md-4">Chimney repair / flashing</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_chimney_repair" style="border-radius: 1rem !important;" v-model="form.chimney_repair_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_chimney_repair" v-model="form.chimney_repair_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_chimney_repair" class="pi pi-dollar"></i> {{(form.enable_chimney_repair ? add_commas(remove_commas(form.chimney_repair_qty)*remove_commas(form.chimney_repair_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_gutters" />
                                        </td>
                                        <td class="col-md-4">Gutters / Downspouts</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_gutters" style="border-radius: 1rem !important;" v-model="form.gutters_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_gutters" v-model="form.gutters_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_gutters" class="pi pi-dollar"></i> {{(form.enable_gutters ? add_commas(remove_commas(form.gutters_qty)*remove_commas(form.gutters_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_siding" />
                                        </td>
                                        <td class="col-md-4">Siding: Vinyl, Wood, Brick</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_siding" style="border-radius: 1rem !important;" v-model="form.siding_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_siding" v-model="form.siding_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_siding" class="pi pi-dollar"></i> {{(form.enable_siding ? add_commas(remove_commas(form.siding_qty)*remove_commas(form.siding_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_paint" />
                                        </td>
                                        <td class="col-md-4">Exterior Paint (per sqft)</td>
                                        <td>
                                            <InputText class="w-full text-right" :disabled="!form.enable_paint" style="border-radius: 1rem !important;" v-model="form.paint_price" />
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_paint" v-model="form.paint_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_paint" class="pi pi-dollar"></i> {{(form.enable_paint ? add_commas(remove_commas(form.paint_qty)*remove_commas(form.paint_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_windows" />
                                        </td>
                                        <td class="col-md-4">Windows / Screens</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_windows" style="border-radius: 1rem !important;" v-model="form.windows_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_windows" v-model="form.windows_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_windows" class="pi pi-dollar"></i> {{(form.enable_windows ? add_commas(remove_commas(form.windows_qty)*remove_commas(form.windows_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_deck" />
                                        </td>
                                        <td class="col-md-4">Deck / Porch Repair</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_deck" style="border-radius: 1rem !important;" v-model="form.deck_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_deck" v-model="form.deck_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_deck" class="pi pi-dollar"></i> {{(form.enable_deck ? add_commas(remove_commas(form.deck_qty)*remove_commas(form.deck_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_shed_repair" />
                                        </td>
                                        <td class="col-md-4">Shed Repair</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_shed_repair" style="border-radius: 1rem !important;" v-model="form.shed_repair_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_shed_repair" v-model="form.shed_repair_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_shed_repair" class="pi pi-dollar"></i> {{(form.enable_shed_repair ? add_commas(remove_commas(form.shed_repair_qty)*remove_commas(form.shed_repair_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_seal_coat" />
                                        </td>
                                        <td class="col-md-4">Driveway: seal coat</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_seal_coat" style="border-radius: 1rem !important;" v-model="form.seal_coat_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_seal_coat" v-model="form.seal_coat_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_seal_coat" class="pi pi-dollar"></i> {{(form.enable_seal_coat ? add_commas(remove_commas(form.seal_coat_qty)*remove_commas(form.seal_coat_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_garage_door" />
                                        </td>
                                        <td class="col-md-4">Garage door</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_garage_door" style="border-radius: 1rem !important;" v-model="form.garage_door_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_garage_door" v-model="form.garage_door_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_garage_door" class="pi pi-dollar"></i> {{(form.enable_garage_door ? add_commas(remove_commas(form.garage_door_qty)*remove_commas(form.garage_door_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_pool_or_spa_repair" />
                                        </td>
                                        <td class="col-md-4">Pool / Spa repair</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_pool_or_spa_repair" style="border-radius: 1rem !important;" v-model="form.pool_or_spa_repair_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_pool_or_spa_repair" v-model="form.pool_or_spa_repair_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_pool_or_spa_repair" class="pi pi-dollar"></i> {{(form.enable_pool_or_spa_repair ? add_commas(remove_commas(form.pool_or_spa_repair_qty)*remove_commas(form.pool_or_spa_repair_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_fencing" />
                                        </td>
                                        <td class="col-md-4">Fencing (wood, vinyl, chainlink)</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_fencing" style="border-radius: 1rem !important;" v-model="form.fencing_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_fencing" v-model="form.fencing_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_fencing" class="pi pi-dollar"></i> {{(form.enable_fencing ? add_commas(remove_commas(form.fencing_qty)*remove_commas(form.fencing_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_dumpster_rental" />
                                        </td>
                                        <td class="col-md-4">Dumpster Rental</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_dumpster_rental" style="border-radius: 1rem !important;" v-model="form.dumpster_rental_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_dumpster_rental" v-model="form.dumpster_rental_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_dumpster_rental" class="pi pi-dollar"></i> {{(form.enable_dumpster_rental ? add_commas(remove_commas(form.dumpster_rental_qty)*remove_commas(form.dumpster_rental_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_foundation_repair" />
                                        </td>
                                        <td class="col-md-4">Foundation repair</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_foundation_repair" style="border-radius: 1rem !important;" v-model="form.foundation_repair_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_foundation_repair" v-model="form.foundation_repair_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_foundation_repair" class="pi pi-dollar"></i> {{(form.enable_foundation_repair ? add_commas(remove_commas(form.foundation_repair_qty)*remove_commas(form.foundation_repair_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_drainage" />
                                        </td>
                                        <td class="col-md-4">Drainage</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_drainage" style="border-radius: 1rem !important;" v-model="form.drainage_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_drainage" v-model="form.drainage_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_drainage" class="pi pi-dollar"></i> {{(form.enable_drainage ? add_commas(remove_commas(form.drainage_qty)*remove_commas(form.drainage_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_port_o_potty_rental" />
                                        </td>
                                        <td class="col-md-4">Port-o-Potty rental</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_port_o_potty_rental" style="border-radius: 1rem !important;" v-model="form.port_o_potty_rental_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_port_o_potty_rental" v-model="form.port_o_potty_rental_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_port_o_potty_rental" class="pi pi-dollar"></i> {{(form.enable_port_o_potty_rental ? add_commas(remove_commas(form.port_o_potty_rental_qty)*remove_commas(form.port_o_potty_rental_price)) : '-')}} </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="card-footer" style="background: none;">
                                <div class="row">
                                    <div class="col-md-10"><strong class="text-lg">Total</strong></div>
                                    <div class="col-md-2 text-center"><i class="pi pi-dollar"></i>{{Number(exterior_total).toLocaleString()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card p-0">
                        <div class="card-header">
                            <h2 class="card-title text-2xl"> LANDSCAPING</h2>
                        </div>

                        <div class="card-body">
                            <table class="w-100" cellpadding="10">
                                <thead>
                                <tr>
                                    <th style="width: 10px;">Select</th>
                                    <th>Description</th>
                                    <th><h3>Price Installed</h3></th>
                                    <th>&nbsp;</th>
                                    <th><h3>Quantity</h3></th>
                                    <th><h3>Total Cost</h3></th>
                                </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_yard_cleanup" />
                                        </td>
                                        <td class="col-md-4">Yard Cleanup</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_yard_cleanup" style="border-radius: 1rem !important;" v-model="form.yard_cleanup_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_yard_cleanup" v-model="form.yard_cleanup_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_yard_cleanup" class="pi pi-dollar"></i> {{(form.enable_yard_cleanup ? add_commas(remove_commas(form.yard_cleanup_qty)*remove_commas(form.yard_cleanup_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_tree_removing" />
                                        </td>
                                        <td class="col-md-4">Tree removal / trimming</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_tree_removing" style="border-radius: 1rem !important;" v-model="form.tree_removing_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_tree_removing" v-model="form.tree_removing_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_tree_removing" class="pi pi-dollar"></i> {{(form.enable_tree_removing ? add_commas(remove_commas(form.tree_removing_qty)*remove_commas(form.tree_removing_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_new_grass_sod" />
                                        </td>
                                        <td class="col-md-4">New grass seeding / sod</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_new_grass_sod" style="border-radius: 1rem !important;" v-model="form.new_grass_sod_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_new_grass_sod" v-model="form.new_grass_sod_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_new_grass_sod" class="pi pi-dollar"></i> {{(form.enable_new_grass_sod ? add_commas(remove_commas(form.new_grass_sod_qty)*remove_commas(form.new_grass_sod_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_new_plants" />
                                        </td>
                                        <td class="col-md-4">New plants / shrubbery</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_new_plants" style="border-radius: 1rem !important;" v-model="form.new_plants_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_new_plants" v-model="form.new_plants_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_new_plants" class="pi pi-dollar"></i> {{(form.enable_new_plants ? add_commas(remove_commas(form.new_plants_qty)*remove_commas(form.new_plants_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_hardscape" />
                                        </td>
                                        <td class="col-md-4">Hardscape, Gravel, Rock</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_hardscape" style="border-radius: 1rem !important;" v-model="form.hardscape_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_hardscape" v-model="form.hardscape_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_hardscape" class="pi pi-dollar"></i> {{(form.enable_hardscape ? add_commas(remove_commas(form.hardscape_qty)*remove_commas(form.hardscape_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_mulch" />
                                        </td>
                                        <td class="col-md-4">Mulch (per sq yard)</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_mulch" style="border-radius: 1rem !important;" v-model="form.mulch_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_mulch" v-model="form.mulch_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_mulch" class="pi pi-dollar"></i> {{(form.enable_mulch ? add_commas(remove_commas(form.mulch_qty)*remove_commas(form.mulch_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_fire_pit" />
                                        </td>
                                        <td class="col-md-4">Fire Pit</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_fire_pit" style="border-radius: 1rem !important;" v-model="form.fire_pit_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_fire_pit" v-model="form.fire_pit_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_fire_pit" class="pi pi-dollar"></i> {{(form.enable_fire_pit ? add_commas(remove_commas(form.fire_pit_qty)*remove_commas(form.fire_pit_price)) : '-')}} </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <Checkbox :binary="true" v-model="form.enable_patio" />
                                        </td>
                                        <td class="col-md-4">Patio</td>
                                        <td>
                                            <div class="position-relative">
                                                <i class="pi pi-dollar position-absolute" style="top: 38%; left: 10px;"></i>
                                                <InputText class="w-full text-right" :disabled="!form.enable_patio" style="border-radius: 1rem !important;" v-model="form.patio_price" />
                                            </div>
                                        </td>
                                        <td style="width: 20px;" class="text-center"><i class="pi pi-times text-xl"></i></td>
                                        <td>
                                            <InputText class="w-full" style="border-radius: 1rem !important;" :disabled="!form.enable_patio" v-model="form.patio_qty" />
                                        </td>
                                        <td class="text-center"> <i v-if="form.enable_patio" class="pi pi-dollar"></i> {{(form.enable_patio ? add_commas(remove_commas(form.patio_qty)*remove_commas(form.patio_price)) : '-')}} </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="card-footer" style="background: none;">
                                <div class="row">
                                    <div class="col-md-10"><strong class="text-lg">Total</strong></div>
                                    <div class="col-md-2 text-center"><i class="pi pi-dollar"></i>{{Number(landscaping_total).toLocaleString()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header pt-3 pb-1 pl-3" style="background: rgba(219,15,25,0.1)!important;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h2 class="text-2xl mb-0 d-flex text-center text-danger align-items-center gap-2">TOTAL RENOVATION COST</h2>
                                    </div>

                                    <div class="col-md-2">
                                        <strong class="text-2xl text-right text-danger">
                                            <i class="pi pi-dollar text-xl"></i>{{Number(landscaping_total+exterior_total+interior_total).toLocaleString()}}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row mb-4">
                                <div class="col-md-8 text-xl">Interior</div>
                                <div class="col-md-4 text-xl">
                                    <strong>{{interior_percentage}}%</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 text-xl">Exterior</div>
                                <div class="col-md-4 text-xl">
                                    <strong>{{exterior_percentage}}%</strong>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 text-xl">Landsaping</div>
                                <div class="col-md-4 text-xl">
                                    <strong>{{landscaping_percentage}}%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card overflow-hidden p-0">
                        <div class="card-header pt-3 pb-1 pl-3" style="background: rgba(219,15,25,0.1)!important;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-2xl mb-0 text-danger text-center">Rehab Breakdown</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="interior_total > 0 || exterior_total > 0 || landscaping_total > 0" class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <graph-pie
                                        :width="500"
                                        :height="500"
                                        :padding-top="100"
                                        :padding-bottom="100"
                                        :padding-left="100"
                                        :padding-right="100"
                                        :values="values"
                                        :names="names"
                                        :active-index="[ 0, 2 ]"
                                        :active-event="'click'"
                                        :show-text-type="'outside'"
                                        :data-format="dataFormat">
                                        <legends :names="names"></legends>
                                        <tooltip :names="names"></tooltip>
                                    </graph-pie>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>


<style scoped>
.p-button-secondary {
    color: #6c757d!important;
}

.card {
    box-shadow: none!important;
    border-color: #EBEBEB!important;
}
.card-body {
    padding: 0;
    overflow: hidden;
}
.card-header {
    background: #FAFAFA!important;
    border-color: #EBEBEB;
}
.text-dark { color: #101136!important; }
.p-inputtext {
    border-color: rgba(145,158,171,0.32)!important;
}
.u_hdr_btn {
    font-size: 13px;
    font-weight: 500;
    font-family: "Nunito";
    letter-spacing: 2px;
}

p.u_fb_like::before {
    transform: rotate(45deg);
    content: "";
    border-radius: 1px;
    box-sizing: border-box;
    position: absolute;
    width: 10px;
    height: 10px;
    top: 13px;
    left: -6px;
    background: #FFFFFF;
    border: 1px solid #E6EAED;
    z-index: -1;
    border-right: 0;
    border-top: 0;
}

p.u_fb_like {
    width: fit-content;
    position: relative;
    z-index: 999999999999;
    font-size: 14px;
    border-color: #E6EAED;
}

.u_frm_hdng {
    font-size: 24px;
}
</style>

