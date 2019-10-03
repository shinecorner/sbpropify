import {mapActions, mapGetters} from 'vuex';
import PasswordValidatorMixin from './passwordValidatorMixin';
import EmailCheckValidatorMixin from './emailCheckValidatorMixin';
import TenantTitleTypes from './methods/tenantTitleTypes';
import {displayError, displaySuccess} from '../helpers/messages';
import UploadUserAvatarMixin from './adminUploadUserAvatarMixin';
import { parse } from 'querystring';

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
                remoteLoading: false,
                buildings: [],
                units: [],
                rent_types: [],
                rent_durations: [],
                deposit_statuses: [],
                rentcontract_statuses: [],
                deposit_types: [],
                user: {},
                unit: {},
                birthDatePickerOptions: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    },
                },
                model: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    birth_date: '',
                    mobile_phone: '',
                    private_phone: '',
                    work_phone: '',
                    title: '',
                    company: '',
                    settings: {
                        language: '',
                    },
                    nation: '',
                    rent_contracts: [],
                },
                visibleDrawer: false,
                rent_contract: {
                    type: '',
                    duration: '',
                    start_date: '',
                    end_date: '',
                    deposit_amount: '',
                    deposit_type: '',
                    monthly_rent_net: '',
                    monthly_maintenance: '',
                    status: 1,
                    deposit_status: 1,
                    monthly_rent_gross: '',
                    parking_price: 0,
                    unit_id: '',
                    building_id: '',
                    media: [],
                    buildings: [],
                    units: [],
                },
                validationRules: {
                    first_name: [{
                        required: true,
                        message: this.$t('models.tenant.validation.first_name.required')
                    }],
                    last_name: [{
                        required: true,
                        message: this.$t('models.tenant.validation.last_name.required')
                    }],
                    language: [{
                        required: true,
                        message: this.$t('models.tenant.validation.language.required')
                    }],
                    email: [{
                        required: true,
                        message: this.$t("general.email_validation.required")
                    }, {
                        type: 'email',
                        message: this.$t("general.email_validation.email")
                    },{
                        validator: this.checkavailabilityEmail
                    }],
                    password: [{
                        validator: this.validatePassword
                    }, {
                        min: 6,
                        message: this.$t("general.password_validation.min")
                    }],
                    password_confirmation: [{
                        validator: this.validateConfirmPassword,
                    }],
                    birth_date: [{
                        required: true,
                        message: this.$t('models.tenant.validation.birth_date.required')
                    }],
                    title: [{
                        required: true,
                        message: this.$t('models.tenant.validation.title.required')
                    }]
                },
                loading: {
                    state: false,
                    text: 'general.please_wait'
                },
                avatar: ''
            };
        },
        methods: {
            isFileImage (file) {
                const ext = file.name.split('.').pop()

                return ['jpg', 'jpeg', 'gif', 'bmp', 'png'].includes(ext);
            },
            isFilePDF (file) {
                debugger;
                const ext = file.name.split('.').pop()
                return ['.pdf'].includes(ext);
            },
            editRentContract(index) {
                this.editingRentContract = this.model.rent_contracts[index];
                console.log('editing', this.editingRentContract)
                this.visibleDrawer = true;
            },
            deleteRentContract(index) {

            },
            toggleDrawer() {
                this.visibleDrawer = true;
            },
            ...mapActions(['getBuildings', 'getUnits', 'getCountries', 'uploadMediaFile']),
        },
        async mounted() {
            await this.getCountries();

            this.rent_types = Object.entries(this.$constants.rentContracts.type).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_types.${label}`)}))
            this.deposit_types = Object.entries(this.$constants.rentContracts.deposit_type).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.deposit_types.${label}`)}))
            this.rent_durations = Object.entries(this.$constants.rentContracts.duration).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_durations.${label}`)}))
            this.deposit_statuses = Object.entries(this.$constants.rentContracts.deposit_status).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.deposit_status.${label}`)}));
            this.rentcontract_statuses = Object.entries(this.$constants.rentContracts.status).map(([value, label]) => ({value: +value, name: this.$t(`models.tenant.rent_status.${label}`)}));

        },
        computed: {
            form() {
                return this.$refs.form;
            },
            ...mapGetters(['countries'])
        }
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.mixins = [PasswordValidatorMixin(), EmailCheckValidatorMixin(), TenantTitleTypes, UploadUserAvatarMixin];

                mixin.methods = {
                    async rentContractUpl(id) {
                        return await this.uploadMediaFile({
                            id,
                            media: this.toUploadRentContract.src
                        }).then(r => {
                            displaySuccess(r.data);
                        }).catch(err => {
                            displayError(err);
                        });
                    },
                    submit(afterValid = false) {
                        this.form.validate(async valid => {
                            if (!valid) {
                                return false;
                            }

                            this.loading.state = true;
                            
                            this.model.rent_contracts.forEach(rent_contract => {
                                rent_contract.monthly_rent_gross = Number(rent_contract.monthly_rent_net) + Number(rent_contract.monthly_maintenance)
                            })

                            let {email, password, password_confirmation, ...tenant} = this.model;

                            try {

                                const resp = await this.createTenant({
                                    user: {
                                        email,
                                        password,
                                        password_confirmation: password_confirmation
                                    },
                                    ...tenant
                                });

                                if (resp.data.user && resp.data.user.id) {
                                    this.uploadAvatarIfNeeded(resp.data.user.id);
                                }

                                
                                displaySuccess(resp);

                                this.model.rent_start = '';
                                this.form.resetFields();
                                if (!!afterValid) {
                                    afterValid(resp);
                                } else {
                                    this.$router.push({
                                        name: 'adminTenantsEdit',
                                        params: {id: resp.data.id}
                                    })
                                }
                            } catch (err) {
                                displayError(err);
                            } finally {
                                this.loading.state = false;
                            }
                        });
                    },

                    ...mixin.methods,
                    ...mapActions(['createTenant'])
                };

                break;
            case 'edit':
                mixin.mixins = [PasswordValidatorMixin({required: false}), EmailCheckValidatorMixin(), TenantTitleTypes, UploadUserAvatarMixin];

                mixin.methods = {
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.form.validate(async valid => {
                                if (!valid) {
                                    resolve(false);
                                    return false;
                                }
                                this.loading.state = true;
                                let {password_confirmation, ...params} = this.model;

                                if (params.password === '') {
                                    params = _.omit(params, ['password'])
                                }

                                try {
                                    const resp = await this.updateTenant(params);

                                    if (resp.data.user && resp.data.user.id) {
                                        this.uploadAvatarIfNeeded(resp.data.user.id);
                                    }

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
                    ...mapActions(['getTenant', 'updateTenant'])
                };

            case 'view':
                mixin.mixins = [PasswordValidatorMixin({required: false}), EmailCheckValidatorMixin(), TenantTitleTypes, UploadUserAvatarMixin];
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['getTenant'])
                }

                mixin.computed = {
                    ...mixin.computed
                };

                mixin.created = async function () {
                    const {password, password_confirmation} = this.validationRules;

                    [...password, ...password_confirmation].forEach(rule => rule.required = false);

                    try {
                        this.loading.state = true;

                        const {address, building, unit, user, ...r} = await this.getTenant({id: this.$route.params.id});
                        this.user = user;
                        this.model = Object.assign({}, this.model, r);
                        this.original_email = this.user.email;
                        this.model.email = user.email;
                        this.model.avatar = user.avatar;
                        this.model.nation = +this.model.nation

                    } catch (err) {
                        this.$router.replace({
                            name: 'adminTenants'
                        });

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