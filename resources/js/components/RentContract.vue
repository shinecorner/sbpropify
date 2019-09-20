<template>
    <card :loading="loading" class="mt15" :header="$t('models.tenant.rent_contract')">
        <el-row :gutter="20">
            <el-col :md="24">
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
                            v-model="model.building_id">                                            
                        <el-option
                                :key="building.id"
                                :label="building.name"
                                :value="building.id"
                                v-for="building in buildings"/>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :md="24">
                <el-form-item :label="$t('models.tenant.unit.name')" prop="unit_id"
                                v-if="model.building_id">
                    <el-select :placeholder="$t('models.tenant.search_unit')" style="display: block"
                                v-model="model.unit_id">
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
        
    </card>
</template>
<script>

export default {
    data(){
        return 
    }
}
</script>