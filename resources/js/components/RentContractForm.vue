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
            <el-col :md="12" v-if="model.building_id">
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
                            prop="type"
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
                            prop="duration"
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
                        prop="start_date">
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
            <el-col :md="12" v-if="model.duration == 2">
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
                <el-form-item :label="$t('models.tenant.status.label')" prop="status" class="label-block">
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
                    ></el-input>
                </el-form-item>
            </el-col>
            <el-col :md="12">
                <el-form-item :label="$t('models.tenant.type_of_deposit')"
                            prop="deposit_type">
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
                v-if=" model.type < 3">
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header">
                    <thead>
                        <tr>
                            <th class="data is-leaf">
                                <div class="cell">{{$t('general.monthly_rent_net')}}</div>
                            </th>
                            <th class="symbol is-leaf">
                                <div class="cell"></div>
                            </th>
                            <th class="data is-leaf">
                                <div class="cell">{{$t('models.tenant.maintenance')}}</div>
                            </th>
                            <th class="symbol is-leaf">
                                <div class="cell"></div>
                            </th>
                            <th class="data is-leaf">
                                <div class="cell">{{$t('models.tenant.gross_rent')}}</div>
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
                                    >
                                        <template slot="prepend">CHF</template>
                                    </el-input>
                                </div>
                            </td>
                            <td class="symbol">
                                <div class="cell">
                                    +
                                </div>
                            </td>
                            <td class="data">
                                <div class="cell">
                                    <el-input type="text"
                                        v-model="model.monthly_maintenance"
                                    >
                                        <template slot="prepend">CHF</template>
                                    </el-input>
                                </div>
                            </td>
                            <td class="symbol">
                                <div class="cell">
                                    =
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
        <el-row :gutter="20" v-if="model.type >= 3">
            <el-col :md="8">
                <el-form-item :label="$t('general.monthly_rent_net')" class="label-block">
                    <el-input type="text"
                            v-model="model.monthly_rent_net"
                    >
                        <template slot="prepend">CHF</template>
                    </el-input>
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
            edit_index: {
                type: Number
            },
            visible: {
                type: Boolean,
                default: false
            },
            used_units: {
                type: Array
            }
        },
        data () {
            return {
                remoteLoading: false,
                buildings: [],
                units: [],
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
                    deposit_amount: [{
                        required: true,
                        message: this.$t('models.tenant.validation.deposit_amount.required')
                    }],
                    deposit_type: [{
                        required: true,
                        message: this.$t('models.tenant.validation.deposit_type.required')
                    }],
                    start_date: [{
                        required: true,
                        message: this.$t('models.tenant.validation.start_date.required')
                    }],
                    type: [{
                        required: true,
                        message: this.$t('models.tenant.validation.rent_type.required')
                    }],
                    duration: [{
                        required: true,
                        message: this.$t('models.tenant.validation.rent_duration.required')
                    }],
                    status: [{
                        required: true,
                        message: this.$t('models.tenant.validation.status.required')
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

                        if (this.tenant_id == undefined || this.tenant_id == 0) 
                        {
                            params.unit = this.units.find(item => item.id == this.model.unit_id)
                            params.building = this.buildings.find(item => item.id == this.model.building_id)
                            if (this.mode == "add") {
                                this.$emit('add-rent-contract', params)
                            }
                            else {
                                this.$emit('update-rent-contract', this.edit_index, params)
                            }
                            
                        }
                        else {
                            
                            params.tenant_id = this.tenant_id

                            if (this.mode == "add") {
                                const resp = await this.$store.dispatch('rentContracts/create', params);
                                this.$emit('add-rent-contract', params)
                            }
                            else {
                                const resp = await this.$store.dispatch('rentContracts/update', params);
                                this.$emit('update-rent-contract', this.edit_index, params)
                            }
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


                    this.used_units.forEach(id => {
                        resp.data = resp.data.filter( item => item.id != id )
                    })

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
                this.model.type = unit.type
                this.model.duration = 1
            },
            addPDFtoRentContract(file) {
                //let toUploadRentContractFile = {...file, url: URL.createObjectURL(file.raw)}
                let toUploadRentContractFile = {media : file.src, name: file.raw.name}
                this.model.media.push(toUploadRentContractFile)
            },
            deletePDFfromRentContract(index) {
                this.model.media.splice(index, 1)
            },
            ...mapActions(['getBuildings', 'getUnits']),
        },
        async created () {

            this.deposit_types = Object.entries(this.$constants.rentContracts.deposit_type).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.deposit_types.${label}`)}))
            this.rent_durations = Object.entries(this.$constants.rentContracts.duration).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_durations.${label}`)}))
            this.deposit_statuses = Object.entries(this.$constants.rentContracts.deposit_status).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.deposit_status.${label}`)}));
            this.rentcontract_statuses = Object.entries(this.$constants.rentContracts.status).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_status.${label}`)}));

            if(this.mode == "edit") {
                this.model = this.data

                if(this.model.building) {
                    await this.remoteRentContractdSearchBuildings(this.model.building.name)
                    await this.searchRentContractUnits()
                }

                if (this.model.unit) {
                    this.model.unit_id = this.model.unit.id
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-form-item {
        margin-bottom: 0;
    }
    /deep/ .rent-data {
        table {
            width: 100%;
            cursor: initial;

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
                            text-align: left;
                            
                            /deep/ .el-input.el-input-group {
                                .el-input-group__prepend {
                                    padding: 2px 8px 0;
                                    font-weight: 600;
                                }
                                .el-input__inner {
                                    padding: 5px;
                                }
                            }
                        }
                    }
                    
                    .symbol {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 20px;

                        .cell {
                            text-overflow: initial;
                            font-size: 16px;
                            padding: 0;
                        }
                    }
                }
            }
        }
        .el-table tbody tr td:last-child .cell {
            padding-left: 10px !important;
        }
    }

    /deep/ .el-input.el-input-group {
        .el-input-group__prepend {
            padding: 2px 8px 0;
            font-weight: 600;
        }
        
    }
    
    .el-alert {
        line-height: 19px;
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
