<template>
    <div>
        <el-form :model="model" ref="form">
            <el-form-item prop="email" :label="$t('general.email')" :rules="validationRules.email">
                <el-input type="email" v-model="model.email" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item prop="act_code" :label="$t('general.activate_code')" :rules="validationRules.act_code">
                <el-input type="text" v-model="model.act_code" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item prop="password" :label="$t('general.password')" :rules="validationRules.password">
                <el-input autocomplete="off" type="password" v-model="model.password"></el-input>
            </el-form-item>
            <el-form-item prop="password_confirmation" :label="$t('general.confirm_password')" :rules="validationRules.password_confirmation">
                <el-input autocomplete="off" type="password"
                            v-model="model.password_confirmation"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" class="text-center w100p" @click="submit">{{$t('general.activate')}}</el-button>
            </el-form-item>
        </el-form>
        <router-link :to="{name: 'login2'}" class="el-menu-item-link">
            <el-button type="primary" class="text-center w100p">{{this.$t("general.back")}}</el-button>
        </router-link>
    </div>
</template>
<script>
    import {mapActions, mapState} from 'vuex';
    import {displaySuccess, displayError} from 'helpers/messages';
    import axios from '@/axios';
    import PasswordValidatorMixin from '../../mixins/passwordValidatorMixin';

    export default {
        mixins: ['PasswordValidatorMixin'],
        data() {
            return {
                model: {
                    email: '',
                    act_code: '',
                    password: '',
                    password_confirmation: ''
                },
                validationRules: {
                    email: [{
                        required: true,
                        message: this.$t("general.email_validation.required")
                    }, {
                        type: 'email',
                        message: this.$t("general.email_validation.email")
                    }],
                    act_code: [{
                        required: true,
                        message: this.$t("general.activate_code_required")
                    }],
                    password: [{
                        required: true,
                        message: this.$t("general.password_validation.required")
                    }, {
                        validator: this.validatePassword,
                    }],
                    password_confirmation: [{
                        required: true,
                        message: this.$t("general.password_validation.required")
                    },{
                        validator: this.validateConfirmPassword,
                    }]
                }
            }
        },
        computed: {
            ...mapState({
                loggedInUser: ({users}) => {
                    return users.loggedInUser;
                }
            })
        },
        mounted() {
            this.model.act_code = this.$route.query.code;
        },
        methods: {
            submit() {
                
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        try {
                            resp = await axios.post(`tenants/activateTenant?activation_token=` + this.model.act_code + 
                                `&email=` + this.model.email + `&password=` + this.model.password);
                            
                            displaySuccess(rest);
                        } catch (err) {
                            displayError(err);
                        }
                    }
                });
            },
            validatePassword(rule, value, callback) {
                let validateObject = this.model;

                if (value === '' && validateObject.password_confirmation) {
                    callback(new Error($t("general.password_validation.required")))
                } else {
                    this.$refs.form.validateField('password_confirmation');
                    callback();
                }

            },
            validateConfirmPassword(rule, value, callback) {
                let validateObject = this.model;

                if (value && !validateObject.password) {
                    this.$refs.form.validateField('password');
                } else if (value !== validateObject.password) {
                    callback(new Error($t("general.password_validation.match")));
                } else {
                    callback();
                }
            }
        },
    }
</script>
<style lang="scss" scoped>
    .el-form-item {
        &:nth-last-child(2), :nth-last-child() :global(.el-form-item__content) {
            display: flex;
            align-items: center;
            :global(.el-checkbox) {
                flex: 1;
                margin: 0;
            }
        }
        .el-button {
            width: 100%;
        }
    }
    .el-menu-item-link {
        .el-button {
            width: 100%;
        }
    }
</style>
