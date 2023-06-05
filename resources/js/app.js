import './bootstrap';
/*import '../css/app.css';*/
import 'primevue/resources/primevue.min.css';
import 'primeflex/primeflex.css';
import 'primeicons/primeicons.css';
import 'prismjs/themes/prism-coy.css';
import '../css/styles/layout.scss';
import '../css/styles/style.css';


import {createApp, h, reactive} from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';
import StyleClass from 'primevue/styleclass';
import Tooltip from 'primevue/tooltip';
import Ripple from 'primevue/ripple';
import Badge from 'primevue/badge';
import BadgeDirective from 'primevue/badgedirective';
import DataTable from "primevue/datatable"
import Column from "primevue/column";
import Button from 'primevue/button';
import InputText from "primevue/inputtext";
import Card from 'primevue/card';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import Panel from 'primevue/panel';
import Fieldset from 'primevue/fieldset';
import Password from 'primevue/password';
import Dropdown from 'primevue/dropdown';
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';
import Divider from 'primevue/divider';
import AutoComplete from 'primevue/autocomplete';
import MultiSelect from 'primevue/multiselect'
import FileUpload from 'primevue/fileupload';
import Chip from 'primevue/chip';
import InlineMessage from 'primevue/inlinemessage'
import VueSocialSharing from 'vue-social-sharing'

window.add_commas = (value, numberOfDecimals = 0) => {

    console.log(value)
    if(numberOfDecimals) return Number(Number(remove_commas(value)).toFixed(numberOfDecimals)).toLocaleString();//.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return Number(remove_commas(value)).toLocaleString();//.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

window.remove_commas = value => {

    if(value == 0 || !value) return value
    return Number(String(value).replace(/\,/g, ""));
}

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title  : (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, app, props, plugin}) {
        const myApp = createApp({render: () => h(app, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueSocialSharing)
            .use(PrimeVue, {ripple: true, inputStyle: 'outlined'})
            .use(ToastService)
            .use(ConfirmationService)
            .directive('tooltip', Tooltip)
            .directive('styleclass', StyleClass)
            .directive('badge', BadgeDirective)
            .directive('ripple', Ripple)
            .component('Badge', Badge)
            .component("DataTable", DataTable)
            .component("Column", Column)
            .component("Button", Button)
            .component("InputText", InputText)
            .component("Card", Card)
            .component('Dialog', Dialog)
            .component('Toast', Toast)
            .component('Panel', Panel)
            .component('Fieldset', Fieldset)
            .component('Password', Password)
            .component('Dropdown', Dropdown)
            .component('ConfirmDialog', ConfirmDialog)
            .component('Divider', Divider)
            .component('AutoComplete', AutoComplete)
            .component('MultiSelect', MultiSelect)
            .component('FileUpload', FileUpload)
            .component('Chip', Chip)
            .component('InlineMessage', InlineMessage)
        ;

        myApp.config.globalProperties.$appState = reactive({theme: 'lara-light-teal', darkTheme: true});
        return myApp.mount(el);
    },
});

InertiaProgress.init({color: '#4B5563'});
