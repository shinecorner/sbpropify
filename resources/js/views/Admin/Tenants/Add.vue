<template>
    <div class="tenants-add">
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
                        
                        
                        <card class="mt15" :header="$t('models.tenant.rent_contract')">
                            <template  v-if="model.rent_contracts.length">
                                <div v-for="(rent_contract, c_index) in model.rent_contracts"
                                        :key="c_index">

                                    <el-row :gutter="20">
                                        <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.building.name')" class="label-block">
                                                <el-select
                                                        :loading="remoteLoading"
                                                        :placeholder="$t('models.tenant.search_building')"
                                                        :remote-method="data => remoteRentContractdSearchBuildings(data, c_index) "
                                                        :rules="validationRules.building_id"
                                                        @change="searchRentContractUnits(c_index, false)"
                                                        filterable
                                                        remote
                                                        reserve-keyword
                                                        style="width: 100%;"
                                                        v-model="rent_contract.building_id">
                                                    <el-option
                                                            :key="building.id"
                                                            :label="building.name"
                                                            :value="building.id"
                                                            v-for="building in rent_contract.buildings"/>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.unit.name')"
                                                        v-if="rent_contract.building_id" class="label-block">
                                                <el-select :placeholder="$t('models.tenant.search_unit')" 
                                                        style="display: block"
                                                        v-model="rent_contract.unit_id"
                                                        @change="changeRentContractUnit(c_index)">
                                                    <el-option
                                                            :key="unit.id"
                                                            :label="unit.name"
                                                            :value="unit.id"
                                                            v-for="unit in rent_contract.units">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                    <el-row :gutter="20" v-if="rent_contract.unit_id">
                                        <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.rent_type')"
                                                        class="label-block">
                                                <el-select placeholder="Select" style="display: block" 
                                                            v-model="rent_contract.type">
                                                    <el-option
                                                            :key="type.value"
                                                            :label="type.name"
                                                            :value="type.value"
                                                            v-for="type in rent_types">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.rent_duration')"
                                                        class="label-block">
                                                <el-select placeholder="Select" style="display: block" 
                                                            v-model="rent_contract.duration">
                                                    <el-option
                                                            :key="type.value"
                                                            :label="type.name"
                                                            :value="type.value"
                                                            v-for="type in rent_durations">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                    <el-row :gutter="20" v-if="rent_contract.unit_id">
                                        <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.rent_start')"
                                                    prop="rent_start">
                                                <el-date-picker
                                                        :picker-options="{disabledDate: disabledRentStart}"
                                                        :placeholder="$t('models.tenant.rent_start')"
                                                        format="dd.MM.yyyy"
                                                        style="width: 100%;"
                                                        type="date"
                                                        v-model="rent_contract.start_date"
                                                        value-format="yyyy-MM-dd"
                                                        @focus="selectRentContract(c_index)"/>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="12" v-if="rent_contract.duration == 2">
                                            <el-form-item :label="$t('models.tenant.rent_end')">
                                                <el-date-picker
                                                    :picker-options="{disabledDate: disabledRentEnd}"
                                                    :placeholder="$t('models.tenant.rent_end')"
                                                    format="dd.MM.yyyy"
                                                    style="width: 100%;"
                                                    type="date"
                                                    v-model="rent_contract.end_date"
                                                    value-format="yyyy-MM-dd"
                                                    @focus="selectRentContract(c_index)"/>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :gutter="20" v-if="rent_contract.unit_id">
                                        <el-col :md="24">
                                            <el-form-item :label="$t('models.tenant.rent_contract_pdf')">

                                            <el-table
                                                :data="rent_contract.media"
                                                style="width: 100%"
                                                v-if="rent_contract.media.length"
                                                >
                                                <el-table-column
                                                    :label="$t('models.rent_contract.filename')"
                                                    prop="name"
                                                >
                                                </el-table-column>
                                                <el-table-column
                                                    align="right"
                                                >
                                                    <template slot-scope="scope">
                                                        <el-tooltip
                                                            :content="$t('general.actions.delete')"
                                                            class="item" effect="light" 
                                                            placement="top-end">
                                                                <el-button @click="deletePDFfromRentContract(c_index, scope.$index)" icon="ti-trash" size="mini" type="danger"/>
                                                        </el-tooltip>
                                                    </template>
                                                </el-table-column>
                                            </el-table>
                                            <upload-rent-contract :rentContractIndex="c_index" @fileUploaded="addPDFtoRentContract" class="drag-custom" drag multiple/>
                                            </el-form-item>
                                        </el-col>
                                    
                                    </el-row>
                                    <el-row :gutter="20" v-if="rent_contract.unit_id">
                                    <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.deposit_amount')"
                                                            prop="deposit_amount">
                                                <el-input type="text"
                                                        v-model="rent_contract.deposit_amount"
                                                        class="dis-autofill"
                                                        @focus="selectRentContract(c_index)"
                                                ></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="12">
                                            <el-form-item :label="$t('models.tenant.type_of_deposit')"
                                                        class="label-block">
                                                <el-select placeholder="Select" style="display: block" 
                                                            v-model="rent_contract.deposit_type"
                                                            @focus="selectRentContract(c_index)">
                                                    <el-option
                                                            :key="type.value"
                                                            :label="type.name"
                                                            :value="type.value"
                                                            v-for="type in deposit_types">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                    
                                    <el-row :gutter="20" v-if="rent_contract.unit_id && rent_contract.type != 3">
                                        <el-col :md="8">
                                            <el-form-item :label="$t('models.tenant.net_rent')" class="label-block">
                                                <el-input type="text"
                                                        v-model="rent_contract.monthly_rent_net" @focus="selectRentContract(c_index)"
                                                ></el-input>
                                            </el-form-item>
                                        </el-col>
                                        
                                        <el-col :md="8">
                                            <el-form-item :label="$t('models.tenant.maintenance')"
                                                        class="label-block">
                                                <el-input type="text"
                                                        v-model="rent_contract.monthly_maintenance" @focus="selectRentContract(c_index)"
                                                ></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="8">
                                            <el-form-item :label="$t('models.tenant.gross_rent')"
                                                        class="label-block">
                                                {{Number(rent_contract.monthly_rent_net) + Number(rent_contract.monthly_maintenance)}}
                                            </el-form-item>
                                        </el-col>
                                    </el-row>

                                    <el-row :gutter="20" v-if="rent_contract.unit_id && rent_contract.type == 3">
                                        <el-col :md="8">
                                            <el-form-item :label="$t('models.tenant.parking_price')" class="label-block">
                                                <el-input type="text"
                                                        v-model="rent_contract.parking_price" @focus="selectRentContract(c_index)"
                                                ></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                    <ui-divider></ui-divider>
                                    <div class="contract-actions">
                                        <el-button type="primary" v-if="c_index == model.rent_contracts.length - 1" @click="addRentContract" icon="icon-plus" size="mini" round>{{$t('models.request.add_contract')}}</el-button>
                                        <el-button type="danger" @click="deleteRentContract(c_index)" icon="icon-minus" size="mini" round>{{$t('models.request.delete_contract')}}</el-button>
                                    </div>
                                </div>
                            </template>
                            
                        </card>
                    </el-col>
                </el-row>
            </el-form>
        </div>

    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import AdminTenantsMixin from 'mixins/adminTenantsMixin';
    import Cropper from 'components/Cropper';
    import UploadRentContract from 'components/UploadRentContract';
    import AddActions from 'components/EditViewActions';
    import SelectLanguage from 'components/SelectLanguage';


    export default {
        mixins: [AdminTenantsMixin({
            mode: 'add'
        })],
        components: {
            Heading,
            Card,
            Cropper,
            UploadRentContract,
            AddActions,
            SelectLanguage,
        },
        mounted() {
            this.$root.$on('changeLanguage', () => this.getCountries());
        },
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
        .heading {
            margin-bottom: 20px;
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

    .contract-actions {
        text-align: right;
    }
</style>
