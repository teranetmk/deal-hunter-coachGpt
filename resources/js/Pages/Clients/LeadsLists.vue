<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import Slider from 'primevue/slider';
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';
import {DomHandler} from 'primevue/utils';
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name : 'Dashboard',
    props: ["propertiesData", "propertyData"],
    async mounted() {
        const res = await axios.get(route('dashboard.data'));
        this.allUserTags = res.data.tags;
        this.addTagsBtnLoading = false;
        this.properties = this.propertiesData;
        this.property = this.propertyData;

    },

    data() {
        return {
            addTagsBtnLoading    : true,
            allUserTags          : null,
            selectedUserTags     : null,
            selectedUserTagsModal: null,
            addTagsModalVisible  : false,
            showAddTagsModal     : false,
            loadingProperties    : false,
            properties           : this.propertiesData,
            tagCount             : 0,
            getPropertyInterval  : null,
            selectedProperties   : [],
            property: this.propertyData
        }
    },
    watch     : {
        selectedUserTags() {
            this.getProperties();
        }
    },
    computed  : {

        propertiesToDisplay() {
            this.properties           = this.propertiesData;
            return this.properties;
        }
    },
    methods   : {
        removedUserTag(tagId) {
            const left = this.selectedUserTags.filter(sut => {
                if (sut.tag_id !== tagId) {
                    return true;
                }
                return false;
            })
            this.selectedUserTags = left;
        },
        exportCSV() {
            const dataToExport = this.propertiesToDisplay;
            const colToFieldNames = {
                "PropertyAddress"  : "PROPERTY ADDRESS",
                "PropertyCity"     : "PROPERTY CITY",
                "PropertyState"    : "PROPERTY STATE",
                "PropertyZipCode"  : "PROPERTY ZIP",
                "OwnerName"        : "OWNER NAME",
                "OwnerPhoneNumber" : "OWNER PHONE NUMBER",
                "OwnerEmailAddress": "OWNER EMAIL ADDRESS",
                "MailingAddress"   : "MAILING ADDRESS",
                "MailingCity"      : "MAILING CITY",
                "MailingState"     : "MAILING STATE",
                "MailingZipCode"   : "MAILING ZIP",
                "DateAddedToList"  : "DATE ADDED TO LIST",
                "uniqueTagCount"   : "DEGREES OF MOTIVATION",
            };
            const columnNames = Object.values(colToFieldNames);
            const colProperties = Object.keys(colToFieldNames);

            // console.log(columnNames);
            let csv = '\ufeff';
            csv += '"' + columnNames.join('","') + '"';
            if (dataToExport) {
                dataToExport.forEach((row) => {
                    // row
                    csv += '\n';
                    let rowInitiated = false;
                    const rowString = '';

                    // Cols
                    for (let i = 0; i < colProperties.length; i++) {
                        if (rowInitiated) csv += ',';
                        else rowInitiated = true;

                        let column = colProperties[i];
                        let cellData = row[column];

                        if (cellData !== null) {
                            cellData = String(cellData).replace(/"/g, '""');
                        } else {
                            cellData = '';
                        }

                        csv += '"' + cellData + '"';
                    }

                })
            }

            DomHandler.exportCSV(csv, 'DealHunterProperties');

            // this.$refs.dt.exportCSV({selectionOnly: false}, this.propertiesToDisplay);
        },
        motivationSliderChange() {
            //console.log(this.tagCount);
        },
        addSelectedMotivationTags() {
            this.selectedUserTags = this.selectedUserTagsModal;
            this.showAddTagsModal = false;
        },
        async getProperties() {
            if (this.getPropertyInterval)
                clearInterval(this.getPropertyInterval);
            this.getPropertyInterval = setInterval(async () => {
                    this.loadingProperties = true;
                    const res = await axios.post(route('dashboard.properties-data'), {requiredTags: this.selectedUserTags})
                    this.properties = res.data.propertyData;
                    this.loadingProperties = false;
                    clearInterval(this.getPropertyInterval);
                }, 500
            )
        }
    },
    components: {AuthenticatedLayout, Head, Slider,Link, VueSlider}

}
</script>
<style>


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

.p-paginator {
    position: relative;
    justify-content: end!important;
}

