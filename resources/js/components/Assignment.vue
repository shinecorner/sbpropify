<template>
    <el-row :gutter="20" id="assignment">
        <el-col id="search">
            <el-select
                :loading="remoteLoading"
                :placeholder="$t('models.propertyManager.placeholders.search')"
                :remote-method="remoteSearch"
                class="custom-remote-select"
                filterable
                :multiple="multiple"
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
                    :label="`${item.first_name} ${item.last_name}`"
                    :value="item.id"
                    v-for="item in toAssignList"/>
            </el-select>
        </el-col>
        <el-col id="assignBtn" :style="innerBtnWidth">
            <el-button :disabled="!toAssign" @click="assign" type="primary">
                <div id="innerBtn" ref="innerBtn">
                    <i class="ti-save"></i>
                    <span>&nbsp;{{$t('models.unit.assign')}}</span>
                </div>
            </el-button>
        </el-col>
    </el-row>
</template>
<script>
    export default {
        props: {
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
            },
            multiple: {
                type: Boolean
            }
        },
        data() {
            return {
                innerBtnWidth: null,
            }
        },
        computed: {
            BtnWidth() {
                return this.innerBtnWidth;
            }
        },
        methods: {
            getBtnWidth() {
                this.innerBtnWidth = this.$refs.innerBtn.clientWidth;
            }
        },
        mounted() {
            this.getBtnWidth();
        },
        created() {
            this.assign();
            this.remoteSearch();
        }
    }
</script>
<style lang="less" scoped>
    #assignment {
        display: flex;
        #assignBtn {
            flex: 1;
        }
    }
</style>