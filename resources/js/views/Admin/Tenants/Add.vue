<template>
    <div class="tenants-add">
        <div class="main-content">
        <heading :title="$t('models.tenant.add')" icon="icon-group" shadow="heavy">
            <add-actions :saveAction="submit" editRoute="adminTenantsEdit" route="adminTenants"/>
        </heading>
        <div class="crud-view">
            <el-form :model="model" ref="form">
                <el-row :gutter="20">
                    <el-col :lg="12" :sm="24">
                        <card :loading="loading" :header="$t('models.tenant.personal_details_card')">
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :rules="validationRules.title"
                                                  :label="$t('general.salutation')"
                                                  prop="title"
                                                  class="label-block">
                                        <el-select placeholder="Select" style="display: block" v-model="model.title">
                                            <el-option
                                                    :key="title"
                                                    :label="$t(`general.salutation_option.${title}`)"
                                                    :value="title"
                                                    v-for="title in titles">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12" v-if="model.title === titles.company">
                                    <el-form-item :label="$t('models.tenant.company')" :rules="validationRules.company"
                                                  prop="company">
                                        <el-input autocomplete="off" type="text" v-model="model.company"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.first_name')" :rules="validationRules.first_name"
                                                  prop="first_name">
                                        <el-input autocomplete="off" type="text" v-model="model.first_name"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.last_name')" :rules="validationRules.last_name"
                                                  prop="last_name">
                                        <el-input autocomplete="off" type="text" v-model="model.last_name"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.birth_date')" :rules="validationRules.birth_date"
                                                  prop="birth_date">
                                        <el-date-picker
                                                format="dd.MM.yyyy"
                                                style="width: 100%;"
                                                type="date"
                                                v-model="model.birth_date"
                                                :picker-options="birthDatePickerOptions"
                                                value-format="yyyy-MM-dd"/>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('general.language')"
                                                  :rules="validationRules.language"
                                                  prop="settings.language"
                                                  class="label-block">
                                        <select-language :active-language.sync="model.settings.language"/>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item class="label-block"
                                                  :label="$t('models.tenant.nation')"
                                                  prop="nation">
                                        <el-select filterable
                                                    clearable
                                                   style="display: block"
                                                   v-model="model.nation">
                                            <el-option :key="country.id"
                                                       :label="country.name"
                                                       :value="country.id"
                                                       v-for="country in countries"></el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </card>
                        <card class="mt15" :loading="loading" :header="$t('models.tenant.contact_info_card')">
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('general.email')" :rules="validationRules.email" prop="email" >
                                        <el-input autocomplete="off" type="email" v-model="model.email"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.mobile_phone')" prop="mobile_phone">
                                        <el-input autocomplete="off" type="text" v-model="model.mobile_phone"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.private_phone')" prop="private_phone">
                                        <el-input autocomplete="off" type="text" v-model="model.private_phone"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.work_phone')" prop="work_phone">
                                        <el-input autocomplete="off"
                                                  type="text"
                                                  v-model="model.work_phone"
                                                  class="dis-autofill"
                                                  readonly
                                                  onfocus="this.removeAttribute('readonly');"
                                        ></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </card>
                    </el-col>
                    <el-col :lg="12" :sm="24">
                        <card :loading="loading" :header="$t('models.tenant.account_info_card')">
                            <!--                            <el-form-item :label="$t('models.user.profile_image')">-->
                            <!--                                <cropper :resize="false" :viewportType="'circle'" @cropped="cropped"/>-->
                            <!--                            </el-form-item>-->

                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('general.password')" :rules="validationRules.password" prop="password">
                                        <el-input autocomplete="off"
                                                  type="password"
                                                  v-model="model.password"
                                                  class="dis-autofill"
                                                  readonly
                                                  onfocus="this.removeAttribute('readonly');"
                                        ></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('general.confirm_password')" :rules="validationRules.password_confirmation"
                                                  prop="password_confirmation">
                                        <el-input autocomplete="off" type="password"
                                                  v-model="model.password_confirmation"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </card>
                        
                        
                        <card class="mt15 rentcontract-box">
                            <template slot="header">
                                
                                {{ $t('models.tenant.rent_contract') }}
                                <el-button style="float:right" type="primary" @click="toggleDrawer" icon="icon-plus" size="mini" round>{{$t('models.request.add_rent_contract')}}</el-button>    
                            
                            </template>
                            
                                <el-table
                                    :data="model.rent_contracts"
                                    style="width: 100%"
                                    class="rentcontract-table"
                                    >
                                    <el-table-column
                                        :label="$t('models.tenant.rentcontract_id')"
                                        prop="id"
                                    >
                                        <template slot-scope="scope">
                                            <span class="clickable" @click="editRentContract(scope.$index)">{{scope.row.id}}</span>
                                        </template>
                                    </el-table-column>
                                    <el-table-column
                                        :label="$t('models.tenant.building.name')"
                                        prop="building.name"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        :label="$t('models.tenant.unit.name')"
                                        prop="unit.name"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        align="right"
                                    >
                                        <template slot-scope="scope">
                                            <el-tooltip
                                                :content="$t('general.actions.edit')"
                                                class="item" effect="light" 
                                                placement="top-end">
                                                    <el-button @click="editRentContract(scope.$index)" icon="ti-pencil" size="mini" type="success"/>
                                            </el-tooltip>
                                            <el-tooltip
                                                :content="$t('general.actions.delete')"
                                                class="item" effect="light" 
                                                placement="top-end">
                                                    <el-button @click="deleteRentContract(scope.$index)" icon="ti-trash" size="mini" type="danger"/>
                                            </el-tooltip>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            
                        </card>
                    </el-col>
                </el-row>
            </el-form>
        </div>
        </div>
        <ui-drawer :visible.sync="visibleDrawer" :z-index="1" direction="right" docked>
            <div class="content" v-if="visibleDrawer">
                <rent-contract-form v-if="editingRentContract" mode="edit" :data="editingRentContract" :tenant_id="model.id" :visible.sync="visibleDrawer" :edit_index="editingRentContractIndex" @update-rent-contract="updateRentContract" :used_units="used_units"/>
                <rent-contract-form v-else mode="add" :tenant_id="model.id" :visible.sync="visibleDrawer" @add-rent-contract="addRentContract" :used_units="used_units"/>
            </div>
        </ui-drawer>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import AdminTenantsMixin from 'mixins/adminTenantsMixin';
    import Cropper from 'components/Cropper';
    import AddActions from 'components/EditViewActions';
    import SelectLanguage from 'components/SelectLanguage';
    import RentContractForm from 'components/RentContractForm';

    export default {
        mixins: [AdminTenantsMixin({
            mode: 'add'
        })],
        components: {
            Heading,
            Card,
            Cropper,
            RentContractForm,
            AddActions,
            SelectLanguage,
        },
        mounted() {
            this.$root.$on('changeLanguage', () => this.getCountries());
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
    .tenants-add {
        overflow: hidden;

        .main-content { 
            overflow-x: hidden;
            overflow-y: scroll;
            height: 100%;
        }

        .heading {
            margin-bottom: 20px;
        }

        

        /deep/ .rentcontract-box.el-card {
            .el-card__header {
                display: block;
            }

            .rentcontract-table {
                .clickable {
                    display: block;
                    width: 100%;
                }
            }
        }

        

        /deep/ .ui-drawer {
            .content {
                height: calc(100% - 32px);
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                padding: 16px;
                overflow-x: hidden;
                overflow-y: auto;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                position: relative;
            }

            .chart-card-header{
                font-size: 16px;
                font-weight: 400;
                padding: 0 20px 16px;
                margin: -4px -10px 10px;
                border-bottom: 1px solid #EBEEF5;

                h3 {
                    font-size: 24px;
                    font-weight: 500;
                }

            }
        }
    }

    .group-name {
        width: 192px;
        text-align: right;
        padding-right: 10px;
        box-sizing: border-box;
        font-size: 16px;
        font-weight: bold;
        color: #6AC06F;
    }

    .mb15 {
        margin-bottom: 15px;
    }

</style>
