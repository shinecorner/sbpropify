<template>
    <div class="districts-edit">
        <heading :title="$t('models.district.edit')" :subtitle="district_format" icon="icon-chat-empty" shadow="heavy">
            <edit-actions :saveAction="submit" :deleteAction="deleteDistrict" route="adminDistricts"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <card :loading="loading">
                    <p class="dividerletter">{{this.$t('models.district.details')}}</p>
                    <el-divider class="column-divider"></el-divider>
                    <el-form :model="model" label-width="192px" ref="form">
                        <el-form-item label="Name" :rules="validationRules.name"
                                    prop="name">
                            <el-input type="text" v-model="model.name"/>
                        </el-form-item>
                    </el-form>
                </card>
            </el-col>
            <el-col :md="12">
                <card :loading="loading">
                    <p class="dividerletter">{{this.$t('models.district.buildings')}}</p>
                    <el-divider class="column-divider"></el-divider>
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
                }]
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
