<template>
    <div class="quarters-edit">
        <heading :title="$t('models.quarter.add')" icon="icon-share" shadow="heavy">
            <add-actions :saveAction="submit" route="adminQuarters" editRoute="adminQuartersEdit"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <card :loading="loading" :header="$t('general.actions.view')">
                    <el-form :model="model" label-width="192px" ref="form">
                        <el-form-item :label="$t('tenant.name')" :rules="validationRules.name"
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
    import QuartersMixin from 'mixins/adminQuartersMixin';
    import {displayError} from "helpers/messages";
    import AddActions from 'components/EditViewActions';


    export default {
        name: 'AdminQuartersEdit',
        mixins: [QuartersMixin({
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
    .quarters-edit {
        .crud-view {
            margin-top: 1%;
        }
    }
</style>


