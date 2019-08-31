import uuid from 'uuid/v1';
import {mapActions} from 'vuex';
import {displayError, displaySuccess} from 'helpers/messages';
import UploadDocument from 'components/UploadDocument';
import RequestMedia from 'components/RequestMedia';
import PrepareCategories from 'mixins/methods/prepareCategories';

export default (config = {}) => {
    let mixin = {
        mixins: [PrepareCategories],
        components: {
            UploadDocument,
            RequestMedia
        },
        props: {
            title: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                model: {
                    title: '',
                    category: '',
                    priority: '',
                    visibility: '',
                    provider_ids: [],
                    building: '',
                    created_by: '',
                    defect:'',
                    location: '',
                    room: '',
                    capture_phase: '',
                    component: '',
                    keyword: '',
                    keywords: [],
                    payer: '',
                    property_managers: [],
                },
                validationRules: {
                    category: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    qualification: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    priority: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    status: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    visibility: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    due_date: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    title: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    description: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }]
                },
                loading: {
                    state: false,
                    text: 'Please wait...'
                },
                remoteLoading: false,
                categories: [],
                first_layout_subcategories: [],
                tenants: [],
                toAssignList: [],
                media: [],
                assignmentTypes: ['managers', 'services'],
                assignmentType: 'managers',
                toAssign: '',
                conversations: [],
                address: {},
                locations: [
                    {name: this.$t('models.request.category_options.locations.house_entrance'), value: 1},
                    {name: this.$t('models.request.category_options.locations.staircase'), value: 2},
                    {name: this.$t('models.request.category_options.locations.elevator'), value: 3},
                    {name: this.$t('models.request.category_options.locations.car_park'), value: 4},
                    {name: this.$t('models.request.category_options.locations.washing'), value: 5},
                    {name: this.$t('models.request.category_options.locations.heating'), value: 6},
                    {name: this.$t('models.request.category_options.locations.electro'), value: 7},
                    {name: this.$t('models.request.category_options.locations.facade'), value: 8},
                    {name: this.$t('models.request.category_options.locations.roof'), value: 9},
                    {name: this.$t('models.request.category_options.locations.other'), value: 10}
                ],
                rooms: [
                    {name: this.$t('models.request.category_options.rooms.bath'), value: 'Bad/WC'},
                    {name: this.$t('models.request.category_options.rooms.shower'), value: 'Du/WC'},
                    {name: this.$t('models.request.category_options.rooms.entrance'), value: 'Entrée'},
                    {name: this.$t('models.request.category_options.rooms.passage'), value: 'Gang'},
                    {name: this.$t('models.request.category_options.rooms.basement'), value: 'Keller'},
                    {name: this.$t('models.request.category_options.rooms.kitchen'), value: 'Küche'},
                    {name: this.$t('models.request.category_options.rooms.reduite'), value: 'Reduit'},
                    {name: this.$t('models.request.category_options.rooms.habitation'), value: 'Wohnen'},
                    {name: this.$t('models.request.category_options.rooms.room1'), value: 'Zimmer 1'},
                    {name: this.$t('models.request.category_options.rooms.room2'), value: 'Zimmer 2'},
                    {name: this.$t('models.request.category_options.rooms.room3'), value: 'Zimmer 3'},
                    {name: this.$t('models.request.category_options.rooms.room4'), value: 'Zimmer 4'},
                    {name: this.$t('models.request.category_options.rooms.all'), value: 'Alle'},
                    {name: this.$t('models.request.category_options.rooms.other'), value: 'Anderes'},
                ],
                acquisitions: [
                    {name: this.$t('models.request.category_options.acquisitions.other'), value: 'other'},
                    {name: this.$t('models.request.category_options.acquisitions.construction'), value: 'building'},
                    {name: this.$t('models.request.category_options.acquisitions.shell'), value: 'shell_building'},
                    {name: this.$t('models.request.category_options.acquisitions.preliminary'), value: 'prehandover'},
                    {name: this.$t('models.request.category_options.acquisitions.work'), value: 'prehandover_building'},
                    {name: this.$t('models.request.category_options.acquisitions.surrender'), value: 'handover'},
                    {name: this.$t('models.request.category_options.acquisitions.inspection'), value: 'inspection'},
                ],
                costs: [
                    {name: this.$t('models.request.category_options.costs.landlord'), value: 'lessor'},
                    {name: this.$t('models.request.category_options.costs.tenant'), value: 'tenant'},
                ],
                showfirstlayout: false,
                showpayer: false,
                showUmgebung: false,
                showLiegenschaft: false,
                showWohnung: false,
                createTag: false,
                editTag: false,
                tags: [],
                alltags: [],
            };
        },
        computed: {
            form() {
                return this.$refs.form;
            },
        },
        methods: {
            ...mapActions(['getRequestCategoriesTree', 'getTenants', 'getServices', 'uploadRequestMedia', 'deleteRequestMedia', 'getPropertyManagers', 'assignProvider', 'assignManager']),
            async remoteSearchTenants(search) {
                if (search === '') {
                    this.tenants = [];
                } else {
                    this.remoteLoading = true;

                    try {
                        const {data} = await this.getTenants({get_all: true, has_building: true,search});
                        this.tenants = data;
                        this.tenants.forEach(t => t.name = `${t.first_name} ${t.last_name}`);
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            async remoteSearchAssignees(search) {

                if (!this.$can(this.$permissions.assign.request)) {
                    return false;
                }

                if (search === '') {
                    this.resetToAssignList();
                } else {
                    this.remoteLoading = true;

                    try {
                        let resp = [];
                        if (this.assignmentType === 'managers') {
                            resp = await this.getPropertyManagers({
                                get_all: true,
                                search,
                            });
                        } else {
                            resp = await this.getServices({get_all: true, search});
                        }

                        this.toAssignList = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            resetToAssignList() {
                this.toAssignList = [];
                this.toAssign = '';
            },
            async assignUser() {
                if (!this.toAssign || !this.model.id) {
                    return false;
                }
                let resp;

                if (this.assignmentType === 'managers') {
                    resp = await this.assignManager({
                        request: this.model.id,
                        toAssignId: this.toAssign
                    });
                } else {
                    resp = await this.assignProvider({
                        request: this.model.id,
                        toAssignId: this.toAssign
                    });
                }

                if (resp && resp.data) {
                    await this.fetchCurrentRequest();
                    this.toAssign = '';
                    this.$refs.assigneesList.fetch();
                    displaySuccess(resp.data)
                }
            },
            uploadFiles(file) {
                const allowedFiles = [
                    'jpeg', 'png'
                ];
                const extension = file.raw.type.split('/');
                if (extension[1] && allowedFiles.includes(extension[1])) {
                    const url = `data:${file.raw.type};base64,${file.src}`;
                    this.media.push({
                        url,
                        id: uuid()
                    });
                } else {
                    displayError({
                        success: false,
                        message: this.$t('general.errors.files_extension_images')
                    });
                }
            },
            async uploadNewMedia(id) {
                if (this.media.length) {
                    for (let i = 0; i < this.media.length; i++) {
                        const image = this.media[i];
                        await this.uploadRequestMedia({
                            id,
                            media: image.url.split('base64,')[1]
                        });
                    }
                }
            },
            async deleteMedia(image) {
                if (!image.model_id) {
                    this.media = this.media.filter((files) => {
                        return files.id !== image.id;
                    });
                    displaySuccess({
                        success: true,
                        message: this.$t('general.actions.deleted')
                    });
                } else {
                    const resp = await this.deleteRequestMedia({
                        id: image.model_id,
                        media_id: image.id
                    });
                    this.model.media = this.model.media.filter((files) => {
                        return files.id !== image.id;
                    });
                    displaySuccess(resp);
                }
            },
            selectedCategoryHasQualification(categoryId) {
                if (!categoryId) {
                    return false;
                }

                const categoryArr = this.categories.filter((category) => {
                    return category.id === categoryId && category.has_qualifications;
                });

                if (categoryArr.length) {
                    return true;
                }

                return false;
            },
            async getRealCategories() {
                const {data: categories} = await this.getRequestCategoriesTree({get_all: true});

                const filteredcategories = categories.filter(category => {
                    if(category.id != 2) {
                        return category;
                    }
                });

                const initialcategories = this.prepareCategories(filteredcategories);
                
                this.categories = initialcategories.filter(category => {
                    if(category.parent_id !== 1) {
                        return category;
                    }
                });
                
                this.first_layout_subcategories = initialcategories.filter(category => {
                    if(category.parent_id == 1) {
                        return category;
                    }
                });
                
                this.first_layout_subcategories = this.first_layout_subcategories.map(item => ({
                    categories: item.categories,
                    description: item.description,
                    has_qualifications: item.has_qualifications,
                    id: item.id,
                    location: item.location,
                    name: item.name.substring(3),
                    parent_id: item.parent_id,
                    room: item.room
                }))
            }
        }
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['createRequest']),
                    async saveRequest() {
                        const resp = await this.createRequest(this.model);

                        await this.uploadNewMedia(resp.data.id);

                        this.media = [];

                        this.form.resetFields();

                        return resp;

                    },
                    async submit(afterValid = false) {
                        const valid = await this.form.validate();
                        if (valid) {
                            this.loading.state = true;
                            try {
                                const resp = await this.saveRequest();
                                displaySuccess(resp);

                                this.form.resetFields();
                                if (!!afterValid) {
                                    afterValid(resp);
                                } else {
                                    this.$router.push({
                                        name: 'adminRequestsEdit',
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
                };

                mixin.created = async function () {
                    this.loading.state = true;

                    this.validationRules.tenant_id = [{
                        required: true,
                        message: 'This field is required'
                    }];

                    const {data: categories} = await this.getRequestCategoriesTree({get_all: true});

                    this.categories = this.prepareCategories(categories);

                    this.loading.state = false;
                };

                break;
            case 'edit':
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['getRequest', 'updateRequest', 'getTenant', 'getRequestConversations', 'getAddress', 'getRequestTags',
                'createRequestTags', 'getTags']),
                    async fetchCurrentRequest() {
                        
                        const resp = await this.getRequest({id: this.$route.params.id});

                        if(resp) {
                            this.model.property_managers = resp.data.property_managers.map((manager) => {
                                manager.name = `${manager.first_name} ${manager.last_name}`;
                                return manager
                            });
                        }
                        
                        this.showfirstlayout = resp.data.category.parent_id == 1 ? true : false;
                        
                        this.showLiegenschaft = resp.data.location != null ? true : false;

                        this.showWohnung = resp.data.room != null ? true : false;
                        
                        this.showpayer = resp.data.qualification == 5 ? true : false;

                        const data = resp.data;

                        this.model = Object.assign({}, this.model, data);
                        if(data.category.parent_id == null) {
                            this.$set(this.model, 'category_id', data.category.id);
                        }
                        else {
                            this.$set(this.model, 'category_id', data.category.parent_id);
                            this.$set(this.model, 'defect', data.category.id);
                        }
                        this.$set(this.model, 'created_by', data.created_by);
                        this.$set(this.model, 'building', data.tenant.building.name);

                        await this.getConversations();
                        
                        if (data.tenant) {
                            this.model.tenant_id = data.tenant.id;
                            await this.getBuildingAddress(data.tenant.building.id);
                        }
                    },
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.form.validate(async valid => {
                                if (!valid) {
                                    resolve(false);
                                    return false;
                                }

                                this.loading.state = true;
                                let {service_providers, property_managers, ...params} = this.model;
                                
                                if(params.category_id == 1)
                                    params.category_id = this.model.defect;
        
                                
                                // const resptags = await this.createRequestTag({
                                //     id: this.$route.params.id,
                                //     keywords: this.model.keywords
                                // });
                                


                                let existingsKeys = [];
                                let newTags = [];
                                
                                this.model.keywords.forEach(keyword => {
                                    let tagObj = this.alltags.find((item) => {
                                        return item.name == keyword;
                                    });
                                    
                                    if ( tagObj != null ) {
                                        existingsKeys.push(tagObj.id);
                                    }
                                    else {
                                        newTags.push(keyword);
                                    }
                                })
                                
                                const requestTags = await this.createRequestTags({
                                    id: this.$route.params.id,
                                    tag_ids: existingsKeys,
                                    tags: newTags
                                });

                                requestTags.data.tags.forEach(item => {
                                    if(this.alltags.findIndex((el) => {return el.id == item.id}) == -1)
                                        this.alltags.push({ id: item.id, name: item.name });
                                })

                                try {
                                    await this.uploadNewMedia(params.id);
                                    
                                    const resp = await this.updateRequest(params);
                                    
                                    
                                    this.media = [];
                                    this.$set(this.model, 'service_providers', resp.data.service_providers);
                                    this.$set(this.model, 'media', resp.data.media);
                                    this.$set(this.model, 'property_managers', resp.data.property_managers);
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
                    async getConversations() {
                        const resp = await this.getRequestConversations({
                            id: this.model.id
                        });

                        if (resp.data) {
                            this.conversations = resp.data;
                        }
                    },
                    async getBuildingAddress(building_id) {
                        const resp = await this.getAddress({
                            id: building_id
                        });
                        if (resp) {
                            this.address = resp;
                        }
                    }
                };

                mixin.created = async function () {
                    this.loading.state = true;

                    this.getRealCategories();

                    const tagsResp = await this.getTags({get_all: true, search: ''});

                    if(tagsResp.success == true) 
                    {
                        this.alltags = tagsResp.data;
                    }

                    const tags = await this.getRequestTags({id: this.$route.params.id});
                    
                    this.tags = tags.data.data.map(item => ({
                        id: item.id,
                        name: item.name
                    }));

                    tags.data.data.map(item => {
                        this.model.keywords.push(item.name);
                    })

                    await this.fetchCurrentRequest();

                    this.loading.state = false;
                };

                break;
        }
    }


    return mixin;
};


