import {mapGetters, mapActions} from 'vuex';
import {displayError, displaySuccess} from 'helpers/messages';
import PasswordValidatorMixin from './passwordValidatorMixin';
import axios from '@/axios';

export default (config = {}) => {
    let mixin = {
        props: {
            title: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                model: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    phone: '',
                    role: '',
                    settings: {
                        language: ''
                    }
                },
                validationRules: {
                    name: [{
                        required: true,
                        message: 'This field is required'
                    }],
                    language: [{
                        required: true,
                        message: 'This field is required'
                    }],
                    email: [{
                        required: true,
                        message: 'This field is required'
                    }, {
                        type: 'email',
                        message: 'This field is required'
                    }, {
                        validator: this.checkavailabilityEmail
                    }],
                    password: [{
                        validator: this.validatePassword
                    }, {
                        required: true,
                        message: 'This field is required'
                    }, {
                        min: 6,
                        message: 'This field must be at least 6 characters'
                    }],
                    password_confirmation: [{
                        validator: this.validateConfirmPassword
                    }, {
                        required: true,
                        message: 'This field is required'
                    }],
                    role: [{
                        required: true,
                        message: 'This field is required'
                    }]
                },
                loading: {
                    state: false,
                    text: 'Please wait...'
                },
                isFormSubmission: false
            };
        },
        computed: {
            ...mapGetters(['allRoles']),

            form() {
                return this.$refs.form;
            },
            queryParams(){
                return {role: this.model.role}
            }            
        },
        methods: {
            async checkavailabilityEmail(rule, value, callback) {
                let validateObject = this.model;

                if(this.isFormSubmission == true)
                    return;
                
                if(config.mode == 'add' || ( this.original_email != null && this.original_email !== validateObject.email)) {
                    try {
                        const resp = await axios.get('users/check-email?email=' + validateObject.email);                
                    } catch(error) {
                        if(error.response.data.success == false) {
                            callback(new Error(error.response.data.message));
                        }
                    }
                }
            },
        }
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.mixins = [PasswordValidatorMixin()];

                mixin.methods = {
                    async submit() {
                        this.isFormSubmission = true;
                        const valid = await this.form.validate();
                        this.isFormSubmission = false;
                        if (!valid) {
                            return false;
                        }
                        this.loading.state = true;

                        try {
                            const resp = await this.createUser(this.model);
                            displaySuccess(resp);

                            this.form.resetFields();
                            return resp;
                        } catch (err) {
                            displayError(err);
                        } finally {
                            this.loading.state = false;
                        }

                    },

                    ...mixin.methods,
                    ...mapActions(['createUser'])
                };
                break;
            case 'edit':
                mixin.mixins = [PasswordValidatorMixin({required: false})];

                mixin.methods = {
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.isFormSubmission = true;
                            this.form.validate(async valid => {

                                if (!valid) {
                                    resolve(false);
                                    return false;
                                }
                                this.isFormSubmission = false;
                                this.loading.state = true;

                                let params = this.model;

                                if (params.password === '') {
                                    params = _.omit(params, ['password', 'password_confirmation'])
                                }

                                try {
                                    const resp = await this.updateUser(params);
                                    displaySuccess(resp);
                                    resolve(true);
                                } catch (err) {
                                    displayError(err);
                                    resolve(false);
                                } finally {
                                    this.loading.state = false;
                                }
                            });
                        });
                    },

                    ...mixin.methods,
                    ...mapActions(['getUser', 'updateUser'])
                };

                mixin.created = async function () {
                    const {password, password_confirmation} = this.validationRules;

                    [...password, ...password_confirmation].forEach(rule => rule.required = false);

                    try {
                        this.loading.state = true;

                        const data = await this.getUser({id: this.$route.params.id});

                        // TODO - do not like this, there is an alternative
                        this.model.id = data.id;
                        this.model.name = data.name;
                        this.model.email = data.email;
                        this.original_email = data.email;
                        this.model.phone = data.phone;
                        this.model.role = data.roles[0].name; // what if returns no roles?
                        this.model.settings = data.settings;
                    } catch (err) {
                        // TODO - probably a better alternative, will do later
                        let route = {
                            name: 'adminUsers',
                            role: {
                                query: {
                                    role: this.$route.query.role
                                }
                            }
                        };

                        if (config.redirectRoute) {
                            route.name = config.redirectRoute;

                            delete route.role;
                        }

                        this.$router.replace(route);

                        displayError(err);
                    } finally {
                        this.loading.state = false;
                    }
                };

                break;
        }
    }


    return mixin;
};
