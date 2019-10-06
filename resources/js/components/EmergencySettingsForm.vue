<template>
    <el-form :model="model" :rules="validationRules" label-position="top"  ref="form" v-loading="loading">
        

        <el-row :gutter="20">
            <el-col :md="24">
                <el-form-item class="switcher">
                    <label class="switcher__label">
                        Activate Emergency Box
                        <span class="switcher__desc">{{$t('models.request.public_desc')}}</span>
                    </label>
                    <el-switch v-model="model.activate_emergency"/>
                </el-form-item>
            </el-col>
        </el-row>
        <el-row>
            <el-col :md="24">
                <el-form-item prop="phone_number" label="Phone Number"
                            class="label-block">
                    <el-input v-model="model.phone_number"></el-input>                    
                </el-form-item>
            </el-col>
        </el-row>

        <el-row>
            <el-col :md="24">
                <el-form-item prop="phone_number" label="Time Schedule"
                            class="label-block">
                    <el-input v-model="model.time_schedule"></el-input>                    
                </el-form-item>
            </el-col>
        </el-row>
        
        <ui-divider></ui-divider>
        <div class="drawer-actions">
            <el-button type="primary" @click="submit" icon="ti-save" round>{{$t('general.actions.save')}}</el-button>
        </div>
        

        

    </el-form>
</template>

<script>
    import {displayError} from "../helpers/messages";
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: "RentContractForm",
        props: {
            data: {
                type: Object
            },
            visible: {
                type: Boolean,
                default: false
            },
        },
        data () {
            return {
                remoteLoading: false,
                loading: false,
                model: {
                    phone_number: '',
                    activate_emergency: false,
                    time_schedule: ''
                },
                validationRules: {
                    phone_number: [{
                        required: true,
                        message: this.$t('models.tenant.validation.building.required')
                    }],
                }
            }
        },
        methods: {
            submit () {
                
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        this.loading = true;  
                        
                    }
                })
            },
            
        },
        async created () {

        }
    }
</script>

<style lang="scss" scoped>

    /deep/ .ui-divider {
        margin: 32px 16px 16px 0;
        
        i {
            padding-right: 0;
        }

        .ui-divider__content {
            left: 0;
            z-index: 1;
            padding-left: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--color-primary);
        }
    }
    .el-form-item {
        margin-bottom: 0;

        &.is-error {
            margin-bottom: 10px;
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

    /deep/ .drawer-actions {
        width: 100%;
        button {
            width: 100%;
            i {
                padding-right: 5px;
            }
        }
    }


    
</style>
