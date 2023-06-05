<script>
import AuthenticatedLayout from "../../../Layouts/AuthenticatedLayout.vue";
import Buttons from "./Partials/Buttons.vue";
import {useForm, usePage, Link, Head} from '@inertiajs/inertia-vue3';
import Form from "./Partials/Form.vue"

export default {
    props: ['comparatives', 'count'],
    data() {
        return {
            form: useForm({
                id: '',
                subject_property_address: '',
                property_address_1: '',
                property_address_2: '',
                property_address_3: '',
                property_address_4: '',
                subject_property_include_analysis: '',
                property_include_analysis_1: '',
                property_include_analysis_2: '',
                property_include_analysis_3: '',
                property_include_analysis_4: '',
                subject_property_style: '',
                property_style_1: '',
                property_style_2: '',
                property_style_3: '',
                property_style_4: '',
                subject_property_square_footage: '',
                property_square_footage_1: '',
                property_square_footage_2: '',
                property_square_footage_3: '',
                property_square_footage_4: '',
                subject_property_beds: '',
                property_beds_1: '',
                property_beds_2: '',
                property_beds_3: '',
                property_beds_4: '',
                subject_property_baths: '',
                property_baths_1: '',
                property_baths_2: '',
                property_baths_3: '',
                property_baths_4: '',
                subject_property_lot_size: '',
                property_lot_size_1: '',
                property_lot_size_2: '',
                property_lot_size_3: '',
                property_lot_size_4: '',
                subject_property_year_built: '',
                property_year_built_1: '',
                property_year_built_2: '',
                property_year_built_3: '',
                property_year_built_4: '',
                subject_property_garage: '',
                property_garage_1: '',
                property_garage_2: '',
                property_garage_3: '',
                property_garage_4: '',
                subject_property_pool: '',
                property_pool_1: '',
                property_pool_2: '',
                property_pool_3: '',
                property_pool_4: '',
                subject_property_proximity: '',
                property_proximity_1: '',
                property_proximity_2: '',
                property_proximity_3: '',
                property_proximity_4: '',
                subject_property_date_sold: '',
                property_date_sold_1: '',
                property_date_sold_2: '',
                property_date_sold_3: '',
                property_date_sold_4: '',
                subject_property_last_sold_price: '',
                property_last_sold_price_1: '',
                property_last_sold_price_2: '',
                property_last_sold_price_3: '',
                property_last_sold_price_4: '',
                subject_property_second_last_sold_price: '',
                property_second_last_sold_price_1: '',
                property_second_last_sold_price_2: '',
                property_second_last_sold_price_3: '',
                property_second_last_sold_price_4: '',
                subject_property_second_curb_appeal: '',
                property_second_curb_appeal_1: '',
                property_second_curb_appeal_2: '',
                property_second_curb_appeal_3: '',
                property_second_curb_appeal_4: '',
                subject_property_curb_appeal: '',
                property_curb_appeal_1: '',
                property_curb_appeal_2: '',
                property_curb_appeal_3: '',
                property_curb_appeal_4: '',
                subject_property_interior: '',
                property_interior_1: '',
                property_interior_2: '',
                property_interior_3: '',
                property_interior_4: '',
                subject_property_fixtures: '',
                property_fixtures_1: '',
                property_fixtures_2: '',
                property_fixtures_3: '',
                property_fixtures_4: '',
                square_footage: '',
                min_square_footage: '',
                max_square_footage: '',
                property_age: '',
                min_year_built: '',
                max_year_built: '',
                proximity_to_subject: '',
                max_days_since_sale: '',
                avg_sale_price: '',
                lowest_sqft: '',
                average_sqft: '',
                highest_sqft: '',
                range: '',
                suggested_sqft: '',
                subject_property_sqft: '',
                subject_property_sqft_x: '',
            }),
            buttons: this.comparatives,
            controllers: null
        }
    },
    methods: {
        saveOrUpdate() {

            if(!this.form.processing) {

                if(this.controller) this.controller.abort()
                this.controller = new AbortController()

                this.form.processing = true;
                if (this.form.id) {

                    axios.post(route('users.calculator.comparative-market-analysis.store', {id: this.form.id}), {...this.form}, {signal: this.controller.signal})
                        .then(() => {

                            this.form.processing = false
                        })
                } else {

                    const self = this;
                    axios.post(route('users.calculator.comparative-market-analysis.store'), {...this.form}, {signal: this.controller.signal})
                        .then(r => r.data)
                        .then(data => {

                            self.form.id = data.id
                            this.form.processing = false
                            this.buttons = data.comparatives
                            window.history.replaceState({}, '', route('users.calculator.comparative-market-analysis.edit', {comparativeMarketAnalysis: data.id}))
                        })
                }
            }
        }
    },
    watch: {
        "form.subject_property_address"(newValue){ this.saveOrUpdate() },
        "form.property_address_1"(newValue){ this.saveOrUpdate() },
        "form.property_address_2"(newValue){ this.saveOrUpdate() },
        "form.property_address_3"(newValue){ this.saveOrUpdate() },
        "form.property_address_4"(newValue){ this.saveOrUpdate() },
        "form.subject_property_include_analysis"(newValue){ this.saveOrUpdate() },
        "form.property_include_analysis_1"(newValue){ this.saveOrUpdate() },
        "form.property_include_analysis_2"(newValue){ this.saveOrUpdate() },
        "form.property_include_analysis_3"(newValue){ this.saveOrUpdate() },
        "form.property_include_analysis_4"(newValue){ this.saveOrUpdate() },
        "form.subject_property_style"(newValue) {

            this.saveOrUpdate()
        },
        "form.property_style_1"(newValue) {

            this.saveOrUpdate()
        },
        "form.property_style_2"(newValue) {

            this.saveOrUpdate()
        },
        "form.property_style_3"(newValue) {

            this.saveOrUpdate()
        },
        "form.property_style_4"(newValue) {

            this.saveOrUpdate()
        },
        "form.subject_property_square_footage"(newValue) {

            this.form.subject_property_square_footage = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_square_footage_1"(newValue) {

            this.form.property_square_footage_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_square_footage_2"(newValue) {

            this.form.property_square_footage_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_square_footage_3"(newValue) {

            this.form.property_square_footage_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_square_footage_4"(newValue) {

            this.form.property_square_footage_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_beds"(newValue) {

            this.form.subject_property_beds = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_beds_1"(newValue) {

            this.form.property_beds_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_beds_2"(newValue) {

            this.form.property_beds_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_beds_3"(newValue) {

            this.form.property_beds_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_beds_4"(newValue) {

            this.form.property_beds_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_baths"(newValue) {

            this.form.subject_property_baths = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_baths_1"(newValue) {

            this.form.property_baths_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_baths_2"(newValue) {

            this.form.property_baths_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_baths_3"(newValue) {

            this.form.property_baths_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_baths_4"(newValue) {

            this.form.property_baths_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_lot_size"(newValue) {

            this.form.subject_property_lot_size = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_lot_size_1"(newValue) {

            this.form.property_lot_size_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_lot_size_2"(newValue) {

            this.form.property_lot_size_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_lot_size_3"(newValue) {

            this.form.property_lot_size_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_lot_size_4"(newValue) {

            this.form.property_lot_size_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_year_built"(newValue) {

            this.form.subject_property_year_built = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_year_built_1"(newValue) {

            this.form.property_year_built_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_year_built_2"(newValue) {

            this.form.property_year_built_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_year_built_3"(newValue) {

            this.form.property_year_built_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_year_built_4"(newValue) {

            this.form.property_year_built_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_garage"(newValue) {this.saveOrUpdate()},
        "form.property_garage_1"(newValue) {this.saveOrUpdate()},
        "form.property_garage_2"(newValue) {this.saveOrUpdate()},
        "form.property_garage_3"(newValue) {this.saveOrUpdate()},
        "form.property_garage_4"(newValue) {this.saveOrUpdate()},
        "form.subject_property_pool"(newValue) {this.saveOrUpdate()},
        "form.property_pool_1"(newValue) {this.saveOrUpdate()},
        "form.property_pool_2"(newValue) {this.saveOrUpdate()},
        "form.property_pool_3"(newValue) {this.saveOrUpdate()},
        "form.property_pool_4"(newValue) {this.saveOrUpdate()},
        "form.subject_property_proximity"(newValue) {

            this.form.subject_property_proximity = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_proximity_1"(newValue) {

            this.form.property_proximity_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_proximity_2"(newValue) {

            this.form.property_proximity_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_proximity_3"(newValue) {

            this.form.property_proximity_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_proximity_4"(newValue) {

            this.form.property_proximity_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_date_sold"(newValue) {this.saveOrUpdate()},
        "form.property_date_sold_1"(newValue) {this.saveOrUpdate()},
        "form.property_date_sold_2"(newValue) {this.saveOrUpdate()},
        "form.property_date_sold_3"(newValue) {this.saveOrUpdate()},
        "form.property_date_sold_4"(newValue) {this.saveOrUpdate()},
        "form.subject_property_last_sold_price"(newValue) {

            this.form.subject_property_last_sold_price = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_last_sold_price_1"(newValue) {

            this.form.property_last_sold_price_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_last_sold_price_2"(newValue) {

            this.form.property_last_sold_price_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_last_sold_price_3"(newValue) {

            this.form.property_last_sold_price_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_last_sold_price_4"(newValue) {

            this.form.property_last_sold_price_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_second_last_sold_price"(newValue) {

            this.form.subject_property_second_last_sold_price = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_last_sold_price_1"(newValue) {

            this.form.property_second_last_sold_price_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_last_sold_price_2"(newValue) {

            this.form.property_second_last_sold_price_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_last_sold_price_3"(newValue) {

            this.form.property_second_last_sold_price_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_last_sold_price_4"(newValue) {

            this.form.property_second_last_sold_price_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_second_curb_appeal"(newValue) {

            this.form.subject_property_second_curb_appeal = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_curb_appeal_1"(newValue) {

            this.form.property_second_curb_appeal_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_curb_appeal_2"(newValue) {

            this.form.property_second_curb_appeal_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_curb_appeal_3"(newValue) {

            this.form.property_second_curb_appeal_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_second_curb_appeal_4"(newValue) {

            this.form.property_second_curb_appeal_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_curb_appeal"(newValue) {

            this.form.subject_property_curb_appeal = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_curb_appeal_1"(newValue) {

            this.form.property_curb_appeal_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_curb_appeal_2"(newValue) {

            this.form.property_curb_appeal_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_curb_appeal_3"(newValue) {

            this.form.property_curb_appeal_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_curb_appeal_4"(newValue) {

            this.form.property_curb_appeal_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_interior"(newValue) {

            this.form.subject_property_interior = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_interior_1"(newValue) {

            this.form.property_interior_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_interior_2"(newValue) {

            this.form.property_interior_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_interior_3"(newValue) {

            this.form.property_interior_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_interior_4"(newValue) {

            this.form.property_interior_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_fixtures"(newValue) {

            this.form.subject_property_fixtures = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_fixtures_1"(newValue) {

            this.form.property_fixtures_1 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_fixtures_2"(newValue) {

            this.form.property_fixtures_2 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_fixtures_3"(newValue) {

            this.form.property_fixtures_3 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_fixtures_4"(newValue) {

            this.form.property_fixtures_4 = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.square_footage"(newValue) {

            this.form.square_footage = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.min_square_footage"(newValue) {

            this.form.min_square_footage = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.max_square_footage"(newValue) {

            this.form.max_square_footage = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.property_age"(newValue) {

            this.form.property_age = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.min_year_built"(newValue) {

            this.form.min_year_built = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.max_year_built"(newValue) {

            this.form.max_year_built = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.proximity_to_subject"(newValue) {

            this.form.proximity_to_subject = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.max_days_since_sale"(newValue) {

            this.form.max_days_since_sale = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.avg_sale_price"(newValue) {

            this.form.avg_sale_price = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.lowest_sqft"(newValue) {

            this.form.lowest_sqft = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.average_sqft"(newValue) {

            this.form.average_sqft = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.highest_sqft"(newValue) {

            this.form.highest_sqft = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.range"(newValue) {

            this.form.range = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.suggested_sqft"(newValue) {

            this.form.suggested_sqft = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_sqft"(newValue) {

            this.form.subject_property_sqft = add_commas(newValue)
            this.saveOrUpdate()
        },
        "form.subject_property_sqft_x"(newValue) {

            this.form.subject_property_sqft_x = add_commas(newValue)
            this.saveOrUpdate()
        },
    },
    components: {AuthenticatedLayout, Head, Link, Form, Buttons}
}
</script>

<template>
    <Head>
        <title>Comparative Market Analysis</title>
        <meta property="og:site_name" content="DealHunter">
        <meta property="og:title" content="Comparative Market Analysis Calculator">
        <meta property="og:description" content="Try Out Our Comparative Market Analysis Calculator">
        <meta property="og:image" content="/images/comparitive_market_analysis.png">
        <meta property="og:url" content="{{route('users.calculator.comparative-market-analysis')}}">
    </Head>
    <AuthenticatedLayout>
        <Head title="Renovation Calculator" />
        <template #pageHeading>
            <Buttons :comparatives="buttons" />
        </template>

        <Form :form="form" :count="this.count" />

    </AuthenticatedLayout>
</template>

<style>
.p-button-secondary {
    color: #6c757d!important;
}
</style>
