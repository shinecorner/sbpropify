<template>
    <div class="quarters-edit">
        <heading :title="$t('models.quarter.edit')" icon="icon-chat-empty" shadow="heavy">
            <template slot="description" v-if="model.quarter_format">
                <div class="subtitle">{{`${model.quarter_format} > ${model.name}`}}</div>
            </template>
            <edit-actions :saveAction="submit" :deleteAction="deleteQuarter" route="adminQuarters"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <card :loading="loading" :header="$t('general.actions.view')">
                    <el-form :model="model" ref="form">
                        <el-row class="last-form-row" :gutter="20">
                            <el-col :md="12">
                                <el-form-item label="Name" :rules="validationRules.name"
                                              prop="name">
                                    <el-input type="text" v-model="model.name"/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item class="label-block" :label="$t('models.quarter.count_of_buildings')"
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
                            filter="quarter_id"
                            v-if="model.id"
                    />
                </card>
            </el-col>
            <el-col :md="12">
                <card :loading="loading" :header="$t('models.quarter.buildings')">
                    <relation-list
                        :actions="quarterActions"
                        :columns="quarterColumns"
                        :filterValue="model.id"
                        fetchAction="getBuildings"
                        filter="quarter_id"
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
    import QuartersMixin from 'mixins/adminQuartersMixin';
    import {displayError} from "helpers/messages";
    import EditActions from 'components/EditViewActions';
    import {mapActions} from 'vuex';
    import RelationList from 'components/RelationListing';

    export default {
        name: 'AdminRequestsEdit',
        mixins: [QuartersMixin({
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
                    label: 'general.tenant'
                }, {
                    type: 'requestTitleWithDesc',
                    label: 'models.request.prop_title'
                }, {
                    type: 'requestStatus',
                    width: 100,
                    label: 'models.request.status.label'
                }],
                requestActions: [{
                    width: 100,
                    buttons: [{
                        icon: 'ti-pencil',
                        title: 'general.actions.edit',
                        onClick: this.requestEditView
                    }]
                }],
                quarterColumns: [{
                    prop: 'name',
                    label: 'general.name'
                }, {
                    align: 'center',
                    prop: 'units_count',
                    label: 'dashboard.buildings.total_units'
                }, {
                    type: 'buildingTenantAvatars',
                    align: 'center',
                    prop: 'tenants',
                    propLimit: 2,
                    count: 'tenants_count',
                    label: 'general.tenants'
                }],
                quarterActions: [{
                    width: '90px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: 'general.actions.edit',
                        onClick: this.buildingEditView
                    }]
                }],
                buildingsCount: 20,
            }
        },
        methods: {
            ...mapActions(['deleteQuarter']),

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

    .el-card .el-card__body {
        display: flex;
        flex-direction: column;
    }
</style>
<style lang="scss" scoped>
    .el-tabs--border-card {
        border-radius: 6px;
        .el-tabs__header {
            border-radius: 6px 6px 0 0;
        }
        .el-tabs__nav-wrap.is-top {
            border-radius: 6px 6px 0 0;
        }
    }

    .last-form-row {
        margin-bottom: -22px;
    }

    .quarters-edit {
        .crud-view {
            margin-top: 1%;
        }
    }
</style>