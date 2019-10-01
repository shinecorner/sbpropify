import {mapActions, mapState} from 'vuex';
import {displaySuccess, displayError} from 'helpers/messages';
// TODO make a common mixin for pinboard and products mixins(media upload at least)
export default {
    name: 'ForgotPassword',
    data() {
        return {
            validationRules: {
                password: [
                    {
                        validator: this.validatePassword,
                    },
                    {
                        required: true
                    },
                    {
                        min: 6,
                        message: this.$t("general.password_validation.min")
                    }
                ],
                password_confirmation: [
                    {
                        validator: this.validateConfirmPassword,
                    },
                    {
                        required: true
                    }
                ],
            },
            resetPassword: {
                email: '',
                token: '',
                password: '',
                password_confirmation: ''
            },
            loading: false
        }
    },
    props: {
       
    },
    created() {
        const query = this.$route.query;

        if (_.isEmpty(query)) {
            this.$router.push({name: 'login'});
        }

        Object.assign(this.resetPassword, query);
    },
    methods: {
        ...mapActions(["resetPasswordRequest"]),
        submitResetPasswordForm() {
            this.$refs.resetPasswordForm.validate((valid) => {
                if (valid) {
                    const validator = new AsyncValidator({
                        email: {
                            type: 'email',
                            required: true
                        },
                        token: {
                            required: true
                        }
                    });

                    validator.validate({
                        email: this.resetPassword.email,
                        token: this.resetPassword.token
                    }, (err) => {
                        if (!err) {
                            this.loading = true;
                            this.resetPasswordRequest(this.resetPassword).then((resp) => {
                                this.loading = false;
                                this.$router.push({name: 'login'});
                                displaySuccess(resp);
                            }).catch((err) => {
                                this.loading = false;
                                displayError(err);
                            });
                        } else {
                            _.each(err, (efield) => {
                                let message = '';

                                if (efield.field == "email") {
                                    message = "general.email_validation.email";
                                } else if (efield.field == "token") {
                                    message = "token_invalid";
                                }

                                displayError({
                                    success: false,
                                    message
                                });
                            });
                        }
                    });

                } else {
                    return false;
                }
            });
        },
        validatePassword(rule, value, callback) {
            if (value === '') {
                callback(new Error(this.$t("general.password_validation.required")));
            } else {
                if (this.resetPassword.password_confirmation !== '') {
                    this.$refs.resetPasswordForm.validateField('password_confirmation');
                }
                callback();
            }
        },
        validateConfirmPassword(rule, value, callback) {
            if (value === '') {
                callback(new Error(this.$t('general.password_validation.confirm')));
            } else if (value !== this.resetPassword.password) {
                callback(new Error(this.$t('general.password_validation.match')));
            } else {
                callback();
            }
        },
    },
   
};