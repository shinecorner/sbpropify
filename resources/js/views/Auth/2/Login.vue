<template>
    <div class='login2-container'>
        <div class="form-header">
            <h3>{{ $t('general.login') }}</h3>
            <p>{{ $t('auth.login_welcome') }}</p>
        </div>
        <el-form :model="model" ref="form">
            <el-form-item prop="email" :label="$t('general.email')" :rules="validationRules.email">
                <el-input
                    type="email" 
                    v-model="model.email" 
                    autocomplete="off"
                    prefix-icon="el-icon-user"
                    :placeholder="$t('general.email')"
                ></el-input>
            </el-form-item>
            <el-form-item prop="password" :label="$t('general.password')" :rules="validationRules.password">
                <el-input
                    type="password" 
                    v-model="model.password" 
                    autocomplete="off"
                    prefix-icon="el-icon-lock"
                    :placeholder="$t('general.password')"
                ></el-input>
            </el-form-item>
            <el-form-item>
                <el-checkbox>{{$t('general.remember_me')}}</el-checkbox>
                <router-link :to="{name: 'forgot'}">
                    <el-button type="text">
                        {{$t('general.forgot_password')}}
                    </el-button>
                </router-link>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" class="text-center w100p" @click="submit" ref="prev">{{$t('general.login')}}</el-button>
            </el-form-item>
        </el-form>
        <router-link :to="{name: 'activateAccount'}" class="el-menu-item-link">
            <el-button type="primary" class="text-center w100p">{{$t('general.activate_account')}}</el-button>
        </router-link>
    </div>
</template>
<script>
    import {mapActions, mapState} from 'vuex';
    import {displaySuccess, displayError} from 'helpers/messages';

    export default {
        data() {
            return {
                model: {
                    email: '',
                    password: ''
                },
                validationRules: {
                    email: [{
                        required: true,
                        message: this.$t("general.email_validation.required")
                    }, {
                        type: 'email',
                        message: this.$t("general.email_validation.email")
                    }],
                    password: [{
                        required: true,
                        message: this.$t("general.password_validation.required")
                    }]
                }
            }
        },
        props: {
          
        },
        computed: {
            ...mapState({
                loggedInUser: ({users}) => {
                    return users.loggedInUser;
                }
            }),
         
        },
        methods: {
            submit() {
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        try {
                            await this.login(this.model);
                            const {data: {settings: {language}}, ...rest} = await this.me();
                            if(!this.$i18n.locale){
                                this.$i18n.locale = language;
                            }                            
                            this.$router.push({
                                name: 'tenantDashboard'
                            });

                            displaySuccess(rest);
                        } catch (err) {
                            displayError(err);
                        }
                    }
                });
            },

            ...mapActions(['me', 'login']),
        },
      
    }
</script>
<style lang="scss" scoped>
    .form-header {
        h3 {
            font-size: 18.48px;
            font-weight: 500;
            margin-top: 0;
            margin-bottom: 14px;
        }
    }
    .el-form-item {
        &:nth-last-child(2) :global(.el-form-item__content) {
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
        .el-form-item__label {
            color: rgba(0, 0, 0, 0.4);
            line-height: 24px;
            font-size: 0.75rem;
        }
    }
    .el-menu-item-link {
        margin-bottom: 5%;
        width: calc(100% - 6em);
        .el-button {
            width: 100%;
        }
    }
   
</style>
<style lang="scss">
    .login2-container {
        position: relative;
        width: 100%;

        .el-form-item {
            .el-form-item__label {
                color: rgba(0, 0, 0, 0.4);
                line-height: 24px;
                font-size: 0.75rem;
            }
            input {
                padding-left: 42px;
            }
            .el-input__icon {
                color: rgba(0, 0, 0, 0.4);
                padding-left: 2px;
            }
        }
    }
</style>
