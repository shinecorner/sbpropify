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
                <card :loading="loading" :header="$t('models.district.details')">
                    <el-form :model="model" label-width="192px" ref="form">
                        <el-form-item label="Name" :rules="validationRules.name"
                                    prop="name">
                            <el-input type="text" v-model="model.name"/>
                        </el-form-item>
                    </el-form>
                </card>

                <card :loading="loading" :header="$t('models.propertyManager.requests')" class="mt15">

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
                    label: this.$t('models.request.tenant')
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
                        title: this.$t('models.request.edit'),
                        onClick: this.requestEditView
                    }]
                }],
                districtColumns: [{
                    prop: 'name',
                    label: this.$t('models.propertyManager.name')
                }, {
                    align: 'center',
                    prop: 'units_count',
                    label: this.$t('dashboard.buildings.total_units')
                }, {
                    type: 'buildingTenantAvatars',
                    align: 'center',
                    prop: 'tenants',
                    label: this.$t('models.building.tenants')
                }],
                districtActions: [{
                    width: '90px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: this.$t('models.request.edit'),
                        onClick: this.buildingEditView
                    }]
                }],
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

<style lang="scss" scoped>
    .districts-edit {
        .crud-view {
            margin-top: 1%;
        }
    }
</style>
