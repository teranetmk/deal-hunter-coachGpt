<script>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { Link } from "@inertiajs/inertia-vue3";
import "flag-icons/css/flag-icons.min.css";
import { onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

import moment from "moment";

onMounted(() => {
    if (!phone_country_code || !phone_country_code.length) {
        phone_country_code = "us";
    }
});

var flabel, fsdate, fedate;

export default {
    name: "ListsPage",
    props: [
        "allMotivationTags",
        "allLists",
        "accepted",
        "denied",
        "allOffers",
        "domains",
        "direct_coms",
        "counterOffers",
    ],
    data() {
        return {
            creds_req: 0,
            startDate: "",
            endDate: "",
            filterLabel: "Date",
            credits: usePage().props.value.auth.user.total_credits,
            acceptCount: this.accepted,
            deniedCount: this.denied,
            offersCount: this.allOffers,
            counterCount: this.counterOffers,
            domains: this.domains,
            direct_coms: this.direct_coms,
            postcard: null,
            allTags: this.allMotivationTags,
            allListsArr: this.allLists,
            selectedDomain: "",
            compaignName: "",
            lists_input: "",
            phone: "",
            lists: this.allLists,
            displayCampaignModal: false,
            displayReviewCampaign: false,
            displayEditTagModal: false,
            displayWebsiteModal1: false,
            displayWebsiteModal2: false,
            displayWebsiteModal3: false,
            displayAddTagModal: false,
            creatingTag: false,
            createTagForm: { tagName: "" },
            savingEditedTag: false,
            editTagForm: { oTagName: null, tagName: null, tagId: null },
            uploadFileForm: { motivation_tags: [], import_file: null },
            uploadFileFormBeforeEdit: null,
            upLoadingList: false,
            filters: null,
            listTableLoading: false,
            listBeingEdited: {
                listId: null,
                fileName: null,
                properties_count: null,
                import_time: null,
                tags: [],
                tagRows: [],
            },
            listNameEditModalActive: false,
            listTagsEditModalActive: false,
            savingListTags: false,
            savingListName: false,
            deletedTagIdArray: [],
            countries: [
                {
                    capital: "Kabul",
                    code: "af",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/af.svg",
                    flag_4x3: "flags/4x3/af.svg",
                    iso: true,
                    name: "Afghanistan",
                },
                {
                    capital: "Mariehamn",
                    code: "ax",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ax.svg",
                    flag_4x3: "flags/4x3/ax.svg",
                    iso: true,
                    name: "Aland Islands",
                },
                {
                    capital: "Tirana",
                    code: "al",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/al.svg",
                    flag_4x3: "flags/4x3/al.svg",
                    iso: true,
                    name: "Albania",
                },
                {
                    capital: "Algiers",
                    code: "dz",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/dz.svg",
                    flag_4x3: "flags/4x3/dz.svg",
                    iso: true,
                    name: "Algeria",
                },
                {
                    capital: "Pago Pago",
                    code: "as",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/as.svg",
                    flag_4x3: "flags/4x3/as.svg",
                    iso: true,
                    name: "American Samoa",
                },
                {
                    capital: "Andorra la Vella",
                    code: "ad",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ad.svg",
                    flag_4x3: "flags/4x3/ad.svg",
                    iso: true,
                    name: "Andorra",
                },
                {
                    capital: "Luanda",
                    code: "ao",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ao.svg",
                    flag_4x3: "flags/4x3/ao.svg",
                    iso: true,
                    name: "Angola",
                },
                {
                    capital: "The Valley",
                    code: "ai",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ai.svg",
                    flag_4x3: "flags/4x3/ai.svg",
                    iso: true,
                    name: "Anguilla",
                },
                {
                    code: "aq",
                    flag_1x1: "flags/1x1/aq.svg",
                    flag_4x3: "flags/4x3/aq.svg",
                    iso: true,
                    name: "Antarctica",
                },
                {
                    capital: "St. John's",
                    code: "ag",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ag.svg",
                    flag_4x3: "flags/4x3/ag.svg",
                    iso: true,
                    name: "Antigua and Barbuda",
                },
                {
                    capital: "Buenos Aires",
                    code: "ar",
                    continent: "South America",
                    flag_1x1: "flags/1x1/ar.svg",
                    flag_4x3: "flags/4x3/ar.svg",
                    iso: true,
                    name: "Argentina",
                },
                {
                    capital: "Yerevan",
                    code: "am",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/am.svg",
                    flag_4x3: "flags/4x3/am.svg",
                    iso: true,
                    name: "Armenia",
                },
                {
                    capital: "Oranjestad",
                    code: "aw",
                    continent: "South America",
                    flag_1x1: "flags/1x1/aw.svg",
                    flag_4x3: "flags/4x3/aw.svg",
                    iso: true,
                    name: "Aruba",
                },
                {
                    capital: "Georgetown",
                    code: "ac",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ac.svg",
                    flag_4x3: "flags/4x3/ac.svg",
                    iso: false,
                    name: "Ascension Island",
                },
                {
                    capital: "Canberra",
                    code: "au",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/au.svg",
                    flag_4x3: "flags/4x3/au.svg",
                    iso: true,
                    name: "Australia",
                },
                {
                    capital: "Vienna",
                    code: "at",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/at.svg",
                    flag_4x3: "flags/4x3/at.svg",
                    iso: true,
                    name: "Austria",
                },
                {
                    capital: "Baku",
                    code: "az",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/az.svg",
                    flag_4x3: "flags/4x3/az.svg",
                    iso: true,
                    name: "Azerbaijan",
                },
                {
                    capital: "Nassau",
                    code: "bs",
                    continent: "North America",
                    flag_1x1: "flags/1x1/bs.svg",
                    flag_4x3: "flags/4x3/bs.svg",
                    iso: true,
                    name: "Bahamas",
                },
                {
                    capital: "Manama",
                    code: "bh",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/bh.svg",
                    flag_4x3: "flags/4x3/bh.svg",
                    iso: true,
                    name: "Bahrain",
                },
                {
                    capital: "Dhaka",
                    code: "bd",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/bd.svg",
                    flag_4x3: "flags/4x3/bd.svg",
                    iso: true,
                    name: "Bangladesh",
                },
                {
                    capital: "Bridgetown",
                    code: "bb",
                    continent: "North America",
                    flag_1x1: "flags/1x1/bb.svg",
                    flag_4x3: "flags/4x3/bb.svg",
                    iso: true,
                    name: "Barbados",
                },
                {
                    capital: "Minsk",
                    code: "by",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/by.svg",
                    flag_4x3: "flags/4x3/by.svg",
                    iso: true,
                    name: "Belarus",
                },
                {
                    capital: "Brussels",
                    code: "be",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/be.svg",
                    flag_4x3: "flags/4x3/be.svg",
                    iso: true,
                    name: "Belgium",
                },
                {
                    capital: "Belmopan",
                    code: "bz",
                    continent: "North America",
                    flag_1x1: "flags/1x1/bz.svg",
                    flag_4x3: "flags/4x3/bz.svg",
                    iso: true,
                    name: "Belize",
                },
                {
                    capital: "Porto-Novo",
                    code: "bj",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/bj.svg",
                    flag_4x3: "flags/4x3/bj.svg",
                    iso: true,
                    name: "Benin",
                },
                {
                    capital: "Hamilton",
                    code: "bm",
                    continent: "North America",
                    flag_1x1: "flags/1x1/bm.svg",
                    flag_4x3: "flags/4x3/bm.svg",
                    iso: true,
                    name: "Bermuda",
                },
                {
                    capital: "Thimphu",
                    code: "bt",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/bt.svg",
                    flag_4x3: "flags/4x3/bt.svg",
                    iso: true,
                    name: "Bhutan",
                },
                {
                    capital: "Sucre",
                    code: "bo",
                    continent: "South America",
                    flag_1x1: "flags/1x1/bo.svg",
                    flag_4x3: "flags/4x3/bo.svg",
                    iso: true,
                    name: "Bolivia",
                },
                {
                    capital: "Kralendijk",
                    code: "bq",
                    continent: "South America",
                    flag_1x1: "flags/1x1/bq.svg",
                    flag_4x3: "flags/4x3/bq.svg",
                    iso: true,
                    name: "Bonaire, Sint Eustatius and Saba",
                },
                {
                    capital: "Sarajevo",
                    code: "ba",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ba.svg",
                    flag_4x3: "flags/4x3/ba.svg",
                    iso: true,
                    name: "Bosnia and Herzegovina",
                },
                {
                    capital: "Gaborone",
                    code: "bw",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/bw.svg",
                    flag_4x3: "flags/4x3/bw.svg",
                    iso: true,
                    name: "Botswana",
                },
                {
                    code: "bv",
                    flag_1x1: "flags/1x1/bv.svg",
                    flag_4x3: "flags/4x3/bv.svg",
                    iso: true,
                    name: "Bouvet Island",
                },
                {
                    capital: "Brasília",
                    code: "br",
                    continent: "South America",
                    flag_1x1: "flags/1x1/br.svg",
                    flag_4x3: "flags/4x3/br.svg",
                    iso: true,
                    name: "Brazil",
                },
                {
                    capital: "Diego Garcia",
                    code: "io",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/io.svg",
                    flag_4x3: "flags/4x3/io.svg",
                    iso: true,
                    name: "British Indian Ocean Territory",
                },
                {
                    capital: "Bandar Seri Begawan",
                    code: "bn",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/bn.svg",
                    flag_4x3: "flags/4x3/bn.svg",
                    iso: true,
                    name: "Brunei Darussalam",
                },
                {
                    capital: "Sofia",
                    code: "bg",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/bg.svg",
                    flag_4x3: "flags/4x3/bg.svg",
                    iso: true,
                    name: "Bulgaria",
                },
                {
                    capital: "Ouagadougou",
                    code: "bf",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/bf.svg",
                    flag_4x3: "flags/4x3/bf.svg",
                    iso: true,
                    name: "Burkina Faso",
                },
                {
                    capital: "Bujumbura",
                    code: "bi",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/bi.svg",
                    flag_4x3: "flags/4x3/bi.svg",
                    iso: true,
                    name: "Burundi",
                },
                {
                    capital: "Praia",
                    code: "cv",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/cv.svg",
                    flag_4x3: "flags/4x3/cv.svg",
                    iso: true,
                    name: "Cabo Verde",
                },
                {
                    capital: "Phnom Penh",
                    code: "kh",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/kh.svg",
                    flag_4x3: "flags/4x3/kh.svg",
                    iso: true,
                    name: "Cambodia",
                },
                {
                    capital: "Yaoundé",
                    code: "cm",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/cm.svg",
                    flag_4x3: "flags/4x3/cm.svg",
                    iso: true,
                    name: "Cameroon",
                },
                {
                    capital: "Ottawa",
                    code: "ca",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ca.svg",
                    flag_4x3: "flags/4x3/ca.svg",
                    iso: true,
                    name: "Canada",
                },
                {
                    code: "ic",
                    flag_1x1: "flags/1x1/ic.svg",
                    flag_4x3: "flags/4x3/ic.svg",
                    iso: false,
                    name: "Canary Islands",
                },
                {
                    code: "es-ct",
                    flag_1x1: "flags/1x1/es-ct.svg",
                    flag_4x3: "flags/4x3/es-ct.svg",
                    iso: false,
                    name: "Catalonia",
                },
                {
                    capital: "George Town",
                    code: "ky",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ky.svg",
                    flag_4x3: "flags/4x3/ky.svg",
                    iso: true,
                    name: "Cayman Islands",
                },
                {
                    capital: "Bangui",
                    code: "cf",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/cf.svg",
                    flag_4x3: "flags/4x3/cf.svg",
                    iso: true,
                    name: "Central African Republic",
                },
                {
                    code: "cefta",
                    flag_1x1: "flags/1x1/cefta.svg",
                    flag_4x3: "flags/4x3/cefta.svg",
                    iso: false,
                    name: "Central European Free Trade Agreement",
                },
                {
                    code: "ea",
                    flag_1x1: "flags/1x1/ea.svg",
                    flag_4x3: "flags/4x3/ea.svg",
                    iso: false,
                    name: "Ceuta & Melilla",
                },
                {
                    capital: "N'Djamena",
                    code: "td",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/td.svg",
                    flag_4x3: "flags/4x3/td.svg",
                    iso: true,
                    name: "Chad",
                },
                {
                    capital: "Santiago",
                    code: "cl",
                    continent: "South America",
                    flag_1x1: "flags/1x1/cl.svg",
                    flag_4x3: "flags/4x3/cl.svg",
                    iso: true,
                    name: "Chile",
                },
                {
                    capital: "Beijing",
                    code: "cn",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/cn.svg",
                    flag_4x3: "flags/4x3/cn.svg",
                    iso: true,
                    name: "China",
                },
                {
                    capital: "Flying Fish Cove",
                    code: "cx",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/cx.svg",
                    flag_4x3: "flags/4x3/cx.svg",
                    iso: true,
                    name: "Christmas Island",
                },
                {
                    code: "cp",
                    flag_1x1: "flags/1x1/cp.svg",
                    flag_4x3: "flags/4x3/cp.svg",
                    iso: false,
                    name: "Clipperton Island",
                },
                {
                    capital: "West Island",
                    code: "cc",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/cc.svg",
                    flag_4x3: "flags/4x3/cc.svg",
                    iso: true,
                    name: "Cocos (Keeling) Islands",
                },
                {
                    capital: "Bogotá",
                    code: "co",
                    continent: "South America",
                    flag_1x1: "flags/1x1/co.svg",
                    flag_4x3: "flags/4x3/co.svg",
                    iso: true,
                    name: "Colombia",
                },
                {
                    capital: "Moroni",
                    code: "km",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/km.svg",
                    flag_4x3: "flags/4x3/km.svg",
                    iso: true,
                    name: "Comoros",
                },
                {
                    capital: "Avarua",
                    code: "ck",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/ck.svg",
                    flag_4x3: "flags/4x3/ck.svg",
                    iso: true,
                    name: "Cook Islands",
                },
                {
                    capital: "San José",
                    code: "cr",
                    continent: "North America",
                    flag_1x1: "flags/1x1/cr.svg",
                    flag_4x3: "flags/4x3/cr.svg",
                    iso: true,
                    name: "Costa Rica",
                },
                {
                    capital: "Zagreb",
                    code: "hr",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/hr.svg",
                    flag_4x3: "flags/4x3/hr.svg",
                    iso: true,
                    name: "Croatia",
                },
                {
                    capital: "Havana",
                    code: "cu",
                    continent: "North America",
                    flag_1x1: "flags/1x1/cu.svg",
                    flag_4x3: "flags/4x3/cu.svg",
                    iso: true,
                    name: "Cuba",
                },
                {
                    capital: "Willemstad",
                    code: "cw",
                    continent: "South America",
                    flag_1x1: "flags/1x1/cw.svg",
                    flag_4x3: "flags/4x3/cw.svg",
                    iso: true,
                    name: "Curaçao",
                },
                {
                    capital: "Nicosia",
                    code: "cy",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/cy.svg",
                    flag_4x3: "flags/4x3/cy.svg",
                    iso: true,
                    name: "Cyprus",
                },
                {
                    capital: "Prague",
                    code: "cz",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/cz.svg",
                    flag_4x3: "flags/4x3/cz.svg",
                    iso: true,
                    name: "Czech Republic",
                },
                {
                    capital: "Yamoussoukro",
                    code: "ci",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ci.svg",
                    flag_4x3: "flags/4x3/ci.svg",
                    iso: true,
                    name: "Côte d'Ivoire",
                },
                {
                    capital: "Kinshasa",
                    code: "cd",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/cd.svg",
                    flag_4x3: "flags/4x3/cd.svg",
                    iso: true,
                    name: "Democratic Republic of the Congo",
                },
                {
                    capital: "Copenhagen",
                    code: "dk",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/dk.svg",
                    flag_4x3: "flags/4x3/dk.svg",
                    iso: true,
                    name: "Denmark",
                },
                {
                    code: "dg",
                    flag_1x1: "flags/1x1/dg.svg",
                    flag_4x3: "flags/4x3/dg.svg",
                    iso: false,
                    name: "Diego Garcia",
                },
                {
                    capital: "Djibouti",
                    code: "dj",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/dj.svg",
                    flag_4x3: "flags/4x3/dj.svg",
                    iso: true,
                    name: "Djibouti",
                },
                {
                    capital: "Roseau",
                    code: "dm",
                    continent: "North America",
                    flag_1x1: "flags/1x1/dm.svg",
                    flag_4x3: "flags/4x3/dm.svg",
                    iso: true,
                    name: "Dominica",
                },
                {
                    capital: "Santo Domingo",
                    code: "do",
                    continent: "North America",
                    flag_1x1: "flags/1x1/do.svg",
                    flag_4x3: "flags/4x3/do.svg",
                    iso: true,
                    name: "Dominican Republic",
                },
                {
                    capital: "Quito",
                    code: "ec",
                    continent: "South America",
                    flag_1x1: "flags/1x1/ec.svg",
                    flag_4x3: "flags/4x3/ec.svg",
                    iso: true,
                    name: "Ecuador",
                },
                {
                    capital: "Cairo",
                    code: "eg",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/eg.svg",
                    flag_4x3: "flags/4x3/eg.svg",
                    iso: true,
                    name: "Egypt",
                },
                {
                    capital: "San Salvador",
                    code: "sv",
                    continent: "North America",
                    flag_1x1: "flags/1x1/sv.svg",
                    flag_4x3: "flags/4x3/sv.svg",
                    iso: true,
                    name: "El Salvador",
                },
                {
                    capital: "London",
                    code: "gb-eng",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gb-eng.svg",
                    flag_4x3: "flags/4x3/gb-eng.svg",
                    iso: false,
                    name: "England",
                },
                {
                    capital: "Malabo",
                    code: "gq",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/gq.svg",
                    flag_4x3: "flags/4x3/gq.svg",
                    iso: true,
                    name: "Equatorial Guinea",
                },
                {
                    capital: "Asmara",
                    code: "er",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/er.svg",
                    flag_4x3: "flags/4x3/er.svg",
                    iso: true,
                    name: "Eritrea",
                },
                {
                    capital: "Tallinn",
                    code: "ee",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ee.svg",
                    flag_4x3: "flags/4x3/ee.svg",
                    iso: true,
                    name: "Estonia",
                },
                {
                    capital: "Lobamba, Mbabane",
                    code: "sz",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/sz.svg",
                    flag_4x3: "flags/4x3/sz.svg",
                    iso: true,
                    name: "Eswatini",
                },
                {
                    capital: "Addis Ababa",
                    code: "et",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/et.svg",
                    flag_4x3: "flags/4x3/et.svg",
                    iso: true,
                    name: "Ethiopia",
                },
                {
                    code: "eu",
                    flag_1x1: "flags/1x1/eu.svg",
                    flag_4x3: "flags/4x3/eu.svg",
                    iso: false,
                    name: "Europe",
                },
                {
                    capital: "Stanley",
                    code: "fk",
                    continent: "South America",
                    flag_1x1: "flags/1x1/fk.svg",
                    flag_4x3: "flags/4x3/fk.svg",
                    iso: true,
                    name: "Falkland Islands",
                },
                {
                    capital: "Tórshavn",
                    code: "fo",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/fo.svg",
                    flag_4x3: "flags/4x3/fo.svg",
                    iso: true,
                    name: "Faroe Islands",
                },
                {
                    capital: "Palikir",
                    code: "fm",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/fm.svg",
                    flag_4x3: "flags/4x3/fm.svg",
                    iso: true,
                    name: "Federated States of Micronesia",
                },
                {
                    capital: "Suva",
                    code: "fj",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/fj.svg",
                    flag_4x3: "flags/4x3/fj.svg",
                    iso: true,
                    name: "Fiji",
                },
                {
                    capital: "Helsinki",
                    code: "fi",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/fi.svg",
                    flag_4x3: "flags/4x3/fi.svg",
                    iso: true,
                    name: "Finland",
                },
                {
                    capital: "Paris",
                    code: "fr",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/fr.svg",
                    flag_4x3: "flags/4x3/fr.svg",
                    iso: true,
                    name: "France",
                },
                {
                    capital: "Cayenne",
                    code: "gf",
                    continent: "South America",
                    flag_1x1: "flags/1x1/gf.svg",
                    flag_4x3: "flags/4x3/gf.svg",
                    iso: true,
                    name: "French Guiana",
                },
                {
                    capital: "Papeete",
                    code: "pf",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/pf.svg",
                    flag_4x3: "flags/4x3/pf.svg",
                    iso: true,
                    name: "French Polynesia",
                },
                {
                    capital: "Saint-Pierre, Réunion",
                    code: "tf",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/tf.svg",
                    flag_4x3: "flags/4x3/tf.svg",
                    iso: true,
                    name: "French Southern Territories",
                },
                {
                    capital: "Libreville",
                    code: "ga",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ga.svg",
                    flag_4x3: "flags/4x3/ga.svg",
                    iso: true,
                    name: "Gabon",
                },
                {
                    code: "es-ga",
                    flag_1x1: "flags/1x1/es-ga.svg",
                    flag_4x3: "flags/4x3/es-ga.svg",
                    iso: false,
                    name: "Galicia",
                },
                {
                    capital: "Banjul",
                    code: "gm",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/gm.svg",
                    flag_4x3: "flags/4x3/gm.svg",
                    iso: true,
                    name: "Gambia",
                },
                {
                    capital: "Tbilisi",
                    code: "ge",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/ge.svg",
                    flag_4x3: "flags/4x3/ge.svg",
                    iso: true,
                    name: "Georgia",
                },
                {
                    capital: "Berlin",
                    code: "de",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/de.svg",
                    flag_4x3: "flags/4x3/de.svg",
                    iso: true,
                    name: "Germany",
                },
                {
                    capital: "Accra",
                    code: "gh",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/gh.svg",
                    flag_4x3: "flags/4x3/gh.svg",
                    iso: true,
                    name: "Ghana",
                },
                {
                    capital: "Gibraltar",
                    code: "gi",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gi.svg",
                    flag_4x3: "flags/4x3/gi.svg",
                    iso: true,
                    name: "Gibraltar",
                },
                {
                    capital: "Athens",
                    code: "gr",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gr.svg",
                    flag_4x3: "flags/4x3/gr.svg",
                    iso: true,
                    name: "Greece",
                },
                {
                    capital: "Nuuk",
                    code: "gl",
                    continent: "North America",
                    flag_1x1: "flags/1x1/gl.svg",
                    flag_4x3: "flags/4x3/gl.svg",
                    iso: true,
                    name: "Greenland",
                },
                {
                    capital: "St. George's",
                    code: "gd",
                    continent: "North America",
                    flag_1x1: "flags/1x1/gd.svg",
                    flag_4x3: "flags/4x3/gd.svg",
                    iso: true,
                    name: "Grenada",
                },
                {
                    capital: "Basse-Terre",
                    code: "gp",
                    continent: "North America",
                    flag_1x1: "flags/1x1/gp.svg",
                    flag_4x3: "flags/4x3/gp.svg",
                    iso: true,
                    name: "Guadeloupe",
                },
                {
                    capital: "Hagåtña",
                    code: "gu",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/gu.svg",
                    flag_4x3: "flags/4x3/gu.svg",
                    iso: true,
                    name: "Guam",
                },
                {
                    capital: "Guatemala City",
                    code: "gt",
                    continent: "North America",
                    flag_1x1: "flags/1x1/gt.svg",
                    flag_4x3: "flags/4x3/gt.svg",
                    iso: true,
                    name: "Guatemala",
                },
                {
                    capital: "Saint Peter Port",
                    code: "gg",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gg.svg",
                    flag_4x3: "flags/4x3/gg.svg",
                    iso: true,
                    name: "Guernsey",
                },
                {
                    capital: "Conakry",
                    code: "gn",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/gn.svg",
                    flag_4x3: "flags/4x3/gn.svg",
                    iso: true,
                    name: "Guinea",
                },
                {
                    capital: "Bissau",
                    code: "gw",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/gw.svg",
                    flag_4x3: "flags/4x3/gw.svg",
                    iso: true,
                    name: "Guinea-Bissau",
                },
                {
                    capital: "Georgetown",
                    code: "gy",
                    continent: "South America",
                    flag_1x1: "flags/1x1/gy.svg",
                    flag_4x3: "flags/4x3/gy.svg",
                    iso: true,
                    name: "Guyana",
                },
                {
                    capital: "Port-au-Prince",
                    code: "ht",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ht.svg",
                    flag_4x3: "flags/4x3/ht.svg",
                    iso: true,
                    name: "Haiti",
                },
                {
                    code: "hm",
                    flag_1x1: "flags/1x1/hm.svg",
                    flag_4x3: "flags/4x3/hm.svg",
                    iso: true,
                    name: "Heard Island and McDonald Islands",
                },
                {
                    capital: "Vatican City",
                    code: "va",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/va.svg",
                    flag_4x3: "flags/4x3/va.svg",
                    iso: true,
                    name: "Holy See",
                },
                {
                    capital: "Tegucigalpa",
                    code: "hn",
                    continent: "North America",
                    flag_1x1: "flags/1x1/hn.svg",
                    flag_4x3: "flags/4x3/hn.svg",
                    iso: true,
                    name: "Honduras",
                },
                {
                    capital: "Hong Kong",
                    code: "hk",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/hk.svg",
                    flag_4x3: "flags/4x3/hk.svg",
                    iso: true,
                    name: "Hong Kong",
                },
                {
                    capital: "Budapest",
                    code: "hu",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/hu.svg",
                    flag_4x3: "flags/4x3/hu.svg",
                    iso: true,
                    name: "Hungary",
                },
                {
                    capital: "Reykjavik",
                    code: "is",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/is.svg",
                    flag_4x3: "flags/4x3/is.svg",
                    iso: true,
                    name: "Iceland",
                },
                {
                    capital: "New Delhi",
                    code: "in",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/in.svg",
                    flag_4x3: "flags/4x3/in.svg",
                    iso: true,
                    name: "India",
                },
                {
                    capital: "Jakarta",
                    code: "id",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/id.svg",
                    flag_4x3: "flags/4x3/id.svg",
                    iso: true,
                    name: "Indonesia",
                },
                {
                    capital: "Tehran",
                    code: "ir",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/ir.svg",
                    flag_4x3: "flags/4x3/ir.svg",
                    iso: true,
                    name: "Iran",
                },
                {
                    capital: "Baghdad",
                    code: "iq",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/iq.svg",
                    flag_4x3: "flags/4x3/iq.svg",
                    iso: true,
                    name: "Iraq",
                },
                {
                    capital: "Dublin",
                    code: "ie",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ie.svg",
                    flag_4x3: "flags/4x3/ie.svg",
                    iso: true,
                    name: "Ireland",
                },
                {
                    capital: "Douglas",
                    code: "im",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/im.svg",
                    flag_4x3: "flags/4x3/im.svg",
                    iso: true,
                    name: "Isle of Man",
                },
                {
                    capital: "Jerusalem",
                    code: "il",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/il.svg",
                    flag_4x3: "flags/4x3/il.svg",
                    iso: true,
                    name: "Israel",
                },
                {
                    capital: "Rome",
                    code: "it",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/it.svg",
                    flag_4x3: "flags/4x3/it.svg",
                    iso: true,
                    name: "Italy",
                },
                {
                    capital: "Kingston",
                    code: "jm",
                    continent: "North America",
                    flag_1x1: "flags/1x1/jm.svg",
                    flag_4x3: "flags/4x3/jm.svg",
                    iso: true,
                    name: "Jamaica",
                },
                {
                    capital: "Tokyo",
                    code: "jp",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/jp.svg",
                    flag_4x3: "flags/4x3/jp.svg",
                    iso: true,
                    name: "Japan",
                },
                {
                    capital: "Saint Helier",
                    code: "je",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/je.svg",
                    flag_4x3: "flags/4x3/je.svg",
                    iso: true,
                    name: "Jersey",
                },
                {
                    capital: "Amman",
                    code: "jo",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/jo.svg",
                    flag_4x3: "flags/4x3/jo.svg",
                    iso: true,
                    name: "Jordan",
                },
                {
                    capital: "Astana",
                    code: "kz",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/kz.svg",
                    flag_4x3: "flags/4x3/kz.svg",
                    iso: true,
                    name: "Kazakhstan",
                },
                {
                    capital: "Nairobi",
                    code: "ke",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ke.svg",
                    flag_4x3: "flags/4x3/ke.svg",
                    iso: true,
                    name: "Kenya",
                },
                {
                    capital: "South Tarawa",
                    code: "ki",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/ki.svg",
                    flag_4x3: "flags/4x3/ki.svg",
                    iso: true,
                    name: "Kiribati",
                },
                {
                    capital: "Pristina",
                    code: "xk",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/xk.svg",
                    flag_4x3: "flags/4x3/xk.svg",
                    iso: false,
                    name: "Kosovo",
                },
                {
                    capital: "Kuwait City",
                    code: "kw",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/kw.svg",
                    flag_4x3: "flags/4x3/kw.svg",
                    iso: true,
                    name: "Kuwait",
                },
                {
                    capital: "Bishkek",
                    code: "kg",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/kg.svg",
                    flag_4x3: "flags/4x3/kg.svg",
                    iso: true,
                    name: "Kyrgyzstan",
                },
                {
                    capital: "Vientiane",
                    code: "la",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/la.svg",
                    flag_4x3: "flags/4x3/la.svg",
                    iso: true,
                    name: "Laos",
                },
                {
                    capital: "Riga",
                    code: "lv",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/lv.svg",
                    flag_4x3: "flags/4x3/lv.svg",
                    iso: true,
                    name: "Latvia",
                },
                {
                    capital: "Beirut",
                    code: "lb",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/lb.svg",
                    flag_4x3: "flags/4x3/lb.svg",
                    iso: true,
                    name: "Lebanon",
                },
                {
                    capital: "Maseru",
                    code: "ls",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ls.svg",
                    flag_4x3: "flags/4x3/ls.svg",
                    iso: true,
                    name: "Lesotho",
                },
                {
                    capital: "Monrovia",
                    code: "lr",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/lr.svg",
                    flag_4x3: "flags/4x3/lr.svg",
                    iso: true,
                    name: "Liberia",
                },
                {
                    capital: "Tripoli",
                    code: "ly",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ly.svg",
                    flag_4x3: "flags/4x3/ly.svg",
                    iso: true,
                    name: "Libya",
                },
                {
                    capital: "Vaduz",
                    code: "li",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/li.svg",
                    flag_4x3: "flags/4x3/li.svg",
                    iso: true,
                    name: "Liechtenstein",
                },
                {
                    capital: "Vilnius",
                    code: "lt",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/lt.svg",
                    flag_4x3: "flags/4x3/lt.svg",
                    iso: true,
                    name: "Lithuania",
                },
                {
                    capital: "Luxembourg City",
                    code: "lu",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/lu.svg",
                    flag_4x3: "flags/4x3/lu.svg",
                    iso: true,
                    name: "Luxembourg",
                },
                {
                    capital: "Macau",
                    code: "mo",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/mo.svg",
                    flag_4x3: "flags/4x3/mo.svg",
                    iso: true,
                    name: "Macau",
                },
                {
                    capital: "Antananarivo",
                    code: "mg",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/mg.svg",
                    flag_4x3: "flags/4x3/mg.svg",
                    iso: true,
                    name: "Madagascar",
                },
                {
                    capital: "Lilongwe",
                    code: "mw",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/mw.svg",
                    flag_4x3: "flags/4x3/mw.svg",
                    iso: true,
                    name: "Malawi",
                },
                {
                    capital: "Kuala Lumpur",
                    code: "my",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/my.svg",
                    flag_4x3: "flags/4x3/my.svg",
                    iso: true,
                    name: "Malaysia",
                },
                {
                    capital: "Malé",
                    code: "mv",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/mv.svg",
                    flag_4x3: "flags/4x3/mv.svg",
                    iso: true,
                    name: "Maldives",
                },
                {
                    capital: "Bamako",
                    code: "ml",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ml.svg",
                    flag_4x3: "flags/4x3/ml.svg",
                    iso: true,
                    name: "Mali",
                },
                {
                    capital: "Valletta",
                    code: "mt",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/mt.svg",
                    flag_4x3: "flags/4x3/mt.svg",
                    iso: true,
                    name: "Malta",
                },
                {
                    capital: "Majuro",
                    code: "mh",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/mh.svg",
                    flag_4x3: "flags/4x3/mh.svg",
                    iso: true,
                    name: "Marshall Islands",
                },
                {
                    capital: "Fort-de-France",
                    code: "mq",
                    continent: "North America",
                    flag_1x1: "flags/1x1/mq.svg",
                    flag_4x3: "flags/4x3/mq.svg",
                    iso: true,
                    name: "Martinique",
                },
                {
                    capital: "Nouakchott",
                    code: "mr",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/mr.svg",
                    flag_4x3: "flags/4x3/mr.svg",
                    iso: true,
                    name: "Mauritania",
                },
                {
                    capital: "Port Louis",
                    code: "mu",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/mu.svg",
                    flag_4x3: "flags/4x3/mu.svg",
                    iso: true,
                    name: "Mauritius",
                },
                {
                    capital: "Mamoudzou",
                    code: "yt",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/yt.svg",
                    flag_4x3: "flags/4x3/yt.svg",
                    iso: true,
                    name: "Mayotte",
                },
                {
                    capital: "Mexico City",
                    code: "mx",
                    continent: "North America",
                    flag_1x1: "flags/1x1/mx.svg",
                    flag_4x3: "flags/4x3/mx.svg",
                    iso: true,
                    name: "Mexico",
                },
                {
                    capital: "Chișinău",
                    code: "md",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/md.svg",
                    flag_4x3: "flags/4x3/md.svg",
                    iso: true,
                    name: "Moldova",
                },
                {
                    capital: "Monaco",
                    code: "mc",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/mc.svg",
                    flag_4x3: "flags/4x3/mc.svg",
                    iso: true,
                    name: "Monaco",
                },
                {
                    capital: "Ulaanbaatar",
                    code: "mn",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/mn.svg",
                    flag_4x3: "flags/4x3/mn.svg",
                    iso: true,
                    name: "Mongolia",
                },
                {
                    capital: "Podgorica",
                    code: "me",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/me.svg",
                    flag_4x3: "flags/4x3/me.svg",
                    iso: true,
                    name: "Montenegro",
                },
                {
                    capital: "Little Bay, Brades, Plymouth",
                    code: "ms",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ms.svg",
                    flag_4x3: "flags/4x3/ms.svg",
                    iso: true,
                    name: "Montserrat",
                },
                {
                    capital: "Rabat",
                    code: "ma",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ma.svg",
                    flag_4x3: "flags/4x3/ma.svg",
                    iso: true,
                    name: "Morocco",
                },
                {
                    capital: "Maputo",
                    code: "mz",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/mz.svg",
                    flag_4x3: "flags/4x3/mz.svg",
                    iso: true,
                    name: "Mozambique",
                },
                {
                    capital: "Naypyidaw",
                    code: "mm",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/mm.svg",
                    flag_4x3: "flags/4x3/mm.svg",
                    iso: true,
                    name: "Myanmar",
                },
                {
                    capital: "Windhoek",
                    code: "na",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/na.svg",
                    flag_4x3: "flags/4x3/na.svg",
                    iso: true,
                    name: "Namibia",
                },
                {
                    capital: "Yaren District",
                    code: "nr",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/nr.svg",
                    flag_4x3: "flags/4x3/nr.svg",
                    iso: true,
                    name: "Nauru",
                },
                {
                    capital: "Kathmandu",
                    code: "np",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/np.svg",
                    flag_4x3: "flags/4x3/np.svg",
                    iso: true,
                    name: "Nepal",
                },
                {
                    capital: "Amsterdam",
                    code: "nl",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/nl.svg",
                    flag_4x3: "flags/4x3/nl.svg",
                    iso: true,
                    name: "Netherlands",
                },
                {
                    capital: "Nouméa",
                    code: "nc",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/nc.svg",
                    flag_4x3: "flags/4x3/nc.svg",
                    iso: true,
                    name: "New Caledonia",
                },
                {
                    capital: "Wellington",
                    code: "nz",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/nz.svg",
                    flag_4x3: "flags/4x3/nz.svg",
                    iso: true,
                    name: "New Zealand",
                },
                {
                    capital: "Managua",
                    code: "ni",
                    continent: "North America",
                    flag_1x1: "flags/1x1/ni.svg",
                    flag_4x3: "flags/4x3/ni.svg",
                    iso: true,
                    name: "Nicaragua",
                },
                {
                    capital: "Niamey",
                    code: "ne",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ne.svg",
                    flag_4x3: "flags/4x3/ne.svg",
                    iso: true,
                    name: "Niger",
                },
                {
                    capital: "Abuja",
                    code: "ng",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ng.svg",
                    flag_4x3: "flags/4x3/ng.svg",
                    iso: true,
                    name: "Nigeria",
                },
                {
                    capital: "Alofi",
                    code: "nu",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/nu.svg",
                    flag_4x3: "flags/4x3/nu.svg",
                    iso: true,
                    name: "Niue",
                },
                {
                    capital: "Kingston",
                    code: "nf",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/nf.svg",
                    flag_4x3: "flags/4x3/nf.svg",
                    iso: true,
                    name: "Norfolk Island",
                },
                {
                    capital: "Pyongyang",
                    code: "kp",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/kp.svg",
                    flag_4x3: "flags/4x3/kp.svg",
                    iso: true,
                    name: "North Korea",
                },
                {
                    capital: "Skopje",
                    code: "mk",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/mk.svg",
                    flag_4x3: "flags/4x3/mk.svg",
                    iso: true,
                    name: "North Macedonia",
                },
                {
                    capital: "Belfast",
                    code: "gb-nir",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gb-nir.svg",
                    flag_4x3: "flags/4x3/gb-nir.svg",
                    iso: false,
                    name: "Northern Ireland",
                },
                {
                    capital: "Saipan",
                    code: "mp",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/mp.svg",
                    flag_4x3: "flags/4x3/mp.svg",
                    iso: true,
                    name: "Northern Mariana Islands",
                },
                {
                    capital: "Oslo",
                    code: "no",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/no.svg",
                    flag_4x3: "flags/4x3/no.svg",
                    iso: true,
                    name: "Norway",
                },
                {
                    capital: "Muscat",
                    code: "om",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/om.svg",
                    flag_4x3: "flags/4x3/om.svg",
                    iso: true,
                    name: "Oman",
                },
                {
                    capital: "Islamabad",
                    code: "pk",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/pk.svg",
                    flag_4x3: "flags/4x3/pk.svg",
                    iso: true,
                    name: "Pakistan",
                },
                {
                    capital: "Ngerulmud",
                    code: "pw",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/pw.svg",
                    flag_4x3: "flags/4x3/pw.svg",
                    iso: true,
                    name: "Palau",
                },
                {
                    capital: "Panama City",
                    code: "pa",
                    continent: "North America",
                    flag_1x1: "flags/1x1/pa.svg",
                    flag_4x3: "flags/4x3/pa.svg",
                    iso: true,
                    name: "Panama",
                },
                {
                    capital: "Port Moresby",
                    code: "pg",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/pg.svg",
                    flag_4x3: "flags/4x3/pg.svg",
                    iso: true,
                    name: "Papua New Guinea",
                },
                {
                    capital: "Asunción",
                    code: "py",
                    continent: "South America",
                    flag_1x1: "flags/1x1/py.svg",
                    flag_4x3: "flags/4x3/py.svg",
                    iso: true,
                    name: "Paraguay",
                },
                {
                    capital: "Lima",
                    code: "pe",
                    continent: "South America",
                    flag_1x1: "flags/1x1/pe.svg",
                    flag_4x3: "flags/4x3/pe.svg",
                    iso: true,
                    name: "Peru",
                },
                {
                    capital: "Manila",
                    code: "ph",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/ph.svg",
                    flag_4x3: "flags/4x3/ph.svg",
                    iso: true,
                    name: "Philippines",
                },
                {
                    capital: "Adamstown",
                    code: "pn",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/pn.svg",
                    flag_4x3: "flags/4x3/pn.svg",
                    iso: true,
                    name: "Pitcairn",
                },
                {
                    capital: "Warsaw",
                    code: "pl",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/pl.svg",
                    flag_4x3: "flags/4x3/pl.svg",
                    iso: true,
                    name: "Poland",
                },
                {
                    capital: "Lisbon",
                    code: "pt",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/pt.svg",
                    flag_4x3: "flags/4x3/pt.svg",
                    iso: true,
                    name: "Portugal",
                },
                {
                    capital: "San Juan",
                    code: "pr",
                    continent: "North America",
                    flag_1x1: "flags/1x1/pr.svg",
                    flag_4x3: "flags/4x3/pr.svg",
                    iso: true,
                    name: "Puerto Rico",
                },
                {
                    capital: "Doha",
                    code: "qa",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/qa.svg",
                    flag_4x3: "flags/4x3/qa.svg",
                    iso: true,
                    name: "Qatar",
                },
                {
                    capital: "Brazzaville",
                    code: "cg",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/cg.svg",
                    flag_4x3: "flags/4x3/cg.svg",
                    iso: true,
                    name: "Republic of the Congo",
                },
                {
                    capital: "Bucharest",
                    code: "ro",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ro.svg",
                    flag_4x3: "flags/4x3/ro.svg",
                    iso: true,
                    name: "Romania",
                },
                {
                    capital: "Moscow",
                    code: "ru",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ru.svg",
                    flag_4x3: "flags/4x3/ru.svg",
                    iso: true,
                    name: "Russia",
                },
                {
                    capital: "Kigali",
                    code: "rw",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/rw.svg",
                    flag_4x3: "flags/4x3/rw.svg",
                    iso: true,
                    name: "Rwanda",
                },
                {
                    capital: "Saint-Denis",
                    code: "re",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/re.svg",
                    flag_4x3: "flags/4x3/re.svg",
                    iso: true,
                    name: "Réunion",
                },
                {
                    capital: "Gustavia",
                    code: "bl",
                    continent: "North America",
                    flag_1x1: "flags/1x1/bl.svg",
                    flag_4x3: "flags/4x3/bl.svg",
                    iso: true,
                    name: "Saint Barthélemy",
                },
                {
                    capital: "Jamestown",
                    code: "sh",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/sh.svg",
                    flag_4x3: "flags/4x3/sh.svg",
                    iso: true,
                    name: "Saint Helena, Ascension and Tristan da Cunha",
                },
                {
                    capital: "Basseterre",
                    code: "kn",
                    continent: "North America",
                    flag_1x1: "flags/1x1/kn.svg",
                    flag_4x3: "flags/4x3/kn.svg",
                    iso: true,
                    name: "Saint Kitts and Nevis",
                },
                {
                    capital: "Castries",
                    code: "lc",
                    continent: "North America",
                    flag_1x1: "flags/1x1/lc.svg",
                    flag_4x3: "flags/4x3/lc.svg",
                    iso: true,
                    name: "Saint Lucia",
                },
                {
                    capital: "Marigot",
                    code: "mf",
                    continent: "North America",
                    flag_1x1: "flags/1x1/mf.svg",
                    flag_4x3: "flags/4x3/mf.svg",
                    iso: true,
                    name: "Saint Martin",
                },
                {
                    capital: "Saint-Pierre",
                    code: "pm",
                    continent: "North America",
                    flag_1x1: "flags/1x1/pm.svg",
                    flag_4x3: "flags/4x3/pm.svg",
                    iso: true,
                    name: "Saint Pierre and Miquelon",
                },
                {
                    capital: "Kingstown",
                    code: "vc",
                    continent: "North America",
                    flag_1x1: "flags/1x1/vc.svg",
                    flag_4x3: "flags/4x3/vc.svg",
                    iso: true,
                    name: "Saint Vincent and the Grenadines",
                },
                {
                    capital: "Apia",
                    code: "ws",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/ws.svg",
                    flag_4x3: "flags/4x3/ws.svg",
                    iso: true,
                    name: "Samoa",
                },
                {
                    capital: "San Marino",
                    code: "sm",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/sm.svg",
                    flag_4x3: "flags/4x3/sm.svg",
                    iso: true,
                    name: "San Marino",
                },
                {
                    capital: "São Tomé",
                    code: "st",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/st.svg",
                    flag_4x3: "flags/4x3/st.svg",
                    iso: true,
                    name: "Sao Tome and Principe",
                },
                {
                    capital: "Riyadh",
                    code: "sa",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/sa.svg",
                    flag_4x3: "flags/4x3/sa.svg",
                    iso: true,
                    name: "Saudi Arabia",
                },
                {
                    capital: "Edinburgh",
                    code: "gb-sct",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gb-sct.svg",
                    flag_4x3: "flags/4x3/gb-sct.svg",
                    iso: false,
                    name: "Scotland",
                },
                {
                    capital: "Dakar",
                    code: "sn",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/sn.svg",
                    flag_4x3: "flags/4x3/sn.svg",
                    iso: true,
                    name: "Senegal",
                },
                {
                    capital: "Belgrade",
                    code: "rs",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/rs.svg",
                    flag_4x3: "flags/4x3/rs.svg",
                    iso: true,
                    name: "Serbia",
                },
                {
                    capital: "Victoria",
                    code: "sc",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/sc.svg",
                    flag_4x3: "flags/4x3/sc.svg",
                    iso: true,
                    name: "Seychelles",
                },
                {
                    capital: "Freetown",
                    code: "sl",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/sl.svg",
                    flag_4x3: "flags/4x3/sl.svg",
                    iso: true,
                    name: "Sierra Leone",
                },
                {
                    capital: "Singapore",
                    code: "sg",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/sg.svg",
                    flag_4x3: "flags/4x3/sg.svg",
                    iso: true,
                    name: "Singapore",
                },
                {
                    capital: "Philipsburg",
                    code: "sx",
                    continent: "North America",
                    flag_1x1: "flags/1x1/sx.svg",
                    flag_4x3: "flags/4x3/sx.svg",
                    iso: true,
                    name: "Sint Maarten",
                },
                {
                    capital: "Bratislava",
                    code: "sk",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/sk.svg",
                    flag_4x3: "flags/4x3/sk.svg",
                    iso: true,
                    name: "Slovakia",
                },
                {
                    capital: "Ljubljana",
                    code: "si",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/si.svg",
                    flag_4x3: "flags/4x3/si.svg",
                    iso: true,
                    name: "Slovenia",
                },
                {
                    capital: "Honiara",
                    code: "sb",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/sb.svg",
                    flag_4x3: "flags/4x3/sb.svg",
                    iso: true,
                    name: "Solomon Islands",
                },
                {
                    capital: "Mogadishu",
                    code: "so",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/so.svg",
                    flag_4x3: "flags/4x3/so.svg",
                    iso: true,
                    name: "Somalia",
                },
                {
                    capital: "Pretoria",
                    code: "za",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/za.svg",
                    flag_4x3: "flags/4x3/za.svg",
                    iso: true,
                    name: "South Africa",
                },
                {
                    capital: "King Edward Point",
                    code: "gs",
                    continent: "Antarctica",
                    flag_1x1: "flags/1x1/gs.svg",
                    flag_4x3: "flags/4x3/gs.svg",
                    iso: true,
                    name: "South Georgia and the South Sandwich Islands",
                },
                {
                    capital: "Seoul",
                    code: "kr",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/kr.svg",
                    flag_4x3: "flags/4x3/kr.svg",
                    iso: true,
                    name: "South Korea",
                },
                {
                    capital: "Juba",
                    code: "ss",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ss.svg",
                    flag_4x3: "flags/4x3/ss.svg",
                    iso: true,
                    name: "South Sudan",
                },
                {
                    capital: "Madrid",
                    code: "es",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/es.svg",
                    flag_4x3: "flags/4x3/es.svg",
                    iso: true,
                    name: "Spain",
                },
                {
                    capital: "Sri Jayawardenepura Kotte, Colombo",
                    code: "lk",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/lk.svg",
                    flag_4x3: "flags/4x3/lk.svg",
                    iso: true,
                    name: "Sri Lanka",
                },
                {
                    capital: "Ramallah",
                    code: "ps",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/ps.svg",
                    flag_4x3: "flags/4x3/ps.svg",
                    iso: true,
                    name: "State of Palestine",
                },
                {
                    capital: "Khartoum",
                    code: "sd",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/sd.svg",
                    flag_4x3: "flags/4x3/sd.svg",
                    iso: true,
                    name: "Sudan",
                },
                {
                    capital: "Paramaribo",
                    code: "sr",
                    continent: "South America",
                    flag_1x1: "flags/1x1/sr.svg",
                    flag_4x3: "flags/4x3/sr.svg",
                    iso: true,
                    name: "Suriname",
                },
                {
                    capital: "Longyearbyen",
                    code: "sj",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/sj.svg",
                    flag_4x3: "flags/4x3/sj.svg",
                    iso: true,
                    name: "Svalbard and Jan Mayen",
                },
                {
                    capital: "Stockholm",
                    code: "se",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/se.svg",
                    flag_4x3: "flags/4x3/se.svg",
                    iso: true,
                    name: "Sweden",
                },
                {
                    capital: "Bern",
                    code: "ch",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ch.svg",
                    flag_4x3: "flags/4x3/ch.svg",
                    iso: true,
                    name: "Switzerland",
                },
                {
                    capital: "Damascus",
                    code: "sy",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/sy.svg",
                    flag_4x3: "flags/4x3/sy.svg",
                    iso: true,
                    name: "Syria",
                },
                {
                    capital: "Taipei",
                    code: "tw",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/tw.svg",
                    flag_4x3: "flags/4x3/tw.svg",
                    iso: true,
                    name: "Taiwan",
                },
                {
                    capital: "Dushanbe",
                    code: "tj",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/tj.svg",
                    flag_4x3: "flags/4x3/tj.svg",
                    iso: true,
                    name: "Tajikistan",
                },
                {
                    capital: "Dodoma",
                    code: "tz",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/tz.svg",
                    flag_4x3: "flags/4x3/tz.svg",
                    iso: true,
                    name: "Tanzania",
                },
                {
                    capital: "Bangkok",
                    code: "th",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/th.svg",
                    flag_4x3: "flags/4x3/th.svg",
                    iso: true,
                    name: "Thailand",
                },
                {
                    capital: "Dili",
                    code: "tl",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/tl.svg",
                    flag_4x3: "flags/4x3/tl.svg",
                    iso: true,
                    name: "Timor-Leste",
                },
                {
                    capital: "Lomé",
                    code: "tg",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/tg.svg",
                    flag_4x3: "flags/4x3/tg.svg",
                    iso: true,
                    name: "Togo",
                },
                {
                    capital: "Nukunonu, Atafu,Tokelau",
                    code: "tk",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/tk.svg",
                    flag_4x3: "flags/4x3/tk.svg",
                    iso: true,
                    name: "Tokelau",
                },
                {
                    capital: "Nukuʻalofa",
                    code: "to",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/to.svg",
                    flag_4x3: "flags/4x3/to.svg",
                    iso: true,
                    name: "Tonga",
                },
                {
                    capital: "Port of Spain",
                    code: "tt",
                    continent: "South America",
                    flag_1x1: "flags/1x1/tt.svg",
                    flag_4x3: "flags/4x3/tt.svg",
                    iso: true,
                    name: "Trinidad and Tobago",
                },
                {
                    code: "ta",
                    flag_1x1: "flags/1x1/ta.svg",
                    flag_4x3: "flags/4x3/ta.svg",
                    iso: false,
                    name: "Tristan da Cunha",
                },
                {
                    capital: "Tunis",
                    code: "tn",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/tn.svg",
                    flag_4x3: "flags/4x3/tn.svg",
                    iso: true,
                    name: "Tunisia",
                },
                {
                    capital: "Ankara",
                    code: "tr",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/tr.svg",
                    flag_4x3: "flags/4x3/tr.svg",
                    iso: true,
                    name: "Turkey",
                },
                {
                    capital: "Ashgabat",
                    code: "tm",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/tm.svg",
                    flag_4x3: "flags/4x3/tm.svg",
                    iso: true,
                    name: "Turkmenistan",
                },
                {
                    capital: "Cockburn Town",
                    code: "tc",
                    continent: "North America",
                    flag_1x1: "flags/1x1/tc.svg",
                    flag_4x3: "flags/4x3/tc.svg",
                    iso: true,
                    name: "Turks and Caicos Islands",
                },
                {
                    capital: "Funafuti",
                    code: "tv",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/tv.svg",
                    flag_4x3: "flags/4x3/tv.svg",
                    iso: true,
                    name: "Tuvalu",
                },
                {
                    capital: "Kampala",
                    code: "ug",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/ug.svg",
                    flag_4x3: "flags/4x3/ug.svg",
                    iso: true,
                    name: "Uganda",
                },
                {
                    capital: "Kiev",
                    code: "ua",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/ua.svg",
                    flag_4x3: "flags/4x3/ua.svg",
                    iso: true,
                    name: "Ukraine",
                },
                {
                    capital: "Abu Dhabi",
                    code: "ae",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/ae.svg",
                    flag_4x3: "flags/4x3/ae.svg",
                    iso: true,
                    name: "United Arab Emirates",
                },
                {
                    capital: "London",
                    code: "gb",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gb.svg",
                    flag_4x3: "flags/4x3/gb.svg",
                    iso: true,
                    name: "United Kingdom",
                },
                {
                    code: "un",
                    flag_1x1: "flags/1x1/un.svg",
                    flag_4x3: "flags/4x3/un.svg",
                    iso: false,
                    name: "United Nations",
                },
                {
                    capital: "Washington, D.C.",
                    code: "um",
                    continent: "North America",
                    flag_1x1: "flags/1x1/um.svg",
                    flag_4x3: "flags/4x3/um.svg",
                    iso: true,
                    name: "United States Minor Outlying Islands",
                },
                {
                    capital: "Washington, D.C.",
                    code: "us",
                    continent: "North America",
                    flag_1x1: "flags/1x1/us.svg",
                    flag_4x3: "flags/4x3/us.svg",
                    iso: true,
                    name: "United States of America",
                },
                {
                    code: "xx",
                    flag_1x1: "flags/1x1/xx.svg",
                    flag_4x3: "flags/4x3/xx.svg",
                    iso: false,
                    name: "Unknown",
                },
                {
                    capital: "Montevideo",
                    code: "uy",
                    continent: "South America",
                    flag_1x1: "flags/1x1/uy.svg",
                    flag_4x3: "flags/4x3/uy.svg",
                    iso: true,
                    name: "Uruguay",
                },
                {
                    capital: "Tashkent",
                    code: "uz",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/uz.svg",
                    flag_4x3: "flags/4x3/uz.svg",
                    iso: true,
                    name: "Uzbekistan",
                },
                {
                    capital: "Port Vila",
                    code: "vu",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/vu.svg",
                    flag_4x3: "flags/4x3/vu.svg",
                    iso: true,
                    name: "Vanuatu",
                },
                {
                    capital: "Caracas",
                    code: "ve",
                    continent: "South America",
                    flag_1x1: "flags/1x1/ve.svg",
                    flag_4x3: "flags/4x3/ve.svg",
                    iso: true,
                    name: "Venezuela",
                },
                {
                    capital: "Hanoi",
                    code: "vn",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/vn.svg",
                    flag_4x3: "flags/4x3/vn.svg",
                    iso: true,
                    name: "Vietnam",
                },
                {
                    capital: "Road Town",
                    code: "vg",
                    continent: "North America",
                    flag_1x1: "flags/1x1/vg.svg",
                    flag_4x3: "flags/4x3/vg.svg",
                    iso: true,
                    name: "Virgin Islands (British)",
                },
                {
                    capital: "Charlotte Amalie",
                    code: "vi",
                    continent: "North America",
                    flag_1x1: "flags/1x1/vi.svg",
                    flag_4x3: "flags/4x3/vi.svg",
                    iso: true,
                    name: "Virgin Islands (U.S.)",
                },
                {
                    capital: "Cardiff",
                    code: "gb-wls",
                    continent: "Europe",
                    flag_1x1: "flags/1x1/gb-wls.svg",
                    flag_4x3: "flags/4x3/gb-wls.svg",
                    iso: false,
                    name: "Wales",
                },
                {
                    capital: "Mata-Utu",
                    code: "wf",
                    continent: "Oceania",
                    flag_1x1: "flags/1x1/wf.svg",
                    flag_4x3: "flags/4x3/wf.svg",
                    iso: true,
                    name: "Wallis and Futuna",
                },
                {
                    capital: "Laayoune",
                    code: "eh",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/eh.svg",
                    flag_4x3: "flags/4x3/eh.svg",
                    iso: true,
                    name: "Western Sahara",
                },
                {
                    capital: "Sana'a",
                    code: "ye",
                    continent: "Asia",
                    flag_1x1: "flags/1x1/ye.svg",
                    flag_4x3: "flags/4x3/ye.svg",
                    iso: true,
                    name: "Yemen",
                },
                {
                    capital: "Lusaka",
                    code: "zm",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/zm.svg",
                    flag_4x3: "flags/4x3/zm.svg",
                    iso: true,
                    name: "Zambia",
                },
                {
                    capital: "Harare",
                    code: "zw",
                    continent: "Africa",
                    flag_1x1: "flags/1x1/zw.svg",
                    flag_4x3: "flags/4x3/zw.svg",
                    iso: true,
                    name: "Zimbabwe",
                },
            ],
            phone_country_code: "",
        };
    },
    created() {
        this.initFilters();
    },
    mounted() {
        let vm = this;
        this.allListsArr.sort((a, b) => a.listId - b.listId);
        $("#fasil").daterangepicker(
            {
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
                locale: {
                    format: "MM/DD/YYYY",
                    separator: " - ",
                    applyLabel: "Apply",
                    cancelLabel: "Cancel",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                    monthNames: [
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
                        "December",
                    ],
                    firstDay: 1,
                },
                alwaysShowCalendars: true,
                startDate: moment().subtract(6, "days"),
                endDate: moment(),
            },
            function (start, end, label) {
                flabel = label;

                vm.filterLabel = label;
                vm.startDate = start;
                vm.endDate = end;
                vm.filterRes();
                console.log(
                    "New date range selected: " +
                        start.format("YYYY-MM-DD") +
                        " to " +
                        end.format("YYYY-MM-DD") +
                        " (predefined range: " +
                        label +
                        ")"
                );
            }
        );
    },

    methods: {
        async filterRes() {
            const res = await axios.post(route("get_dm_filter_data"), {
                start: this.startDate,
                end: this.endDate,
            });

            this.direct_coms = res.data.coms;
            // this.acceptCount = res.data.ao;
            // this.deniedCount = res.data.do;
            // this.offersCount = res.data.ao;
        },
        chooseFiles: function () {
            document.getElementById("logoWebsite").click();
        },
        displayDates() {
            $("#fasil").click();
        },

        earthImage() {
            return this.$appState.darkTheme
                ? "/images/icons/earth.png"
                : "/images/icons/earth.png";
        },

        callImage() {
            return this.$appState.darkTheme
                ? "/images/icons/call.png"
                : "/images/icons/call.png";
        },

        campaignImage() {
            return this.$appState.darkTheme
                ? "/images/campaign.png"
                : "/images/campaign.png";
        },

        envelopeImage() {
            return this.$appState.darkTheme
                ? "/images/icons/envelope.png"
                : "/images/icons/envelope.png";
        },

        topbarImage() {
            return this.$appState.darkTheme
                ? "/images/icons/check.png"
                : "/images/icons/check.png";
        },
        deniedImage() {
            return this.$appState.darkTheme
                ? "/images/icons/denied.png"
                : "/images/icons/denied.png";
        },
        counterImage() {
            return this.$appState.darkTheme
                ? "/images/icons/counter.png"
                : "/images/icons/counter.png";
        },
        totalImage() {
            return this.$appState.darkTheme
                ? "/images/icons/total.png"
                : "/images/icons/total.png";
        },
        chartImage() {
            return this.$appState.darkTheme
                ? "/images/icons/chart.png"
                : "/images/icons/chart.png";
        },
        questionImage() {
            return this.$appState.darkTheme
                ? "/images/icons/question.png"
                : "/images/icons/question.png";
        },

        async previewCampaign() {
            if (this.compaignName.length < 1) {
                this.handleResponse({
                    status: "error",
                    message: "Compaig name is required",
                });
                return false;
            } else if (this.selectedDomain.length < 1) {
                this.handleResponse({
                    status: "error",
                    message: "domain is required",
                });
                return false;
            } else if (this.phone.length < 1) {
                this.handleResponse({
                    status: "error",
                    message: "Phone is required",
                });
                return false;
            } else if (this.lists_input.length < 1) {
                this.handleResponse({
                    status: "error",
                    message: "List is required",
                });
                return false;
            }

            const res = await axios.post(route("get_template"), {
                domain: this.selectedDomain,
                phone: this.phone,
            });

            this.postcard = res.data;
            this.creds_req = 0;
            var vm = this;
            this.lists_input.map(function (value, key) {
                vm.creds_req = vm.creds_req + value.properties_count * 0.5;
            });
            vm.creds_req = 5;
            // if (res.data.status === 'success') {
            //     this.allTags = res.data.allTags;
            //     this.displayAddTagModal = false;
            //     this.createTagForm.tagName = null;
            // }

            this.displayCampaignModal = false;
            this.displayReviewCampaign = true;
        },

        async websiteStep2() {
            this.displayWebsiteModal1 = false;
            this.displayWebsiteModal2 = true;
        },

        async websiteStep2Back() {
            this.displayWebsiteModal1 = true;
            this.displayWebsiteModal2 = false;
        },

        async websiteStep3() {
            const res = await axios.post(route("sendMails"), {
                domain: this.selectedDomain,
                phone: this.phone,
                list: this.lists_input,
                name: this.compaignName,
            });

            console.log(res.data);

            // alert(res.data.status)
            if (res.data.status == "success") {
                this.handleResponse({
                    status: "success",
                    message: res.data.message,
                });

                this.direct_coms = res.data.coms;
            }

            // this.postcard = res.data;

            this.displayWebsiteModal2 = false;
            this.displayWebsiteModal3 = true;
            this.displayReviewCampaign = false;
        },

        async websiteStep3Back() {
            this.displayWebsiteModal2 = true;
            this.displayWebsiteModal3 = false;
        },

        hydrateListBeingEditedObj(listId) {
            const listToEdit = this.allListsArr.filter(
                (list) => list.listId === listId
            );
            this.listBeingEdited = JSON.parse(JSON.stringify(listToEdit[0]));
            this.listBeingEdited.tagRows = [];
            //ensure tags in the tagsArray have not already been deleted
            this.listBeingEdited.tags = this.listBeingEdited.tags.filter(
                (tt) => {
                    if (tt) {
                        const tagRow = this.allTags.filter(
                            (tgRow) => tgRow.tag_name === tt
                        );
                        return tagRow && tagRow.length > 0;
                    }
                    return false;
                }
            );

            for (const tag of this.listBeingEdited.tags) {
                const tagRow = this.allTags.filter(
                    (tgRow) => tgRow.tag_name === tag
                );
                if (tagRow) this.listBeingEdited.tagRows.push(tagRow[0]);
            }
        },

        showEditListTagsModal(listId) {
            this.savingListTags = false;
            this.hydrateListBeingEditedObj(listId);
            this.listTagsEditModalActive = true;
        },

        async saveListTags() {
            this.savingListTags = true;
            const res = await axios.post(
                route("users.lists.edit.tags"),
                this.listBeingEdited
            );
            this.handleResponse(res.data);
            if (res.data.status === "success") {
                const listToEdit = this.allListsArr.findIndex(
                    (rw) => rw.listId === this.listBeingEdited.listId
                );
                this.allListsArr[listToEdit].tags = res.data.newTags;
            }
            this.savingListTags = false;
            this.listTagsEditModalActive = false;
        },
        async saveListName() {
            this.savingListName = true;
            const res = await axios.post(
                route("users.lists.edit.name"),
                this.listBeingEdited
            );
            this.handleResponse(res.data);
            if (res.data["status"] === "success") {
                const listToEdit = this.allListsArr.findIndex(
                    (rw) => rw.listId === this.listBeingEdited.listId
                );
                this.allListsArr[listToEdit].fileName = res.data.newName;
                this.listNameEditModalActive = false;
            }
            this.savingListName = false;
        },
        showEditListNameModal(listId) {
            this.savingListName = false;
            this.hydrateListBeingEditedObj(listId);
            this.listNameEditModalActive = true;
        },
        addMotivationTagSelectionChanged() {},
        async showTagEditModal(tagName, tagId) {
            this.editTagForm.oTagName = tagName;
            this.editTagForm.tagName = tagName;
            this.editTagForm.tagId = tagId;
            this.displayEditTagModal = true;
        },
        async saveEditedTag() {
            if (!this.editTagForm.tagName || !this.editTagForm.tagName.length) {
                this.handleResponse({
                    status: "error",
                    message: "Tag Name Cannot be empty",
                });
            } else if (this.editTagForm.tagName === this.editTagForm.oTagName) {
                this.handleResponse({
                    status: "error",
                    message: "No change in tag name detected",
                });
            } else {
                const res = await axios.post(
                    route("motivation-tags.edit"),
                    this.editTagForm
                );
                if (res.data.status === "success") {
                    const selectedTags = this.uploadFileForm.motivation_tags;
                    this.uploadFileForm.motivation_tags = selectedTags.map(
                        (st) => {
                            const found = res.data.allTags.filter(
                                (at) => at.id === st.id
                            );
                            if (found && found.length > 0) {
                                return found[0];
                            }
                        }
                    );
                    this.allTags = res.data.allTags;
                    this.displayEditTagModal = false;
                }
                this.handleResponse(res.data);
            }
        },
        async createNewTag() {
            this.creatingTag = true;
            if (this.createTagForm.tagName.length > 0) {
                // check for duplicate
                const existingTag = this.allTags.filter((eTag) => {
                    return eTag.tag_name === this.createTagForm.tagName;
                });
                if (existingTag.length === 0) {
                    const res = await axios.post(
                        route("motivation-tags.store"),
                        { tagName: this.createTagForm.tagName }
                    );
                    if (res.data.status === "success") {
                        this.allTags = res.data.allTags;
                        this.displayAddTagModal = false;
                        this.createTagForm.tagName = null;
                    }
                    this.handleResponse(res.data);
                } else {
                    // Duplicate
                    this.handleResponse({
                        status: "error",
                        message: "A tag with the same name already exists",
                    });
                }
            } else {
                // Empty
                this.handleResponse({
                    status: "error",
                    message: "Tag Name cannot be empty",
                });
            }
            this.creatingTag = false;
        },
        async deleteList(listId) {
            const res = await axios.post(route("users.lists.delete"), {
                listId: listId,
            });
            this.handleResponse(res.data);
            if (res.data.status === "success") {
                // const listToEdit = this.allListsArr.findIndex((rw) => rw.listId === this.listBeingEdited.listId);
                // this.allListsArr.splice(listToEdit, 1);
                this.allListsArr = res.data.lists;
            }
        },
        confirmListDelete(listFileName, listId, propertiesCount) {
            this.$confirm.require({
                message: `This will delete the list along with all its ${propertiesCount} properties. Proceed?`,
                header: `Delete List ( #${listId} ): ${listFileName} `,
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.deleteList(listId);
                },
                reject: () => {},
            });
        },
        async confirmTagDelete(tagName, tagId) {
            this.$confirm.require({
                message: `Do you want to delete Tag '${tagName}' ?`,
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.deleteTag(tagId);
                },
                reject: () => {},
            });
        },
        async deleteTag(tagId) {
            const res = await axios.post(route("motivation-tags.delete"), {
                tagId: tagId,
            });
            if (res.data.status === "success") {
                if (!this.deletedTagIdArray.includes(tagId))
                    this.deletedTagIdArray.push(tagId);

                const selectedTags = this.uploadFileForm.motivation_tags;
                this.uploadFileForm.motivation_tags = selectedTags
                    .map((st) => {
                        const found = res.data.allTags.filter(
                            (at) => at.id === st.id
                        );
                        if (found && found.length > 0) {
                            return found[0];
                        }
                    })
                    .filter((tt) => tt && tt.id !== undefined);
                console.log(this.uploadFileForm.motivation_tags);
                this.allTags = res.data.allTags;
            }
            this.handleResponse(res.data);
        },
        clearFilter() {
            this.initFilters();
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                listId: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.EQUALS },
                    ],
                },
                fileName: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                import_time: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.DATE_IS },
                    ],
                },
            };
        },

        handleResponse(response) {
            switch (response.status) {
                case "success":
                    console.log("success");
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: response.message ?? "Action Successful",
                        life: 3000,
                    });
                    break;
                case "error":
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: response.message,
                        life: 3000,
                    });
                    break;
            }
        },
        onSelectedFiles(event) {
            this.uploadFileForm.import_file = event.files;
        },
        onFilesClear() {
            this.uploadFileForm.import_file = null;
        },
        async uploadList() {
            this.upLoadingList = true;
            const res = await axios({
                url: route("users.lists.upload"),
                method: "POST",
                data: this.uploadFileForm,
                headers: {
                    "content-type": "multipart/form-data",
                },
            });
            this.upLoadingList = false;
            this.handleResponse(res.data);
            if (res.data.status === "success") {
                this.allListsArr = res.data.allLists;
                this.displayUploadModal = false;
            }
        },
    },
    components: { AuthenticatedLayout, Head, Link },
};
</script>
<template>
    <AuthenticatedLayout>
        <Head><title>Lists</title></Head>
        <template #pageHeading>
            <div class="">
                <img
                    :src="envelopeImage()"
                    style="height: 20px; margin-right: 10px; margin-top: -8px"
                />
                <span class="text-2xl mr-3"
                    ><strong>INSTA-OFFER Direct Mail Dashboard</strong></span
                >
            </div>

            <div class="d-flex w-20 justify-content-between">
                <div
                    class="d-flex justify-content-between me-3"
                    style="
                        border: 1px solid #ebebeb;
                        padding: 7px;
                        border-radius: 7px;
                    "
                >
                    <div class="h-100 p-1 mr-2 cred-text text-center">
                        <span class="creditBalance">{{ credits }}</span>
                        <br />
                        <span> Credit Balance </span>
                    </div>
                    <Button
                        class="p-button p-button-danger"
                        style="
                            border: 0px;
                            border-radius: 0.7rem !important;
                            background-color: #fbe7e8;
                            color: #db0f19;
                            padding: 0.714rem 1rem;
                        "
                        @click="displayUploadModal = true"
                        label="Top Up"
                    >
                    </Button>
                </div>

                <!-- <div class="ranges">
                    <input class="p-button p-button-outlined p-button-danger"
                        style="border-radius: 0.6em !important;padding:0px 30px;font-size:17px;height:60px" type="text" id="fasil" name="daterange"  />
                </div> -->

                <div>
                    <div
                        @click="displayDates()"
                        class="p-button p-button-outlined p-button-danger d-flex h-100"
                        style="
                            border-radius: 0.6em !important;
                            padding: 0px 30px;
                            font-size: 17px;
                            height: 60px;
                        "
                    >
                        <i class="my-auto pi pi-calendar-times mr-3"></i>
                        {{ filterLabel }}
                    </div>
                    <input
                        class=""
                        style="height: 0; width: 0; border: none; outline: none"
                        type="text"
                        id="fasil"
                        name="daterange"
                    />
                </div>

                <!-- <Button class="p-button p-button-outlined p-button-danger"
                        style="border-radius: 0.6em !important;padding:0px 30px;font-size:17px;height:60px"
                        icon="pi pi-calendar-times"
                        @click="displayUploadModal = true"
                        label="Today">

                </Button> -->
            </div>
        </template>

        <div class="row mt-5">
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div
                            class="col-md-2 mt-3 ml-3"
                            style="
                                background: rgba(27, 200, 65, 0.1);
                                border-radius: 100px;
                                height: 40px;
                                width: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <img
                                class="text-center"
                                :src="topbarImage()"
                                alt=""
                            />
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0 mt-3">Accepted Offers</p>
                            <p class="mb-3" style="font-weight: 700">
                                {{ acceptCount }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <Button
                                class="p-button p-button-danger"
                                style="
                                    border-radius: 1.5em !important;
                                    padding: 15px;
                                    font-size: 13px;
                                    height: 27px;
                                    color: #db0f19;
                                    background: rgba(219, 15, 25, 0.1);
                                    margin-bottom: 9px;
                                    width: 100%;
                                "
                                label="View Leads"
                                icon="pi pi-eye"
                            >
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div
                            class="col-md-2 mt-3 ml-3"
                            style="
                                background: rgba(233, 39, 39, 0.1);
                                border-radius: 100px;
                                height: 40px;
                                width: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <img
                                class="text-center"
                                :src="deniedImage()"
                                alt=""
                            />
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0 mt-3">Denied Offers</p>
                            <p class="mb-3" style="font-weight: 700">
                                {{ deniedCount }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <Button
                                class="p-button p-button-danger"
                                style="
                                    border-radius: 1.5em !important;
                                    padding: 15px;
                                    font-size: 13px;
                                    height: 27px;
                                    color: #db0f19;
                                    background: rgba(219, 15, 25, 0.1);
                                    margin-bottom: 9px;
                                    width: 100%;
                                "
                                label="View Leads"
                                icon="pi pi-eye"
                            >
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div
                            class="col-md-2 mt-3 ml-3"
                            style="
                                background: rgba(169, 194, 15, 0.1);
                                border-radius: 100px;
                                height: 40px;
                                width: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <img
                                class="text-center"
                                :src="counterImage()"
                                alt=""
                            />
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0 mt-3">Counter Offers</p>
                            <p class="mb-3" style="font-weight: 700">
                                {{ counterCount }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <Button
                                class="p-button p-button-danger"
                                style="
                                    border-radius: 1.5em !important;
                                    padding: 15px;
                                    font-size: 13px;
                                    height: 27px;
                                    color: #db0f19;
                                    background: rgba(219, 15, 25, 0.1);
                                    margin-bottom: 9px;
                                    width: 100%;
                                "
                                label="View Leads"
                                icon="pi pi-eye"
                            >
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top-cards">
                    <div class="row">
                        <div
                            class="col-md-2 mt-3 ml-3"
                            style="
                                background: rgba(45, 124, 243, 0.1);
                                border-radius: 100px;
                                height: 40px;
                                width: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <img
                                class="text-center"
                                :src="totalImage()"
                                alt=""
                            />
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0 mt-3">Total Leads</p>
                            <p class="mb-3" style="font-weight: 700">
                                {{ offersCount }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <Button
                                class="p-button p-button-danger"
                                style="
                                    border-radius: 1.5em !important;
                                    padding: 15px;
                                    font-size: 13px;
                                    height: 27px;
                                    color: #db0f19;
                                    background: rgba(219, 15, 25, 0.1);
                                    margin-bottom: 9px;
                                    width: 100%;
                                "
                                label="View Leads"
                                icon="pi pi-eye"
                            >
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <br />
        <br />

        <DataTable
            :value="direct_coms"
            :paginator="true"
            :rows="10"
            dataKey="listId"
            :rowHover="true"
            v-model:filters="filters"
            :loading="listTableLoading"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            :rowsPerPageOptions="[10, 25, 50]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            :globalFilterFields="[
                'fileName',
                'properties_count',
                'import_time',
            ]"
            responsiveLayout="scroll"
        >

        <div class="row mt-5">
            <div class="d-flex justify-content-between">
                <div class="d-flex ml-3">
                    <img
                        :src="envelopeImage()"
                        style="height: 20px; margin-top: 8px"
                    />
                    <p class="ml-3" style="font-weight: 700; font-size: 23px">
                        Direct Mail Campaigns
                    </p>
                </div>
                <div class="d-flex mr-3 mb-3">
                    <Button
                        class="p-button p-button-outlined p-button-danger"
                        style="
                            border-radius: 0.6em !important;
                            padding: 0px 30px;
                            font-size: 15px;
                            height: 40px;
                        "
                        icon="pi pi-plus"
                        @click="displayCampaignModal = true"
                        label="Create Direct Mail Campaign"
                    >
                    </Button>
                </div>
            </div>
        </div>
            <template #empty> No List found. </template>
            <template #loading> Loading List data. Please wait. </template>

            <Column
                field="Campaign Name"
                header="Campaign Name"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    {{ data.name }}
                </template>
            </Column>

            <Column
                field="Date Sent"
                header="Date Sent"
                sortable
                style="min-width: 10rem"
            >
                <template #body="{ data }">
                    {{ data.date_sent }}
                </template>
            </Column>

            <Column
                field="Sent To"
                header="Sent To"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    {{ Number(data.sent_count).toLocaleString() }}
                </template>
            </Column>

            <Column
                field="Accept"
                header="Accept"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    {{ Number(data.accept).toLocaleString() }}
                </template>
            </Column>

            <Column field="Deny" header="Deny" sortable style="min-width: 8rem">
                <template #body="{ data }">
                    {{ Number(data.deny).toLocaleString() }}
                </template>
            </Column>
            <Column
                field="Counter-OFFER"
                header="Counter-OFFER"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    {{ data.counter_count }}
                </template>
            </Column>
            <Column
                field="Total Optins"
                header="Total Optins"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    {{ data.total_count }}
                </template>
            </Column>
            <Column
                field="Action"
                header="Action"
                sortable
                style="min-width: 12rem"
            >
                <template #body="{ data }">
                    <Button
                        icon="pi pi-eye"
                        @click="showEditListNameModal(data.listId)"
                        class="p-button-rounded p-button-grey p-button-outlined mr-2"
                    />
                    <Button
                        icon="pi pi-trash"
                        @click="
                            confirmListDelete(
                                data.fileName,
                                data.listId,
                                data.properties_count
                            )
                        "
                        class="p-button-rounded p-button-grey p-button-outlined"
                    />
                </template>
            </Column>
        </DataTable>
    </AuthenticatedLayout>

    <!--Website Modal 1 -->
    <Dialog
        header=""
        :draggable="false"
        v-model:visible="displayCampaignModal"
        :style="{ width: '40vw' }"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 90%"
            >
                <span class="p-dialog-title">Create Direct Mail Campaign</span>
            </div>
        </template>
        <div class="">
            <!--Company Name-->
            <div class="field grid mt-5">
                <div class="col-12">
                    <span class="p-float-label">
                        <InputText
                            id="companyName"
                            placeholder="Type Campaign Name"
                            autofocus
                            class="w-full py-4"
                            type="text"
                            v-model="compaignName"
                            style="border-radius: 1rem !important"
                        />
                        <label for="companyName">Campaign Name</label>
                    </span>
                </div>
            </div>

            <div class="field grid mt-3">
                <span class="col-12">
                    <Dropdown
                        class="w-full py-2 w-100"
                        id="multiselect"
                        :filter="true"
                        placeholder="Select Domain Name"
                        display="chip"
                        style="
                            border-radius: 1rem !important;
                            width: 100% !important;
                        "
                        v-model="selectedDomain"
                        optionLabel="domain"
                        :options="domains"
                    >
                        <template #option="slotProps">
                            <!-- <span class="">{{ slotProps.option.domain }} ({{
                                    slotProps.option.property_count
                                }}) </span> -->
                        </template>
                    </Dropdown>
                </span>
            </div>

            <div class="field grid mt-2">
                <div class="col-12">
                    <div class="p-inputgroup">
                        <Dropdown
                            v-model="phone_country_code"
                            :options="countries"
                            style="
                                border-top-left-radius: 1rem;
                                border-bottom-left-radius: 1rem;
                                border-right: none;
                                width: 5rem;
                            "
                            optionLabel="name"
                            optionValue="code"
                        >
                            <template #value="slotProps">
                                <div
                                    class="flex align-items-center"
                                    style="height: 100%"
                                >
                                    <div v-if="slotProps.value">
                                        <span
                                            :class="'fi fi-' + slotProps.value"
                                        />
                                    </div>
                                    <span v-else>
                                        <span :class="'fi fi-us'" />
                                    </span>
                                </div>
                            </template>
                            <template #option="slotProps">
                                <div class="" style="display: inline">
                                    <span
                                        :class="
                                            'fi fi-' + slotProps.option.code
                                        "
                                    ></span>
                                    <div class="ml-3" style="display: inline">
                                        {{ slotProps.option.name }}
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                        <span class="p-float-label">
                            <InputText
                                id="phone-number"
                                class="text-2xl"
                                v-model="phone"
                                style="
                                    border-top-right-radius: 1rem;
                                    border-bottom-right-radius: 1rem;
                                "
                                required
                                placeholder="Type phone number.."
                            />
                            <label for="phone-number" class="move-left"
                                >Phone Number</label
                            >
                        </span>
                    </div>
                </div>
            </div>

            <div class="field col-12 px-0">
                <span class="p-float-label">
                    <MultiSelect
                        class="w-full"
                        id="multiselect"
                        :filter="true"
                        placeholder="Add Lists"
                        display="chip"
                        v-model="lists_input"
                        optionLabel="filename"
                        :options="lists"
                    >
                        <template #option="slotProps">
                            <span class="">{{
                                slotProps.option.filename
                            }}</span>
                            <span class="flex-grow-1"></span>
                        </template>
                    </MultiSelect>
                    <label for="multiselect">Add Lists</label>
                </span>
            </div>

            <!--Upload Button -->
            <div class="field col-12 px-0 mt-2">
                <Button
                    class="p-button p-button-outlined p-button-danger w-full py-3"
                    style="border-radius: 0.5rem !important"
                    @click="previewCampaign"
                    :loading="upLoadingList"
                >
                    <div class="w-100" style="align-items: center">
                        <span style="font-size: 20px">Next Step</span>
                        <span
                            class="pi pi-arrow-right ms-3"
                            style="font-size: 20px"
                        ></span>
                    </div>
                </Button>
            </div>
        </div>
    </Dialog>

    <!--Website Modal 2 -->
    <Dialog
        header=""
        class="scm"
        :draggable="false"
        v-model:visible="displayReviewCampaign"
        :style="{ width: '39vw !important' }"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 90%"
            >
                <span class="p-dialog-title">Review Direct Mail Campaign</span>
            </div>
        </template>
        <div class="pb-0 mt-2">
            <!-- <hr class="mt-0 border border-1 border-dark" /> -->
            <!--Headline-->
            <div class="field grid mb-0 ml-3">
                <div class="col-12">
                    <span class="p-float-label fs-4">
                        {{ compaignName }}
                    </span>
                </div>
            </div>
            <!--Sub-Headline-->
            <div class="field grid mt-2 ml-3">
                <div class="d-flex col-12">
                    <img :src="earthImage()" alt="" />
                    <span class="p-float-label fs-5 ms-3">
                        {{ selectedDomain.domain }}
                    </span>
                </div>
            </div>

            <!--Offer Codes-->
            <div class="field grid mt-2 ml-3">
                <div class="d-flex col-12">
                    <img :src="callImage()" alt="" />
                    <span class="p-float-label fs-5 ms-3">
                        {{ phone }}
                    </span>
                </div>
            </div>

            <!--Offer Codes-->
            <div class="field grid">
                <div class="d-flex col-12">
                    <span
                        v-for="list in lists_input"
                        class="p-float-label fs-5 ms-3"
                        style="
                            background-color: rgb(250, 250, 250);
                            padding: 3px;
                            border-radius: 4px;
                        "
                    >
                        {{ list.filename }}
                    </span>
                </div>
            </div>

            <div class="field grid mb-0">
                <div class="col-12 text-center">
                    <div v-html="postcard"></div>
                    <!-- <img class="" :src="campaignImage()" alt=""> -->
                </div>
            </div>

            <div class="row mx-2 mt-3">
                <div class="col-md-7 d-flex mt-3">
                    <p>
                        The Direct Mail campaign will cost
                        {{ creds_req }} credits to send
                    </p>
                </div>
                <div class="col-md-5 d-flex">
                    <div
                        class="cred-con d-flex ms-auto"
                        style="width: fit-content"
                    >
                        <div class="h-100 p-1 mr-2 cred-text text-center">
                            <span class="creditBalance">{{
                                credits.toLocaleString("en-US")
                            }}</span>
                            <br />
                            <span>Credit Balance</span>
                        </div>
                        <div class="">
                            <span></span>
                        </div>

                        <Link
                            :href="route('credits')"
                            method="get"
                            exact
                            class="p-button p-button-danger-shadow"
                        >
                            <span>Top Up</span>
                        </Link>
                    </div>
                    <!-- <div class="d-flex justify-content-between col-md-5"
                     style="border:1px solid grey;padding:10px 18px;border-radius:10px;">
                        <div style="margin-right:20px">
                            <p class="text-center mb-0" style="font-weight:700">{{credits}}</p>
                            <span>
                            Credit Balance
                        </span>
                        </div>
                        <Button class="p-button  p-button-danger"
                                style="border: 0px;border-radius: 0.7rem !important;background-color:#FBE7E8;color: #DB0F19;padding:0px 40px"
                                @click="displayUploadModal = true"
                                label="Top Up">
                        </Button>
                    </div> -->
                </div>
            </div>

            <div class="field grid mt-5 mb-0">
                <div class="field col-12 px-0 mt-2">
                    <Button
                        class="p-button p-button-outlined p-button-danger w-full py-3"
                        style="border-radius: 0.5rem !important"
                        @click="websiteStep3"
                        :loading="upLoadingList"
                    >
                        <div class="w-100" style="align-items: center">
                            <span style="font-size: 20px">Send Campaign</span>
                        </div>
                    </Button>
                </div>
            </div>
        </div>
    </Dialog>

    <Toast />
    <ConfirmDialog />
</template>

<style>
.scm .p-dialog-content {
    overflow: scroll !important;
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
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 17px;
    width: 17px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: red;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
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
    background: #db0f19;
}

.p-dropdown {
    flex-grow: 0;
}

.p-float-label input:focus ~ label.move-left,
.p-float-label input.p-filled ~ label.move-left {
    margin-left: -5rem;
}

.top-cards {
    border: 1px solid #ebebeb;
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
    color: #575a7b;
    border: 0 none;
    /*box-shadow: inset 0 0 0 1px var(--surface-border) !important;*/
}

.p-button-danger-shadow {
    background: rgba(219, 15, 25, 0.1);
    border-radius: 8px;
    /* Primary */

    color: #db0f19 !important;
}

.cred-text {
    padding: 10px 28px;
    font-family: "Nunito";
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;

    /* Text 2 */

    color: #575a7b;

    text-align: center;
}

.topup-label {
    /* Primary */

    background: #db0f1924;
    /* opacity: 0.1; */
    border-radius: 8px;
    padding: 10px 28px;
}

.topup-label span {
    font-family: "Nunito";
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 19px;
    /* identical to box height */

    /* Primary */

    color: #db0f19;
}

.cred-con {
    background: #ffffff;
    border: 1px solid #ebebeb;
    border-radius: 10px;
    padding: 7px;
    /* margin-left: auto; */
}
.cred-con a {
    font-weight: 700;
}

.p-divider.p-divider-horizontal:before {
    border-top: 1px rgba(0, 0, 0, 0.38) !important;
    position: absolute;
    display: block;
    top: 50%;
    left: 0;
    width: 100%;
    content: "";
}

.p-fileupload-choose.p-button-danger:hover {
    background-color: #d32f2f;
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

.daterangepicker td.active,
.daterangepicker td.active:hover {
    /* border-color: none!important; */
    background: rgba(219, 15, 25, 1) !important;
    height: 30px;
    width: 30px;
    border-radius: 50% !important;
}

.daterangepicker .ranges li.active {
    border-color: rgba(219, 15, 25, 1) !important;
    background: rgba(219, 15, 25, 1) !important;
}

.applyBtn {
    border-color: rgba(219, 15, 25, 1) !important;
    background: rgba(219, 15, 25, 1) !important;
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
.timelineStepLine {
    height: 3px;
    background: #e6eaed;
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
    margin: 1rem;
}

.timeline-steps .timeline-step.active:not(:last-child):after {
    content: "";
    display: block;
    border-top: 0.3rem solid red;
    width: 11rem;
    position: absolute;
    left: 5.9rem;
    top: 0.3125rem;
}

.timeline-steps .timeline-content {
    width: 6rem;
    text-align: center;
}

.timeline-steps .timeline-content .inner-circle {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #3b82f6;
}

.timeline-steps .timeline-content .inner-circle.active:before {
    content: "";
    background-color: #db0f19;
    display: inline-block;
    height: 4.1rem;
    color: #ffffff;
    min-width: 4.1rem;
    border-radius: 6.25rem;
}

.timeline-steps .timeline-content .inner-circle:before {
    content: "";
    background-color: white;
    display: inline-block;
    border: 4px solid red;
    height: 4.1rem;
    color: black;
    min-width: 4.1rem;
    border-radius: 6.25rem;
}

.timeline-steps .timeline-content .inner-circle-white {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
}

.timeline-steps .timeline-content .inner-circle-white:before {
    content: "";
    background-color: #ffffff;
    display: inline-block;
    height: 2.1rem;
    width: 2.1rem;
    border: 1px solid #d9d9d9;
    color: #ffffff;
    min-width: 2.1rem;
    border-radius: 6.25rem;
}

.time-line-txt-active {
    color: #ffffff;
    margin: 1px 0px 0px -33px;
    font-size: 1.2rem;
}

.time-line-txt {
    color: #8a8a8a;
    margin: 1px 0px 0px -21px;
    font-size: 0.8rem;
    font-weight: 600;
}

.count-butonn {
    background: white;
    color: #8a8a8a;
    border: 1px solid #d9d9d9;
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
.p-dialog-content {
    padding-bottom: 0;
    overflow: hidden;
}
</style>
