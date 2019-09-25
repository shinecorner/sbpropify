import {mapActions} from 'vuex';
import {displayError, displaySuccess} from 'helpers/messages';
import Heading from 'components/Heading';
import Card from 'components/Card';
import uuid from "uuid/v1";
import UploadDocument from 'components/UploadDocument';
import Media from 'components/RequestMedia';
import RequestMedia from 'components/RequestMedia';

// TODO make a common mixin for posts and products mixins(media upload at least)
export default (config = {}) => {
    let mixin = {
        components: {
            Heading,
            Card,
            UploadDocument,
            Media,
            RequestMedia
        },
        props: {
            title: {
                type: String
            }
        },
        data() {
            return {
                remoteLoading: false,
                model: {
                    content: '',
                    visibility: 1,
                    status: 1,
                    sub_type: 1,
                    media: [],
                    published_at: '',
                    user_id: '',
                    pinned: '',
                    notify_email: false,
                    category: '',
                    execution_period: 2,
                    is_execution_time: false,
                    execution_start: null,
                    execution_end: null,
                    pinned_category: true
                },
                validationRules: {
                    content: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    type: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    visibility: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    status: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }],
                    published_at: [{
                        required: true,
                        message: this.$t('validation.general.required')
                    }]
                },
                loading: {
                    state: false,
                    text: 'Please wait...'
                },
                media: [],
                assignmentTypes: ['building', 'quarter'],
                assignmentType: 'building',
                toAssign: '',
                toAssignList: [],
                toAssignProvider: '',
                toAssignProviderList: [],
                types: [],
                showdefaultimage: false,
                rolename: ''

            }
        },
        computed: {
            form() {
                return this.$refs.form;
            },
            mediaFiles() {
                return [...this.model.media, ...this.media];
            },
            postConstants() {
                return this.$constants.posts
            }
        },
        methods: {
            ...mapActions(['uploadPostMedia', 'deletePostMedia', 'getBuildings', 'getQuarters', 'assignPostBuilding',
                'assignPostQuarter', 'getServices', 'assignPostProvider']),
            translateType(type) {
                return this.$t(`general.assignmentTypes.${type}`);
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
                        await this.uploadPostMedia({
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
                        message: this.$t('models.post.media.removed')
                    });
                } else {
                    const resp = await this.deletePostMedia({
                        id: image.model_id,
                        media_id: image.id
                    });
                    this.model.media = this.model.media.filter((files) => {
                        return files.id !== image.id;
                    });                    
                    displaySuccess(resp);
                }
            },
            async remoteSearchBuildings(search) {
                if (search === '') {
                    this.resetToAssignList();
                } else {
                    this.remoteLoading = true;

                    try {
                        let resp = [];
                        if (this.assignmentType == 'building') {
                            resp = await this.getBuildings({
                                get_all: true,
                                search,
                            });
                        } else {
                            resp = await this.getQuarters({get_all: true, search});
                        }

                        this.toAssignList = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },

            attachBuilding() {
                return new Promise(async (resolve, reject) => {
                    if (!this.toAssign || (!this.model.id && config.mode === 'edit')) {
                        return false;
                    }

                    try {

                        let resp;

                        if (this.assignmentType === 'building') {
                            resp = await this.assignPostBuilding({
                                id: this.model.id,
                                toAssignId: this.toAssign
                            });
                        } else {
                            resp = await this.assignPostQuarter({
                                id: this.model.id,
                                toAssignId: this.toAssign
                            });
                        }

                        if (resp && resp.data && config.mode === 'edit') {
                            await this.fetchCurrentPost();
                            this.$refs.assignmentsList.fetch();
                            this.toAssign = '';                            
                            displaySuccess(resp)
                        }

                        resolve(true);

                    } catch (e) {
                        if (e.response && !e.response.data.success) {
                            displayError(resp)
                        }

                        reject(false);
                    }
                })
            },
            resetToAssignList() {
                this.toAssignList = [];
                this.toAssign = '';
            },
            resetToAssignProviderList() {
                this.toAssignProviderList = [];
                this.toAssignProvider = '';
            },
            async remoteSearchProviders(search) {
                if (search === '') {
                    this.resetToAssignProviderList();
                } else {
                    this.remoteLoading = true;

                    try {

                        const resp = await this.getServices({get_all: true, search});

                        this.toAssignProviderList = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.remoteLoading = false;
                    }
                }
            },
            attachProvider() {
                return new Promise(async (resolve, reject) => {
                    if (!this.toAssignProvider || (!this.model.id && config.mode === 'edit')) {
                        reject(false);
                        return false;
                    }

                    try {

                        const resp = await this.assignPostProvider({
                            id: this.model.id,
                            toAssignId: this.toAssignProvider
                        });

                        if (resp && resp.data && config.mode === 'edit') {
                            await this.fetchCurrentPost();
                            this.$refs.assignmentsProviderList.fetch();
                            this.toAssignProvider = '';
                            displaySuccess(resp)
                        }

                        resolve(true);

                    } catch (e) {                        
                        displayError(e);
                        reject(false);
                    }
                })
            },
            resetExecutionTime() {
                this.model.execution_start
                    ? this.model.execution_start = this.model.execution_start.split(' ')[0] + ' 00:00:00'
                    : '';
                this.model.execution_end
                    ? this.model.execution_end = this.model.execution_end.split(' ')[0] + ' 00:00:00'
                    : '';
            },
        }
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['createPost', 'changePostPublish']),
                    async submit(afterValid = false) {
                        const valid = this.form.validate();
                        if (!valid) {
                            return false;
                        }

                        this.loading.state = true;

                        try {
                            this.model.pinned = this.model.type == 3 ? true : false;
                            const resp = await this.createPost(this.model);

                            if (resp && resp.data.id) {
                                this.$set(this.model, 'id', resp.data.id);
                                await this.uploadNewMedia(resp.data.id);
                                if (this.toAssign) {
                                    await this.attachBuilding();
                                }

                                if (this.toAssignProvider) {
                                    await this.attachProvider();
                                }

                                await this.changePostPublish({
                                    id: resp.data.id,
                                    status: this.model.status
                                })
                            }
                            this.form.resetFields();
                            this.media = [];
                            displaySuccess(resp);
                            if (!!afterValid) {
                                afterValid(resp);
                            } else {
                                this.$router.push({
                                    name: 'adminServicesEdit',
                                    params: {id: resp.data.id}
                                })
                            }
                            return resp;
                        } catch (err) {
                            displayError(err);
                        } finally {
                            this.loading.state = false;
                        }

                    },

                };

                break;
            case 'edit':
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['getPost', 'updatePost', 'changePostPublish']),
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.form.validate(async valid => {
                                if (!valid) {
                                    resolve(false);
                                    return false;
                                }

                                try {
                                    this.loading.state = true;
                                    this.model.status = 2;
                                    this.model.pinned = this.model.type == 3 ? true : false;

                                    await this.uploadNewMedia(this.model.id);

                                    const resp = await this.updatePost(this.model);

                                    this.model = Object.assign({}, this.model, resp.data);
                                    this.media = [];


                                    await this.changePostPublish({
                                        id: resp.data.id,
                                        status: this.model.status
                                    });
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
                    async fetchCurrentPost() {
                        const {
                            execution_period,
                            is_execution_time,
                            execution_start,
                            execution_end,

                            ...restData
                        } = await this.getPost({id: this.$route.params.id});

                        this.model = {
                            execution_period: this.model.execution_period,
                            is_execution_time: this.model.is_execution_time,
                            execution_start: this.model.execution_start,
                            execution_end: this.model.execution_end,

                            ...restData
                        };

                        this.showdefaultimage = this.model.category != null ? true : false;

                        return this.model;
                    }
                };

                mixin.created = async function () {
                    try {
                        this.loading.state = true;
                        await this.fetchCurrentPost();
                        if (this.model.type === 2) {
                            this.$router.replace({
                                name: 'adminPosts'
                            });
                        }
                        this.resetExecutionTime();
                    } catch (err) {
                        this.$router.replace({
                            name: 'adminPosts'
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
