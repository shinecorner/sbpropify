<template>
    <el-dialog  :close-on-click-modal="true" 
                :title="$t(`general.swal.to_done.title`)"
                :visible="statusChangeModalVisible"
                width="40%"
                class="request-status-change-modal"
                :modalAppendToBody="false">
        <el-form ref="form" :model="model" label-position="top" :rules="validationRules">
            <el-row>
                <el-col :span="24" v-if="statusChangeModalType=='done'">
                    <p class="description">{{ $t(`general.swal.to_done.desc`) }}</p>
                    <p class="description">{{ $t(`general.swal.to_done.message`) }}</p>
                </el-col>
                <el-col :span="24" v-if="statusChangeModalType=='reactivate'">
                    <p class="description">{{ $t(`general.swal.reactivate.text`) }}</p>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="24">
                    <el-form-item prop="message" required>
                        <el-input type="textarea" :autosize="{ minRows: 3}" v-model="model.message" ></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
            <span class="dialog-footer" slot="footer">
                <el-button @click="close" size="mini">{{$t('tenant.cancel')}}</el-button>
                <el-button :disabled="model.message == null || model.message == ''" @click="changeStatus(statusChangeModalType, model.message)" size="mini" type="danger">{{$t('tenant.close_request')}}</el-button>
            </span>
        
    </el-dialog>
</template>
<script>
    export default {
        name: 'p-request-status-change-modal',
        props: {
            statusChangeModalVisible: {
                type: Boolean,
                required: true
            },
            statusChangeModalType: {
                type: String,
                required: true
            },
            changeStatus: {
                type: Function,
                required: true
            },
            closeModal: {
                type: Function,
                required: true
            }
        },
        data() {
            return {
                model: {
                    message: null
                },
                validationRules: {
                    message: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.title')})
                    }               
                },
            }
        },
        methods: {
            close() {
                this.closeModal();
            }          
        },  
    };
</script>
<style lang="scss">
    .request-status-change-modal {        

        .el-row {
            margin: 0 0 22px 0;
        }

        .description {
            margin: 0;
        }
        .el-dialog__body {
            word-break: break-word;
        }
    }
</style>
