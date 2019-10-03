<template>
    <el-form :model="model" :rules="validationRules" label-position="top"  ref="form" v-loading="loading">
        <el-row :gutter="20">
            <h3 class="chart-card-header">
                <i class="icon-handshake-o ti-user icon "/>
                    &nbsp;{{ $t('models.tenant.rent_contract') }}
            </h3>
        </el-row>

        <el-row :gutter="20">
            <el-col :md="12">
                <el-form-item prop="building_id" :label="$t('models.tenant.building.name')" class="label-block">
                    <el-select
                            :loading="remoteLoading"
                            :placeholder="$t('models.tenant.search_building')"
                            :remote-method="remoteRentContractdSearchBuildings"
                            @change="searchRentContractUnits()"
                            filterable
                            remote
                            reserve-keyword
                            style="width: 100%;"
                            v-model="model.building_id">
                        <el-option
                                :key="building.id"
                                :label="building.name"
                                :value="building.id"
                                v-for="building in buildings"/>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :md="12">
                <el-form-item prop="unit_id" :label="$t('models.tenant.unit.name')"
                            class="label-block">
                    <el-select :placeholder="$t('models.tenant.search_unit')" 
                            style="display: block"
                            v-model="model.unit_id"
                            @change="changeRentContractUnit">
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
                <el-form-item :label="$t('models.tenant.rent_type')"
                            class="label-block">
                    <!-- <el-select placeholder="Select" style="display: block" 
                                v-model="model.type">
                        <el-option
                                :key="type.value"
                                :label="type.name"
                                :value="type.value"
                                v-for="type in rent_types">
                        </el-option>
                    </el-select> -->
                    <el-select :placeholder="$t('models.unit.type.label')"
                                v-model="model.type">
                        <el-option
                                :key="key"
                                :label="$t('models.unit.type.' + value )"
                                :value="+key"
                                v-for="(value, key) in $constants.units.type">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.rent_duration')"
                            class="label-block">
                    <el-select placeholder="Select" style="display: block" 
                                v-model="model.duration">
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
        <el-row :gutter="20" >
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.rent_start')"
                        prop="rent_start">
                    <el-date-picker
                            :picker-options="{disabledDate: disabledRentStart}"
                            :placeholder="$t('models.tenant.rent_start')"
                            format="dd.MM.yyyy"
                            style="width: 100%;"
                            type="date"
                            v-model="model.start_date"
                            value-format="yyyy-MM-dd"/>
                </el-form-item>
            </el-col>
            <el-col :md="12" >
                <el-form-item :label="$t('models.tenant.rent_end')">
                    <el-date-picker
                        :picker-options="{disabledDate: disabledRentEnd}"
                        :placeholder="$t('models.tenant.rent_end')"
                        format="dd.MM.yyyy"
                        style="width: 100%;"
                        type="date"
                        v-model="model.end_date"
                        value-format="yyyy-MM-dd"/>
                </el-form-item>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.rentcontract_id')"
                                class="label-block">
                    <el-input
                        v-model="model.id"
                        :disabled="true">
                    </el-input>
                </el-form-item>
            </el-col>
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.status.label')" class="label-block">
                    <el-select placeholder="Select" style="display: block" 
                                v-model="model.status">
                        <el-option
                                :key="status.value"
                                :label="status.name"
                                :value="status.value"
                                v-for="status in rentcontract_statuses">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>
        <ui-divider></ui-divider>
        <el-row :gutter="20" >
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.deposit_amount')"
                                prop="deposit_amount">
                    <el-input type="text"
                            v-model="model.deposit_amount"
                            class="dis-autofill"
                    ></el-input>
                </el-form-item>
            </el-col>
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.type_of_deposit')"
                            class="label-block">
                    <el-select placeholder="Select" style="display: block" 
                                v-model="model.deposit_type">
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
        <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition rent-data" 
                style="width: 100%;"
                v-if=" model.type != 3">
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header">
                    <thead>
                        <tr>
                            <th class="data is-leaf">
                                <div class="cell">Monthly rent</div>
                            </th>
                            <th class="symbol is-leaf">
                                <div class="cell"></div>
                            </th>
                            <th class="data is-leaf">
                                <div class="cell">Maintenance</div>
                            </th>
                            <th class="symbol is-leaf">
                                <div class="cell"></div>
                            </th>
                            <th class="data is-leaf">
                                <div class="cell">Gross rent</div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body">
                    <tbody>
                        <tr>
                            <td class="data">
                                <div class="cell">
                                    <el-input type="text"
                                            v-model="model.monthly_rent_net"
                                    ></el-input>
                                </div>
                            </td>
                            <td class="symbol">
                                <div class="cell">
                                    <i class="icon-plus"></i>
                                </div>
                            </td>
                            <td class="data">
                                <div class="cell">
                                    <el-input type="text"
                                        v-model="model.monthly_maintenance"
                                ></el-input>
                                </div>
                            </td>
                            <td class="symbol">
                                <div class="cell">
                                    <i class="icon-eq"></i>
                                </div>
                            </td>
                            <td class="data">
                                <div class="cell">
                                    {{Number(model.monthly_rent_net) + Number(model.monthly_maintenance)}}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <el-row :gutter="20" v-if="model.type == 3">
            <el-col :md="8">
                <el-form-item :label="$t('general.monthly_rent_net')" class="label-block">
                    <el-input type="text"
                            v-model="model.monthly_rent_net"
                    ></el-input>
                </el-form-item>
            </el-col>
        </el-row>
        <!-- <el-row :gutter="20">
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.deposit_status.label')"
                                class="label-block">
                    <el-radio-group v-model="model.deposit_status">
                        <el-radio-button 
                            :key="status.value" 
                            :label="status.value" 
                            v-for="status in deposit_statuses"
                        >
                            {{status.name}}
                        </el-radio-button>
                    </el-radio-group>
                </el-form-item>
            </el-col>
        </el-row> -->

        <ui-divider></ui-divider>
        <el-row :gutter="20" >
            <el-col :md="24">
                <el-form-item :label="$t('models.tenant.rent_contract_pdf')">

                <el-table
                    :data="model.media"
                    style="width: 100%"
                    v-if="model.media.length"
                    class="rentcontract-file-table"
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
                                    <el-button @click="deletePDFfromRentContract(scope.$index)" icon="ti-trash" size="mini" type="danger"/>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>

                <el-alert
                    :title="$t('models.request.pdf_only_desc')"
                    type="info"
                    show-icon
                    :closable="false"
                >
                </el-alert>

                <upload-rent-contract @fileUploaded="addPDFtoRentContract" class="upload-custom" acceptType=".pdf" drag multiple/>
                
                </el-form-item>
            </el-col>
        
        </el-row>
        
        <ui-divider></ui-divider>
        <div class="rentcontract-actions">
            <el-button type="primary" @click="submit" icon="ti-save" round>{{$t('general.actions.save')}}</el-button>
        </div>
        

        

    </el-form>
