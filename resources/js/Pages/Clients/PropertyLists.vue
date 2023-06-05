<template>
    <AuthenticatedLayout>
        <Head><title>Lists</title></Head>
        <template #pageHeading>
            <div>
                <i class="pi pi-book mr-2 text-2xl font-bold" />
                <span class="text-2xl mr-3"
                    ><strong
                        >Lists (
                        <span v-if="allLists !== null">{{
                            allListsArr.length
                        }}</span
                        ><span v-else>0</span> )</strong
                    ></span
                >

                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                        v-model="filters['global'].value"
                        placeholder="Search"
                    />
                </span>
            </div>

            <Button
                class="p-button p-button-outlined p-button-danger"
                style="border-radius: 0.5rem !important"
                icon="pi pi-upload"
                @click="displayUploadModal = true"
                label="Upload List"
            ></Button>
        </template>

        <DataTable
            :value="allListsArr"
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
            <template #empty> No List found. </template>
            <template #loading> Loading List data. Please wait. </template>

            <Column
                field="fileName"
                header="FILE NAME"
                sortable
                style="min-width: 14rem"
            >
                <!-- <template #body="{data}">
                    <span
                    @click="showEditListTagsModal(data.listId)"
                    class="hover-links"
                    >
                    {{ data.fileName }}

                    </span>

                </template> -->
                <template #body="{ data }">
                    <Link
                        :href="route('properties-data.list', data.listId)"
                        :class="['p-ripple']"
                        method="get"
                        exact
                        class="hover-links"
                        role="menuitem"
                        v-ripple
                        v-tooltip.top="data.fileName"
                    >
                        <!-- <i class="pi pi-sign-out text-xl"></i> -->
                        <span>{{ data.fileName }}</span>
                    </Link>
                </template>
            </Column>

            <Column
                field="properties_count"
                header="PROPERTIES"
                sortable
                style="min-width: 4rem"
            >
                <template #body="{ data }">
                    {{ data.properties_count }}
                </template>
            </Column>

            <Column
                field="tags"
                header="MOTIVATION TAGS"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    <Chip
                        v-for="(tag, index) in data.tags"
                        :key="index"
                        :label="tag"
                        class="text-sm mr-2 mb-2"
                    />
                </template>
            </Column>

            <Column
                field="import_time"
                header="IMPORT DATE"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    <i class="pi pi-calendar mr-2"></i>
                    {{ data.import_time }}
                </template>
            </Column>

            <Column
                field="tags"
                header="ACTION"
                sortable
                style="min-width: 14rem"
            >
                <template #body="{ data }">
                    <Button
                        icon="pi pi-pencil"
                        @click="showEditListNameModal(data.listId)"
                        class="p-button-rounded p-button-grey p-button-outlined mr-2"
                    />
                    <Button
                        icon="pi pi-tags"
                        @click="showEditListTagsModal(data.listId)"
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

    <!--Upload List Modal -->
    <Dialog
        header=""
        :draggable="false"
        v-model:visible="displayUploadModal"
        :style="{ width: '50vw' }"
        :modal="true"
    >
        <template #header>
            <div
                class="flex justify-content-between align-items-center"
                style="width: 90%"
            >
                <span class="p-dialog-title">Upload List File</span>
                <a
                    :href="route('downloadTemplate')"
                    class="p-button p-button-danger p-button-text underline text-sm"
                >
                    <i class="pi pi-download mr-2"></i>Download Template
                </a>
            </div>
        </template>
        <div class="">
            <!--Add or Select Motivation Tags-->
            <div class="field col-12 px-0 mt-4 mb-0">
                <span class="p-float-label">
                    <MultiSelect
                        class="w-full"
                        id="multiselect"
                        :filter="true"
                        placeholder="Add Motivation Tags"
                        display="chip"
                        v-model="uploadFileForm.motivation_tags"
                        @change="addMotivationTagSelectionChanged"
                        optionLabel="tag_name"
                        :options="allTags"
                    >
                        <template #option="slotProps">
                            <span class="">{{
                                slotProps.option.tag_name
                            }}</span>
                            <span class="flex-grow-1"></span>
                            <span
                                class="mr-2"
                                v-if="slotProps.option.tag_type !== 'admin'"
                            >
                                <Button
                                    icon="pi pi-pencil"
                                    @click.stop="!showTagEditModal"
                                    @click="
                                        showTagEditModal(
                                            slotProps.option.tag_name,
                                            slotProps.option.id
                                        )
                                    "
                                    class="p-button-rounded p-button-grey p-button-outlined mr-2"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    @click.stop="!confirmTagDelete"
                                    @click="
                                        confirmTagDelete(
                                            slotProps.option.tag_name,
                                            slotProps.option.id
                                        )
                                    "
                                    class="p-button-rounded p-button-grey p-button-outlined"
                                />
                            </span>
                        </template>
                        <template #footer>
                            <hr />
                            <div class="grid">
                                <div class="col-12">
                                    <Button
                                        label="Add Motivation Tags"
                                        icon="pi pi-pencil"
                                        @click="displayAddTagModal = true"
                                        class="ml-2 p-button-danger p-button-text underline"
                                    />
                                </div>
                            </div>
                        </template>
                    </MultiSelect>
                    <label for="multiselect">Add Motivation Tags</label>
                </span>
            </div>

            <!-- File Upload-->
            <div class="field col-12 px-0">
                <Divider class="mb-0 mt-0" align="left" style="">
                    <!--                    1px solid rgba(0, 0, 0, 0.38)-->
                    <span style="font-size: 12px; color: rgba(0, 0, 0, 0.6)"
                        >Upload List File</span
                    >
                </Divider>
                <div
                    class="p-3"
                    style="
                        border: 1px solid rgba(0, 0, 0, 0.15);
                        margin-top: -0.5rem;
                    "
                >
                    <FileUpload
                        mode="basic"
                        chooseLabel="Upload File"
                        chooseIcon="pi pi-upload"
                        class="p-button-danger p-button-outlined p-button-sm"
                        style="border-radius: 0.5rem !important"
                        @select="onSelectedFiles"
                        @clear="onFilesClear"
                        @remove="onFilesClear"
                        accept=".xlsx,.csv,.xls,.ods"
                    />
                    <div class="text-sm mt-2">
                        Accepted File Types Include: .CSV, .XLS, .XLSX, .ODS
                    </div>
                </div>
            </div>

            <!--Upload Button -->
            <div class="field col-12 px-0 mt-2">
                <Button
                    class="p-button p-button-outlined p-button-danger w-full py-3"
                    style="border-radius: 0.5rem !important"
                    @click="uploadList"
                    :loading="upLoadingList"
                    label="Upload List"
                />
            </div>
        </div>
    </Dialog>

    <!--Add Motivation Tags Modal -->
    <Dialog
        header="Add New Motivation Tag"
        v-model:visible="displayAddTagModal"
        :draggable="false"
        :style="{ width: '50vw' }"
        :modal="true"
    >
        <hr />

        <!--Tag Name -->
        <div class="field grid mt-5">
            <div class="col-12">
                <span class="p-float-label">
                    <InputText
                        id="createTag"
                        placeholder="Type Tag Name Here.."
                        autofocus
                        class="w-full py-4"
                        type="text"
                        style="border-radius: 1rem !important"
                        v-model="createTagForm.tagName"
                    />
                    <label for="inputtext">Name</label>
                </span>
            </div>
        </div>

        <div class="field grid mt-5">
            <div class="col-12">
                <Button
                    class="p-button-outlined p-button-danger py-4 w-full"
                    style="border-radius: 1rem !important"
                    @click="createNewTag"
                    :disabled="creatingTag"
                    label="Create Tag"
                />
            </div>
        </div>
    </Dialog>

    <!-- Edit Motivation Tag Dialog -->
    <Dialog
        header="Edit Motivation Tag"
        v-model:visible="displayEditTagModal"
        :draggable="false"
        :style="{ width: '50vw' }"
        :modal="true"
    >
        <hr />
        <div class="field grid mt-5">
            <div class="col-12">
                <span class="p-float-label">
                    <InputText
                        id="editTag"
                        autofocus
                        class="w-full py-4"
                        type="text"
                        style="border-radius: 1rem !important"
                        v-model="editTagForm.tagName"
                    />
                    <label for="inputtext">Name</label>
                </span>
            </div>
        </div>
        <div class="field grid mt-5">
            <div class="col-12">
                <Button
                    class="p-button-outlined p-button-danger py-4 w-full"
                    style="border-radius: 1rem !important"
                    @click="saveEditedTag"
                    :disabled="savingEditedTag"
                    label="Save Tag"
                />
            </div>
        </div>
    </Dialog>

    <!--Edit List Name Modal-->
    <Dialog
        header="Edit List Name"
        :draggable="false"
        v-model:visible="listNameEditModalActive"
        :style="{ width: '50vw' }"
        :modal="true"
    >
        <hr />
        <div class="field grid mt-5">
            <div class="col-12">
                <span class="p-float-label">
                    <InputText
                        id="editListName"
                        autofocus
                        class="w-full py-4"
                        type="text"
                        style="border-radius: 1rem !important"
                        v-model="listBeingEdited.fileName"
                    />
                    <label for="inputtext">FILE NAME</label>
                </span>
            </div>
        </div>
        <div class="field grid mt-5">
            <div class="col-12">
                <Button
                    class="p-button-outlined p-button-danger py-4 w-full"
                    style="border-radius: 1rem !important"
                    @click="saveListName"
                    :disabled="savingListName"
                    label="Save File Name"
                />
            </div>
        </div>
    </Dialog>

    <!--Edit List Tags-->
    <Dialog
        :header="'Edit List Tags: ' + listBeingEdited.fileName"
        v-model:visible="listTagsEditModalActive"
        :draggable="false"
        :style="{ width: '50vw' }"
        :modal="true"
    >
        <hr />

        <!--Add or Select Motivation Tags-->
        <div class="field col-12 px-0">
            <span class="p-float-label">
                <MultiSelect
                    class="w-full"
                    id="multiselect"
                    :filter="true"
                    placeholder="Add Motivation Tags"
                    display="chip"
                    v-model="listBeingEdited.tagRows"
                    optionLabel="tag_name"
                    :options="allTags"
                >
                    <template #option="slotProps">
                        <span class="">{{ slotProps.option.tag_name }}</span>
                        <span class="flex-grow-1"></span>
                        <span
                            class="mr-2"
                            v-if="slotProps.option.tag_type !== 'admin'"
                        >
                            <Button
                                icon="pi pi-pencil"
                                @click.stop="!showTagEditModal"
                                @click="
                                    showTagEditModal(
                                        slotProps.option.tag_name,
                                        slotProps.option.id
                                    )
                                "
                                class="p-button-rounded p-button-grey p-button-outlined mr-2"
                            />
                            <Button
                                icon="pi pi-trash"
                                @click.stop="!confirmTagDelete"
                                @click="
                                    confirmTagDelete(
                                        slotProps.option.tag_name,
                                        slotProps.option.id
                                    )
                                "
                                class="p-button-rounded p-button-grey p-button-outlined"
                            />
                        </span>
                    </template>
                    <template #footer>
                        <hr />
                        <div class="grid">
                            <div class="col-12">
                                <Button
                                    label="Add Motivation Tags"
                                    icon="pi pi-pencil"
                                    @click="displayAddTagModal = true"
                                    class="ml-2 p-button-danger p-button-text underline"
                                />
                            </div>
                        </div>
                    </template>
                </MultiSelect>
                <label for="multiselect">Add Motivation Tags</label>
            </span>
        </div>

        <div class="field grid mt-5">
            <div class="col-12">
                <Button
                    class="p-button-outlined p-button-danger py-4 w-full"
                    style="border-radius: 1rem !important"
                    @click="saveListTags"
                    :disabled="savingListTags"
                    label="Save Selected Tags"
                />
            </div>
        </div>
    </Dialog>

    <Toast />
    <ConfirmDialog />
</template>

<script>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: "ListsPage",
    props: ["allMotivationTags", "allLists"],
    data() {
        return {
            allTags: this.allMotivationTags,
            allListsArr: this.allLists,
            displayEditTagModal: false,
            displayUploadModal: false,
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
        };
    },

    created() {
        this.initFilters();
    },
    mounted() {
        this.allListsArr.sort((a, b) => a.listId - b.listId);
    },
    methods: {
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
                    /*this.$toast.add({
                        severity: 'success',
                        summary : 'Success',
                        detail  : response.message ?? "Action Successful",
                        life    : 3000
                    });*/
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

<style>
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
    box-shadow: inset 0 0 0 1px var(--surface-border) !important;
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

.hover-links:hover {
    cursor: pointer;
    color: rgba(219, 15, 25, 1);
}

.p-paginator .p-paginator-pages .p-paginator-page.p-highlight {
    background: rgba(63, 81, 181, 0.12) !important;
    color: rgba(0, 0, 0, 0.6);
}
</style>
