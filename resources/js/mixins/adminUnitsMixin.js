import {mapGetters, mapActions} from 'vuex';
import {displayError, displaySuccess} from 'helpers/messages';
import unitTypes from 'mixins/methods/unitTypes';
import axios from '@/axios';

export default (config = {}) => {
    let mixin = {
        mixins: [unitTypes],
        props: {
            title: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                remoteLoading: false,
                toAssignList: [],
                buildings: [],
                model: {
                    tenant_id: '',
                    name: '',
                    type: 1,
                    room_no: '',
                    monthly_rent: '',
                    floor: '',
                    sq_meter: '',
                    basement: false,
                    attic: false,
                    building_id: this.$route.params.id,
                    selected_tenant: '',
                    tenants: []
                },
                validationRules: {
                    tenant_id: [{
                        required: false,
                        message: this.$t("models.unit.validation.tenant.required")
                    }],
                    name: [{
                        required: true,
                        message: this.$t("models.unit.validation.name.required")
                    }],
                    type: [{
                        required: true
                    }],
                    room_no: [{
                        required: true,
                        message: this.$t("models.unit.validation.room_no.required")
                    }],
                    monthly_rent: [{
                        required: true,
                        message: this.$t("models.unit.validation.monthly_rent.required")
                    }],
                    floor: [{
                        required: true,
                        message: this.$t("models.unit.validation.floor.required")
                    }],
                    building_id: [{
                        required: true,
                        message: this.$t("models.unit.validation.building.required")
                    }]
                },
                loading: {
                    state: false,
                    text: 'Please wait...'
                },
                requestColumns: [{
                    prop: 'category.name',
                    label: this.$t('models.request.category')
                }],
                requestActions: [{
                    width: '180px',
                    buttons: [{
                        title: this.$t('general.actions.edit'),
                        type: 'primary',
                        onClick: this.requestEditView
                    }]
                }],
                toAssign: '',
            }
        },
        methods: {
            ...mapActions(['getTenants', 'getBuildings']),
            requestEditView(row) {
                return this.$router.push({
                    name: 'adminRequestsEdit',
                    params: {
                        id: row.id
                    }
                });
            },
            async remoteSearchBuildings(search) {
                if (search === '') {
                    this.buildings = [];
                } else {
                    this.remoteLoading = true;

                    try {
                        const {data} = await this.getBuildings({get_all: true, search});

                        this.buildings = data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            async remoteSearchTenants(search) {
                if (search === '') {
                    this.toAssignList = [];
                } else {
                    this.remoteLoading = true;

                    try {
                        const {data} = await this.getTenants({get_all: true, search});

                        this.toAssignList = data;
                        this.toAssignList.forEach(t => t.name = `${t.first_name} ${t.last_name}`);
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            async assignTenant() {
                if (!this.toAssign || !this.model.id) {
                    return false;
                }
                let resp; 
                try {
                    resp = await axios.post(`units/`+ this.model.id + `/assignees/` + this.toAssign);              
                } catch {
                    console.log(e);
                }

                if (resp && resp.data) {
                    this.toAssign = '';
                    this.$refs.assigneesList.fetch();
                    displaySuccess(resp.data)
                }
            },
            notifyUnassignment(tenant) {
                this.$confirm(this.$t(`general.swal.confirmChange.title`), this.$t('general.swal.confirmChange.warning'), {
                    confirmButtonText: this.$t(`general.swal.confirmChange.confirmBtnText`),
                    cancelButtonText: this.$t(`general.swal.confirmChange.cancelBtnText`),
                    type: 'warning'
                }).then(async () => {
                    try {
                        this.loading.status = true;

                        let resp;

                        try {
                            resp = await axios.delete(`units/`+ this.model.id + `/assignees/` + tenant.id);               
                        } catch {
                            console.log(e);
                        }

                        if (resp && resp.data) {
                            this.$refs.assigneesList.fetch();
                            displaySuccess(resp.data)
                        }

                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.loading.status = false;
                    }
                }).catch(async () => {
                    this.loading.status = false;
                });
            },
        },
        computed: {
            form() {
                return this.$refs.form;
            },
            rooms() {
                let rooms = [];

                for (let i = 1; i <= 6.5; i += .5) {
                    rooms.push({
                        value: i,
                        label: i
                    });
                }

                return rooms;
            }
        }
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.methods = {
                    async submit(afterValid = false) {
                        const valid = await this.form.validate();
                        if (valid) {
                            this.loading.state = true;
                            try {
                                const response = await this.createUnit(this.model);
                                displaySuccess(response);
                                

                                this.form.resetFields();
                                if (!!afterValid) {
                                    afterValid(response);
                                } else {
                                    this.$router.push({
                                        name: 'adminUnitsEdit',
                                        params: {id: response.data.id}
                                    })
                                }
                            } catch (err) {
                                displayError(err);
                            } finally {
                                this.loading.state = false;
                            }
                        }
                    },

                    ...mixin.methods,
                    ...mapActions(['createUnit'])
                };

                break;
            case 'edit':
                mixin.methods = {
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.form.validate(async valid => {
                                if (!valid) {
                                    resolve(false);
                                    return false;
                                }

                                this.loading.state = true;
                                try {
                                    const resp = await this.updateUnit(this.model)
                                    displaySuccess(resp);
                                    resolve(true);
                                    return resp;
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
                    ...mapActions(['getUnit', 'updateUnit', 'getBuilding'])
                };

                mixin.created = async function () {
                    try {
                        this.loading.state = true;

                        this.model = await this.getUnit({id: this.$route.params.id});

                        if (this.model.tenant) {
                            this.$set(this.model, 'tenant_id', this.model.tenant.id);
                            this.remoteSearchTenants(`${this.model.tenant.first_name}`);
                        }

                        if (config.withRelation && this.model.building_id) {
                            const building = await this.getBuilding({id: this.model.building_id});
                            this.remoteSearchBuildings(`${building.name}`);
                        }

                    } catch (err) {
                        this.$router.replace({
                            name: 'adminUnits'
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
