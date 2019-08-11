<template>
    <el-row :gutter="20">
        <el-col :lg="6">
            <el-select @change="resetToAssignList"
                        class="custom-select"
                        :value="assignmentType" @input="$emit('update:assignmentType', $event)"
            >
                <el-option
                    :key="type"
                    :label="type"
                    :value="type"
                    v-for="(type) in assignmentTypes">
                </el-option>
            </el-select>
        </el-col>
        <el-col :lg="12" :xl="14">
            <el-select
                :loading="remoteLoading"
                :placeholder="$t('models.request.placeholders.search')"
                :remote-method="remoteSearch"
                class="custom-remote-select"
                filterable
                remote
                reserve-keyword
                style="width: 100%;"
                :value="toAssign" @input="$emit('update:toAssign', $event)"
            >
                <div class="custom-prefix-wrapper" slot="prefix">
                    <i class="el-icon-search custom-icon"></i>
                </div>
                <el-option
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                    v-for="item in toAssignList"/>
            </el-select>
        </el-col>
        <el-col :lg="6" :xl="4">
            <el-button :disabled="!toAssign" @click="assign" class="full-button"
                        icon="ti-save" type="primary">
                {{$t('models.request.assign')}}
            </el-button>
        </el-col>
    </el-row>
</template>
<script>
    export default {
        props: {
            resetToAssignList: { 
                type: Function 
            },
            assignmentType: {
                required: true
            },
            assignmentTypes: {
                type: Array
            },
            toAssign: {
                required: true
            },
            assign: { 
                type: Function 
            },
            toAssignList: {
                type: Array
            },
            remoteLoading: {
                type: Boolean
            },
            remoteSearch: {
                type: Function 
            }
        },
        created() {
            this.resetToAssignList();
            this.assign();
            this.remoteSearch();
        }
    }
</script>
