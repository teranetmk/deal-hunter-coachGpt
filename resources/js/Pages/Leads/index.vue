<script>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue"
import {Head} from '@inertiajs/inertia-vue3';
import axios from 'axios';
import {FilterMatchMode, FilterOperator} from "primevue/api";
import {Link} from "@inertiajs/inertia-vue3";
import "flag-icons/css/flag-icons.min.css";
import {onMounted ,ref} from "vue";
import { useForm, usePage} from '@inertiajs/inertia-vue3';
import ColorPicker from 'primevue/colorpicker';

import moment from 'moment'


onMounted(() => {
    if (!phone_country_code || !phone_country_code.length) {
        phone_country_code = 'us';
        msgphone_country_code = 'us'
    }
})

export default {
    name: "ListsPage",
    props: ['LeadId','allLists','accepted','denied','allOffers', 'lists','LeadCount', 'counterOffers'],
    data() {
        return {
            showLearnHow: false,
            lists_input: null,
            startDate:'',
            endDate: '',
            filterLabel: 'Date',
            credits: usePage().props.value.auth.user.total_credits,
            allListsArr : this.allLists,
            LeadUser : this.LeadId,
            acceptCount : this.accepted,
            deniedCount : this.denied,
            offersCount : this.allOffers,
            counterCount: this.counterOffers,
            lists: this.lists,
            enableOfferCode: '',
            enableCounterOffers: '',
            enableAddPixel: '',
            LeadCount: this.LeadCount,
            displayWebsiteModal1: false,
            displayWebsiteModal2: false,
            displayWebsiteModal3: false,
            displayWebsiteEditModal1: false,
            displayWebsiteEditModal2: false,
            displayWebsiteEditModal3: false,
            verifyStep1 : false,
            verifyStep2 : false,
            verifyStep3 : false,
            leadMachine: {companyName : null, logoImage : null, phoneNo: null, email: null, buisnessAddress: null, zipCode: null, state: null, city: null, headline: null, subHeadline: null, domain: null, msgPhone: null, lists_input: [], color: '#000000'},
            editLogo: null,
            leadBeingEdited  : {
                "company_name" : null,
                "lists_input" : null,
                "logo" : null,
                "phone" : null,
                "email" : null,
                "buisness_address" : null,
                "city" : null,
                "state" : null,
                "zip_code" : null,
                "headline" : null,
                "sub_headline" : null,
                "domain" : null,
                "sms_number" : null,
                "phone_code" : null,
                "smsphone_code" : null,
                "enable_offer_code": this.LeadId.enable_offer_code,
                "enable_counter_offer": this.LeadId.enable_counter_offer,
                "enable_ad_pixel": this.LeadId.enable_ad_pixel,
                "pixel_code":  this.LeadId.pixel_code,
                "color": this.LeadId.color,
            },
            countries: [
                {
                    "capital": "Pago Pago",
                    "code": "+1-684",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/as.svg",
                    "flag_4x3": "flags/4x3/as.svg",
                    "iso": true,
                    "name": "American Samoa"
                },
                {
                    "capital": "Andorra la Vella",
                    "code": "+376",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ad.svg",
                    "flag_4x3": "flags/4x3/ad.svg",
                    "iso": true,
                    "name": "Andorra"
                },
                {
                    "capital": "Luanda",
                    "code": "+244",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ao.svg",
                    "flag_4x3": "flags/4x3/ao.svg",
                    "iso": true,
                    "name": "Angola"
                },
                {
                    "capital": "The Valley",
                    "code": "+1-264",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/ai.svg",
                    "flag_4x3": "flags/4x3/ai.svg",
                    "iso": true,
                    "name": "Anguilla"
                },
                {
                    "code": "+672",
                    "flag_1x1": "flags/1x1/aq.svg",
                    "flag_4x3": "flags/4x3/aq.svg",
                    "iso": true,
                    "name": "Antarctica"
                },
                {
                    "capital": "St. John's",
                    "code": "+1-268",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/ag.svg",
                    "flag_4x3": "flags/4x3/ag.svg",
                    "iso": true,
                    "name": "Antigua and Barbuda"
                },
                {
                    "capital": "Buenos Aires",
                    "code": "+54",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/ar.svg",
                    "flag_4x3": "flags/4x3/ar.svg",
                    "iso": true,
                    "name": "Argentina"
                },
                {
                    "capital": "Yerevan",
                    "code": "+374",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/am.svg",
                    "flag_4x3": "flags/4x3/am.svg",
                    "iso": true,
                    "name": "Armenia"
                },
                {
                    "capital": "Oranjestad",
                    "code": "+297",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/aw.svg",
                    "flag_4x3": "flags/4x3/aw.svg",
                    "iso": true,
                    "name": "Aruba"
                },

                {
                    "capital": "Canberra",
                    "code": "+61",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/au.svg",
                    "flag_4x3": "flags/4x3/au.svg",
                    "iso": true,
                    "name": "Australia"
                },
                {
                    "capital": "Vienna",
                    "code": "+43",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/at.svg",
                    "flag_4x3": "flags/4x3/at.svg",
                    "iso": true,
                    "name": "Austria"
                },
                {
                    "capital": "Baku",
                    "code": "+994",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/az.svg",
                    "flag_4x3": "flags/4x3/az.svg",
                    "iso": true,
                    "name": "Azerbaijan"
                },
                {
                    "capital": "Nassau",
                    "code": "+1-242",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/bs.svg",
                    "flag_4x3": "flags/4x3/bs.svg",
                    "iso": true,
                    "name": "Bahamas"
                },
                {
                    "capital": "Manama",
                    "code": "+73",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/bh.svg",
                    "flag_4x3": "flags/4x3/bh.svg",
                    "iso": true,
                    "name": "Bahrain"
                },
                {
                    "capital": "Dhaka",
                    "code": "+880",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/bd.svg",
                    "flag_4x3": "flags/4x3/bd.svg",
                    "iso": true,
                    "name": "Bangladesh"
                },
                {
                    "capital": "Bridgetown",
                    "code": "+1-246",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/bb.svg",
                    "flag_4x3": "flags/4x3/bb.svg",
                    "iso": true,
                    "name": "Barbados"
                },
                {
                    "capital": "Minsk",
                    "code": "+375",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/by.svg",
                    "flag_4x3": "flags/4x3/by.svg",
                    "iso": true,
                    "name": "Belarus"
                },
                {
                    "capital": "Brussels",
                    "code": "+32",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/be.svg",
                    "flag_4x3": "flags/4x3/be.svg",
                    "iso": true,
                    "name": "Belgium"
                },
                {
                    "capital": "Belmopan",
                    "code": "+501",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/bz.svg",
                    "flag_4x3": "flags/4x3/bz.svg",
                    "iso": true,
                    "name": "Belize"
                },
                {
                    "capital": "Porto-Novo",
                    "code": "+229",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/bj.svg",
                    "flag_4x3": "flags/4x3/bj.svg",
                    "iso": true,
                    "name": "Benin"
                },
                {
                    "capital": "Hamilton",
                    "code": "+1-441",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/bm.svg",
                    "flag_4x3": "flags/4x3/bm.svg",
                    "iso": true,
                    "name": "Bermuda"
                },
                {
                    "capital": "Thimphu",
                    "code": "+975",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/bt.svg",
                    "flag_4x3": "flags/4x3/bt.svg",
                    "iso": true,
                    "name": "Bhutan"
                },
                {
                    "capital": "Sucre",
                    "code": "+591",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/bo.svg",
                    "flag_4x3": "flags/4x3/bo.svg",
                    "iso": true,
                    "name": "Bolivia"
                },
                {
                    "capital": "Gaborone",
                    "code": "+267",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/bw.svg",
                    "flag_4x3": "flags/4x3/bw.svg",
                    "iso": true,
                    "name": "Botswana"
                },
                {
                    "capital": "Brasília",
                    "code": "+55",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/br.svg",
                    "flag_4x3": "flags/4x3/br.svg",
                    "iso": true,
                    "name": "Brazil"
                },

                {
                    "capital": "Bandar Seri Begawan",
                    "code": "+673",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/bn.svg",
                    "flag_4x3": "flags/4x3/bn.svg",
                    "iso": true,
                    "name": "Brunei Darussalam"
                },
                {
                    "capital": "Sofia",
                    "code": "+359",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/bg.svg",
                    "flag_4x3": "flags/4x3/bg.svg",
                    "iso": true,
                    "name": "Bulgaria"
                },
                {
                    "capital": "Ouagadougou",
                    "code": "+226",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/bf.svg",
                    "flag_4x3": "flags/4x3/bf.svg",
                    "iso": true,
                    "name": "Burkina Faso"
                },
                {
                    "capital": "Bujumbura",
                    "code": "+257",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/bi.svg",
                    "flag_4x3": "flags/4x3/bi.svg",
                    "iso": true,
                    "name": "Burundi"
                },
                {
                    "capital": "Praia",
                    "code": "+238",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/cv.svg",
                    "flag_4x3": "flags/4x3/cv.svg",
                    "iso": true,
                    "name": "Cabo Verde"
                },
                {
                    "capital": "Phnom Penh",
                    "code": "+855",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/kh.svg",
                    "flag_4x3": "flags/4x3/kh.svg",
                    "iso": true,
                    "name": "Cambodia"
                },
                {
                    "capital": "Yaoundé",
                    "code": "+237",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/cm.svg",
                    "flag_4x3": "flags/4x3/cm.svg",
                    "iso": true,
                    "name": "Cameroon"
                },
                {
                    "capital": "Ottawa",
                    "code": "+1",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/ca.svg",
                    "flag_4x3": "flags/4x3/ca.svg",
                    "iso": true,
                    "name": "Canada"
                },

                {
                    "capital": "Beijing",
                    "code": "+86",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/cn.svg",
                    "flag_4x3": "flags/4x3/cn.svg",
                    "iso": true,
                    "name": "China"
                },
                {
                    "capital": "Flying Fish Cove",
                    "code": "+61",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/cx.svg",
                    "flag_4x3": "flags/4x3/cx.svg",
                    "iso": true,
                    "name": "Christmas Island"
                },
                {
                    "capital": "Bogotá",
                    "code": "+57",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/co.svg",
                    "flag_4x3": "flags/4x3/co.svg",
                    "iso": true,
                    "name": "Colombia"
                },
                {
                    "capital": "Moroni",
                    "code": "+269",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/km.svg",
                    "flag_4x3": "flags/4x3/km.svg",
                    "iso": true,
                    "name": "Comoros"
                },
                {
                    "capital": "Avarua",
                    "code": "+61",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/ck.svg",
                    "flag_4x3": "flags/4x3/ck.svg",
                    "iso": true,
                    "name": "Cook Islands"
                },
                {
                    "capital": "San José",
                    "code": "+506",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/cr.svg",
                    "flag_4x3": "flags/4x3/cr.svg",
                    "iso": true,
                    "name": "Costa Rica"
                },
                {
                    "capital": "Zagreb",
                    "code": "+385",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/hr.svg",
                    "flag_4x3": "flags/4x3/hr.svg",
                    "iso": true,
                    "name": "Croatia"
                },
                {
                    "capital": "Havana",
                    "code": "+53",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/cu.svg",
                    "flag_4x3": "flags/4x3/cu.svg",
                    "iso": true,
                    "name": "Cuba"
                },
                {
                    "capital": "Copenhagen",
                    "code": "+45",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/dk.svg",
                    "flag_4x3": "flags/4x3/dk.svg",
                    "iso": true,
                    "name": "Denmark"
                },
                {
                    "capital": "Djibouti",
                    "code": "+253",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/dj.svg",
                    "flag_4x3": "flags/4x3/dj.svg",
                    "iso": true,
                    "name": "Djibouti"
                },
                {
                    "capital": "Roseau",
                    "code": "+1-767",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/dm.svg",
                    "flag_4x3": "flags/4x3/dm.svg",
                    "iso": true,
                    "name": "Dominica"
                },
                {
                    "capital": "Quito",
                    "code": "+593",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/ec.svg",
                    "flag_4x3": "flags/4x3/ec.svg",
                    "iso": true,
                    "name": "Ecuador"
                },
                {
                    "capital": "Cairo",
                    "code": "+20",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/eg.svg",
                    "flag_4x3": "flags/4x3/eg.svg",
                    "iso": true,
                    "name": "Egypt"
                },
                {
                    "capital": "San Salvador",
                    "code": "+503",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/sv.svg",
                    "flag_4x3": "flags/4x3/sv.svg",
                    "iso": true,
                    "name": "El Salvador"
                },
                {
                    "capital": "Malabo",
                    "code": "+240",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/gq.svg",
                    "flag_4x3": "flags/4x3/gq.svg",
                    "iso": true,
                    "name": "Equatorial Guinea"
                },
                {
                    "capital": "Asmara",
                    "code": "+291",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/er.svg",
                    "flag_4x3": "flags/4x3/er.svg",
                    "iso": true,
                    "name": "Eritrea"
                },
                {
                    "capital": "Tallinn",
                    "code": "+372",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ee.svg",
                    "flag_4x3": "flags/4x3/ee.svg",
                    "iso": true,
                    "name": "Estonia"
                },
                {
                    "capital": "Addis Ababa",
                    "code": "+251",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/et.svg",
                    "flag_4x3": "flags/4x3/et.svg",
                    "iso": true,
                    "name": "Ethiopia"
                },
                {
                    "capital": "Stanley",
                    "code": "+500",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/fk.svg",
                    "flag_4x3": "flags/4x3/fk.svg",
                    "iso": true,
                    "name": "Falkland Islands"
                },
                {
                    "capital": "Tórshavn",
                    "code": "+298",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/fo.svg",
                    "flag_4x3": "flags/4x3/fo.svg",
                    "iso": true,
                    "name": "Faroe Islands"
                },
                {
                    "capital": "Suva",
                    "code": "+679",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/fj.svg",
                    "flag_4x3": "flags/4x3/fj.svg",
                    "iso": true,
                    "name": "Fiji"
                },
                {
                    "capital": "Helsinki",
                    "code": "+358",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/fi.svg",
                    "flag_4x3": "flags/4x3/fi.svg",
                    "iso": true,
                    "name": "Finland"
                },
                {
                    "capital": "Paris",
                    "code": "+33",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/fr.svg",
                    "flag_4x3": "flags/4x3/fr.svg",
                    "iso": true,
                    "name": "France"
                },

                {
                    "capital": "Papeete",
                    "code": "+689",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/pf.svg",
                    "flag_4x3": "flags/4x3/pf.svg",
                    "iso": true,
                    "name": "French Polynesia"
                },

                {
                    "capital": "Libreville",
                    "code": "+241",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ga.svg",
                    "flag_4x3": "flags/4x3/ga.svg",
                    "iso": true,
                    "name": "Gabon"
                },

                {
                    "capital": "Banjul",
                    "code": "+220",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/gm.svg",
                    "flag_4x3": "flags/4x3/gm.svg",
                    "iso": true,
                    "name": "Gambia"
                },
                {
                    "capital": "Tbilisi",
                    "code": "+995",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/ge.svg",
                    "flag_4x3": "flags/4x3/ge.svg",
                    "iso": true,
                    "name": "Georgia"
                },
                {
                    "capital": "Berlin",
                    "code": "+49",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/de.svg",
                    "flag_4x3": "flags/4x3/de.svg",
                    "iso": true,
                    "name": "Germany"
                },
                {
                    "capital": "Accra",
                    "code": "+233",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/gh.svg",
                    "flag_4x3": "flags/4x3/gh.svg",
                    "iso": true,
                    "name": "Ghana"
                },
                {
                    "capital": "Gibraltar",
                    "code": "+350",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/gi.svg",
                    "flag_4x3": "flags/4x3/gi.svg",
                    "iso": true,
                    "name": "Gibraltar"
                },
                {
                    "capital": "Athens",
                    "code": "+30",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/gr.svg",
                    "flag_4x3": "flags/4x3/gr.svg",
                    "iso": true,
                    "name": "Greece"
                },
                {
                    "capital": "Nuuk",
                    "code": "gl",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/gl.svg",
                    "flag_4x3": "flags/4x3/gl.svg",
                    "iso": true,
                    "name": "Greenland"
                },
                {
                    "capital": "St. George's",
                    "code": "+299",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/gd.svg",
                    "flag_4x3": "flags/4x3/gd.svg",
                    "iso": true,
                    "name": "Grenada"
                },

                {
                    "capital": "Hagåtña",
                    "code": "+1-671",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/gu.svg",
                    "flag_4x3": "flags/4x3/gu.svg",
                    "iso": true,
                    "name": "Guam"
                },
                {
                    "capital": "Guatemala City",
                    "code": "+502",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/gt.svg",
                    "flag_4x3": "flags/4x3/gt.svg",
                    "iso": true,
                    "name": "Guatemala"
                },
                {
                    "capital": "Saint Peter Port",
                    "code": "+44-1481",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/gg.svg",
                    "flag_4x3": "flags/4x3/gg.svg",
                    "iso": true,
                    "name": "Guernsey"
                },
                {
                    "capital": "Conakry",
                    "code": "+224",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/gn.svg",
                    "flag_4x3": "flags/4x3/gn.svg",
                    "iso": true,
                    "name": "Guinea"
                },
                {
                    "capital": "Bissau",
                    "code": "+245",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/gw.svg",
                    "flag_4x3": "flags/4x3/gw.svg",
                    "iso": true,
                    "name": "Guinea-Bissau"
                },
                {
                    "capital": "Georgetown",
                    "code": "+592",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/gy.svg",
                    "flag_4x3": "flags/4x3/gy.svg",
                    "iso": true,
                    "name": "Guyana"
                },
                {
                    "capital": "Port-au-Prince",
                    "code": "+509",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/ht.svg",
                    "flag_4x3": "flags/4x3/ht.svg",
                    "iso": true,
                    "name": "Haiti"
                },

                {
                    "capital": "Tegucigalpa",
                    "code": "+504",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/hn.svg",
                    "flag_4x3": "flags/4x3/hn.svg",
                    "iso": true,
                    "name": "Honduras"
                },
                {
                    "capital": "Hong Kong",
                    "code": "+852",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/hk.svg",
                    "flag_4x3": "flags/4x3/hk.svg",
                    "iso": true,
                    "name": "Hong Kong"
                },
                {
                    "capital": "Budapest",
                    "code": "+36",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/hu.svg",
                    "flag_4x3": "flags/4x3/hu.svg",
                    "iso": true,
                    "name": "Hungary"
                },
                {
                    "capital": "Reykjavik",
                    "code": "+354",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/is.svg",
                    "flag_4x3": "flags/4x3/is.svg",
                    "iso": true,
                    "name": "Iceland"
                },
                {
                    "capital": "New Delhi",
                    "code": "+91",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/in.svg",
                    "flag_4x3": "flags/4x3/in.svg",
                    "iso": true,
                    "name": "India"
                },
                {
                    "capital": "Jakarta",
                    "code": "+62",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/id.svg",
                    "flag_4x3": "flags/4x3/id.svg",
                    "iso": true,
                    "name": "Indonesia"
                },
                {
                    "capital": "Tehran",
                    "code": "+98",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/ir.svg",
                    "flag_4x3": "flags/4x3/ir.svg",
                    "iso": true,
                    "name": "Iran"
                },
                {
                    "capital": "Baghdad",
                    "code": "+964",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/iq.svg",
                    "flag_4x3": "flags/4x3/iq.svg",
                    "iso": true,
                    "name": "Iraq"
                },
                {
                    "capital": "Dublin",
                    "code": "+353",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ie.svg",
                    "flag_4x3": "flags/4x3/ie.svg",
                    "iso": true,
                    "name": "Ireland"
                },
                {
                    "capital": "Douglas",
                    "code": "+44-1624",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/im.svg",
                    "flag_4x3": "flags/4x3/im.svg",
                    "iso": true,
                    "name": "Isle of Man"
                },
                {
                    "capital": "Jerusalem",
                    "code": "+972",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/il.svg",
                    "flag_4x3": "flags/4x3/il.svg",
                    "iso": true,
                    "name": "Israel"
                },
                {
                    "capital": "Rome",
                    "code": "+39",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/it.svg",
                    "flag_4x3": "flags/4x3/it.svg",
                    "iso": true,
                    "name": "Italy"
                },
                {
                    "capital": "Kingston",
                    "code": "+1-876",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/jm.svg",
                    "flag_4x3": "flags/4x3/jm.svg",
                    "iso": true,
                    "name": "Jamaica"
                },
                {
                    "capital": "Tokyo",
                    "code": "+81",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/jp.svg",
                    "flag_4x3": "flags/4x3/jp.svg",
                    "iso": true,
                    "name": "Japan"
                },
                {
                    "capital": "Saint Helier",
                    "code": "+44-1534",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/je.svg",
                    "flag_4x3": "flags/4x3/je.svg",
                    "iso": true,
                    "name": "Jersey"
                },
                {
                    "capital": "Amman",
                    "code": "+962",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/jo.svg",
                    "flag_4x3": "flags/4x3/jo.svg",
                    "iso": true,
                    "name": "Jordan"
                },
                {
                    "capital": "Astana",
                    "code": "+7",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/kz.svg",
                    "flag_4x3": "flags/4x3/kz.svg",
                    "iso": true,
                    "name": "Kazakhstan"
                },
                {
                    "capital": "Nairobi",
                    "code": "+254",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ke.svg",
                    "flag_4x3": "flags/4x3/ke.svg",
                    "iso": true,
                    "name": "Kenya"
                },
                {
                    "capital": "South Tarawa",
                    "code": "+686",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/ki.svg",
                    "flag_4x3": "flags/4x3/ki.svg",
                    "iso": true,
                    "name": "Kiribati"
                },
                {
                    "capital": "Pristina",
                    "code": "+383",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/xk.svg",
                    "flag_4x3": "flags/4x3/xk.svg",
                    "iso": false,
                    "name": "Kosovo"
                },
                {
                    "capital": "Kuwait City",
                    "code": "+965",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/kw.svg",
                    "flag_4x3": "flags/4x3/kw.svg",
                    "iso": true,
                    "name": "Kuwait"
                },
                {
                    "capital": "Bishkek",
                    "code": "+996",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/kg.svg",
                    "flag_4x3": "flags/4x3/kg.svg",
                    "iso": true,
                    "name": "Kyrgyzstan"
                },
                {
                    "capital": "Vientiane",
                    "code": "+856",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/la.svg",
                    "flag_4x3": "flags/4x3/la.svg",
                    "iso": true,
                    "name": "Laos"
                },
                {
                    "capital": "Riga",
                    "code": "+371",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/lv.svg",
                    "flag_4x3": "flags/4x3/lv.svg",
                    "iso": true,
                    "name": "Latvia"
                },
                {
                    "capital": "Beirut",
                    "code": "+961",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/lb.svg",
                    "flag_4x3": "flags/4x3/lb.svg",
                    "iso": true,
                    "name": "Lebanon"
                },
                {
                    "capital": "Maseru",
                    "code": "+266",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ls.svg",
                    "flag_4x3": "flags/4x3/ls.svg",
                    "iso": true,
                    "name": "Lesotho"
                },
                {
                    "capital": "Monrovia",
                    "code": "+231",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/lr.svg",
                    "flag_4x3": "flags/4x3/lr.svg",
                    "iso": true,
                    "name": "Liberia"
                },
                {
                    "capital": "Tripoli",
                    "code": "+218",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ly.svg",
                    "flag_4x3": "flags/4x3/ly.svg",
                    "iso": true,
                    "name": "Libya"
                },
                {
                    "capital": "Vaduz",
                    "code": "+423",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/li.svg",
                    "flag_4x3": "flags/4x3/li.svg",
                    "iso": true,
                    "name": "Liechtenstein"
                },
                {
                    "capital": "Vilnius",
                    "code": "+370",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/lt.svg",
                    "flag_4x3": "flags/4x3/lt.svg",
                    "iso": true,
                    "name": "Lithuania"
                },
                {
                    "capital": "Luxembourg City",
                    "code": "+352",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/lu.svg",
                    "flag_4x3": "flags/4x3/lu.svg",
                    "iso": true,
                    "name": "Luxembourg"
                },
                {
                    "capital": "Macau",
                    "code": "+853",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/mo.svg",
                    "flag_4x3": "flags/4x3/mo.svg",
                    "iso": true,
                    "name": "Macau"
                },
                {
                    "capital": "Antananarivo",
                    "code": "+261",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/mg.svg",
                    "flag_4x3": "flags/4x3/mg.svg",
                    "iso": true,
                    "name": "Madagascar"
                },
                {
                    "capital": "Lilongwe",
                    "code": "+265",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/mw.svg",
                    "flag_4x3": "flags/4x3/mw.svg",
                    "iso": true,
                    "name": "Malawi"
                },
                {
                    "capital": "Kuala Lumpur",
                    "code": "+60",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/my.svg",
                    "flag_4x3": "flags/4x3/my.svg",
                    "iso": true,
                    "name": "Malaysia"
                },
                {
                    "capital": "Malé",
                    "code": "+960",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/mv.svg",
                    "flag_4x3": "flags/4x3/mv.svg",
                    "iso": true,
                    "name": "Maldives"
                },
                {
                    "capital": "Bamako",
                    "code": "+223",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ml.svg",
                    "flag_4x3": "flags/4x3/ml.svg",
                    "iso": true,
                    "name": "Mali"
                },
                {
                    "capital": "Valletta",
                    "code": "+356",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/mt.svg",
                    "flag_4x3": "flags/4x3/mt.svg",
                    "iso": true,
                    "name": "Malta"
                },
                {
                    "capital": "Majuro",
                    "code": "+692",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/mh.svg",
                    "flag_4x3": "flags/4x3/mh.svg",
                    "iso": true,
                    "name": "Marshall Islands"
                },

                {
                    "capital": "Nouakchott",
                    "code": "+222",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/mr.svg",
                    "flag_4x3": "flags/4x3/mr.svg",
                    "iso": true,
                    "name": "Mauritania"
                },
                {
                    "capital": "Port Louis",
                    "code": "+230",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/mu.svg",
                    "flag_4x3": "flags/4x3/mu.svg",
                    "iso": true,
                    "name": "Mauritius"
                },
                {
                    "capital": "Mamoudzou",
                    "code": "+262",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/yt.svg",
                    "flag_4x3": "flags/4x3/yt.svg",
                    "iso": true,
                    "name": "Mayotte"
                },
                {
                    "capital": "Mexico City",
                    "code": "+52",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/mx.svg",
                    "flag_4x3": "flags/4x3/mx.svg",
                    "iso": true,
                    "name": "Mexico"
                },
                {
                    "capital": "Chișinău",
                    "code": "+373",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/md.svg",
                    "flag_4x3": "flags/4x3/md.svg",
                    "iso": true,
                    "name": "Moldova"
                },
                {
                    "capital": "Monaco",
                    "code": "+377",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/mc.svg",
                    "flag_4x3": "flags/4x3/mc.svg",
                    "iso": true,
                    "name": "Monaco"
                },
                {
                    "capital": "Ulaanbaatar",
                    "code": "+976",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/mn.svg",
                    "flag_4x3": "flags/4x3/mn.svg",
                    "iso": true,
                    "name": "Mongolia"
                },
                {
                    "capital": "Podgorica",
                    "code": "+382",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/me.svg",
                    "flag_4x3": "flags/4x3/me.svg",
                    "iso": true,
                    "name": "Montenegro"
                },
                {
                    "capital": "Little Bay, Brades, Plymouth",
                    "code": "+1-664",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/ms.svg",
                    "flag_4x3": "flags/4x3/ms.svg",
                    "iso": true,
                    "name": "Montserrat"
                },
                {
                    "capital": "Rabat",
                    "code": "+212",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ma.svg",
                    "flag_4x3": "flags/4x3/ma.svg",
                    "iso": true,
                    "name": "Morocco"
                },
                {
                    "capital": "Maputo",
                    "code": "+258",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/mz.svg",
                    "flag_4x3": "flags/4x3/mz.svg",
                    "iso": true,
                    "name": "Mozambique"
                },
                {
                    "capital": "Naypyidaw",
                    "code": "+95",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/mm.svg",
                    "flag_4x3": "flags/4x3/mm.svg",
                    "iso": true,
                    "name": "Myanmar"
                },
                {
                    "capital": "Windhoek",
                    "code": "+264",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/na.svg",
                    "flag_4x3": "flags/4x3/na.svg",
                    "iso": true,
                    "name": "Namibia"
                },
                {
                    "capital": "Yaren District",
                    "code": "+674",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/nr.svg",
                    "flag_4x3": "flags/4x3/nr.svg",
                    "iso": true,
                    "name": "Nauru"
                },
                {
                    "capital": "Kathmandu",
                    "code": "+977",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/np.svg",
                    "flag_4x3": "flags/4x3/np.svg",
                    "iso": true,
                    "name": "Nepal"
                },
                {
                    "capital": "Amsterdam",
                    "code": "+31",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/nl.svg",
                    "flag_4x3": "flags/4x3/nl.svg",
                    "iso": true,
                    "name": "Netherlands"
                },
                {
                    "capital": "Nouméa",
                    "code": "+687",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/nc.svg",
                    "flag_4x3": "flags/4x3/nc.svg",
                    "iso": true,
                    "name": "New Caledonia"
                },
                {
                    "capital": "Wellington",
                    "code": "+64",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/nz.svg",
                    "flag_4x3": "flags/4x3/nz.svg",
                    "iso": true,
                    "name": "New Zealand"
                },
                {
                    "capital": "Managua",
                    "code": "+505",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/ni.svg",
                    "flag_4x3": "flags/4x3/ni.svg",
                    "iso": true,
                    "name": "Nicaragua"
                },
                {
                    "capital": "Niamey",
                    "code": "+227",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ne.svg",
                    "flag_4x3": "flags/4x3/ne.svg",
                    "iso": true,
                    "name": "Niger"
                },
                {
                    "capital": "Abuja",
                    "code": "+234",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ng.svg",
                    "flag_4x3": "flags/4x3/ng.svg",
                    "iso": true,
                    "name": "Nigeria"
                },
                {
                    "capital": "Alofi",
                    "code": "+683",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/nu.svg",
                    "flag_4x3": "flags/4x3/nu.svg",
                    "iso": true,
                    "name": "Niue"
                },

                {
                    "capital": "Pyongyang",
                    "code": "+850",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/kp.svg",
                    "flag_4x3": "flags/4x3/kp.svg",
                    "iso": true,
                    "name": "North Korea"
                },

                {
                    "capital": "Saipan",
                    "code": "+1-670",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/mp.svg",
                    "flag_4x3": "flags/4x3/mp.svg",
                    "iso": true,
                    "name": "Northern Mariana Islands"
                },
                {
                    "capital": "Oslo",
                    "code": "+47",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/no.svg",
                    "flag_4x3": "flags/4x3/no.svg",
                    "iso": true,
                    "name": "Norway"
                },
                {
                    "capital": "Muscat",
                    "code": "+968",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/om.svg",
                    "flag_4x3": "flags/4x3/om.svg",
                    "iso": true,
                    "name": "Oman"
                },
                {
                    "capital": "Islamabad",
                    "code": "+92",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/pk.svg",
                    "flag_4x3": "flags/4x3/pk.svg",
                    "iso": true,
                    "name": "Pakistan"
                },
                {
                    "capital": "Ngerulmud",
                    "code": "+680",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/pw.svg",
                    "flag_4x3": "flags/4x3/pw.svg",
                    "iso": true,
                    "name": "Palau"
                },
                {
                    "capital": "Panama City",
                    "code": "+507",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/pa.svg",
                    "flag_4x3": "flags/4x3/pa.svg",
                    "iso": true,
                    "name": "Panama"
                },
                {
                    "capital": "Port Moresby",
                    "code": "+675",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/pg.svg",
                    "flag_4x3": "flags/4x3/pg.svg",
                    "iso": true,
                    "name": "Papua New Guinea"
                },
                {
                    "capital": "Asunción",
                    "code": "+595",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/py.svg",
                    "flag_4x3": "flags/4x3/py.svg",
                    "iso": true,
                    "name": "Paraguay"
                },
                {
                    "capital": "Lima",
                    "code": "+51",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/pe.svg",
                    "flag_4x3": "flags/4x3/pe.svg",
                    "iso": true,
                    "name": "Peru"
                },
                {
                    "capital": "Manila",
                    "code": "+63",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/ph.svg",
                    "flag_4x3": "flags/4x3/ph.svg",
                    "iso": true,
                    "name": "Philippines"
                },
                {
                    "capital": "Adamstown",
                    "code": "+64",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/pn.svg",
                    "flag_4x3": "flags/4x3/pn.svg",
                    "iso": true,
                    "name": "Pitcairn"
                },
                {
                    "capital": "Warsaw",
                    "code": "+48",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/pl.svg",
                    "flag_4x3": "flags/4x3/pl.svg",
                    "iso": true,
                    "name": "Poland"
                },
                {
                    "capital": "Lisbon",
                    "code": "+351",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/pt.svg",
                    "flag_4x3": "flags/4x3/pt.svg",
                    "iso": true,
                    "name": "Portugal"
                },
                {
                    "capital": "San Juan",
                    "code": "+1-787",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/pr.svg",
                    "flag_4x3": "flags/4x3/pr.svg",
                    "iso": true,
                    "name": "Puerto Rico"
                },
                {
                    "capital": "Doha",
                    "code": "+974",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/qa.svg",
                    "flag_4x3": "flags/4x3/qa.svg",
                    "iso": true,
                    "name": "Qatar"
                },
                {
                    "capital": "Brazzaville",
                    "code": "+242",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/cg.svg",
                    "flag_4x3": "flags/4x3/cg.svg",
                    "iso": true,
                    "name": "Republic of the Congo"
                },
                {
                    "capital": "Bucharest",
                    "code": "+40",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ro.svg",
                    "flag_4x3": "flags/4x3/ro.svg",
                    "iso": true,
                    "name": "Romania"
                },
                {
                    "capital": "Moscow",
                    "code": "+7",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ru.svg",
                    "flag_4x3": "flags/4x3/ru.svg",
                    "iso": true,
                    "name": "Russia"
                },
                {
                    "capital": "Kigali",
                    "code": "+250",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/rw.svg",
                    "flag_4x3": "flags/4x3/rw.svg",
                    "iso": true,
                    "name": "Rwanda"
                },
                {
                    "capital": "Saint-Denis",
                    "code": "+262",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/re.svg",
                    "flag_4x3": "flags/4x3/re.svg",
                    "iso": true,
                    "name": "Réunion"
                },
                {
                    "capital": "Gustavia",
                    "code": "+590",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/bl.svg",
                    "flag_4x3": "flags/4x3/bl.svg",
                    "iso": true,
                    "name": "Saint Barthélemy"
                },

                {
                    "capital": "Basseterre",
                    "code": "+1-869",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/kn.svg",
                    "flag_4x3": "flags/4x3/kn.svg",
                    "iso": true,
                    "name": "Saint Kitts and Nevis"
                },
                {
                    "capital": "Castries",
                    "code": "+1-758",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/lc.svg",
                    "flag_4x3": "flags/4x3/lc.svg",
                    "iso": true,
                    "name": "Saint Lucia"
                },
                {
                    "capital": "Marigot",
                    "code": "+590",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/mf.svg",
                    "flag_4x3": "flags/4x3/mf.svg",
                    "iso": true,
                    "name": "Saint Martin"
                },
                {
                    "capital": "Saint-Pierre",
                    "code": "+508",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/pm.svg",
                    "flag_4x3": "flags/4x3/pm.svg",
                    "iso": true,
                    "name": "Saint Pierre and Miquelon"
                },
                {
                    "capital": "Kingstown",
                    "code": "+1-784",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/vc.svg",
                    "flag_4x3": "flags/4x3/vc.svg",
                    "iso": true,
                    "name": "Saint Vincent and the Grenadines"
                },
                {
                    "capital": "Apia",
                    "code": "+685",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/ws.svg",
                    "flag_4x3": "flags/4x3/ws.svg",
                    "iso": true,
                    "name": "Samoa"
                },
                {
                    "capital": "San Marino",
                    "code": "+378",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/sm.svg",
                    "flag_4x3": "flags/4x3/sm.svg",
                    "iso": true,
                    "name": "San Marino"
                },
                {
                    "capital": "São Tomé",
                    "code": "+239",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/st.svg",
                    "flag_4x3": "flags/4x3/st.svg",
                    "iso": true,
                    "name": "Sao Tome and Principe"
                },
                {
                    "capital": "Riyadh",
                    "code": "+966",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/sa.svg",
                    "flag_4x3": "flags/4x3/sa.svg",
                    "iso": true,
                    "name": "Saudi Arabia"
                },

                {
                    "capital": "Dakar",
                    "code": "+221",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/sn.svg",
                    "flag_4x3": "flags/4x3/sn.svg",
                    "iso": true,
                    "name": "Senegal"
                },
                {
                    "capital": "Belgrade",
                    "code": "+381",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/rs.svg",
                    "flag_4x3": "flags/4x3/rs.svg",
                    "iso": true,
                    "name": "Serbia"
                },
                {
                    "capital": "Victoria",
                    "code": "+248",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/sc.svg",
                    "flag_4x3": "flags/4x3/sc.svg",
                    "iso": true,
                    "name": "Seychelles"
                },
                {
                    "capital": "Freetown",
                    "code": "+232",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/sl.svg",
                    "flag_4x3": "flags/4x3/sl.svg",
                    "iso": true,
                    "name": "Sierra Leone"
                },
                {
                    "capital": "Singapore",
                    "code": "+65",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/sg.svg",
                    "flag_4x3": "flags/4x3/sg.svg",
                    "iso": true,
                    "name": "Singapore"
                },
                {
                    "capital": "Philipsburg",
                    "code": "+590",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/sx.svg",
                    "flag_4x3": "flags/4x3/sx.svg",
                    "iso": true,
                    "name": "Sint Maarten"
                },
                {
                    "capital": "Bratislava",
                    "code": "+421",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/sk.svg",
                    "flag_4x3": "flags/4x3/sk.svg",
                    "iso": true,
                    "name": "Slovakia"
                },
                {
                    "capital": "Ljubljana",
                    "code": "+386",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/si.svg",
                    "flag_4x3": "flags/4x3/si.svg",
                    "iso": true,
                    "name": "Slovenia"
                },
                {
                    "capital": "Honiara",
                    "code": "+677",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/sb.svg",
                    "flag_4x3": "flags/4x3/sb.svg",
                    "iso": true,
                    "name": "Solomon Islands"
                },
                {
                    "capital": "Mogadishu",
                    "code": "+252",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/so.svg",
                    "flag_4x3": "flags/4x3/so.svg",
                    "iso": true,
                    "name": "Somalia"
                },
                {
                    "capital": "Pretoria",
                    "code": "+27",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/za.svg",
                    "flag_4x3": "flags/4x3/za.svg",
                    "iso": true,
                    "name": "South Africa"
                },

                {
                    "capital": "Seoul",
                    "code": "+82",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/kr.svg",
                    "flag_4x3": "flags/4x3/kr.svg",
                    "iso": true,
                    "name": "South Korea"
                },
                {
                    "capital": "Juba",
                    "code": "+211",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ss.svg",
                    "flag_4x3": "flags/4x3/ss.svg",
                    "iso": true,
                    "name": "South Sudan"
                },
                {
                    "capital": "Madrid",
                    "code": "+34",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/es.svg",
                    "flag_4x3": "flags/4x3/es.svg",
                    "iso": true,
                    "name": "Spain"
                },
                {
                    "capital": "Sri Jayawardenepura Kotte, Colombo",
                    "code": "+94",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/lk.svg",
                    "flag_4x3": "flags/4x3/lk.svg",
                    "iso": true,
                    "name": "Sri Lanka"
                },

                {
                    "capital": "Khartoum",
                    "code": "+249",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/sd.svg",
                    "flag_4x3": "flags/4x3/sd.svg",
                    "iso": true,
                    "name": "Sudan"
                },
                {
                    "capital": "Paramaribo",
                    "code": "+597",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/sr.svg",
                    "flag_4x3": "flags/4x3/sr.svg",
                    "iso": true,
                    "name": "Suriname"
                },
                {
                    "capital": "Longyearbyen",
                    "code": "+47",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/sj.svg",
                    "flag_4x3": "flags/4x3/sj.svg",
                    "iso": true,
                    "name": "Svalbard and Jan Mayen"
                },
                {
                    "capital": "Stockholm",
                    "code": "+46",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/se.svg",
                    "flag_4x3": "flags/4x3/se.svg",
                    "iso": true,
                    "name": "Sweden"
                },
                {
                    "capital": "Bern",
                    "code": "+41",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ch.svg",
                    "flag_4x3": "flags/4x3/ch.svg",
                    "iso": true,
                    "name": "Switzerland"
                },
                {
                    "capital": "Damascus",
                    "code": "+963",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/sy.svg",
                    "flag_4x3": "flags/4x3/sy.svg",
                    "iso": true,
                    "name": "Syria"
                },
                {
                    "capital": "Taipei",
                    "code": "+886",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/tw.svg",
                    "flag_4x3": "flags/4x3/tw.svg",
                    "iso": true,
                    "name": "Taiwan"
                },
                {
                    "capital": "Dushanbe",
                    "code": "+992",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/tj.svg",
                    "flag_4x3": "flags/4x3/tj.svg",
                    "iso": true,
                    "name": "Tajikistan"
                },
                {
                    "capital": "Dodoma",
                    "code": "+255",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/tz.svg",
                    "flag_4x3": "flags/4x3/tz.svg",
                    "iso": true,
                    "name": "Tanzania"
                },
                {
                    "capital": "Bangkok",
                    "code": "+66",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/th.svg",
                    "flag_4x3": "flags/4x3/th.svg",
                    "iso": true,
                    "name": "Thailand"
                },

                {
                    "capital": "Lomé",
                    "code": "+228",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/tg.svg",
                    "flag_4x3": "flags/4x3/tg.svg",
                    "iso": true,
                    "name": "Togo"
                },
                {
                    "capital": "Nukunonu, Atafu,Tokelau",
                    "code": "+690",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/tk.svg",
                    "flag_4x3": "flags/4x3/tk.svg",
                    "iso": true,
                    "name": "Tokelau"
                },
                {
                    "capital": "Nukuʻalofa",
                    "code": "+676",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/to.svg",
                    "flag_4x3": "flags/4x3/to.svg",
                    "iso": true,
                    "name": "Tonga"
                },
                {
                    "capital": "Port of Spain",
                    "code": "+1-868",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/tt.svg",
                    "flag_4x3": "flags/4x3/tt.svg",
                    "iso": true,
                    "name": "Trinidad and Tobago"
                },

                {
                    "capital": "Tunis",
                    "code": "+216",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/tn.svg",
                    "flag_4x3": "flags/4x3/tn.svg",
                    "iso": true,
                    "name": "Tunisia"
                },
                {
                    "capital": "Ankara",
                    "code": "+90",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/tr.svg",
                    "flag_4x3": "flags/4x3/tr.svg",
                    "iso": true,
                    "name": "Turkey"
                },
                {
                    "capital": "Ashgabat",
                    "code": "+993",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/tm.svg",
                    "flag_4x3": "flags/4x3/tm.svg",
                    "iso": true,
                    "name": "Turkmenistan"
                },
                {
                    "capital": "Cockburn Town",
                    "code": "+1-649",
                    "continent": "North America",
                    "flag_1x1": "flags/1x1/tc.svg",
                    "flag_4x3": "flags/4x3/tc.svg",
                    "iso": true,
                    "name": "Turks and Caicos Islands"
                },
                {
                    "capital": "Funafuti",
                    "code": "+688",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/tv.svg",
                    "flag_4x3": "flags/4x3/tv.svg",
                    "iso": true,
                    "name": "Tuvalu"
                },
                {
                    "capital": "Kampala",
                    "code": "+256",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/ug.svg",
                    "flag_4x3": "flags/4x3/ug.svg",
                    "iso": true,
                    "name": "Uganda"
                },
                {
                    "capital": "Kiev",
                    "code": "+380",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/ua.svg",
                    "flag_4x3": "flags/4x3/ua.svg",
                    "iso": true,
                    "name": "Ukraine"
                },
                {
                    "capital": "Abu Dhabi",
                    "code": "+971",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/ae.svg",
                    "flag_4x3": "flags/4x3/ae.svg",
                    "iso": true,
                    "name": "United Arab Emirates"
                },
                {
                    "capital": "London",
                    "code": "+44",
                    "continent": "Europe",
                    "flag_1x1": "flags/1x1/gb.svg",
                    "flag_4x3": "flags/4x3/gb.svg",
                    "iso": true,
                    "name": "United Kingdom"
                },

                {
                    "capital": "Montevideo",
                    "code": "+598",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/uy.svg",
                    "flag_4x3": "flags/4x3/uy.svg",
                    "iso": true,
                    "name": "Uruguay"
                },
                {
                    "capital": "Tashkent",
                    "code": "+998",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/uz.svg",
                    "flag_4x3": "flags/4x3/uz.svg",
                    "iso": true,
                    "name": "Uzbekistan"
                },
                {
                    "capital": "Port Vila",
                    "code": "+678",
                    "continent": "Oceania",
                    "flag_1x1": "flags/1x1/vu.svg",
                    "flag_4x3": "flags/4x3/vu.svg",
                    "iso": true,
                    "name": "Vanuatu"
                },
                {
                    "capital": "Caracas",
                    "code": "+58",
                    "continent": "South America",
                    "flag_1x1": "flags/1x1/ve.svg",
                    "flag_4x3": "flags/4x3/ve.svg",
                    "iso": true,
                    "name": "Venezuela"
                },
                {
                    "capital": "Hanoi",
                    "code": "+84",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/vn.svg",
                    "flag_4x3": "flags/4x3/vn.svg",
                    "iso": true,
                    "name": "Vietnam"
                },

                {
                    "capital": "Laayoune",
                    "code": "+212",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/eh.svg",
                    "flag_4x3": "flags/4x3/eh.svg",
                    "iso": true,
                    "name": "Western Sahara"
                },
                {
                    "capital": "Sana'a",
                    "code": "+967",
                    "continent": "Asia",
                    "flag_1x1": "flags/1x1/ye.svg",
                    "flag_4x3": "flags/4x3/ye.svg",
                    "iso": true,
                    "name": "Yemen"
                },
                {
                    "capital": "Lusaka",
                    "code": "+260",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/zm.svg",
                    "flag_4x3": "flags/4x3/zm.svg",
                    "iso": true,
                    "name": "Zambia"
                },
                {
                    "capital": "Harare",
                    "code": "+263",
                    "continent": "Africa",
                    "flag_1x1": "flags/1x1/zw.svg",
                    "flag_4x3": "flags/4x3/zw.svg",
                    "iso": true,
                    "name": "Zimbabwe"
                }
            ],
            file: '',

        }
    },
    mounted() {
        let vm = this;
        this.LeadUser = this.LeadId;
        this.allListsArr.sort((a, b) => a.listId - b.listId);
        $('#fasil').daterangepicker({
            ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Su",
                        "Mo",
                        "Tu",
                        "We",
                        "Th",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                    "firstDay": 1
                },
            "alwaysShowCalendars": true,
            "startDate": moment().subtract(6, 'days'),
            "endDate": moment()
        }, function(start, end, label) {
            vm.filterLabel = label;
            vm.startDate = start;
            vm.endDate = end;
            vm.filterRes();
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    },
    methods: {
        handleClose(){
            this.showLearnHow = false;
        },
        toggleLearnHow() {
            this.showLearnHow = true;
        },
        formateNumber (value) {
            return `${Number(value).toLocaleString()}`
        },
        async filterRes() {
            const res = await axios.post(route('get_io_filter_data'),
            {start: this.startDate, end: this.endDate});

            this.allListsArr = res.data.coms;
            this.acceptCount = res.data.ao;
            this.deniedCount = res.data.do;
            this.offersCount = res.data.alo;
        },
        creditDetails(){
            window.location.href = `/credits`;
        },
        displayDates() {
            $('#fasil').click();
        },
        copyUrl() {
            navigator.clipboard.writeText(this.LeadUser.domain);
            this.$toast.add({severity: 'success', summary: 'Copied', detail: "URL is copied to clipboard", life: 3000});
        },
        confirmListDelete(Iid) {
           this.$confirm.require({
                message    : `Are you sure to proceed?`,
                header     : `Delete Entry `,
                icon       : 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept     : () => {
                    this.deleteList(Iid);
                },
                reject     : () => {
                }
            });
        },

        async deleteList(Iid) {
           const res = await axios.post(route('leadMachine.instant.delete'), {InstantId: Iid})
            // this.handleResponse(res.data);
            if (res.data.status === 'error') {
              console.log('error aya ha')
            }
            if (res.data.status === 'success') {
                this.allListsArr = res.data.alllists;
            }
        },

        format_date(value){
            if (value) {
                return moment(String(value)).format('DD/MM/YY')
            }
        },
        chooseFiles: function () {
            document.getElementById('logoWebsite').click()
        },

        FileName(e) {
            // this.files = e.target.files;
            // var span = document.getElementsByClassName('showFileName');
            // span[0].innerHTML = this.files[0].name;
            // console.log(this.$refs.file.input)

            const files = event.target.files
            let filename = files[0].name
            const fileReader = new FileReader()
            fileReader.addEventListener('load', () => {
                this.imageUrl = fileReader.result
            })
            fileReader.readAsDataURL(files[0])
            this.image = files[0];

            this.leadMachine.logoImage = this.image;
            this.leadBeingEdited.logo = this.image;
            this.editLogo = this.image;
            // console.log(this.leadBeingEdited.logo);
            var span = document.getElementsByClassName('showFileName');
            span[0].innerHTML = this.image.name;

        },

        topbarImage() {
            return this.$appState.darkTheme ? '/images/icons/check.png' : '/images/icons/check.png';
        },
        editLogoImage() {
            return this.$appState.darkTheme ? this.leadBeingEdited.logo : this.leadBeingEdited.logo;
        },
        deniedImage() {
            return this.$appState.darkTheme ? '/images/icons/denied.png' : '/images/icons/denied.png';
        },
        counterImage() {
            return this.$appState.darkTheme ? '/images/icons/counter.png' : '/images/icons/counter.png';
        },
        totalImage() {
            return this.$appState.darkTheme ? '/images/icons/total.png' : '/images/icons/total.png';
        },
        chartImage() {
            return this.$appState.darkTheme ? '/images/icons/Chart.png' : '/images/icons/Chart.png';
        },
        questionImage() {
            return this.$appState.darkTheme ? '/images/icons/question.png' : '/images/icons/question.png';
        },

        async websiteStep2() {
            this.verifyStep1 = true;
            const res = await axios({
                url    : route('leadMachine.step1'),
                method : 'POST',
                baseURL: "http://127.0.0.1:8000/",
                data   : this.leadMachine,
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
            this.verifyStep1 = false;
            if (res.data.status === 'success') {
                this.displayWebsiteModal1 = false;
                this.displayWebsiteModal2 = true;
            }
            if(res.data.status === 'error') {
                this.$toast.add({severity: 'error', summary: 'Error', detail: res.data.message, life: 3000});
            }
        },

        async websiteStep3() {
            this.verifyStep2 = true;
            const res = await axios({
                url    : route('leadMachine.step2'),
                method : 'POST',
                data   : this.leadMachine,
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
            this.verifyStep2 = false;
            if (res.data.status === 'success') {
                this.displayWebsiteModal2 = false;
                this.displayWebsiteModal3 = true;
            }
            if(res.data.status === 'error') {
                this.$toast.add({severity: 'error', summary: 'Error', detail: res.data.message, life: 3000});
            }
        },

        async finishWebsite(){
            this.verifyStep3 = true;
            const res = await axios({
                url    : route('leadMachine.step3'),
                method : 'POST',
                data   : this.leadMachine,
                headers: {
                    'content-type': 'multipart/form-data'
                }
            });
            this.verifyStep3 = false;
            if (res.data.status === 'success') {
                this.displayWebsiteModal3 = false;
                this.$toast.add({severity: 'success', summary: 'Success', detail: res.data.message, life: 3000});
            }
            if(res.data.status === 'error') {
                this.$toast.add({severity: 'error', summary: 'Error', detail: res.data.message, life: 3000});
            }
        },

        async websiteStep2Back() {
            this.displayWebsiteModal2 = false;
            this.displayWebsiteModal1 = true;
        },

        async websiteStep3Back() {
            this.displayWebsiteModal2 = true;
            this.displayWebsiteModal3 = false;
        },


        hydrateListBeingEditedObj() {
            const listToEdit = this.LeadId;
            this.leadBeingEdited = JSON.parse(JSON.stringify(listToEdit));

        },

        async showEditModal1(){
            this.displayWebsiteEditModal1 = true;
            this.hydrateListBeingEditedObj();
        },

        async websiteEditStep2(){
            this.displayWebsiteEditModal1 = false;
            this.hydrateListBeingEditedObj();
            this.displayWebsiteEditModal2 = true;
        },

        async websiteEditStep2Back(){
            this.displayWebsiteEditModal1 = true;
            this.displayWebsiteEditModal2 = false;
        },

        async websiteEditStep3(){
            this.displayWebsiteEditModal2 = false;
            this.displayWebsiteEditModal3 = true;
        },

        async websiteEditStep3Back(){
            this.displayWebsiteEditModal3 = false;
            this.displayWebsiteEditModal2 = true;
        },

        async finishEditWebsite(){
            console.log(this.leadBeingEdited);
            const res = await axios.post(route('leadMachine.update'), this.leadBeingEdited);
            if (res.data.status === 'success') {
                this.LeadUser = res.data.lead;
                this.displayWebsiteEditModal3 = false;
                this.$toast.add({severity: 'success', summary: 'Success', detail: res.data.message, life: 3000});
            }
            if(res.data.status === 'error') {
                this.$toast.add({severity: 'error', summary: 'Error', detail: res.data.message, life: 3000});
            }
        }

    },
    components: {AuthenticatedLayout, Head, Link}

}
</script>
<template>
    <AuthenticatedLayout>
        <Head><title>Lists</title></Head>
        <template #pageHeading>
            <div class="checks">
                <i class="pi pi-home mr-2 text-2xl font-bold"/>
                <span class="text-2xl mr-3"><strong>Leads Machine INSTA-OFFER Webite Dashboard </strong></span>
            </div>

            <div class="d-flex w-20 justify-content-between">
                <div class="d-flex justify-content-between me-3"
                     style="border:1px solid #EBEBEB;padding:7px;border-radius:7px;">
                    <div class="h-100 p-1 mr-2 cred-text text-center">
                        <span class="creditBalance">{{ credits }}</span>
                        <br/>
                        <span>
                        Credit Balance
                    </span>
                    </div>
                    <Button class="p-button  p-button-danger"
                            style="border: 0px;border-radius: 0.7rem !important;background-color:#FBE7E8;color: #DB0F19;padding:0.714rem 1rem"
                            @click="creditDetails"
                            label="Top Up">
                    </Button>
                </div>

                <!-- <Button class="p-button p-button-outlined p-button-danger"
                        style="border-radius: 0.6em !important;padding:0px 30px;font-size:17px;height:60px"
                        icon="pi pi-calendar-times"
                        label="Today">

                </Button> -->

                <div>
                    <div @click="displayDates();" class="p-button p-button-outlined p-button-danger d-flex h-100"
                        style="border-radius: 0.6em !important;padding:0px 30px;font-size:17px;height:60px">

                        <i class="my-auto pi pi-calendar-times mr-3"></i> {{filterLabel}}
                    </div>
                    <input class=""
                        style="height: 0; width: 0; border: none; outline: none;" type="text" id="fasil" name="daterange"  />
                </div>
            </div>


        </template>


        <div class="row mt-5">
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div class="col-md-2 mt-3 ml-3"
                             style="background: rgba(27, 200, 65, 0.1);border-radius:100px;height:40px;width:40px;display: flex;align-items: center;justify-content: center;">
                            <img class="text-center" :src="topbarImage()" alt="">
                        </div>
                        <div class="col-md-5">
                            <p class="mb-0 mt-3">Accepted Offers</p>
                            <p class="mb-3" style="font-weight:700">
                                {{acceptCount}}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div class="col-md-2 mt-3 ml-3"
                             style="background: rgba(233, 39, 39, 0.1);border-radius:100px;height:40px;width:40px;display: flex;align-items: center;justify-content: center">
                            <img class="text-center" :src="deniedImage()" alt="">
                        </div>
                        <div class="col-md-5">
                            <p class="mb-0 mt-3">Denied Offers</p>
                            <p class="mb-3" style="font-weight:700">
                                {{deniedCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div class="col-md-2 mt-3 ml-3"
                             style="background: rgba(169, 194, 15, 0.1);border-radius:100px;height:40px;width:40px;display: flex;align-items: center;justify-content: center;">
                            <img class="text-center" :src="counterImage()" alt="">
                        </div>
                        <div class="col-md-5">
                            <p class="mb-0 mt-3">Counter Offers</p>
                            <p class="mb-3" style="font-weight:700">
                                {{ counterCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div class="col-md-2 mt-3 ml-3"
                             style="background: rgba(45, 124, 243, 0.1);border-radius:100px;height:40px;width:40px;display: flex;align-items: center;justify-content: center;">
                            <img class="text-center" :src="totalImage()" alt="">
                        </div>
                        <div class="col-md-5">
                            <p class="mb-0 mt-3">Total Leads</p>
                            <p class="mb-3" style="font-weight:700">
                                {{offersCount}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <br>
        <br>

        <DataTable :value="allListsArr"
                   :paginator="true"
                   :rows="10"
                   dataKey="Iid"
                   :rowHover="true"
                   paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
                   :rowsPerPageOptions="[10,25,50]"
                   currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
                   :globalFilterFields="['address','name','email','phone','status']"
                   responsiveLayout="scroll">
                   <div class="row mt-5">
            <div class="d-flex justify-content-between ml-3">
                <div class="d-flex ">
                    <img :src="chartImage()" style="height:20px;margin-top:8px">
                    <p class="ml-3" style="font-weight:700;font-size:23px">
                        Leads ({{offersCount}})
                    </p>
                </div>
                <div class="d-flex mb-3">
                    <div class="d-flex justify-content-between me-3 copy-btn-border"
                        >
                        <div style="margin-right:20px;margin-top:7px">
                        <span>
                            {{LeadUser.domain}}
                        </span>
                        </div>
                        <Button @click="copyUrl()" class="p-button  p-button-danger"
                                style="border: 0px;border-radius: 0.7rem !important;background-color:#FBE7E8;color: #DB0F19;padding:7px 40px"
                                label="copy">
                        </Button>
                    </div>
                    <Button class="p-button p-button-outlined p-button-danger mr-6"
                            style="border-radius: 0.6em !important;padding:0px 30px;font-size:15px;height:40px"
                            v-if="LeadCount == 0"
                            icon="pi pi-globe"
                            disabled: true
                            @click="displayWebsiteModal1 = true"
                            label="Set Up Insta-Offer Website">

                    </Button>
                    <Button class="p-button p-button-outlined p-button-danger mr-6"
                            style="border-radius: 0.6em !important;padding:0px 30px;font-size:15px;height:40px"
                            v-if="LeadCount > 0"
                            icon="pi pi-globe"
                            @click="showEditModal1"
                            label="Edit Insta-Offer Website">

                    </Button>
                </div>
            </div>
        </div>

            <template #empty>
                No List found.
            </template>
            <template #loading>
                Loading List data. Please wait.
            </template>

            <Column field="name" header="Name" sortable style="min-width:5rem">
                <template #body="{data}">
                    {{ data.name }}
                </template>

            </Column>

            <Column field="address" header="Address" sortable style="min-width: 10rem">
                <template #body="{data}">
                    {{ data.address }}
                </template>
            </Column>

            <Column field="email" header="Email" sortable style="min-width: 14rem">
                <template #body="{data}">
                    {{ data.email }}
                </template>
            </Column>

            <Column field="phone" header="Phone" sortable style="min-width: 14rem">
                <template #body="{data}">
                    {{ data.phone }}
                </template>
            </Column>

            <Column field="arvPrice" header="ARV" sortable style="min-width: 8rem">
                <template #body="{data}">
                    ${{ formateNumber(data.arv) }}
                </template>
            </Column>
            <Column field="instantOffer" header="INSTA-OFFER" sortable style="min-width: 10rem">
                <template #body="{data}">
                    ${{ formateNumber(data.offer_price) }}
                </template>
            </Column>
            <Column field="status" header="Status" sortable style="min-width: 8rem">
                <template #body="{data}">
                    <Button v-if="data.status.length > 0 && data.status == 'counter'" class="p-button p-button-outlined p-button-success-half text center"
                            style="border-radius: 1.5em !important;padding:0px 20px;font-size:13px;height:30px"
                            >
                            {{ data.status }}
                            <br>
                            ${{ data.offer_price }}
                    </Button>
                    <Button v-if="data.status.length > 0 && data.status == 'accepted'" class="p-button p-button-outlined p-button-success"
                            style="border-radius: 1.5em !important;padding:0px 20px;font-size:13px;height:30px"
                            >
                            {{ data.status }}
                    </Button>
                    <Button v-if="data.status.length > 0 && data.status == 'denied'" class="p-button p-button-outlined p-button-danger"
                            style="border-radius: 1.5em !important;padding:0px 20px;font-size:13px;height:30px"
                            >
                            {{ data.status }}
                    </Button>
                    <Button v-if="data.status.length > 0 && data.status == 'optin'" class="p-button p-button-outlined p-button-info"
                            style="border-radius: 1.5em !important;padding:0px 20px;font-size:13px;height:30px"
                            >
                            {{ data.status }}
                    </Button>
                </template>
            </Column>
            <Column field="created" header="Date" sortable style="min-width: 10rem">
                <template #body="{data}">
                            {{ format_date(data.created_at) }}
                </template>
            </Column>
            <Column field="action" header="Action" sortable style="min-width:14rem">
                <template #body="{data}">
<!--                    <Button icon="pi pi-eye"-->
<!--                            class="p-button-rounded p-button-grey p-button-outlined mr-2"/>-->
                    <Button icon="pi pi-trash"
                            @click="confirmListDelete(data.Iid)"
                            class="p-button-rounded p-button-grey p-button-outlined"/>
                </template>
            </Column>
        </DataTable>
    </AuthenticatedLayout>

    <!--Website Modal 1 -->
    <Dialog header=""
            :draggable="false"
            v-model:visible="displayWebsiteModal1 "

            :style="{width: '40vw'}"
            :modal="true">
        <template #header>
            <div class="flex justify-content-between align-items-center" style="width: 90%;">
                <span class="p-dialog-title">Create Website</span>
            </div>
        </template>
        <div class="checks">
            <div class="col-lg-12 mt-2">
                <div class="pt-2">
                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                        <div class="timelineStepLine"></div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">1</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Branding</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle">
                                    <div class="time-line-txt-active" style="color:black">2</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Customize</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle">
                                    <div class="time-line-txt-active" style="color:black">3</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Company Name-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="companyName"
                               placeholder="Type Company Name"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.companyName"
                               />
                    <label>Company Name</label>
                </span>
                </div>
            </div>
            <!--Logo -->
            <div class="field grid mt-5">
                <div class="col-12">
                    <span class="p-float-label" style="border-radius: 1rem !important;
                                padding: 53px;
                                border-style: dashed;
                                border-color: #DB0F19;
                                background: rgba(219, 15, 25, 0.05);">
                        <InputText id="logoWebsite"
                                   style="display:none"
                                   @change="FileName"
                                   class="w-full  custom-file-input"
                                   type="file"
                                   ref="file"

                                   />

                        <div class="text-center">
                            <button @click="chooseFiles()" class="w-25 m-auto custom-file-input">Upload File</button>
                                <span class="d-block mt-2 showFileName">
                                 Size Requirements: 250 X 250 px
                                </span>
                        </div>
                    </span>
                </div>
            </div>


            <div class="field grid mt-2">
                <div class="col-12">
                    <div class="p-inputgroup">
                        <Dropdown v-model="leadMachine.phone_country_code"
                                  :options="countries"
                                  style="border-top-left-radius: 1rem;border-bottom-left-radius: 1rem; border-right: none"
                                  optionLabel="name"
                                  optionValue="code">

                            <template #value="slotProps">
                                <div class="flex align-items-center" style="height: 100%">
                                    <div v-if="slotProps.value">
                                        <span :class="'fi fi-' + slotProps.value"/>
                                    </div>
                                    <span v-else>
                                            <span :class="'fi fi-us'"/>
                                    </span>
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="" style="display: inline;">
                                    <span :class="'fi fi-' + slotProps.option.code"></span>
                                    <div class="ml-3" style="display: inline;">{{
                                            slotProps.option.name
                                        }}
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                        <span class="p-float-label">
                            <InputText
                                id="phone-number"
                                class="text-2xl"
                                style="border-top-right-radius: 1rem;border-bottom-right-radius: 1rem;"
                                required
                                placeholder="Type phone number here.."
                                v-model="leadMachine.phoneNo"
                            />
                                <label for="phone-number" class="move-left">Phone Number</label>
                        </span>
                    </div>
                </div>
            </div>

            <!--Email-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="email"
                               placeholder="Email Address"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.email"
                               />
                    <label for="email">Email</label>
                    </span>
                </div>
            </div>

            <!--Buisness Address-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="buisnessAddress"
                               placeholder="Type Buisness Address"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.buisnessAddress"
                               />
                    <label for="buisnessAddress">Buisness Address</label>
                    </span>
                </div>
            </div>

            <!--City-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="city"
                               placeholder="City"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.city"
                               />
                    <label for="city">City</label>
                    </span>
                </div>
            </div>

            <!--State-->
            <div class="field grid mt-5">
                <div class="col-6">
                <span class="p-float-label">
                    <InputText id="state"
                               placeholder="State"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.state"
                               />
                    <label for="state">State</label>
                    </span>
                </div>
                <!--City-->
                <div class="col-6">
                    <span class="p-float-label">
                        <InputText id="zip_code"
                                   placeholder="Zip Code"
                                   autofocus
                                   class="w-full py-3"
                                   type="text"
                                   style="border-radius: 1rem !important;"
                                   v-model="leadMachine.zipCode"
                        />
                        <label for="zip_code">Zip Code</label>
                    </span>
                </div>
            </div>

            <!--Upload Button -->
            <div class="field col-12 px-0 mt-2">
                <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                        style="border-radius: 0.5rem !important;"
                        @click="websiteStep2"
                        :loading="verifyStep1"
                >
                    <div class="w-100" style="align-items: center;">
                        <span style="font-size:20px">Next Step</span>
                        <span class="pi pi-arrow-right ms-3" style="font-size:20px"></span>
                    </div>
                </Button>
            </div>

        </div>
    </Dialog>

    <!--website edit modal 1 -->
    <Dialog header=""
            :draggable="false"
            v-model:visible="displayWebsiteEditModal1 "

            :style="{width: '40vw'}"
            :modal="true">
        <template #header>
            <div class="flex justify-content-between align-items-center" style="width: 90%;">
                <span class="p-dialog-title">Edit Website</span>
            </div>
        </template>
        <div class="checks">
            <div class="col-lg-12 mt-2">
                <div class="pt-2">
                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                        <div class="timelineStepLine"></div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">1</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Branding</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle">
                                    <div class="time-line-txt-active" style="color:black">2</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Customize</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle">
                                    <div class="time-line-txt-active" style="color:black">3</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Company Name-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="companyName"
                               placeholder="Type Company Name"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.company_name"
                    />
                    <label>Company Name</label>
                </span>
                </div>
            </div>
            <!--Logo -->
            <div class="field grid mt-5">
                <div class="col-12">
                    <span class="p-float-label" style="border-radius: 1rem !important;
                                padding: 53px;
                                border-style: dashed;
                                border-color: #DB0F19;
                                background: rgba(219, 15, 25, 0.05);">
                        <InputText id="logoWebsite"
                                   style="display:none"
                                   @change="FileName"
                                   class="w-full  custom-file-input"
                                   type="file"
                                   ref="file"

                        />

                        <div class="text-center">
                            <button @click="chooseFiles()" class="w-25 m-auto custom-file-input">Upload File</button>
                                <span class="d-block mt-2 showFileName">
                                 Size Requirements: 250 X 250 px
                                </span>
                        </div>
                    </span>
                </div>
            </div>
            <!--Old Image-->
            <div class="field grid mt-5">
                <div class="col-12">
                    <label>Old Logo</label>
                    <span class="p-float-label text-center">
                        <img class="mt-3" style="width: 100px;" :src="editLogoImage()" alt="">
                        <input type="hidden" v-model="leadBeingEdited.logo">
                    </span>
                </div>
            </div>


            <div class="field grid mt-2">
                <div class="col-12 mt-3">
                    <div class="p-inputgroup">
                        <Dropdown v-model="leadBeingEdited.phone_code"
                                  :options="countries"
                                  style="border-top-left-radius: 1rem;border-bottom-left-radius: 1rem; border-right: none"
                                  optionLabel="name"
                                  optionValue="code">

                            <template #value="slotProps">
                                <div class="flex align-items-center" style="height: 100%">
                                    <div v-if="slotProps.value">
                                        <span :class="'fi fi-' + slotProps.value"/>
                                    </div>
                                    <span v-else>
                                            <span :class="'fi fi-us'"/>
                                    </span>
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="" style="display: inline;">
                                    <span :class="'fi fi-' + slotProps.option.code"></span>
                                    <div class="ml-3" style="display: inline;">{{
                                            slotProps.option.name
                                        }}
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                        <span class="p-float-label">
                            <InputText
                                id="phone-number"
                                class="text-2xl"
                                style="border-top-right-radius: 1rem;border-bottom-right-radius: 1rem;"
                                required
                                placeholder="Type phone number here.."
                                v-model="leadBeingEdited.phone"
                            />
                                <label for="phone-number" class="move-left">Phone Number</label>
                        </span>
                    </div>
                </div>
            </div>

            <!--Email-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="email"
                               placeholder="Email Address"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.email"
                    />
                    <label for="email">Email</label>
                    </span>
                </div>
            </div>

            <!--Buisness Address-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="buisnessAddress"
                               placeholder="Type Buisness Address"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.buisness_address"
                    />
                    <label for="buisnessAddress">Buisness Address</label>
                    </span>
                </div>
            </div>

            <!--City-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="city"
                               placeholder="City"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.city"
                    />
                    <label for="city">City</label>
                    </span>
                </div>
            </div>

            <!--State-->
            <div class="field grid mt-5">
                <div class="col-6">
                <span class="p-float-label">
                    <InputText id="state"
                               placeholder="State"
                               autofocus
                               class="w-full py-3"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.state"
                    />
                    <label for="state">State</label>
                    </span>
                </div>
                <!--City-->
                <div class="col-6">
                    <span class="p-float-label">
                        <InputText id="zip_code"
                                   placeholder="Zip Code"
                                   autofocus
                                   class="w-full py-3"
                                   type="text"
                                   style="border-radius: 1rem !important;"
                                   v-model="leadBeingEdited.zip_code"
                        />
                        <label for="zip_code">Zip Code</label>
                    </span>
                </div>
            </div>

            <!--Upload Button -->
            <div class="field col-12 px-0 mt-2">
                <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                        style="border-radius: 0.5rem !important;"
                        @click="websiteEditStep2"
                        :loading="verifyStep1"
                >
                    <div class="w-100" style="align-items: center;">
                        <span style="font-size:20px">Next Step</span>
                        <span class="pi pi-arrow-right ms-3" style="font-size:20px"></span>
                    </div>
                </Button>
            </div>

        </div>
    </Dialog>

    <!--Website Modal 2 -->
    <Dialog header=""
            :draggable="false"
            v-model:visible="displayWebsiteModal2"

            :style="{width: '40vw'}"
            :modal="true">
        <template #header>
            <div class="flex justify-content-between align-items-center" style="width: 90%;">
                <span class="p-dialog-title">Create Website</span>
            </div>
        </template>
        <div class="checks">
            <!-- <hr class="mt-0 border border-1 border-dark"> -->
            <div class="col-lg-12">
                <div class="pt-2">
                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                        <div class="timelineStepLine"></div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">1</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Branding</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">2</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Customize</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle">
                                    <div class="time-line-txt-active" style="color:black">3</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Headline-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="headlineField"
                               placeholder="Type Headline"
                               autofocus
                               class="w-full py-4"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.headline"/>
                    <label for="headlineField">Headline</label>
                    </span>
                </div>
            </div>
            <!--Sub-Headline-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="SubheadlineField"
                               placeholder="Type Subheadline"
                               autofocus
                               class="w-full py-4"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadMachine.subHeadline"/>
                    <label for="SubheadlineField">Subheadline</label>
                    </span>
                </div>
            </div>

            <div class="row mt-5">
                <div class="my-auto col-md-2 d-flex">
                    <input
                    class="my-auto"
                style="height: 47px;
                padding: 0;"
                type="color"  v-model="leadMachine.color" name="" id=""
                >
                </div>
                <div class="field grid my-0 col-md-10">
                    <div class="col-12">
                    <span class="p-float-label">
                        <InputText
                                placeholder="Color"
                                autofocus
                                class="w-full py-4"
                                type="text"
                                style="border-radius: 1rem !important;"
                                v-model="leadMachine.color"/>
                        <label for="SubheadlineField">Color Scheme</label>
                        </span>
                    </div>
                </div>
            </div>

            <!--Offer Codes-->
            <div class="field grid mt-5">
                <div class="col-9">
                    <span class="p-float-label">
                        <label class="mt-1" style="font-weight:500" >Enable Offer Codes?</label>
                    </span>
                </div>
                <div class="col-3 d-flex px-3 ">
                    <div class="form-check form-switch ms-auto d-flex">
                        <input class="form-check-input my-auto" type="checkbox">
                        <img class="my-auto" :src="questionImage()" style="height:22px;margin-left:3px" alt="">
                    </div>
                </div>
            </div>

            <!--Counter Offer-->
            <div class="field grid mt-5">
                <div class="col-9">
                    <span class="p-float-label">
                        <label class="mt-1" style="font-weight:500" for="email">Enable Counter Offer?</label>
                    </span>
                </div>
                <div class="col-3 d-flex px-3 ">
                    <div class="form-check form-switch ms-auto d-flex">
                        <input class="form-check-input my-auto" type="checkbox" id="counterOffer">
                        <img class="my-auto" :src="questionImage()" style="height:22px;margin-left:3px" alt="">
                    </div>
                </div>
            </div>




            <!--Enable Add Pixel-->
            <div class="field grid mt-5">
                <div class="col-9">
                    <span class="p-float-label">
                        <label class="mt-1" style="font-weight:500" for="email">Enable Add  Pixel?</label>
                    </span>
                </div>
                <div class="col-3 d-flex px-3 ">
                    <div class="form-check form-switch ms-auto d-flex">
                        <input class="form-check-input my-auto" type="checkbox">
                        <img class="my-auto" :src="questionImage()" style="height:22px;margin-left:3px" alt="">
                    </div>
                </div>
            </div>

            <div class="field grid mt-5 mb-0">
                <!--Back Button-->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="websiteStep2Back"

                    >
                        <div class="w-100" style="align-items: center;">
                            <span class="pi pi-arrow-left" style="font-size:20px"></span>
                            <span class="ms-3" style="font-size:20px">Go Back</span>
                        </div>
                    </Button>
                </div>
                <!--Upload Button -->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="websiteStep3"
                            :loading="verifyStep2"
                    >
                        <div class="w-100" style="align-items: center;">
                            <span style="font-size:20px">Next Step</span>
                            <span class="pi pi-arrow-right ms-3" style="font-size:20px" ></span>
                        </div>
                    </Button>
                </div>
            </div>

        </div>
    </Dialog>

    <!--Website Edit Modal 2-->
    <Dialog header=""
            :draggable="false"
            v-model:visible="displayWebsiteEditModal2"

            :style="{width: '40vw'}"
            :modal="true">
        <template #header>
            <div class="flex justify-content-between align-items-center" style="width: 90%;">
                <span class="p-dialog-title">Create Website</span>
            </div>
        </template>
        <div class="checks">
            <!-- <hr class="mt-0 border border-1 border-dark"> -->
            <div class="col-lg-12">
                <div class="pt-2">
                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                        <div class="timelineStepLine"></div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">1</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Branding</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">2</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Customize</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <div class="timeline-content">
                                <div class="inner-circle">
                                    <div class="time-line-txt-active" style="color:black">3</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Headline-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="headlineField"
                               placeholder="Type Headline"
                               autofocus
                               class="w-full py-4"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.headline"/>
                    <label for="headlineField">Headline</label>
                    </span>
                </div>
            </div>
            <!--Sub-Headline-->
            <div class="field grid mt-5">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText id="SubheadlineField"
                               placeholder="Type Subheadline"
                               autofocus
                               class="w-full py-4"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.sub_headline"/>
                    <label for="SubheadlineField">Subheadline</label>
                    </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="my-auto col-md-2 d-flex">
                    <input
                    class="my-auto"

                style="height: 47px;
                padding: 0;"
                type="color"  v-model="leadBeingEdited.color" name="" id=""
                >
                </div>
                <div class="field grid my-0 col-md-10">
                <div class="col-12">
                <span class="p-float-label">
                    <InputText
                               placeholder="Color"
                               autofocus
                               class="w-full py-4"
                               type="text"
                               style="border-radius: 1rem !important;"
                               v-model="leadBeingEdited.color"/>
                    <label for="SubheadlineField">Color Scheme</label>
                    </span>
                </div>
            </div>
            </div>




            <!--Offer Codes-->
            <div class="field grid mt-5">
                <div class="col-9">
                    <span class="p-float-label">
                        <label class="mt-1" style="font-weight:500" >Enable Offer Codes?</label>
                    </span>
                </div>
                <div class="col-3 d-flex px-3 ">
                    <div class="form-check form-switch ms-auto d-flex">
                        <input  @input="leadBeingEdited.enable_offer_code = $event.target.checked" :checked="leadBeingEdited.enable_offer_code"   class="form-check-input my-auto" type="checkbox" id="offerCodes">
                        <img class="my-auto" :src="questionImage()" style="height:22px;margin-left:3px" alt="">
                    </div>
                </div>
            </div>

            <!--Counter Offer-->


            <div class="field grid mt-5">
                <div class="col-9">
                    <span class="p-float-label">
                        <label class="mt-1" style="font-weight:500" for="email">Enable Counter Offer?</label>
                    </span>
                </div>
                <div class="col-3 d-flex px-3 ">
                    <div class="form-check form-switch ms-auto d-flex">

                        <input  @input="leadBeingEdited.enable_counter_offer = $event.target.checked" :checked="leadBeingEdited.enable_counter_offer"  class="form-check-input my-auto" type="checkbox" id="counterOffer">
                        <img class="my-auto" :src="questionImage()" style="height:22px;margin-left:3px" alt="">
                    </div>
                </div>
            </div>

            <!--Enable Add Pixel-->


            <div class="field grid mt-5">
                <div class="col-9">
                    <span class="p-float-label">
                        <label class="mt-1" style="font-weight:500" for="email">Enable Add  Pixel?</label>
                    </span>
                </div>
                <div class="col-3 d-flex px-3 ">
                    <div class="form-check form-switch ms-auto d-flex">

                        <input   @input="leadBeingEdited.enable_ad_pixel = $event.target.checked" :checked="leadBeingEdited.enable_ad_pixel"  class="form-check-input my-auto" type="checkbox" id="adPixel">
                        <img class="my-auto" :src="questionImage()" style="height:22px;margin-left:3px" alt="">
                    </div>
                </div>
            </div>
            <div class="field  mt-5" v-if="leadBeingEdited.enable_ad_pixel">
                <div class="col-12">
                    <span class="p-float-label">
                        <Textarea rows="3" cols="30" id="tagMsg"

                                autofocus
                                class="w-full p-4 textArea"




                                style="border-radius: 1rem !important;"
                                v-model="leadBeingEdited.pixel_code"
                                :value="leadBeingEdited.pixel_code"
                                @input="leadBeingEdited.pixel_code = $event.target.value"


                                />
                        <label for="tagMsg">Pixel Code</label>
                        </span>
                </div>
            </div>

            <div class="field grid mt-5 mb-0">
                <!--Back Button-->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="websiteEditStep2Back"

                    >
                        <div class="w-100" style="align-items: center;">
                            <span class="pi pi-arrow-left" style="font-size:20px"></span>
                            <span class="ms-3" style="font-size:20px">Go Back</span>
                        </div>
                    </Button>
                </div>
                <!--Upload Button -->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="websiteEditStep3"
                            :loading="verifyStep2"
                    >
                        <div class="w-100" style="align-items: center;">
                            <span style="font-size:20px">Next Step</span>
                            <span class="pi pi-arrow-right ms-3" style="font-size:20px" ></span>
                        </div>
                    </Button>
                </div>
            </div>

        </div>
    </Dialog>

    <!--Website Modal 3 -->
    <Dialog header=""
            :draggable="false"
            v-model:visible="displayWebsiteModal3"

            :style="{width: '40vw'}"
            :modal="true">
        <template #header>
            <div class="flex justify-content-between align-items-center" style="width: 90%;">
                <span class="p-dialog-title">Create Website</span>

            </div>
        </template>
        <div class="checks">
            <hr class="mt-0 border border-1 border-dark">
            <div class="col-lg-12">
                <div class="pt-2">
                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                        <div class="timelineStepLine"></div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">1</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Branding</p>
                            </div>
                        </div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">2</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Customize</p>
                            </div>
                        </div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">3</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Headline-->
            <div class="field grid ">
                <div class="col-12">
                    <label for="domainNameField" style="font-size:18px">Step 1: Type Your Domain</label>
                    <span class="p-float-label">
                        <InputText
                            id="domainNameField"
                            placeholder="www.example.com"
                            class="w-full py-4 mt-2"
                            type="text"
                            style="border-radius: 1rem !important;"
                            v-model="leadMachine.domain"/>
                    </span>
                </div>
            </div>
            <!--Update DNS-->
            <div class="field grid mt-2 mb-0">
                <div class="col-12">
                    <label for="domainNameField" style="font-size:18px">Step 2: Update Your DNS Records To Connect
                        Domain</label>
                    <div class="field grid mt-2">
                        <!--Back Button-->
                        <div class="field col-6">
                            <Button class="p-button  p-button-danger"
                                    style="
                                    border: 0px;
                                    padding: 20px;
                                    border-radius: 0.7rem !important;
                                    background-color: rgb(251, 231, 232);
                                    width: 100%;
                                    color: rgb(219, 15, 25);"
                                    @click="displayUploadModal = true"
                                    label="Learn How">

                                <div @click="toggleLearnHow()" class="w-100" style="align-items: center;">
                                    <span class="pi pi-question-circle" style="font-size:18px;"></span>
                                    <span class="ms-3" style="font-size:15px;">Learn How</span>
                                </div>
                            </Button>
                        </div>
                        <!--Upload Button -->
                        <div class="field col-6">
                            <Button class="p-button  p-button-danger"
                                    style="
                                    border: 0px;
                                    padding: 20px;
                                    width: 100%;
                                    border-radius: 0.7rem !important;
                                    background-color: rgb(251, 231, 232);
                                    color: rgb(219, 15, 25);"
                                    @click="displayUploadModal = true"
                                    label="Top Up">
                                <div class="w-100" style="align-items: center;">
                                    <span class="pi pi-check-circle" style="font-size:18px;"></span>
                                    <span class="ms-3" style="font-size:15px;">Mark As Completed</span>
                                </div>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="field grid">
                <div class="col-12">
                    <div class="p-inputgroup">
                        <Dropdown v-model="leadBeingEdited.smsphone_code"
                                  :options="countries"
                                  style="border-top-left-radius: 1rem;border-bottom-left-radius: 1rem; border-right: none"
                                  optionLabel="name"
                                  optionValue="code">

                            <template #value="slotProps">
                                <div class="flex align-items-center" style="height: 100%">
                                    <div v-if="slotProps.value">
                                        <span :class="'fi fi-' + slotProps.value"/>
                                    </div>
                                    <span v-else>
                                            <span :class="'fi fi-us'"/>
                                    </span>
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="" style="display: inline;">
                                    <span :class="'fi fi-' + slotProps.option.code"></span>
                                    <div class="ml-3" style="display: inline;">{{
                                            slotProps.option.name
                                        }}
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                        <span class="p-float-label">
                            <InputText
                                id="phone-number"
                                class="text-2xl"
                                v-model="leadMachine.msgPhone"
                                style="border-top-right-radius: 1rem;border-bottom-right-radius: 1rem;"
                                required
                                placeholder="Type phone number here.."/>
                                <label for="phone-number" class="move-left">New Lead SMS Notification</label>
                        </span>
                    </div>
                </div>
            </div> -->

<!--            <Button class="p-button p-button-outlined p-button-danger"-->
<!--                    style="border-radius: 1.5em !important;padding:0px 30px;font-size:15px;height:40px"-->
<!--                    label="Add More"-->
<!--                    icon="pi pi-plus">-->

<!--            </Button>-->

            <div class="field col-12 px-0 px-0">
                <span class="p-float-label">
                    <MultiSelect class="w-full"
                                 id="multiselect"
                                 :filter="true"
                                 placeholder="Add Lists"
                                 display="chip"
                                 v-model="lists_input"
                                 optionLabel="filename"
                                 :options="lists"
                    >

                        <template #option="slotProps">
                                    <span class="">{{ slotProps.option.filename }}</span>
                                <span class="flex-grow-1"></span>

                            </template>

                        </MultiSelect>
                    <label for="multiselect">Add Lists</label>
                </span>
            </div>

            <div class="field grid mt-2 mb-0">
                <!--Back Button-->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="websiteStep3Back"

                    >
                        <div class="w-100" style="align-items: center;">
                            <span class="pi pi-arrow-left" style="font-size:20px"></span>
                            <span class="ms-3" style="font-size:20px">Go Back</span>
                        </div>
                    </Button>
                </div>
                <!--Upload Button -->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="finishWebsite"
                            :loading="verifyStep3"
                    >
                        <div class="w-100" style="align-items: center;">
                            <span style="font-size:20px">Finish Website</span>
                        </div>
                    </Button>
                </div>
            </div>
        </div>
    </Dialog>

    <!--Website Edit Modal 3 -->
    <Dialog header=""
            :draggable="false"
            v-model:visible="displayWebsiteEditModal3"

            :style="{width: '40vw'}"
            :modal="true">
        <template #header>
            <div class="flex justify-content-between align-items-center" style="width: 90%;">
                <span class="p-dialog-title">Create Website</span>

            </div>
        </template>
        <div class="checks">
            <hr class="mt-0 border border-1 border-dark">
            <div class="col-lg-12">
                <div class="pt-2">
                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                        <div class="timelineStepLine"></div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">1</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Branding</p>
                            </div>
                        </div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">2</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Customize</p>
                            </div>
                        </div>
                        <div class="timeline-step active">
                            <div class="timeline-content">
                                <div class="inner-circle active">
                                    <div class="time-line-txt-active">3</div>
                                </div>
                                <p class="h6 mb-1 count-btn-txt-active">Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Headline-->
            <div class="field grid ">
                <div class="col-12">
                    <label for="domainNameField" style="font-size:18px">Step 1: Type Your Domain</label>
                    <span class="p-float-label">
                        <InputText
                            id="domainNameField"
                            placeholder="www.example.com"
                            class="w-full py-4 mt-2"
                            type="text"
                            style="border-radius: 1rem !important;"
                            v-model="leadBeingEdited.domain"/>
                    </span>
                </div>
            </div>
            <!--Update DNS-->
            <div class="field grid mt-2 mb-0">
                <div class="col-12">
                    <label for="domainNameField" style="font-size:18px">Step 2: Update Your DNS Records To Connect
                        Domain</label>
                    <div class="field grid mt-2">
                        <!--Back Button-->
                        <div class="field col-6">
                            <Button class="p-button  p-button-danger"
                                    style="
                                    border: 0px;
                                    padding: 20px;
                                    width: 100%;
                                    border-radius: 0.7rem !important;
                                    background-color: rgb(251, 231, 232);
                                    color: rgb(219, 15, 25);"
                                    @click="displayUploadModal = true"
                                    label="Learn How">

                                <div @click="toggleLearnHow()" class="w-100" style="align-items: center;">
                                    <span class="pi pi-question-circle" style="font-size:18px;"></span>
                                    <span class="ms-3" style="font-size:15px;">Learn How</span>
                                </div>
                            </Button>
                        </div>
                        <!--Upload Button -->
                        <div class="field col-6">
                            <Button class="p-button  p-button-danger"
                                    style="
                                    border: 0px;
                                    padding: 20px;
                                    width: 100%;
                                    border-radius: 0.7rem !important;
                                    background-color: rgb(251, 231, 232);
                                    color: rgb(219, 15, 25);"
                                    @click="displayUploadModal = true"
                                    label="Top Up">
                                <div class="w-100" style="align-items: center;">
                                    <span class="pi pi-check-circle" style="font-size:18px;"></span>
                                    <span class="ms-3" style="font-size:15px;">Mark As Completed</span>
                                </div>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="field grid">
                <div class="col-12">
                    <div class="p-inputgroup">
                        <Dropdown v-model="leadMachine.msgphone_country_code"
                                  :options="countries"
                                  style="border-top-left-radius: 1rem;border-bottom-left-radius: 1rem; border-right: none"
                                  optionLabel="name"
                                  optionValue="code">

                            <template #value="slotProps">
                                <div class="flex align-items-center" style="height: 100%">
                                    <div v-if="slotProps.value">
                                        <span :class="'fi fi-' + slotProps.value"/>
                                    </div>
                                    <span v-else>
                                            <span :class="'fi fi-us'"/>
                                    </span>
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="" style="display: inline;">
                                    <span :class="'fi fi-' + slotProps.option.code"></span>
                                    <div class="ml-3" style="display: inline;">{{
                                            slotProps.option.name
                                        }}
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                        <span class="p-float-label">
                            <InputText
                                id="phone-number"
                                class="text-2xl"
                                v-model="leadBeingEdited.sms_number"
                                style="border-top-right-radius: 1rem;border-bottom-right-radius: 1rem;"
                                required
                                placeholder="Type phone number here.."/>
                                <label for="phone-number" class="move-left">New Lead SMS Notification</label>
                        </span>
                    </div>
                </div>
            </div> -->

            <!--            <Button class="p-button p-button-outlined p-button-danger"-->
            <!--                    style="border-radius: 1.5em !important;padding:0px 30px;font-size:15px;height:40px"-->
            <!--                    label="Add More"-->
            <!--                    icon="pi pi-plus">-->

            <!--            </Button>-->

            <div class="field col-12 px-0 px-0">
                <span class="p-float-label">
                    <MultiSelect class="w-full"
                                 id="multiselect"
                                 :filter="true"
                                 placeholder="Add Lists"
                                 display="chip"
                                 v-model="leadBeingEdited.lists_input"
                                 optionLabel="filename"
                                 :options="lists"
                    >
                        <template #option="slotProps">
                            <span class="">{{ slotProps.option.filename }}</span>
                            <span class="flex-grow-1"></span>
                        </template>
                    </MultiSelect>
                    <label for="multiselect">Add Lists</label>
                </span>
            </div>

            <div class="field grid mt-2 mb-0">
                <!--Back Button-->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="websiteEditStep3Back"

                    >
                        <div class="w-100" style="align-items: center;">
                            <span class="pi pi-arrow-left" style="font-size:20px"></span>
                            <span class="ms-3" style="font-size:20px">Go Back</span>
                        </div>
                    </Button>
                </div>
                <!--Upload Button -->
                <div class="field col-6 mt-2">
                    <Button class="p-button p-button-outlined p-button-danger w-full py-3"
                            style="border-radius: 0.5rem !important;"
                            @click="finishEditWebsite"
                            :loading="verifyStep3"
                    >
                        <div class="w-100" style="align-items: center;">
                            <span style="font-size:20px">Finish Website</span>
                        </div>
                    </Button>
                </div>
            </div>
        </div>
    </Dialog>


    <Dialog @update:visible="handleClose" class="u_ndnddn" v-model:visible="showLearnHow" :draggable="false" :modal="true">
            <h3 class="text-center mt-0 u_fnt-22 font-bold">
                Learn How To Connect Custom Domain <br />

            </h3>

            <p class="text-center u_mdl_fnt_14px">
                Watch Video Below To Learn Exactly Step By Step How To Connect A Custom Domain To Your Lead Machine Website
            </p>
            <div>
                    <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_n2nr5pvma4 videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/n2nr5pvma4/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>
            </div>


    </Dialog>


    <Toast/>
    <ConfirmDialog/>
</template>


<style>

    .p-float-label input:focus ~ label.move-left, .p-float-label input.p-filled ~ label.move-left {
        margin-left: -5rem;
    }

    .p-float-label .p-dropdown .p-placeholder {
        opacity: 1!important;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: grey;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 17px;
        width: 17px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: red;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .custom-file-input {
        border: 1px solid #999;
        border-radius: 30px;
        padding: 12px 21px;
        cursor: pointer;
        color: white;
        font-size: 9pt;
        background: #DB0F19;
    }

    .form-check-input:checked {
        background-color: #DB0F19;
        border-color: #DB0F19;
    }

    .checks .form-check-input {
        width: 38px!important;
        height: 20px;
    }

    .p-dropdown {
        width: 5rem !important;
        flex-grow: 0;
    }

    .p-float-label input:focus ~ label.move-left, .p-float-label input.p-filled ~ label.move-left {
        margin-left: -5rem;
    }

    .top-cards {
        border: 1px solid #EBEBEB;
        border-radius: 10px;
        padding: 10px;
    }

    .p-paginator .p-paginator-pages .p-paginator-page.p-highlight {
        background: rgba(219, 15, 25, 0.12);
        border-color: rgba(219, 15, 25, 0.12);
        color: rgba(219, 15, 25, 1);
        font-weight: bold;
    }

    .p-dropdown-panel .p-dropdown-items .p-dropdown-item.p-highlight {
        color: rgba(219, 15, 25, 1);
        background: rgba(219, 15, 25, 0.12);
    }

    .p-dialog-header {
        padding-bottom: 0.5rem !important;
    }

    .no-left-border {
        border-left: 0 !important;
    }

    .no-right-border {
        border-right: 0 !important;
    }

    .s-border-cu {
        border-top: 1px solid !important;
    }

    .p-button.p-button-grey.p-button-outlined {
        background-color: transparent;
        color: #575A7B;
        border: 0 none;
        /*box-shadow: inset 0 0 0 1px var(--surface-border) !important;*/
    }

    .p-divider.p-divider-horizontal:before {
        border-top: 1px rgba(0, 0, 0, 0.38) !important;
        position: absolute;
        display: block;
        top: 50%;
        left: 0;
        width: 100%;
        content: '';
    }

    .p-fileupload-choose.p-button-danger:hover {
        background-color: #D32F2F;
    }

    .p-multiselect-panel .p-multiselect-items .p-multiselect-item.p-highlight {
        color: inherit;
        background: rgba(219, 15, 25, 0.12);
    }

    .p-multiselect-item > .p-checkbox {
        display: none;
    }

    .p-checkbox .p-checkbox-box.p-highlight:not(.p-disabled).p-focus {
        border-color: rgba(219, 15, 25, 1);
        background: rgba(219, 15, 25, 1);
    }

    .hover-links:hover {
        cursor: pointer;
        color: rgba(219, 15, 25, 1);
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        position: relative;
        max-width: 502px;
        margin: 0 auto;
    }
    .timelineStepLine{
            height: 3px;
            background: #E6EAED;
            border-radius: 10px;
            position: absolute;
            top: 20%;
            width: 80%;
            left: 11%;
        }
    .timeline-steps .timeline-step {
        align-items: center;
        display: flex;
        flex-direction: column;
        position: relative;
        margin: 1rem
    }

    .timeline-steps .timeline-step.active:not(:last-child):after {
        content: "";
        display: block;
        border-top: 0.3rem solid red;
        width: 11rem;
        position: absolute;
        left: 5.1rem;
        top: 0.3125rem;
    }

    .timeline-steps .timeline-content {
        /* width: 6rem; */
        text-align: center
    }

    .daterangepicker td.active, .daterangepicker td.active:hover {
        /* border-color: none!important; */
        background: rgba(219, 15, 25, 1)!important;
        height: 30px;
        width: 30px;
        border-radius: 50%!important;
    }

    .daterangepicker .ranges li.active {
        border-color: rgba(219, 15, 25, 1)!important;
        background: rgba(219, 15, 25, 1)!important;
    }

    .p-button-success-half {
        padding: 20px!important;
        border-color: #B3DB15!important;
        color: #B3DB15!important;

    }

    .applyBtn {
        border-color: rgba(219, 15, 25, 1)!important;
        background: rgba(219, 15, 25, 1)!important;
    }

    .timeline-steps .timeline-content .inner-circle {
        border-radius: 1.5rem;
        height: 1rem;
        width: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #3b82f6
    }

    .timeline-steps .timeline-content .inner-circle.active:before {
        content: "";
        background-color: #DB0F19;
        display: inline-block;
        height: 3.1rem;
        color: #ffffff;
        min-width: 3.1rem;
        border-radius: 6.25rem;
    }

    .timeline-steps .timeline-content .inner-circle:before {


        content: "";
        background-color: white;
        display: inline-block;
        border: 4px solid red;
        height: 3.1rem;
        color: black;
        min-width: 3.1rem;
        border-radius: 6.25rem;
    }

    .timeline-steps .timeline-content .inner-circle-white {
        border-radius: 1.5rem;
        height: 1rem;
        width: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff
    }

    .timeline-steps .timeline-content .inner-circle-white:before {
        content: "";
        background-color: #ffffff;
        display: inline-block;
        height: 2.1rem;
        width: 2.1rem;
        border: 1px solid #D9D9D9;
        color: #ffffff;
        min-width: 2.1rem;
        border-radius: 6.25rem;
    }

    .time-line-txt-active {
        color: #ffffff;
        margin: 1px 0px 0px -28px;
        font-size: 1.2rem;

    }

    .time-line-txt {
        color: #8A8A8A;
        margin: 1px 0px 0px -21px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .count-butonn {
        background: white;
        color: #8A8A8A;
        border: 1px solid #D9D9D9;
        border-radius: 50px;
        font-weight: 500;
        text-align: center;
        font-size: 0.8rem;
        padding: 4px 10px 4px 10px;
    }

    .count-btn-txt-active {
        font-size: 1.2rem;
        text-align: center;
        padding: 8px 0px 0px 20px;
    }

    .count-btn-txt {
        color: #838383;
        font-weight: 600;
        font-size: 0.7rem;
        text-align: center;
        padding: 8px 0px 0px 12px;
    }
    .cred-text {
    padding: 10px 28px ;
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;

    /* Text 2 */

    color: #575A7B;

    text-align: center;
}

.copy-btn-border {
    border: 1px solid #EBEBEB;
    border-radius: 10px;
    padding: 3px;
    padding-left: 15px;
}

.p-datatable tr:first-child th:first-child {
    border-top-left-radius: 0px !important;
}
.p-datatable tr:first-child th:last-child {
    border-top-right-radius: 0px !important;
}
.p-paginator .p-paginator-pages .p-paginator-page.p-highlight {
    background: rgba(63, 81, 181, 0.12) !important;
    color: rgba(0, 0, 0, 0.6);
}
</style>
