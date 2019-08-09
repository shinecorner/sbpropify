<template>
    <div class="districts-edit">
        <heading :title="$t('models.district.add')" icon="icon-share" shadow="heavy">
            <add-actions :saveAction="submit" route="adminDistricts" editRoute="adminDistrictsEdit"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <card :loading="loading">
                    <el-divider class="column-divider" content-position="left">
                        {{this.$t('models.district.details')}}
                    </el-divider>
                    <el-form :model="model" label-width="192px" ref="form">
                        <el-form-item label="Name" :rules="validationRules.name"
                                    prop="name">
                            <el-input type="text" v-model="model.name"/>
                        </el-form-item>
                    </el-form>
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
    import AddActions from 'components/EditViewActions';


    export default {
        name: 'AdminDistrictsEdit',
        mixins: [DistrictsMixin({
            mode: 'add'
        })],
        components: {
            Heading,
            Card,
            AddActions
        }
    };
</script>

<style lang="scss" scoped>
    .districts-edit {
        .crud-view {
            margin-top: 1%;
        }
    }
</style>


