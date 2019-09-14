<template>
    <el-form ref="form" class="request-add" :model="model" label-position="top" :validate-on-rule-change="false" v-loading="loading">
        <el-row type="flex" :gutter="16">
            <el-col>
                <el-form-item prop="category_id" :label="$t('models.request.category')" required>
                    <el-select v-model="model.category_id" 
                                :placeholder="$t('models.request.placeholders.category')"
                                @change="showSubcategory">
                        <el-option v-for="category in categories" 
                                    :key="category.id" 
                                    :label="category.name" 
                                    :value="category.id" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col v-if="this.showsubcategory == true">
                <el-form-item prop="defect" :label="$t('models.request.defect_location.label')" required  >
                    <el-select v-model="model.defect" 
                                :placeholder="$t('general.placeholders.select')"
                                @change="showLocationOrRoom">
                        <el-option v-for="category in categories" 
                                    :key="category.id" 
                                    :label="category.name" 
                                    :value="category.id" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col>
                <el-form-item prop="priority" label="Priority" required>
                    <el-select :placeholder="$t('models.request.placeholders.priority')" v-model="model.priority">
                        <el-option v-for="priority in priorities" :key="priority.value" :label="$t(`models.request.priority.${priority.label}`)" :value="priority.value" />
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>
        <el-form-item prop="title" :label="$t('tenant.title')" required>
            <el-input v-model="model.title" />
        </el-form-item>
        <el-form-item prop="description" label="Description" required>
            <el-input type="textarea" ref="description" v-model="model.description" :autosize="{minRows: 4, maxRows: 16}" />
        </el-form-item>
        <el-form-item prop="visibility" :label="$t('models.request.visibility.label')" required>
            <el-select v-model="model.visibility" :placeholder="$t('models.request.placeholders.visibility')">
                <el-option :key="k" :label="$t(`models.request.visibility.${visibility}`)" :value="parseInt(k)" v-for="(visibility, k) in $constants.serviceRequests.visibility">
                </el-option>
            </el-select>
        </el-form-item>
        <el-divider />
        <media-upload ref="upload" v-model="model.media" :size="mediaUploadMaxSize" :allowed-types="['image/jpg', 'image/jpeg', 'image/png', 'application/pdf']" :cols="4" />
        <el-form-item class="submitBtnDiv" v-if="showSubmit" style="grid-column: span 6">
            <el-button class="submit" type="primary" :disabled="loading" @click="submit">{{$t('tenant.actions.save')}}</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import {MEDIA_UPLOAD_MAX_SIZE} from '@/config'
    import MediaUpload from 'components/MediaUpload'
    import ServicesTypes from 'mixins/methods/servicesTypes'
    import PrepareCategories from 'mixins/methods/prepareCategories'
    import {displaySuccess, displayError} from 'helpers/messages'
    import PQueue from 'p-queue'

    export default {
        mixins: [
            ServicesTypes,
            PrepareCategories
        ],
        props: {
            showSubmit: {
                type: Boolean,
                default: true
            }
        },
        components: {
            MediaUpload
        },
        data () {
            return {
                model: {
                    title: '',
                    category_id: '',
                    priority: '',
                    visibility: '',
                    description: '',
                    media: [],
                    defect:'',
                    location: '',
                    room: '',
                    capture_phase: '',
                    component: '',
                    keyword: '',
                    keywords: [],
                    payer: '',
                },
                categories: [],
                priorities: [],
                loading: false,
                defect_subcategories: [],
                mediaUploadMaxSize: MEDIA_UPLOAD_MAX_SIZE,
                showsubcategory: false,
                showpayer: false,
                showUmgebung: false,
                showLiegenschaft: false,
                showacquisition: false,
                showWohnung: false,
            }
        },
        methods: {
            showSubcategory() {
                this.showsubcategory = this.model.category_id == 1 ? true : false;
                this.showpayer = this.model.qualification == 5 ? true : false;
            },
            showLocationOrRoom() {
                const subcategory = this.defect_subcategories.find(category => {
                    return category.id == this.model.defect;
                });

                this.model.room = '';
                this.model.location = '';
                this.showLiegenschaft = false;
                this.showUmgebung = false;
                this.showWohnung = false;

                if(subcategory.room == 1) {
                    this.showWohnung = true;
                }
                else if(subcategory.location == 1) {
                    this.showLiegenschaft = true;
                }
                else if(subcategory.location == 0 && subcategory.room == 0) {
                    this.showUmgebung = true;
                }
            },
            submit () {
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        try {
                            this.loading = true

                            const {media, ...params} = this.model

                            //const data = await this.$store.dispatch('createRequest', params)

                            const resp = await this.$store.dispatch('newRequests/create', params);
                            
                            displaySuccess(resp.message)

                            const {id} = resp.data

                            if (media.length) {
                                const queue = new PQueue({concurrency: 1})

                                // media.forEach(({file}) => queue.add(async () => await this.$store.dispatch('uploadRequestMedia', {
                                //     id, media: file.src
                                // })))
                                media.forEach(
                                    ({file}) => queue.add(
                                        async () => { 
                                            const mediaResp = await this.$store.dispatch('newRequests/uploadMedia', {
                                                id, media: file.src
                                            }) 
                                        }
                                    )
                                )

                                await queue.onIdle()
                            }

                            this.$refs.form.resetFields()
                            this.$refs.upload.clear()
                        } catch (err) {
                            displayError(err);
                        } finally {
                            this.loading = false
                        }
                    }
                })
            }
        },
        async mounted () {
            try {
                const {data} = await this.$store.dispatch('getRequestCategoriesTree', {get_all: true})

                const initialCategories = data;
                console.log('initial', initialCategories);
                this.categories = this.categories = this.prepareCategories(data);

            } catch (err) {
                displayError(err)
            }

            this.priorities = Object.entries(this.$constants.serviceRequests.priority).map(([value, label]) => ({value: +value, label}));
        }
    };
</script>

<style lang="scss" scoped>
    .request-add.el-form {
        .el-form-item {
            .el-select {
                width: 100%;
            }
            :global(.el-input__inner),
            :global(.el-textarea__inner) {
                background-color: transparentize(#fff, .44);
            }
        }
        > .el-form-item:last-child :global(.el-form-item__content) {
            display: flex;
            align-items: center;
            small {
                margin-left: 12px;
                line-height: 1.48;
                word-break: break-word;
                color: darken(#fff, 40%);
            }
        }
        .el-divider {
            margin: 16px 0;
            &:last-of-type {
                margin-bottom: 0;
            }
        }

        .submitBtnDiv {
            // position: absolute;
            width: 100%;
            grid-column: span 6 / auto;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: flex-end;
            margin-bottom: 30px;
            
            :global(.el-form-item__content) {
                // margin-right: 9%;
            }
        }
        .el-button.submit {
            margin-top: 1em;
            width: 100%;
        }
    }
</style>
