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

<!--                <card :loading="loading" class="mt15">-->
<!--                    <p class="dividerletter">{{$t('models.propertyManager.requests')}}</p>-->
<!--                    <el-divider class="column-divider"></el-divider>-->

<!--                    <relation-list-->
<!--                            :actions="requestActions"-->
<!--                            :columns="requestColumns"-->
<!--                            :statuses="requestStatuses"-->
<!--                            :tenantAvatars="requestTenantAvatars"-->
<!--                            :filterValue="model.id"-->
<!--                            fetchAction="getRequests"-->
<!--                            filter="district_id"-->
<!--                            v-if="model.user"-->
<!--                    />-->
<!--                </card>-->
            </el-col>
            <el-col :md="12">
                <card :loading="loading" :header="$t('models.district.buildings')">
                    <relation-list
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
                districtColumns: [{
                    prop: 'name',
                    label: this.$t('models.propertyManager.name')
                }],
                requestColumns: [{
                    prop: 'category.name',
                    label: this.$t('models.request.prop_title')
                }],
                requestActions: [{
                    width: '90px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: this.$t('models.request.edit'),
                        onClick: this.requestEditView
                    }]
                }],
                requestStatuses: [{
                    prop: 'status',
                    label: this.$t('models.request.status.label')
                }],
                requestTenantAvatars: [{
                    prop: 'avatar',
                    label: this.$t('models.building.tenants')
                }],
            }
        },
        methods: {
            ...mapActions(['deleteDistrict'])
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
