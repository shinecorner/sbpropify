import {mapActions, mapState} from 'vuex';
import {displaySuccess, displayError} from 'helpers/messages';

// TODO make a common mixin for pinboard and products mixins(media upload at least)
export default {
    name: 'ForgotPassword',
    data() {
        return {
            validationRules: {
                email: [
                    {
                        required: true,
                        message: this.$t("general.email_validation.required")
                    },
                    {
                        type: 'email',
                        message: this.$t("general.email_validation.email")
                    }
                ],
            },
            resetPassword: {
                email: ''
            },
            loading: false
        }
    },
    props: {
     
    },
    methods: {
        ...mapActions(["sendForgotPassword"]),
        submitResetPasswordForm() {
            this.$refs.resetPasswordEmailForm.validate((valid) => {
                if (!valid) {
                    return false;
                }

                this.loading = true;
                this.sendForgotPassword(this.resetPassword).then((resp) => {
                    this.loading = false;
                    this.$refs.resetPasswordEmailForm.resetFields();
                    displaySuccess(resp);
                }).catch((err) => {
                    this.loading = false;
                    displayError(err);
                });
            });
        }
    },

};
