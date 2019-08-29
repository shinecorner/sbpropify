<template>
    <div class="districts-edit">
        <heading :title="$t('models.district.edit')" icon="icon-chat-empty" shadow="heavy">
            <template slot="description" v-if="model.district_format">
                <div class="subtitle">{{`${model.district_format} > ${model.name}`}}</div>
            </template>
            <edit-actions :saveAction="submit" :deleteAction="deleteDistrict" route="adminDistricts"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <card :loading="loading" :header="$t('general.actions.view')">
                    <el-form :model="model" ref="form">
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item label="Name" :rules="validationRules.name"
                                              prop="name">
                                    <el-input type="text" v-model="model.name"/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item class="label-block" :label="$t('models.district.count_of_buildings')"
                                              prop="title">
                                    <el-select style="display: block" v-model="model.count_of_buildings">
                                        <el-option
                                                :key="building"
                                                :value="building"
                                                v-for="building in buildingsCount">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </card>

                <card :loading="loading" :header="$t('general.requests')" class="mt15">

                    <relation-list
                            :actions="requestActions"
                            :columns="requestColumns"
                            :filterValue="model.id"
                            fetchAction="getRequests"
                            filter="district_id"
                            v-if="model.id"
                    />
                </card>
            </el-col>
            <el-col :md="12">
                <card :loading="loading" :header="$t('models.district.buildings')">
                    <relation-list
                        :actions="districtActions"
                        :columns="districtColumns"
                        :filterValue="model.id"
                        fetchAction="getBuildings"
                        filter="district_id"
                        v-if="model.id"
                    />
                </card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import DistrictsMixin from 'mixins/adminDistrictsMixin';
    import {displayError} from "helpers/messages";
    import EditActions from 'components/EditViewActions';
    import {mapActions} from 'vuex';
    import RelationList from 'components/RelationListing';

    export default {
        name: 'AdminRequestsEdit',
        mixins: [DistrictsMixin({
            mode: 'edit',
            withRelation: true
        })],
        components: {
            Heading,
            Card,
            EditActions,
            RelationList
        },
        data() {
            return {
                requestColumns: [{
                    type: 'requestTenantAvatar',
                    width: 75,
                    prop: 'tenant',
                    label: this.$t('general.tenant')
                }, {
                    type: 'requestTitleWithDesc',
                    label: this.$t('models.request.prop_title')
                }, {
                    type: 'requestStatus',
                    label: this.$t('models.request.status.label')
                }],
                requestActions: [{
                    width: '90px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: this.$t('general.actions.edit'),
                        onClick: this.requestEditView
                    }]
                }],
                districtColumns: [{
                    prop: 'name',
                    label: this.$t('general.name')
                }, {
                    align: 'center',
                    prop: 'units_count',
                    label: this.$t('dashboard.buildings.total_units')
                }, {
                    type: 'buildingTenantAvatars',
                    align: 'center',
                    prop: 'tenants',
                    propLimit: 2,
                    count: 'tenants_count',
                    label: this.$t('general.tenants')
                }],
                districtActions: [{
                    width: '90px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: this.$t('general.actions.edit'),
                        onClick: this.buildingEditView
                    }]
                }],
                buildingsCount: 20,
            }
        },
        methods: {
            ...mapActions(['deleteDistrict']),

            requestEditView(row) {
                this.$router.push({
                    name: 'adminRequestsEdit',
                    params: {
                        id: row.id
                    }
                })
            },

            buildingEditView(row) {
                this.$router.push({
                    name: 'adminBuildingsEdit',
                    params: {
                        id: row.id
                    }
                })
            },
        }
    }
</script>

<style lang="scss">
    .label-block .el-form-item__label {
        display: block;
        float: none;
        text-align: left;
    }
</style>
<style lang="scss" scoped>
    .districts-edit {
        .crud-view {
            margin-top: 1%;
        }
    }
</style>
