export default (config = {}) => {
    const {model = 'model', form = 'form', required = true, nestedModel = ''} = config;
    
    return {
        methods: {
            validatePassword(rule, value, callback) {
                let validateObject = this[model];

                if (nestedModel) {
                    validateObject = this[model][nestedModel];
                }

                if ((value === '' && required) || value === '' && validateObject.password_confirmation) {
                    callback(new Error(this.$t('validation.required', {attribute: this.$t('general.password')})))
                } else {
                    this.$refs[form].validateField('password_confirmation');

                    callback();
                }

            },
            validateConfirmPassword(rule, value, callback) {
                let validateObject = this[model];

                if (nestedModel) {
                    validateObject = this[model][nestedModel];
                }

                if (required && value === '') {
                    callback(new Error(this.$t('validation.required', {attribute: this.$t('general.confirm_password')})));
                } else if (value && !validateObject.password) {
                    this.$refs[form].validateField('password');
                } else if (value !== validateObject.password) {
                    callback(new Error(this.$t('validation.same', {attribute: this.$t('general.password'), other: this.$t('general.confirm_password')})));
                } else {
                    callback();
                }
            }
        }
    };
};