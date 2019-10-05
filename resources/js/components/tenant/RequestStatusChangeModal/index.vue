<template>
    <el-dialog  :close-on-click-modal="true" 
                :title="statusChangeModalType=='done' ? $t(`general.swal.to_done.title`) : $t(`general.swal.reactivate.title`)"
                :visible="statusChangeModalVisible"
                width="40%"
                class="request-status-change-modal"
                @close="closeModal()"
                :modalAppendToBody="false">
        <el-form ref="form" :model="model" label-position="top" :rules="validationRules">
            <el-row>
                <el-col :span="24" v-if="statusChangeModalType=='done'">
                    <p class="description">{{ $t(`general.swal.to_done.desc`) }}</p>
                    <br/>
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
                <el-button v-if="statusChangeModalType=='done'" :disabled="model.message == null || model.message == ''" @click="changeStatus(statusChangeModalType, model.message)" size="mini" type="primary">{{statusChangeModalType=='done' ? $t('tenant.close_request') : $t('tenant.actions.to_reactivated')}}</el-button>
                <el-button v-else @click="changeStatus(statusChangeModalType, model.message)" size="mini" type="primary">{{statusChangeModalType=='done' ? $t('tenant.close_request') : $t('tenant.actions.to_reactivated')}}</el-button>
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
                        message: this.$t('validation.required',{attribute: this.$t('tenant.message')})
                    }               
                },
            }
        },
        methods: {
            close() {
                console.log('close called')
                this.model.message = null;
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

        .el-row:last-child {
            margin-bottom: 0;
        }

        .description {
            margin: 0;
        }

        .el-dialog__header {
            border-bottom: 1px solid lightgrey;
        }

        .el-dialog__body {
            word-break: break-word;
            padding-bottom: 0;
        }
    }
</style>