</template>

<script>
    import {displayError} from "../helpers/messages";
    import UploadRentContract from 'components/UploadRentContract';
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: "RentContractForm",
        components: {
            UploadRentContract,
        },
        props: {
            mode: {
                type: String
            },
            tenant_id: {
                type: Number
            },
            data: {
                type: Object
            },
            visible: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                remoteLoading: false,
                buildings: [],
                units: [],
                rent_types: [],
                rent_durations: [],
                deposit_statuses: [],
                rentcontract_statuses: [],
                deposit_types: [],
                loading: false,
                model: {
                    type: '',
                    duration: '',
                    start_date: '',
                    end_date: '',
                    deposit_amount: '',
                    deposit_type: '',
                    monthly_rent_net: '',
                    monthly_maintenance: '',
                    status: 1,
                    deposit_status: 1,
                    monthly_rent_gross: '',
                    unit_id: '',
                    building_id: '',
                    media: [],
                    buildings: [],
                    units: [],
                },
                validationRules: {
                    building_id: [{
                        required: true,
                        message: this.$t('models.tenant.validation.building.required')
                    }],
                    unit_id: [{
                        required: true,
                        message: this.$t('models.tenant.validation.unit.required')
                    }],
                }
            }
        },
        methods: {
            submit () {
                
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        this.loading = true;
                        const {...params} = this.model

                        console.log('params', params)

                        console.log('tenant_id', this.tenant_id)
                        if(this.tenant_id == undefined || this.tenant_id == 0) 
                        {
                            this.$emit('add-rent-contract', params)
                            this.$emit('update:visible', false);
                        }
                        else {
                            
                            
                            params.tenant_id = this.tenant_id

                            const resp = await this.$store.dispatch('rentContracts/create', params);
                        
                        }

                        this.loading = false
                        this.$refs.form.resetFields()
                        this.$emit('update:visible', false);
                        
                    }
                })
            },
            disabledRentStart(date) {
                const d = new Date(date).getTime();
                const rentEnd = new Date(this.model.end_date).getTime();
                return d >= rentEnd;
            },
            disabledRentEnd(date) {
                const d = new Date(date).getTime();
                const rentStart = new Date(this.model.start_date).getTime();
                return d <= rentStart;
            },
            rentContractUploaded(file) {
                this.uploadMediaFile({
                    id: this.model.id,
                    media: file.src
                }).then(r => {                    
                    displaySuccess(r);

                    this.model.media.push(r.data);
                }).catch(err => {
                    displayError(err);
                });
            },
            async remoteRentContractdSearchBuildings(search) {
                if (search === '') {
                    this.buildings = [];
                } else {
                    this.remoteLoading = true;

                    try {
                        const resp = await this.getBuildings({get_all: true, search});
                        this.buildings = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            async searchRentContractUnits() {

                this.model.unit_id = '';
                try {
                    const resp = await this.getUnits({
                        get_all: true,
                        building_id: this.model.building_id
                    });

                    
                    // this.model.rent_contracts.forEach((rent_contract, cc_index) => {
                    //     resp.data = resp.data.filter( item => item.id != rent_contract.unit_id )
                    // })

                    this.units = resp.data

                } catch (err) {
                    displayError(err);
                } finally {
                    this.remoteLoading = false;
                }
            },
            changeRentContractUnit() {
                let unit = this.units.find(item => item.id == this.model.unit_id)
                this.model.monthly_rent_net = unit.monthly_rent_net
                this.model.monthly_maintenance = unit.monthly_maintenance
                this.model.monthly_rent_gross = unit.monthly_rent_gross
            },
            deleteRentContract( c_index ) {
                //this.model.rent_contracts.splice(c_index, 1)
            },
            addPDFtoRentContract(file) {
                //console.log('file', file)
                let toUploadRentContractFile = file.src
                //let toUploadRentContractFile = {...file, url: URL.createObjectURL(file.raw)};
                this.model.media.push(toUploadRentContractFile)
            },
            deletePDFfromRentContract(index) {
                this.model.media.splice(index, 1)
            },
            ...mapActions(['getBuildings', 'getUnits']),
        },
        async created () {

            if(this.mode == "edit") {
                this.model = this.data

                if(this.model.building) {
                    await this.remoteRentContractdSearchBuildings(this.model.building.name)
                }

                if (this.model.unit) {

                    await this.searchRentContractUnits()
                    this.model.unit_id = this.model.unit.id
                }
            }
            this.rent_types = Object.entries(this.$constants.rentContracts.type).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_types.${label}`)}))
            this.deposit_types = Object.entries(this.$constants.rentContracts.deposit_type).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.deposit_types.${label}`)}))
            this.rent_durations = Object.entries(this.$constants.rentContracts.duration).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_durations.${label}`)}))
            this.deposit_statuses = Object.entries(this.$constants.rentContracts.deposit_status).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.deposit_status.${label}`)}));
            this.rentcontract_statuses = Object.entries(this.$constants.rentContracts.status).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_status.${label}`)}));

            console.log('model', this.model)
        }
    }
</script>

<style lang="scss" scoped>
    /deep/ .rent-data {
        table {
            width: 100%;

            thead, tbody {
                width: 100%;

                tr {
                    display: flex;
                    width: 100%;

                    .data {
                        flex: 1;
                        display: flex;
                        align-items: center;

                        .cell {
                            width: 100%;
                        }
                    }
                    
                    .symbol {
                        display: flex;
                        align-items: center;
                        width: 30px;

                        .cell {
                            text-overflow: initial;
                        }
                    }
                }
            }
        }
    }

    .el-alert {
        margin-bottom: 10px;
    }

    /deep/ .rentcontract-actions {
        width: 100%;
        button {
            width: 100%;
            i {
                padding-right: 5px;
            }
        }
    }

    /deep/ .rentcontract-file-table {
        margin-bottom: 10px;
    }
</style>
