<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['comparatives', 'comparative'],
    data() {
        return {
            form: useForm({
                id: this.comparative.id,
                title: this.comparative.title,
                subject_property_address: this.comparative.subject_property_address,
                property_address_1: this.comparative.property_address_1,
                property_address_2: this.comparative.property_address_2,
                property_address_3: this.comparative.property_address_3,
                property_address_4: this.comparative.property_address_4,
                subject_property_include_analysis: this.comparative.subject_property_include_analysis,
                property_include_analysis_1: this.comparative.property_include_analysis_1,
                property_include_analysis_2: this.comparative.property_include_analysis_2,
                property_include_analysis_3: this.comparative.property_include_analysis_3,
                property_include_analysis_4: this.comparative.property_include_analysis_4,
                subject_property_style: this.comparative.subject_property_style,
                property_style_1: this.comparative.property_style_1,
                property_style_2: this.comparative.property_style_2,
                property_style_3: this.comparative.property_style_3,
                property_style_4: this.comparative.property_style_4,
                subject_property_square_footage: this.comparative.subject_property_square_footage,
                property_square_footage_1: this.comparative.property_square_footage_1,
                property_square_footage_2: this.comparative.property_square_footage_2,
                property_square_footage_3: this.comparative.property_square_footage_3,
                property_square_footage_4: this.comparative.property_square_footage_4,
                subject_property_beds: this.comparative.subject_property_beds,
                property_beds_1: this.comparative.property_beds_1,
                property_beds_2: this.comparative.property_beds_2,
                property_beds_3: this.comparative.property_beds_3,
                property_beds_4: this.comparative.property_beds_4,
                subject_property_baths: this.comparative.subject_property_baths,
                property_baths_1: this.comparative.property_baths_1,
                property_baths_2: this.comparative.property_baths_2,
                property_baths_3: this.comparative.property_baths_3,
                property_baths_4: this.comparative.property_baths_4,
                subject_property_lot_size: this.comparative.subject_property_lot_size,
                property_lot_size_1: this.comparative.property_lot_size_1,
                property_lot_size_2: this.comparative.property_lot_size_2,
                property_lot_size_3: this.comparative.property_lot_size_3,
                property_lot_size_4: this.comparative.property_lot_size_4,
                subject_property_year_built: this.comparative.subject_property_year_built,
                property_year_built_1: this.comparative.property_year_built_1,
                property_year_built_2: this.comparative.property_year_built_2,
                property_year_built_3: this.comparative.property_year_built_3,
                property_year_built_4: this.comparative.property_year_built_4,
                subject_property_garage: this.comparative.subject_property_garage,
                property_garage_1: this.comparative.property_garage_1,
                property_garage_2: this.comparative.property_garage_2,
                property_garage_3: this.comparative.property_garage_3,
                property_garage_4: this.comparative.property_garage_4,
                subject_property_pool: this.comparative.subject_property_pool,
                property_pool_1: this.comparative.property_pool_1,
                property_pool_2: this.comparative.property_pool_2,
                property_pool_3: this.comparative.property_pool_3,
                property_pool_4: this.comparative.property_pool_4,
                subject_property_proximity: this.comparative.subject_property_proximity,
                property_proximity_1: this.comparative.property_proximity_1,
                property_proximity_2: this.comparative.property_proximity_2,
                property_proximity_3: this.comparative.property_proximity_3,
                property_proximity_4: this.comparative.property_proximity_4,
                subject_property_date_sold: this.comparative.subject_property_date_sold,
                property_date_sold_1: this.comparative.property_date_sold_1,
                property_date_sold_2: this.comparative.property_date_sold_2,
                property_date_sold_3: this.comparative.property_date_sold_3,
                property_date_sold_4: this.comparative.property_date_sold_4,
                subject_property_last_sold_price: this.comparative.subject_property_last_sold_price,
                property_last_sold_price_1: this.comparative.property_last_sold_price_1,
                property_last_sold_price_2: this.comparative.property_last_sold_price_2,
                property_last_sold_price_3: this.comparative.property_last_sold_price_3,
                property_last_sold_price_4: this.comparative.property_last_sold_price_4,
                subject_property_second_last_sold_price: this.comparative.subject_property_second_last_sold_price,
                property_second_last_sold_price_1: this.comparative.property_second_last_sold_price_1,
                property_second_last_sold_price_2: this.comparative.property_second_last_sold_price_2,
                property_second_last_sold_price_3: this.comparative.property_second_last_sold_price_3,
                property_second_last_sold_price_4: this.comparative.property_second_last_sold_price_4,
                subject_property_second_curb_appeal: this.comparative.subject_property_second_curb_appeal,
                property_second_curb_appeal_1: this.comparative.property_second_curb_appeal_1,
                property_second_curb_appeal_2: this.comparative.property_second_curb_appeal_2,
                property_second_curb_appeal_3: this.comparative.property_second_curb_appeal_3,
                property_second_curb_appeal_4: this.comparative.property_second_curb_appeal_4,
                subject_property_curb_appeal: this.comparative.subject_property_curb_appeal,
                property_curb_appeal_1: this.comparative.property_curb_appeal_1,
                property_curb_appeal_2: this.comparative.property_curb_appeal_2,
                property_curb_appeal_3: this.comparative.property_curb_appeal_3,
                property_curb_appeal_4: this.comparative.property_curb_appeal_4,
                subject_property_interior: this.comparative.subject_property_interior,
                property_interior_1: this.comparative.property_interior_1,
                property_interior_2: this.comparative.property_interior_2,
                property_interior_3: this.comparative.property_interior_3,
                property_interior_4: this.comparative.property_interior_4,
                subject_property_fixtures: this.comparative.subject_property_fixtures,
                property_fixtures_1: this.comparative.property_fixtures_1,
                property_fixtures_2: this.comparative.property_fixtures_2,
                property_fixtures_3: this.comparative.property_fixtures_3,
                property_fixtures_4: this.comparative.property_fixtures_4,
                square_footage: this.comparative.square_footage,
                min_square_footage: this.comparative.min_square_footage,
                max_square_footage: this.comparative.max_square_footage,
                property_age: this.comparative.property_age,
                min_year_built: this.comparative.min_year_built,
                max_year_built: this.comparative.max_year_built,
                proximity_to_subject: this.comparative.proximity_to_subject,
                max_days_since_sale: this.comparative.max_days_since_sale,
                avg_sale_price: this.comparative.avg_sale_price,
                lowest_sqft: this.comparative.lowest_sqft,
                average_sqft: this.comparative.average_sqft,
                highest_sqft: this.comparative.highest_sqft,
                range: this.comparative.range,
                suggested_sqft: this.comparative.suggested_sqft,
                subject_property_sqft: this.comparative.subject_property_sqft,
                subject_property_sqft_x: this.comparative.subject_property_sqft_x,
            }),
            controller: null
        }
    },
    methods: {

        update() {

            if(this.controller) this.controller.abort()
            this.controller = new AbortController()

            axios.post(route('users.calculator.comparative-market-analysis.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
        }
    },
    watch: {
        "form.subject_property_address"(newValue){ this.update() },
        "form.property_address_1"(newValue){ this.update() },
        "form.property_address_2"(newValue){ this.update() },
        "form.property_address_3"(newValue){ this.update() },
        "form.property_address_4"(newValue){ this.update() },
        "form.subject_property_include_analysis"(newValue){ this.update() },
        "form.property_include_analysis_1"(newValue){ this.update() },
        "form.property_include_analysis_2"(newValue){ this.update() },
        "form.property_include_analysis_3"(newValue){ this.update() },
        "form.property_include_analysis_4"(newValue){ this.update() },
        "form.subject_property_style"(newValue) {

            this.update()
        },
        "form.property_style_1"(newValue) {

            this.update()
        },
        "form.property_style_2"(newValue) {

            this.update()
        },
        "form.property_style_3"(newValue) {

            this.update()
        },
        "form.property_style_4"(newValue) {

            this.update()
        },
        "form.subject_property_square_footage"(newValue) {

            this.form.subject_property_square_footage = add_commas(newValue)
            this.update()
        },
        "form.property_square_footage_1"(newValue) {

            this.form.property_square_footage_1 = add_commas(newValue)
            this.update()
        },
        "form.property_square_footage_2"(newValue) {

            this.form.property_square_footage_2 = add_commas(newValue)
            this.update()
        },
        "form.property_square_footage_3"(newValue) {

            this.form.property_square_footage_3 = add_commas(newValue)
            this.update()
        },
        "form.property_square_footage_4"(newValue) {

            this.form.property_square_footage_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_beds"(newValue) {

            this.form.subject_property_beds = add_commas(newValue)
            this.update()
        },
        "form.property_beds_1"(newValue) {

            this.form.property_beds_1 = add_commas(newValue)
            this.update()
        },
        "form.property_beds_2"(newValue) {

            this.form.property_beds_2 = add_commas(newValue)
            this.update()
        },
        "form.property_beds_3"(newValue) {

            this.form.property_beds_3 = add_commas(newValue)
            this.update()
        },
        "form.property_beds_4"(newValue) {

            this.form.property_beds_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_baths"(newValue) {

            this.form.subject_property_baths = add_commas(newValue)
            this.update()
        },
        "form.property_baths_1"(newValue) {

            this.form.property_baths_1 = add_commas(newValue)
            this.update()
        },
        "form.property_baths_2"(newValue) {

            this.form.property_baths_2 = add_commas(newValue)
            this.update()
        },
        "form.property_baths_3"(newValue) {

            this.form.property_baths_3 = add_commas(newValue)
            this.update()
        },
        "form.property_baths_4"(newValue) {

            this.form.property_baths_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_lot_size"(newValue) {

            this.form.subject_property_lot_size = add_commas(newValue)
            this.update()
        },
        "form.property_lot_size_1"(newValue) {

            this.form.property_lot_size_1 = add_commas(newValue)
            this.update()
        },
        "form.property_lot_size_2"(newValue) {

            this.form.property_lot_size_2 = add_commas(newValue)
            this.update()
        },
        "form.property_lot_size_3"(newValue) {

            this.form.property_lot_size_3 = add_commas(newValue)
            this.update()
        },
        "form.property_lot_size_4"(newValue) {

            this.form.property_lot_size_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_year_built"(newValue) {

            this.form.subject_property_year_built = add_commas(newValue)
            this.update()
        },
        "form.property_year_built_1"(newValue) {

            this.form.property_year_built_1 = add_commas(newValue)
            this.update()
        },
        "form.property_year_built_2"(newValue) {

            this.form.property_year_built_2 = add_commas(newValue)
            this.update()
        },
        "form.property_year_built_3"(newValue) {

            this.form.property_year_built_3 = add_commas(newValue)
            this.update()
        },
        "form.property_year_built_4"(newValue) {

            this.form.property_year_built_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_garage"(newValue) {this.update()},
        "form.property_garage_1"(newValue) {this.update()},
        "form.property_garage_2"(newValue) {this.update()},
        "form.property_garage_3"(newValue) {this.update()},
        "form.property_garage_4"(newValue) {this.update()},
        "form.subject_property_pool"(newValue) {this.update()},
        "form.property_pool_1"(newValue) {this.update()},
        "form.property_pool_2"(newValue) {this.update()},
        "form.property_pool_3"(newValue) {this.update()},
        "form.property_pool_4"(newValue) {this.update()},
        "form.subject_property_proximity"(newValue) {

            this.form.subject_property_proximity = add_commas(newValue)
            this.update()
        },
        "form.property_proximity_1"(newValue) {

            this.form.property_proximity_1 = add_commas(newValue)
            this.update()
        },
        "form.property_proximity_2"(newValue) {

            this.form.property_proximity_2 = add_commas(newValue)
            this.update()
        },
        "form.property_proximity_3"(newValue) {

            this.form.property_proximity_3 = add_commas(newValue)
            this.update()
        },
        "form.property_proximity_4"(newValue) {

            this.form.property_proximity_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_date_sold"(newValue) {this.update()},
        "form.property_date_sold_1"(newValue) {this.update()},
        "form.property_date_sold_2"(newValue) {this.update()},
        "form.property_date_sold_3"(newValue) {this.update()},
        "form.property_date_sold_4"(newValue) {this.update()},
        "form.subject_property_last_sold_price"(newValue) {

            this.form.subject_property_last_sold_price = add_commas(newValue)
            this.update()
        },
        "form.property_last_sold_price_1"(newValue) {

            this.form.property_last_sold_price_1 = add_commas(newValue)
            this.update()
        },
        "form.property_last_sold_price_2"(newValue) {

            this.form.property_last_sold_price_2 = add_commas(newValue)
            this.update()
        },
        "form.property_last_sold_price_3"(newValue) {

            this.form.property_last_sold_price_3 = add_commas(newValue)
            this.update()
        },
        "form.property_last_sold_price_4"(newValue) {

            this.form.property_last_sold_price_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_second_last_sold_price"(newValue) {

            this.form.subject_property_second_last_sold_price = add_commas(newValue)
            this.update()
        },
        "form.property_second_last_sold_price_1"(newValue) {

            this.form.property_second_last_sold_price_1 = add_commas(newValue)
            this.update()
        },
        "form.property_second_last_sold_price_2"(newValue) {

            this.form.property_second_last_sold_price_2 = add_commas(newValue)
            this.update()
        },
        "form.property_second_last_sold_price_3"(newValue) {

            this.form.property_second_last_sold_price_3 = add_commas(newValue)
            this.update()
        },
        "form.property_second_last_sold_price_4"(newValue) {

            this.form.property_second_last_sold_price_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_second_curb_appeal"(newValue) {

            this.form.subject_property_second_curb_appeal = add_commas(newValue)
            this.update()
        },
        "form.property_second_curb_appeal_1"(newValue) {

            this.form.property_second_curb_appeal_1 = add_commas(newValue)
            this.update()
        },
        "form.property_second_curb_appeal_2"(newValue) {

            this.form.property_second_curb_appeal_2 = add_commas(newValue)
            this.update()
        },
        "form.property_second_curb_appeal_3"(newValue) {

            this.form.property_second_curb_appeal_3 = add_commas(newValue)
            this.update()
        },
        "form.property_second_curb_appeal_4"(newValue) {

            this.form.property_second_curb_appeal_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_curb_appeal"(newValue) {

            this.form.subject_property_curb_appeal = add_commas(newValue)
            this.update()
        },
        "form.property_curb_appeal_1"(newValue) {

            this.form.property_curb_appeal_1 = add_commas(newValue)
            this.update()
        },
        "form.property_curb_appeal_2"(newValue) {

            this.form.property_curb_appeal_2 = add_commas(newValue)
            this.update()
        },
        "form.property_curb_appeal_3"(newValue) {

            this.form.property_curb_appeal_3 = add_commas(newValue)
            this.update()
        },
        "form.property_curb_appeal_4"(newValue) {

            this.form.property_curb_appeal_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_interior"(newValue) {

            this.form.subject_property_interior = add_commas(newValue)
            this.update()
        },
        "form.property_interior_1"(newValue) {

            this.form.property_interior_1 = add_commas(newValue)
            this.update()
        },
        "form.property_interior_2"(newValue) {

            this.form.property_interior_2 = add_commas(newValue)
            this.update()
        },
        "form.property_interior_3"(newValue) {

            this.form.property_interior_3 = add_commas(newValue)
            this.update()
        },
        "form.property_interior_4"(newValue) {

            this.form.property_interior_4 = add_commas(newValue)
            this.update()
        },
        "form.subject_property_fixtures"(newValue) {

            this.form.subject_property_fixtures = add_commas(newValue)
            this.update()
        },
        "form.property_fixtures_1"(newValue) {

            this.form.property_fixtures_1 = add_commas(newValue)
            this.update()
        },
        "form.property_fixtures_2"(newValue) {

            this.form.property_fixtures_2 = add_commas(newValue)
            this.update()
        },
        "form.property_fixtures_3"(newValue) {

            this.form.property_fixtures_3 = add_commas(newValue)
            this.update()
        },
        "form.property_fixtures_4"(newValue) {

            this.form.property_fixtures_4 = add_commas(newValue)
            this.update()
        },
        "form.square_footage"(newValue) {

            this.form.square_footage = add_commas(newValue)
            this.update()
        },
        "form.min_square_footage"(newValue) {

            this.form.min_square_footage = add_commas(newValue)
            this.update()
        },
        "form.max_square_footage"(newValue) {

            this.form.max_square_footage = add_commas(newValue)
            this.update()
        },
        "form.property_age"(newValue) {

            this.form.property_age = add_commas(newValue)
            this.update()
        },
        "form.min_year_built"(newValue) {

            this.form.min_year_built = add_commas(newValue)
            this.update()
        },
        "form.max_year_built"(newValue) {

            this.form.max_year_built = add_commas(newValue)
            this.update()
        },
        "form.proximity_to_subject"(newValue) {

            this.form.proximity_to_subject = add_commas(newValue)
            this.update()
        },
        "form.max_days_since_sale"(newValue) {

            this.form.max_days_since_sale = add_commas(newValue)
            this.update()
        },
        "form.avg_sale_price"(newValue) {

            this.form.avg_sale_price = add_commas(newValue)
            this.update()
        },
        "form.lowest_sqft"(newValue) {

            this.form.lowest_sqft = add_commas(newValue)
            this.update()
        },
        "form.average_sqft"(newValue) {

            this.form.average_sqft = add_commas(newValue)
            this.update()
        },
        "form.highest_sqft"(newValue) {

            this.form.highest_sqft = add_commas(newValue)
            this.update()
        },
        "form.range"(newValue) {

            this.form.range = add_commas(newValue)
            this.update()
        },
        "form.suggested_sqft"(newValue) {

            this.form.suggested_sqft = add_commas(newValue)
            this.update()
        },
        "form.subject_property_sqft"(newValue) {

            this.form.subject_property_sqft = add_commas(newValue)
            this.update()
        },
        "form.subject_property_sqft_x"(newValue) {

            this.form.subject_property_sqft_x = add_commas(newValue)
            this.update()
        },
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="COMPARATIVE MARKET ANALYSIS" />
        <template #pageHeading>
            <Buttons :comparatives="comparatives" />
        </template>

        <Form :form="form" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>