.p-paginator-current {
    position: absolute!important;
    left: 0;
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

.vue-slider-process {
    background-color: rgba(219, 15, 25, 1) !important;
}

.vue-slider-dot-tooltip-inner {
    background-color: rgba(219, 15, 25, 1) !important;
    border-color: rgba(219, 15, 25, 1) !important;
}

.vue-slider-rail {
    background-color: rgba(219, 15, 25, 0.2) !important;
}

.vue-slider-mark-step {
    background-color: rgba(219, 15, 25, 0) !important;
}

.vue-slider-dot-handle {
    background: rgba(219, 15, 25, 1);
}

.p-datatable .p-datatable-tbody > tr.p-highlight {
    color: inherit;
    background: rgba(219, 15, 25, 0.12);
}


.p-checkbox:not(.p-checkbox-disabled) .p-checkbox-box.p-highlight:hover {
    border-color: rgba(219, 15, 29, 1);
    background: rgba(219, 15, 29, 1);
    color: #ffffff;
}

.p-checkbox .p-checkbox-box.p-highlight {
    border-color: rgba(219, 15, 29, 1);
    background: rgba(219, 15, 29, 1) !important;
}

.layout-main-container-leads {
    padding-top: 1rem!important;
}
</style>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout >



        <!-- <div class="grid">
            <div class="col-12">
                <Chip v-for="tagAr in selectedUserTags"
                      :key="tagAr.tag_id"
                      class="text-xs mr-1 mb-1"
                      @remove="removedUserTag(tagAr.tag_id)"
                      :label="tagAr.tag_name + ' (' + tagAr.property_count + ')'"
                      removable/>
            </div>
        </div> -->


        <DataTable :value="propertiesToDisplay"

                   ref="dt"
                   :paginator="true"
                   :rows="10"
                   dataKey="id"
                   v-model:selection="selectedProperties"
                   :rowHover="true"
                   :loading="loadingProperties"



                   paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
                   :rowsPerPageOptions="[10,25,50]"
                   currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
                   responsiveLayout="scroll">
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <span>
                        <Link :href="route('users.lists.get')"
                          :class="[ 'p-ripple']"
                          method="get"
                          exact
                          class="hover-links"
                          role="menuitem" v-ripple
                          >
                            <!-- <i class="pi pi-sign-out text-xl"></i> -->
                            <i class="pi pi-arrow-left text-2xl mr-2 font-bold"/>
                        </Link>

                        <span class="text-2xl mr-3"><strong><span >{{ property.filename }}</span>  ( {{
                                propertiesToDisplay.length ?? 0
                            }} )</strong></span>
                    </span>
                    <!-- <span class="flex-grow-1"></span>
                    <span class="mr-3 align-self-end"><img src="/BullsEyeIcon.svg"/></span> -->
                    <!-- <span class="mr-4 ml-2" style="width:240px;">
                        <vue-slider :height="8"
                                    :adsorb="true"
                                    :marks="true"
                                    @change="motivationSliderChange"
                                    :min="0"
                                    :max="10"
                                    :step="1"
                                    v-model="tagCount"/>
                    </span> -->
                    <!-- <span>
                        <Button class="p-button p-button-outlined p-button-danger"
                                style="border-radius: 0.5rem !important; display: inline-block !important"
                                icon="pi pi-download"
                                @click="exportCSV($event)"
                                label="Download List"/>
                    </span> -->


                </div>
            </template>
            <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
            <Column field="PropertyAddress"
                    header="PROPERTY ADDRESS"
                    exportFooter="PROPERTY ADDRESS"
                    style="min-width: 14rem">
                    <template #body="{data}">
                    <Link :href="route('properties-data.list.lead', data.id)"
                        :class="[ 'p-ripple']"
                        method="get"
                        exact
                        class="hover-links"
                        role="menuitem" v-ripple
                        >
                        <span>{{ data.PropertyAddress }}</span>
                    </Link>

                    </template>
            </Column>
            <Column field="PropertyCity" header="PROPERTY CITY" exportFooter="PROPERTY CITY" style="min-width: 10rem"/>
            <Column field="PropertyState"
                    header="PROPERTY STATE"
                    exportFooter="PROPERTY STATE"
                    style="min-width: 12rem"/>
            <Column field="PropertyZipCode" header="PROPERTY ZIP" exportFooter="PROPERTY ZIP" style="min-width: 10rem"/>
            <Column field="OwnerName" header="OWNER NAME" exportFooter="OWNER NAME" style="min-width: 12rem"/>
            <Column field="OwnerPhoneNumber"
                    header="OWNER PHONE NUMBER"
                    exportFooter="OWNER PHONE NUMBER"
                    style="min-width: 14rem"/>
            <Column field="OwnerEmailAddress"
                    header="OWNER EMAIL ADDRESS"
                    exportFooter="OWNER EMAIL ADDRESS"
                    style="min-width: 14rem"/>
            <Column field="MailingAddress"
                    header="MAILING ADDRESS"
                    exportFooter="MAILING ADDRESS"
                    style="min-width: 14rem"/>
            <Column field="MailingCity" header="MAILING CITY" exportFooter="MAILING CITY" style="min-width: 10rem"/>
            <Column field="MailingState" header="MAILING STATE" exportFooter="MAILING STATE" style="min-width: 10rem"/>
            <Column field="MailingZipCode"
                    header="MAILING ZIP"
                    exportFooter="MAILING ZIP"
                    style="min-width: 10rem"/>

            <Column field="DateAddedToList"
                    header="DATE ADDED TO LIST"
                    exportFooter="DATE ADDED TO LIST"
                    style="min-width: 12rem"/>
            <Column field="uniqueTagCount"
                    sortable
                    header="DEGREES OF MOTIVATION"
                    exportFooter="DEGREES OF MOTIVATION"
                    style="min-width: 16rem"/>
        </DataTable>




    </AuthenticatedLayout>
</template>
