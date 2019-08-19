import {mapActions} from 'vuex';
import {displayError, displaySuccess} from 'helpers/messages';
import PasswordValidatorMixin from './passwordValidatorMixin';
import UploadUserAvatarMixin from './adminUploadUserAvatarMixin';
import PropertyManagerTitlesMixin from './methods/propertyManagerTitleTypes';
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
                    user: {
                        email: '',
                        password: '',
                        password_confirmation: '',
                        name: '',
                        phone: '',
                    },
                    settings: {
                        language: ''
                    }
                },
                statistics: {
                    raw: [{
                        icon: 'ti-plus',
                        color: '#003171',
                        value: 0,
                        description: this.$t('models.building.requestStatuses.total')
                    },{
                        icon: 'ti-plus',
                        color: '#26A65B',
                        value: 0,
                        description: this.$t('models.building.requestStatuses.solved')
                    },{
                        icon: 'ti-plus',
                        color: '#26A65B',
                        value: 0,
                        description: this.$t('models.building.requestStatuses.pending')
                    },{
                        icon: 'ti-user',
                        color: '#003171',
                        value: 0,
                        description: this.$t('models.building.assigned_buildings')
                    }, ],
                    percentage: {
                        occupied_units: 0,
                        free_units: 0,
                        }
                    },
                validationRules: {
                    first_name: [{
                        required: true,
                        message: 'This field is required'
                    }],
                    last_name: [{
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
                    linkedin_url: [{
                        type: 'url',
                        message: 'This field should be valid url'
                    }],
                    xing_url: [{
                        type: 'url',
                        message: 'This field should be valid url'
                    }],
                    title: [{
                        required: true,
                        message: this.$t('models.tenant.validation.title.required')
                    }]
                },
                loading: {
                    state: false,
                    text: 'Please wait...'
                },
                buildings: [],
                requests: [],
                assignmentTypes: ['building', 'district'],
                assignmentType: 'building',
                toAssign: '',
                toAssignList: [],
                alreadyAssigned: {
                    buildings: [],
                    districts: []
                },
                remoteLoading: false
            };
        },
        computed: {
            form() {
                return this.$refs.form;
            },
        },
        methods: {
            ...mapActions(['getBuildings', 'getDistricts', 'assignBuilding', 'assignDistrict', 'unassignBuilding', 'unassignDistrict']),
            async remoteSearchBuildings(search) {
                if (search === '') {
                    this.resetToAssignList();
                } else {
                    this.remoteLoading = true;

                    try {
                        let resp = [];
                        if (this.assignmentType === 'building') {
                            resp = await this.getBuildings({
                                get_all: true,
                                search,
                            });

                            resp.data = resp.data.filter((building) => {
                                return !this.alreadyAssigned.buildings.includes(building.id)
                            });
                        } else {
                            resp = await this.getDistricts({get_all: true, search});

                            resp.data = resp.data.filter((district) => {
                                return !this.alreadyAssigned.districts.includes(district.id)
                            });
                        }

                        this.toAssignList = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },  
            async checkavailabilityEmail(rule, value, callback) {
                let validateObject = this.model;
                
                if(config.mode == 'add' || ( this.original_email != null && this.original_email !== validateObject.user.email)) {
                    try {
                        const resp = await axios.get('users/check-email?email=' + validateObject.user.email);                
                    } catch(error) {
                        if(error.response.data.success == false) {
                            callback(new Error(error.response.data.message));
                        }
                    }
                }
            },
            resetToAssignList() {
                this.toAssignList = [];
                this.toAssign = '';
            },
            async attachBuilding() {
                if (!this.toAssign || !this.model.id) {
                    return false;
                }
                try {

                    let resp;

                    if (this.assignmentType === 'building') {
                        resp = await this.assignBuilding({
                            id: this.model.id,
                            toAssignId: this.toAssign
                        });
                    } else {
                        resp = await this.assignDistrict({
                            id: this.model.id,
                            toAssignId: this.toAssign
                        });
                    }

                    if (resp && resp.data) {
                        await this.fetchCurrentManager();
                        this.$refs.assignmentsList.fetch();
                        this.toAssign = '';
                        this.toAssignList = [];                        
                        displaySuccess(resp)
                    }
                } catch (e) {
                    if (!e.response.data.success) {
                        displayError(e.response)
                    }
                }

            },
            async unassign(toUnassign) {
                let resp;
                if (toUnassign.aType == 1) {
                    resp = await this.unassignBuilding({
                        id: this.model.id,
                        toAssignId: toUnassign.id
                    })
                } else {
                    resp = await this.unassignDistrict({
                        id: this.model.id,
                        toAssignId: toUnassign.id
                    })
                }

                if (resp) {
                    await this.fetchCurrentManager();
                    this.$refs.assignmentsList.fetch();

                    this.toAssign = '';
                    const type = toUnassign.aType == 1 ? 'Building' : 'District';
                    displaySuccess(resp);
                }
            }
        }
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.mixins = [PasswordValidatorMixin({
                    nestedModel: 'user'
                }), UploadUserAvatarMixin, PropertyManagerTitlesMixin];

                mixin.methods = {
                    async submit() {
                        const valid = await this.form.validate();
                        if (valid) {
                            this.loading.state = true;
                            try {
                                const resp = await this.createPropertyManager(this.model);

                                if (resp.data.user && resp.data.user.id) {
                                    await this.uploadAvatarIfNeeded(resp.data.user.id);
                                }                                  
                                displaySuccess(resp);

                                this.form.resetFields();
                                this.model.buildings = [];
                                return resp;
                            } catch (err) {
                                displayError(err);
                            } finally {
                                this.loading.state = false;
                            }
                        }
                    },

                    ...mixin.methods,
                    ...mapActions(['createPropertyManager'])
                };
                break;
            case 'edit':
                mixin.mixins = [PasswordValidatorMixin({
                    required: false,
                    nestedModel: 'user'
                }), UploadUserAvatarMixin, PropertyManagerTitlesMixin];

                mixin.methods = {
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.form.validate(async valid => {
                                if (!valid) {
                                    resolve(false);
                                    return
                                }
                                this.loading.state = true;
                                let {...params} = this.model;

                                if (params.password === '') {
                                    params = _.omit(params, ['password', 'password_confirmation'])
                                }

                                try {
                                    params.buildings = params.building_ids;
                                    this.model.building_ids = params.building_ids;
                                    const resp = await this.updatePropertyManager(params);

                                    if (resp.data.user && resp.data.user.id) {
                                        await this.uploadAvatarIfNeeded(resp.data.user.id);
                                    }

                                    this.model = Object.assign({}, this.model, resp.data);                                    
                                    displaySuccess(resp);
                                    resolve(true);
                                } catch (err) {
                                    displayError(err);
                                    resolve(false);
                                } finally {
                                    this.loading.state = false;
                                }
                            })
                        });
                    },

                    async fetchCurrentManager() {
                        const resp = await this.getPropertyManager({id: this.$route.params.id});
                        const data = resp.data;
                        this.model = Object.assign({}, this.model, data);

                        this.alreadyAssigned.buildings = this.model.buildings.map((building) => building.id);
                        this.alreadyAssigned.districts = this.model.districts.map((district) => district.id);

                        return resp.data;
                    },

                    ...mixin.methods,
                    ...mapActions(['getPropertyManager', 'updatePropertyManager', 'getRequests'])
                };

                mixin.created = async function () {
                    const {password, password_confirmation} = this.validationRules;

                    [...password, ...password_confirmation].forEach(rule => rule.required = false);

                    this.loading.state = true;

                    

                    await this.fetchCurrentManager();

                    const reqResp = await this.getRequests({
                        get_all: true,
                        assignee_id: this.model.user.id
                    });


                    this.requests = reqResp.data;

                    const {
                        data: {
                            ...restData
                        }
                    } = await this.getPropertyManager({id: this.$route.params.id});

                    this.statistics.raw[0].value = restData.requests_count;
                    this.statistics.raw[1].value = restData.solved_requests_count;
                    this.statistics.raw[2].value = restData.pending_requests_count;
                    this.statistics.raw[3].value = restData.buildings_count;

                    this.original_email = this.model.user.email;
                    
                    this.loading.state = false;
                };

                break;
        }
    }


    return mixin;
};


