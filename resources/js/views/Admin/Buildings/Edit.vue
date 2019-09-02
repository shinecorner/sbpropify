<template>
    <div class="buildings-edit ">
        <heading :title="$t('models.building.edit_title')" icon="icon-commerical-building" shadow="heavy">
            <template slot="description" v-if="model.building_format">
                <div class="subtitle">{{`${model.building_format} > ${model.name}`}}</div>
            </template>
            <template>
                <div class="action-group">
                    <el-button @click="submit" size="small" type="primary" round> {{this.$t('general.actions.save')}}</el-button>
                    <el-button @click="saveAndClose" size="small" type="primary" round> {{this.$t('general.actions.saveAndClose')}}
                    </el-button>
                    <el-button @click="batchDeleteBuilding" size="small" type="danger" round icon="ti-trash"> {{this.$t('general.actions.delete')}}</el-button>
                    <el-button @click="goToListing" size="small" type="warning" round> {{this.$t('general.actions.close')}}
                    </el-button>
                </div>
            </template>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <el-tabs type="border-card" v-model="activeTab">
                    <el-tab-pane :label="$t('general.actions.view')" name="details">
                        <el-form :model="model" label-position="top" label-width="192px" ref="form">
                            <el-row :gutter="20">
                                <el-col :md="10">
                                    <el-form-item :label="$t('models.address.street')" :rules="validationRules.street"
                                                  prop="street"
                                                  style="max-width: 512px;">
                                        <el-input type="text" v-model="model.street" v-on:change="setBuildingName"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="4">
                                    <el-form-item :label="$t('models.building.house_nr')"
                                                  :rules="validationRules.street_nr"
                                                  prop="street_nr" style="max-width: 512px;">
                                        <el-input type="text" v-model="model.street_nr" v-on:change="setBuildingName"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="10">
                                    <el-form-item :label="$t('general.name')" :rules="validationRules.name"
                                                  prop="name"
                                                  style="max-width: 512px;">
                                        <el-input type="text" v-model="model.name"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row :gutter="20">
                                <el-col :md="4">
                                    <el-form-item :label="$t('general.zip')" :rules="validationRules.zip"
                                                  prop="zip"
                                                  style="max-width: 512px;">
                                        <el-input type="text" v-model="model.zip"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="8">
                                    <el-form-item :label="$t('general.city')" :rules="validationRules.city"
                                                  prop="city"
                                                  style="max-width: 512px;">
                                        <el-input type="text" v-model="model.city"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.address.state.label')"
                                                  :rules="validationRules.state_id"
                                                  prop="state_id" style="max-width: 512px;">
                                        <el-select :placeholder="$t('models.address.state.label')"
                                                   style="display: block"
                                                   v-model="model.state_id">
                                            <el-option :key="state.id" :label="state.name" :value="state.id"
                                                       v-for="state in states"></el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.building.district')" prop="district_id"
                                                  style="max-width: 512px;">
                                        <el-select
                                                :loading="remoteLoading"
                                                :placeholder="$t('general.placeholders.search')"
                                                :remote-method="remoteSearchDistricts"
                                                filterable
                                                remote
                                                reserve-keyword
                                                style="width: 100%;"
                                                v-model="model.district_id">
                                            <el-option
                                                    :label="$t('general.none')"
                                                    value=""
                                            />
                                            <el-option
                                                    :key="district.id"
                                                    :label="district.name"
                                                    :value="district.id"
                                                    v-for="district in districts"/>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.building.floor_nr')"
                                                  :rules="validationRules.floor_nr"
                                                  prop="floor_nr" style="max-width: 512px;">
                                        <el-input type="number" v-model="model.floor_nr"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane :label="$t('models.building.files')" name="files">
                        <draggable @sort="sortFiles" v-model="model.media">
                            <transition-group name="list-complete">
                                <el-row :gutter="10" :key="element.name" class="list-complete-item"
                                        v-for="(element, i) in model.media">
                                    <el-col :md="12">
                                        <strong>{{$t(`models.building.${element.collection_name}`)}}</strong>
                                    </el-col>
                                    <el-col :md="11">
                                        <a :href="element.url" class="file-name" target="_blank">
                                            {{element.name}}
                                        </a>
                                    </el-col>
                                    <el-col :md="1" style="text-align: right">
                                        <el-button :style="{color: 'red'}" @click="deleteDocument('media', i)"
                                                   icon="ti-close" size="mini" type="text"
                                        />
                                    </el-col>
                                </el-row>
                            </transition-group>
                        </draggable>
                        <div class="mt15">
                            <label class="card-label">{{$t('models.building.add_files')}}</label>
                            <el-select :placeholder="$t('models.building.select_media_category')"
                                       class="category-select"
                                       v-model="selectedFileCategory">
                                <el-option
                                    :key="item"
                                    :label="$t('models.building.' + item)"
                                    :value="item"
                                    v-for="item in model.media_category">
                                </el-option>
                            </el-select>
                            <upload-document @fileUploaded="uploadFiles" class="drag-custom" drag multiple
                                             v-if="selectedFileCategory"/>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane :label="$t('models.building.companies')" name="companies">
                        <label class="card-label">{{$t('settings.contact_enable.label')}}</label>
                        <el-select
                                placeholder="Chose"
                                style="width: 100%;"
                                v-model="model.contact_enable"
                        >
                            <el-option
                                    :key="contactEnableValue.id"
                                    :label="contactEnableValue.label"
                                    :value="contactEnableValue.value"
                                    v-for="contactEnableValue in contactEnableValues"/>
                        </el-select>
                        <div v-if="model.service_providers && model.service_providers.length" class="mt15">
                            <el-row :gutter="10" :key="service.id" class="list-complete-item"
                                    v-for="service in model.service_providers">
                                <el-col :md="7">
                                    <strong>{{$t(`models.service.${service.category}`)}}</strong>
                                </el-col>
                                <el-col :md="16">
                                    {{service.name}}
                                </el-col>
                                <el-col :md="1" style="text-align: right">
                                    <el-button :style="{color: 'red'}" @click="removeService(service)"
                                               icon="ti-close" size="mini"
                                               type="text"
                                    />
                                </el-col>
                            </el-row>
                        </div>
                        <div v-else class="mt15">
                            {{$t('models.building.no_services')}}
                        </div>
                        <div class="mt15">
                            <label class="">{{$t('models.building.add_companies')}}</label>
                            <el-select multiple
                                       placeholder="Select"
                                       style="margin: 15px 0;width: 100%" v-model="model.service_providers_ids">
                                <el-option-group
                                    :key="serviceCategory"
                                    :label="$t(`models.service.${serviceCategory}`)"
                                    v-for="(services, serviceCategory) in allServices">
                                    <el-option
                                        :key="service.id"
                                        :label="service.name"
                                        :value="service.id"
                                        v-for="service in services">
                                    </el-option>
                                </el-option-group>
                            </el-select>
                        </div>
                    </el-tab-pane>

                    <el-tab-pane :label="$t('general.requests')" name="requests">
                        <relation-list
                            :actions="requestActions"
                            :columns="requestColumns"
                            :filterValue="model.id"
                            fetchAction="getRequests"
                            filter="building_id"
                            v-if="model.id"
                        />
                    </el-tab-pane>
                </el-tabs>
            </el-col>
            <el-col :md="12">
                <el-tabs type="border-card" v-model="activeRightTab">
                    <el-tab-pane :label="$t('general.tenants')" name="tenants" v-loading="loading.state">
                        <relation-list
                            :actions="tenantActions"
                            :columns="tenantColumns"
                            :filterValue="model.id"
                            fetchAction="getTenants"
                            filter="building_id"
                            v-if="model.id"
                        />
                    </el-tab-pane>
                    <el-tab-pane :label="$t('models.building.managers')" name="managers">
                        <assignment
                            :toAssign.sync="toAssign"
                            :assign="assignManagers"
                            :toAssignList="toAssignList"
                            :remoteLoading="remoteLoading"
                            :remoteSearch="remoteSearchManagers"
                            :multiple="multiple"
                        />
                        <relation-list
                            :actions="managerActions"
                            :columns="managerColumns"
                            :filterValue="model.id"
                            fetchAction="getPropertyManagers"
                            filter="building_id"
                            ref="propertyManagersList"
                            v-if="model.id"
                        />
                    </el-tab-pane>
                    <el-tab-pane :label="$t('models.building.units')" name="units" v-loading="loading.state">
                        <relation-list
                            :actions="unitActions"
                            :columns="unitColumns"
                            :filterValue="model.id"
                            fetchAction="getUnits"
                            filter="building_id"
                            v-if="model.id"
                        />
                    </el-tab-pane>
                </el-tabs>
                <div>
                    <raw-grid-statistics-card :cols="8" :data="statistics.raw"/>
                </div>
                <el-row :gutter="15" type="flex">
                    <el-col :span="12">
                        <circular-progress-statistics-card
                            :percentage="+statistics.percentage.occupied_units"
                            :title="$t('models.building.occupied_units')"
                            :color="getUnitsCountColor('occupied_units', 'name')"/>
                    </el-col>
                    <el-col :span="12">
                        <circular-progress-statistics-card
                            :percentage="+statistics.percentage.free_units"
                            :title="$t('models.building.free_units')"
                            :color="getUnitsCountColor('free_units', 'name')"/>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>

        <DeleteBuildingModal 
            :deleteBuildingVisible="deleteBuildingVisible"
            :delBuildingStatus="delBuildingStatus"
            :closeModal="closeDeleteBuildModal"
            :deleteSelectedBuilding="deleteSelectedBuilding"
        />
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import {displayError, displaySuccess} from "helpers/messages";
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import RawGridStatisticsCard from 'components/RawGridStatisticsCard';
    import CircularProgressStatisticsCard from 'components/CircularProgressStatisticsCard';
    import ColoredStatisticsCard from 'components/ColoredStatisticsCard.vue';
    import BuildingsMixin from 'mixins/adminBuildingsMixin';
    import UploadDocument from 'components/UploadDocument';
    import draggable from 'vuedraggable';
    import RelationList from 'components/RelationListing';    
    import globalFunction from "helpers/globalFunction";
    import DeleteBuildingModal from 'components/DeleteBuildingModal';
    import Assignment from 'components/Assignment';

    export default {
        mixins: [globalFunction, BuildingsMixin({
            mode: 'edit'
        })],
        components: {
            Heading,
            Card,
            RawGridStatisticsCard,
            CircularProgressStatisticsCard,
            ColoredStatisticsCard,
            UploadDocument,
            draggable,
            RelationList,
            DeleteBuildingModal,
            Assignment       
        },
        data() {
            return {
                selectedFileCategory: 'house_rules',
                activeTab: 'details',
                activeRightTab: 'tenants',
                tenantColumns: [{
                    type: 'requestTenantAvatar',
                    width: 70,
                    label: this.$t('general.tenant')
                }, {
                    prop: 'name',
                    label: this.$t('general.name')
                }, {
                    prop: 'status',
                    i18n: this.tenantStatusLabel,
                    withBadge: this.tenantStatusBadge,
                    label: this.$t('models.tenant.status.label')
                }],
                tenantActions: [{
                    buttons: [{
                        title: this.$t('models.tenant.view'),
                        onClick: this.tenantEditView,
                        icon: 'el-icon-user'
                    }]
                }],
                managerColumns: [{
                    type: 'requestTenantAvatar',
                    width: 50,
                }, {
                    prop: 'name',
                    label: this.$t('general.name')
                }],
                managerActions: [{
                    width: '180px',
                    buttons: [{
                        title: 'models.building.unassign_manager',
                        type: 'danger',
                        onClick: this.unassignManager,
                        tooltipMode: true,
                        icon: 'el-icon-close'
                    }, {
                        title: 'general.actions.edit',
                        type: 'primary',
                        onClick: this.managerEditView,
                        tooltipMode: true,
                        icon: 'el-icon-edit'
                    }]
                }],
                unitColumns: [{
                    prop: 'name',
                    label: this.$t('models.unit.name')
                },{
                    prop: 'typeLabel',
                    label: this.$t('models.unit.type.label')
                },{
                    prop: 'floor',
                    label: this.$t('models.unit.floor')
                }],
                unitActions: [{
                    width: '180px',
                    buttons: [{
                        title: 'general.actions.edit',
                        type: 'primary',
                        onClick: this.unitEditView,
                        tooltipMode: true,
                        icon: 'el-icon-edit'
                    }]
                }],
                requestColumns: [{
                    type: 'requestTenantAvatar',
                    width: 75,
                    prop: 'tenant',
                    label: this.$t('general.tenant')
                }, {
                    type: 'requestTitleWithDesc',
                    width: 270,
                    label: this.$t('models.request.prop_title')
                }, {
                    type: 'requestStatus',
                    width: 120,
                    label: this.$t('models.request.status.label')
                }],
                requestActions: [{
                    width: '120px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: this.$t('general.actions.edit'),
                        onClick: this.requestEditView
                    }]
                }],
                toAssignList: [],
                toAssign: '',
                remoteLoading: false,
                deleteBuildingVisible: false,
                multiple: true,
                delBuildingStatus: -1, // 0: unit, 1: request, 2: both
                contactUseGlobalAddition: ''
            };
        },
        methods: {
            ...mapActions([
                'getRealEstate',
                "uploadBuildingFile",
                "deleteBuildingFile",
                "deleteBuildingService",
                "getPropertyManagers",
                "batchAssignUsersToBuilding",
                "unassignBuildingManager",
                "deleteBuilding",
                'deleteBuildingWithIds', 
                'checkUnitRequestWidthIds'
            ]),
            fetchRealEstate() {
                this.getRealEstate().then((resp) => {
                    this.contactUseGlobalAddition = resp.data.contact_enable ? this.$t('settings.contact_enable.show') : this.$t('settings.contact_enable.hide');
                }).catch((error) => {
                    displayError(error);
                });
            },
            unassignManager(manager) {
                this.$confirm(this.$t(`general.swal.confirmChange.title`), this.$t('general.swal.confirmChange.warning'), {
                    confirmButtonText: this.$t(`general.swal.confirmChange.confirmBtnText`),
                    cancelButtonText: this.$t(`general.swal.confirmChange.cancelBtnText`),
                    type: 'warning'
                }).then(async () => {
                    try {
                        const resp = await this.unassignBuildingManager({
                            building_id: this.model.id,
                            id: manager.id
                        });

                        displaySuccess(resp);

                        this.$refs.propertyManagersList.fetch();

                    } catch (e) {
                        displayError(e);
                    } finally {
                        this.loading.status = false;
                    }
                }).catch(() => {
                    this.loading.status = false;
                })

            },
            tenantEditView(row) {
                this.$router.push({
                    name: 'adminTenantsView',
                    params: {
                        id: row.id
                    }
                });
            },
            managerEditView(row) {
                this.$router.push({
                    name: 'adminPropertyManagersEdit',
                    params: {
                        id: row.id
                    }
                });
            },
            unitEditView(row) {
                 this.$router.push({
                    name: 'adminBuildingUnitsEdit',
                    params: {
                        id: row.id
                    }
                });
            },
            requestEditView(request) {
                this.$router.push({
                    name: 'adminRequestsEdit',
                    params: {
                        id: request.id
                    }
                })
            },
            requestStatusBadge(status) {                
                return this.getRequestStatusColor(status);
            },
            requestStatusLabel(status) {
                return this.$t(`models.request.status.${this.requestStatusConstants[status]}`)
            },
            insertDocument(prop, file) {
                file.order = this.model.media.length + 1;
                this.uploadBuildingFile({
                    id: this.model.id,
                    [`${prop}_upload`]: file.src
                }).then((resp) => {
                    displaySuccess(resp);
                    this.model.media.push(resp.media);
                }).catch((err) => {
                    displayError(err);
                });
            },
            deleteDocument(prop, index) {
                this.deleteBuildingFile({
                    id: this.model.id,
                    media_id: this.model[prop][index].id
                }).then((resp) => {
                    displaySuccess(resp);
                    this.model[prop].splice(index, 1);
                    this.setOrder(prop);
                }).catch((error) => {
                    displayError(error);
                })
            },
            tenantStatusBadge(status) {
                const classObject = {
                    1: 'icon-success',
                    2: 'icon-danger'
                };

                return classObject[status];
            },
            tenantStatusLabel(status) {
                return this.$t(`models.tenant.status.${this.tenantStatusConstants[status]}`)
            },
            setOrder() {
                _.each(this.model.media, (file, i) => {
                    file.order = i + 1;
                });
                this.$forceUpdate();
            },
            sortFiles() {
                this.setOrder();
            },
            uploadFiles(file) {
                this.insertDocument(this.selectedFileCategory, file);
            },
            removeService(service) {
                this.deleteBuildingService({
                    building_id: this.$route.params.id,
                    id: service.id
                }).then((resp) => {
                    this.model.service_providers = this.model.service_providers.filter((provider) => {
                        return provider.id !== service.id;
                    });
                    displaySuccess(resp);
                }).catch((error) => {
                    displayError(error);
                });
            },

            async assignManagers() {
                if (!this.toAssign || !this.model.id) {
                    return false;
                }
                try {
                    const resp = await this.batchAssignUsersToBuilding({
                        id: this.model.id,
                        managersIds: this.toAssign
                    });                    
                    displaySuccess(resp);
                    this.resetToAssignList();
                    this.$refs.propertyManagersList.fetch();
                } catch (e) {
                    displayError(e);
                    this.resetToAssignList();
                }
            },

            async remoteSearchManagers(search) {
                if (search === '') {
                    this.resetToAssignList();
                } else {
                    this.remoteLoading = true;

                    try {
                        const resp = await this.getPropertyManagers({
                            get_all: true,
                            search
                        });

                        this.toAssignList = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            resetToAssignList() {
                this.toAssignList = [];
                this.toAssign = [];
            },
            async batchDeleteBuilding() {
                try {              
                    const resp = await this.checkUnitRequestWidthIds({ids:[this.model.id]});                    
                    this.delBuildingStatus = resp.data;

                    if(this.delBuildingStatus == -1) {
                        this.$confirm(this.$t('general.swal.delete.text'), this.$t('general.swal.delete.title'), {
                            type: 'warning'
                        }).then(() => {
                            this.deleteBuilding({id:this.model.id})
                                .then(r => {
                                    displaySuccess(r);
                                    this.goToListing();
                                })
                                .catch(err => displayError(err));                            
                        }).catch(() => {
                        });
                    }else {
                        this.deleteBuildingVisible = true;
                    }
                } catch(err) {
                    displayError(err);
                } finally {                    
                }
            },     
            async deleteSelectedBuilding(isUnits, isRequests) {
                try {
                    const resp = await this.deleteBuildingWithIds({
                        ids: [this.model.id],
                        is_units: isUnits,
                        is_requests: isRequests
                    });
                    this.deleteBuildingVisible = false;
                    displaySuccess(resp); 
                    this.goToListing();            
                } catch (err) {
                    displayError(err);
                } finally {
                }
            },
            closeDeleteBuildModal() {
                this.deleteBuildingVisible = false;
            },

            async saveAndClose() {
                try {
                    const resp = await this.submit();
                    if (resp) {
                        this.goToListing();
                    }
                } catch (e) {
                    console.log(e)
                }
            },
            goToListing() {
                return this.$router.push({
                    name: "adminBuildings",
                    query: this.queryParams
                })
            },
            setBuildingName(event ) {
                this.model.name = this.model.street + ' ' + this.model.street_nr;
            }
        },
        mounted() {
            this.$root.$on('changeLanguage', () => this.getStates());
        },
        computed: {
            ...mapGetters('application', {
                constants: 'constants'
            }),
            requestStatusConstants() {
                return this.constants.serviceRequests.status
            },
            tenantStatusConstants() {
                return this.constants.tenants.status
            },
            contactEnableValues() {
                this.fetchRealEstate();
                return [{
                    value: 1,
                    label: `${this.$t('settings.contact_enable.use_global')} (${this.contactUseGlobalAddition})`,
                }, {
                    value: 2,
                    label: this.$t('settings.contact_enable.show'),
                }, {
                    value: 3,
                    label: this.$t('settings.contact_enable.hide'),
                }]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .mt15 {
        margin-top: 15px;
    }

    .buildings-edit {
        .heading {
            margin-bottom: 20px;
        }

        > .el-row > .el-col:last-of-type:not(.custom-column) {
            /*min-width: 448px;*/
            /*max-width: 576px;*/

            :global(.el-card) {
                label {
                    margin-bottom: .5em;
                    display: block;
                }
            }

            > *:not(:last-of-type) {
                margin-bottom: 1em;
            }
        }
    }

    .list-complete-item {
        transition: all 1s;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #eee;

        & > .el-col {
            border-left: 1px solid #eee;
            padding-top: 10px;
            min-height: 50px;
            padding-bottom: 10px;
            display: flex;
            align-items: center;

            &:last-child {
                border-right: 1px solid #eee;
                justify-content: center;
            }
        }

        &:last-child {
            border-bottom: 1px solid #eee;
        }
    }

    .list-complete-enter, .list-complete-leave-active {
        opacity: 0;
    }

    .card-label {
        display: block;
        margin-bottom: 15px;
    }

    .file-name {
        max-width: 75%;
        word-wrap: break-word;
        color: #333;
    }

    .category-select {
        margin-bottom: 30px;
        width: 100%;
    }

    .btn-assign {
        width: 100%;
    }
</style>
