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
                            <template  v-if="contracts.length">
                                <div v-for="(contract, c_index) in contracts"
                                        :key="c_index">

                                <el-row :gutter="20">
                                    <el-col :md="12">
                                         <el-form-item :label="$t('models.tenant.building.name')" prop="building_id">
                                            {{contract.building_id}}
                                         </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.unit.name')" prop="unit_id">
                                            {{contract.unit_id}}
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.rent_type')" prop="rent_type"
                                                    class="label-block">
                                            {{contract.rent_type}}
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.rent_duration')" prop="rent_duration"
                                                    class="label-block">
                                            {{contract.rent_duration}}
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.rent_start')"
                                                prop="rent_start">
                                            {{contract.rent_start}}
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12" v-if="model.contract.rent_duration == 'limited'">
                                        <el-form-item :label="$t('models.tenant.rent_end')"
                                                        prop="rent_end">
                                            {{contract.rent_end}}
                                        </el-form-item>
                                    </el-col>
                                </el-row>   
                                
                                <el-form-item :label="$t('models.tenant.rent_contract_pdf')">
                                    <el-table
                                        :data="contract.media"
                                        style="width: 100%"
                                        v-if="contract.media.length"
                                        >
                                        <el-table-column
                                            :label="$t('models.rent_contract.filename')"
                                            prop="name"
                                        >
                                        </el-table-column>
                                        <!-- <el-table-column
                                            align="right"
                                        >
                                            <template slot-scope="scope">
                                                <el-tooltip
                                                    :content="$t('general.actions.delete')"
                                                    class="item" effect="light" 
                                                    placement="top-end">
                                                        <el-button @click="deletePDFfromContract(c_index, scope.$index)" icon="ti-trash" size="mini" type="danger"/>
                                                </el-tooltip>
                                            </template>
                                        </el-table-column> -->
                                    </el-table>
                                </el-form-item>
                            
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.deposit_amount')"
                                                        prop="deposit_amount">
                                            {{contract.deposit_amount}}
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.type_of_deposit')" prop="deposit_type"
                                                    class="label-block">
                                            {{contract.deposit_type}}
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <ui-divider></ui-divider>
                                <div class="contract-actions">
                                    <el-button @click="deleteContract(contract.id)" type="danger" icon="icon-minus" size="mini" round>{{$t('models.request.delete_contract')}}</el-button>
                                </div>
                                </div>
                            </template>
                            
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.building.name')" prop="building_id">
                                        <el-select
                                                :loading="remoteLoading"
                                                :placeholder="$t('models.tenant.search_building')"
                                                :remote-method="remoteSearchBuildings"
                                                :rules="validationRules.building_id"
                                                @change="searchUnits"
                                                filterable
                                                remote
                                                reserve-keyword
                                                style="width: 100%;"
                                                v-model="model.contract.building_id">
                                            <el-option
                                                    :key="building.id"
                                                    :label="building.name"
                                                    :value="building.id"
                                                    v-for="building in buildings"/>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.unit.name')" prop="unit_id"
                                                  v-if="model.contract.building_id">
                                        <el-select :placeholder="$t('models.tenant.search_unit')" style="display: block"
                                                   v-model="model.contract.unit_id">
                                            <el-option
                                                    :key="unit.id"
                                                    :label="unit.name"
                                                    :value="unit.id"
                                                    v-for="unit in units">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.rent_type')" prop="rent_type"
                                                  class="label-block">
                                        <el-select placeholder="Select" style="display: block" 
                                                    v-model="model.contract.rent_type">
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
                                    <el-form-item :label="$t('models.tenant.rent_duration')" prop="rent_duration"
                                                  class="label-block">
                                        <el-select placeholder="Select" style="display: block" 
                                                    v-model="model.contract.rent_duration">
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
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.rent_start')"
                                              prop="rent_start">
                                        <el-date-picker
                                                :picker-options="{disabledDate: disabledRentStart}"
                                                :placeholder="$t('models.tenant.rent_start')"
                                                format="dd.MM.yyyy"
                                                style="width: 100%;"
                                                type="date"
                                                v-model="model.contract.rent_start"
                                                value-format="yyyy-MM-dd"/>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12" v-if="model.contract.rent_duration == 'limited'">
                                    <el-form-item :label="$t('models.tenant.rent_end')"
                                                    prop="rent_end">
                                        <el-date-picker
                                            :picker-options="{disabledDate: disabledRentEnd}"
                                            :placeholder="$t('models.tenant.rent_end')"
                                            format="dd.MM.yyyy"
                                            style="width: 100%;"
                                            type="date"
                                            v-model="model.contract.rent_end"
                                            value-format="yyyy-MM-dd"/>
                                    </el-form-item>
                                </el-col>
                            </el-row>   
                            
                            <el-form-item :label="$t('models.tenant.rent_contract_pdf')">
                                <!-- <el-row :gutter="20" class="list-complete-item" justify="center"
                                        style="margin-bottom: 1em;"
                                        type="flex"
                                        v-if="!_.isEmpty(toUploadContract)">
                                    <el-col :span="20">
                                        <a :href="toUploadContract.url" target="_blank"><strong>{{
                                            toUploadContract.name }}</strong></a>
                                        <el-image :src="toUploadContract.url"
                                                    v-if="isFileImage(toUploadContract.raw)"/>
                                        <embed :src="toUploadContract.url" v-else/>
                                    </el-col>
                                    <el-col :span="4">
                                        <el-button @click="deleteToUploadContract" icon="ti-trash" size="mini"
                                                    type="danger"/>
                                    </el-col>
                                </el-row> -->
                                <el-table
                                    :data="model.contract.media"
                                    style="width: 100%"
                                    v-if="model.contract.media.length"
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
                                                    <el-button @click="deleteToUploadContract(scope.$index)" icon="ti-trash" size="mini" type="danger"/>
                                            </el-tooltip>
                                        </template>
                                    </el-table-column>
                                </el-table>
                                <upload-document @fileUploaded="contractToUpload" class="drag-custom" drag multiple/>
                                <!-- <ui-media-gallery :files="model.contract.media.map(({url}) => url)" />
                                <ui-media-uploader v-model="model.media" 
                                                :headers="{'Authorization': `Bearer ${authorizationToken}`, 'Accept': 'application/json, text/plain, */*', 'Content-Type': 'application/json;charset=UTF-8'}" 
                                                :action="`api/v1/contracts/${model.contract.id}/media`" 
                                                :id="model.contract.id" 
                                                type="contract"
                                                :options="{drop: true, draggable: true, multiple: true}" /> -->

                            </el-form-item>
                           
                           <el-row :gutter="20">
                               <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.deposit_amount')"
                                                    prop="deposit_amount">
                                         <el-input type="text"
                                                  v-model="model.contract.deposit_amount"
                                                  class="dis-autofill"
                                        ></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.type_of_deposit')" prop="deposit_type"
                                                  class="label-block">
                                        <el-select placeholder="Select" style="display: block" 
                                                    v-model="model.contract.deposit_type">
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
                            <!-- <el-row :gutter="20">
                               <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.net_rent')"
                                                    prop="net_rent">
                                         <el-input type="text"
                                                  v-model="model.contract.net_rent"
                                                  class="dis-autofill"
                                        ></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.tenant.heating_operating_costs_installment')" prop="deposit_type"
                                                  class="label-block">
                                        <el-input type="text"
                                                  v-model="model.contract.heating_operating_costs_installment"
                                                  class="dis-autofill"
                                        ></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row> -->
                            <ui-divider></ui-divider>
                            <div class="contract-actions">
                                <el-button type="primary" @click="addContract" icon="icon-plus" size="mini" round>{{$t('models.request.add_contract')}}</el-button>
                                <!-- <el-button type="danger" icon="icon-minus" size="mini" round>{{$t('models.request.delete_contract')}}</el-button> -->
                            </div>
                            
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
    import UploadDocument from 'components/UploadDocument';
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
            UploadDocument,
            AddActions,
            SelectLanguage,
        },
        data() {
            return {
                toUploadContract: {},
                contractColumns: [{
                    prop: 'filename',
                    label: 'filename'
                }],
                contractActions: [{
                    width: '180px',
                    buttons: [{
                        title: 'general.actions.delete',
                        type: 'primary',
                        onClick: this.unitEditView,
                        tooltipMode: true,
                        icon: 'el-icon-close'
                    }]
                }],
            }
        },
        methods: {
            contractToUpload(file) {
                this.toUploadContract = {...file, url: URL.createObjectURL(file.raw)};
                console.log('new contract media', this.model.contract.media)
                this.model.contract.media.push(this.toUploadContract)
            },
            deleteToUploadContract(index) {
                this.model.contract.media.splice(index, 1)
                console.log('after delete contract media', this.model.contract.media)
                this.toUploadContract = {};
            },
            deletePDFfromContract(contract_index, index) {
                console.log('delete PDF', contract_index, index)
            },
            deleteContract( contract_index ) {

            }
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
