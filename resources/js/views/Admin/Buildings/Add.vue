<template>
    <div class="buildings-add ">
        <heading :title="$t('models.building.add')" icon="icon-commerical-building" shadow="heavy">
            <add-actions :saveAction="submit" route="adminBuildings" editRoute="adminBuildingsEdit"/>
        </heading>
        <div class="crud-view">
            <card :loading="loading">
                <el-form :model="model" label-position="right" label-width="192px" ref="form">
                    <el-form-item :label="$t('models.address.street')" :rules="validationRules.street" prop="street"
                                  style="max-width: 512px;">
                        <el-input type="text" v-model="model.street" v-on:change="setBuildingName"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('models.address.house_num')" :rules="validationRules.house_num"
                                  prop="house_num" style="max-width: 512px;">
                        <el-input type="text" v-model="model.house_num" v-on:change="setBuildingName"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('general.name')" :rules="validationRules.name" prop="name"
                                  style="max-width: 512px;" ref="name">
                        <el-input type="text" v-model="model.name"></el-input>
                    </el-form-item>
                    <!--<el-form-item prop="description" :label="$t('general.description')" :rules="validationRules.description" style="max-width: 512px;">-->
                    <!--<el-input type="textarea" v-model="model.description"></el-input>-->
                    <!--</el-form-item>-->
                    <el-form-item :label="$t('models.building.floor_nr')" :rules="validationRules.floor_nr" prop="floor_nr"
                                  style="max-width: 512px;">
                        <el-input type="number" v-model="model.floor_nr"></el-input>
                    </el-form-item>
                    <el-form-item :label="`${ordinalSuffixFloor(item)} ${$t('models.unit.floor')}`"
                                  :rules="validationRules.floor"
                                  :prop="'floor.'+ item"
                                  style="max-width: 512px;"
                                  :key="item"
                                  v-for="item in floors">
                        <el-input type="number" v-model.number="model.floor[item]"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('models.unit.attic')" :rules="validationRules.attic" class="switch-wrapper">
                        <el-switch v-model="model.attic">
                        </el-switch>
                    </el-form-item>
                    <el-form-item :label="$t('general.zip')" :rules="validationRules.zip" prop="zip"
                                  style="max-width: 512px;">
                        <el-input type="text" v-model="model.zip"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('general.city')" :rules="validationRules.city" prop="city"
                                  style="max-width: 512px;">
                        <el-input type="text" v-model="model.city"></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('models.address.state.label')" :rules="validationRules.state_id"
                                  prop="state_id" style="max-width: 512px;">
                        <el-select :placeholder="$t('models.address.state.label')" style="display: block"
                                   v-model="model.state_id">
                            <el-option :key="state.id" :label="state.name" :value="state.id"
                                       v-for="state in states"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="$t('models.building.quarter')" prop="quarter_id" style="max-width: 512px;">
                        <el-select
                            :loading="remoteLoading"
                            :placeholder="$t('general.placeholders.search')"
                            :remote-method="remoteSearchQuarters"
                            filterable
                            remote
                            reserve-keyword
                            style="width: 100%;"
                            v-model="model.quarter_id">
                            <el-option
                                :key="quarter.id"
                                :label="quarter.name"
                                :value="quarter.id"
                                v-for="quarter in quarters"/>
                        </el-select>
                    </el-form-item>
                </el-form>
            </card>
        </div>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import BuildingsMixin from 'mixins/adminBuildingsMixin';
    import AddActions from 'components/EditViewActions';

    export default {
        mixins: [BuildingsMixin({
            mode: 'add'
        })],
        components: {
            Heading,
            Card,
            AddActions
        },
        methods: {
            setBuildingName() {
                this.model.name = this.model.street + ' ' + this.model.house_num;
            },
            ordinalSuffixFloor(i) {
                let j = +i % 10,
                    k = +i % 100;
                if (+i === 0) {
                    return 'Base'
                }
                if (j === 1 && k !== 11) {
                    return i + "st";
                }
                if (j === 2 && k !== 12) {
                    return i + "nd";
                }
                if (j === 3 && k !== 13) {
                    return i + "rd";
                }
                return i + "th";
            },
        },
        mounted() {
            this.$root.$on('changeLanguage', () => this.getStates());
        },
        computed: {
            floors() {
                let arr = [];

                for (let i = 0; i < this.model.floor_nr; i++) {
                    arr.push(i);
                }

                if (this.model.floor_nr !== '' ) {
                    this.model.floor = this.model.floor.splice(0, this.model.floor_nr);
                }

                return arr;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .buildings-add {
        .heading {
            margin-bottom: 20px;
        }
    }
</style>
