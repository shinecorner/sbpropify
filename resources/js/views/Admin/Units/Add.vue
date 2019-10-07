<template>
    <div class="units-add">
        <heading :title="$t('models.unit.add')" icon="icon-unit" style="margin-bottom: 20px;" shadow="heavy">
            <add-actions :saveAction="submit" route="adminUnits" editRoute="adminUnitsEdit"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col :md="12">
                <card :loading="loading" :header="$t('general.actions.view')">                    
                    <el-form :model="model" label-position="top" label-width="192px" ref="form">
                        <el-row class="last-form-row" :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('models.unit.building')" 
                                        :rules="validationRules.building_id" 
                                        prop="building_id">
                                    <el-select
                                        :loading="remoteLoading"
                                        :placeholder="$t('general.placeholders.search')"
                                        :remote-method="remoteSearchBuildings"
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
                                <el-form-item :label="$t('models.unit.assigned_tenant')" 
                                            :rules="validationRules.tenant_id"
                                            prop="tenant_id">
                                    <el-select
                                        :loading="remoteLoading"
                                        :placeholder="$t('general.placeholders.search')"
                                        :remote-method="remoteSearchTenants"
                                        filterable
                                        remote
                                        clearable
                                        reserve-keyword
                                        style="width: 100%;"
                                        v-model="model.tenant_id">
                                        <el-option
                                            :key="tenant.id"
                                            :label="tenant.name"
                                            :value="tenant.id"
                                            v-for="tenant in toAssignList"/>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row class="last-form-row" :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('models.unit.name')" :rules="validationRules.name" prop="name">
                                    <el-input autocomplete="off" type="text" v-model="model.name"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('models.unit.type.label')" :rules="validationRules.type" prop="type">
                                    <el-select :placeholder="$t('models.unit.type.label')" class="w100p" style="width: 100%;"
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
                        </el-row>
                        <el-row class="last-form-row" :gutter="20">
                            <el-col :md="12" v-if="model.type === 1">
                                <el-form-item :label="$t('models.unit.room_no')" :rules="validationRules.room_no" prop="room_no"
                                            >
                                    <el-select :placeholder="$t('general.placeholders.select')" class="w100p" style="width: 100%;"
                                            v-model="model.room_no">
                                        <el-option :key="room.value"
                                                :label="room.label"
                                                :value="room.value"
                                                v-for="room in rooms"/>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12" v-if="model.type >= 3">
                                <el-form-item :label="$t('general.monthly_rent_net')" :rules="validationRules.monthly_rent_net"
                                            prop="monthly_rent_net">
                                    <el-input autocomplete="off" step="0.01" type="number"
                                            v-model="model.monthly_rent_net"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="24" v-if="model.type < 3">
                                <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition rent-data" 
                                        style="width: 100%;">
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
                                                            <el-form-item 
                                                                :rules="validationRules.monthly_rent_net"
                                                                prop="monthly_rent_net">
                                                                <el-input type="text"
                                                                        v-model="model.monthly_rent_net"
                                                                >
                                                                    <template slot="prepend">CHF</template>
                                                                </el-input>
                                                            </el-form-item>
                                                        </div>
                                                    </td>
                                                    <td class="symbol">
                                                        <div class="cell">
                                                            +
                                                        </div>
                                                    </td>
                                                    <td class="data">
                                                        <div class="cell">
                                                            <el-form-item 
                                                                :rules="validationRules.monthly_maintenance"
                                                                prop="monthly_maintenance">
                                                                <el-input type="text"
                                                                        v-model="model.monthly_maintenance"
                                                                >
                                                                    <template slot="prepend">CHF</template>
                                                                </el-input>
                                                            </el-form-item>
                                                        </div>
                                                    </td>
                                                    <td class="symbol">
                                                        <div class="cell">
                                                            =
                                                        </div>
                                                    </td>
                                                    <td class="data">
                                                        <div class="cell">
                                                            <el-form-item 
                                                                prop="monthly_rent_net">
                                                                {{Number(model.monthly_rent_net) + Number(model.monthly_maintenance)}}
                                                            </el-form-item>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                        <el-row class="last-form-row" :gutter="20">
                            <el-col :md="8">
                                <el-form-item :label="$t('models.unit.floor')" :rules="validationRules.floor" prop="floor">
                                    <el-input autocomplete="off" type="number" v-model="model.floor"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="8">
                                <el-form-item :label="$t('models.unit.sq_meter')" prop="sq_meter">
                                    <el-input autocomplete="off" type="number" v-model="model.sq_meter"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="8">
                                <el-form-item :label="$t('models.unit.attic')" :rules="validationRules.attic" class="switch-wrapper">
                                    <el-switch v-model="model.attic">
                                    </el-switch>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import UnitsMixin from 'mixins/adminUnitsMixin';
    import AddActions from 'components/EditViewActions';

    export default {
        mixins: [UnitsMixin({
            mode: 'add'
        })],
        components: {
            Heading,
            Card,
            AddActions
        }
    }
</script>
