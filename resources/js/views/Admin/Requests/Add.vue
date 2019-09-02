<template>
    <div class="services-edit">
        <heading :title="$t('models.request.add_title')" icon="icon-chat-empty" shadow="heavy">
            <add-actions :saveAction="submit" route="adminRequests" editRoute="adminRequestsEdit"/>
        </heading>
        <el-row :gutter="20" class="crud-view" id="add_request">
            <el-col :md="12">
                <el-form :model="model" :rules="validationRules" ref="form">
                <card :loading="loading">
                    <el-row :gutter="20">
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.category')"
                                            :rules="validationRules.category"
                                            prop="category_id">
                                <el-select :disabled="$can($permissions.update.serviceRequest)"
                                            :placeholder="$t('models.request.placeholders.category')"
                                            class="custom-select"
                                            v-model="model.category_id"
                                            @change="showSubcategory">
                                    <el-option
                                        :key="category.id"
                                        :label="category.name"
                                        :value="category.id"
                                        v-for="category in categories">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.defect_location.label')" v-if="this.showsubcategory == true">
                                <el-select :disabled="$can($permissions.update.serviceRequest)"
                                            :placeholder="$t(`general.placeholders.select`)"
                                            class="custom-select"
                                            v-model="model.defect"
                                            @change="showLocationOrRoom">
                                    <el-option
                                        :key="category.id"
                                        :label="category.name"
                                        :value="category.id"
                                        v-for="category in first_layout_subcategories">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.category_options.range')"
                                v-if="this.showsubcategory == true && this.showLiegenschaft == true && this.showWohnung == false">
                                <el-select :disabled="$can($permissions.update.serviceRequest)"
                                            :placeholder="$t(`general.placeholders.select`)"
                                            class="custom-select"
                                            v-model="model.location">
                                    <el-option
                                        :key="location.value"
                                        :label="location.name"
                                        :value="location.value"
                                        v-for="location in locations">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.category_options.room')"
                                v-if="this.showsubcategory == true && this.showWohnung == true && this.showLiegenschaft == false">
                                <el-select :disabled="$can($permissions.update.serviceRequest)"
                                            :placeholder="$t(`general.placeholders.select`)"
                                            class="custom-select"
                                            v-model="model.room">
                                    <el-option
                                        :key="room.value"
                                        :label="room.name"
                                        :value="room.value"
                                        v-for="room in rooms">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.qualification.label')"
                                        :rules="validationRules.qualification"
                                        prop="qualification"
                                        v-if="model.category_id && selectedCategoryHasQualification(model.category_id)">
                                <el-select :placeholder="$t('models.request.placeholders.qualification')"
                                        class="custom-select"
                                        v-model="model.qualification"
                                        @change="selectPayer">
                                    <el-option
                                        :key="k"
                                        :label="$t(`models.request.qualification.${qualification}`)"
                                        :value="parseInt(k)"
                                        v-for="(qualification, k) in $constants.service_requests.qualification">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.category_options.cost')" 
                                v-if="model.category_id && selectedCategoryHasQualification(model.category_id) && this.showpayer == true">
                                <el-select :disabled="$can($permissions.update.serviceRequest)"
                                            :placeholder="$t(`general.placeholders.select`)"
                                            class="custom-select"
                                            v-model="model.payer">
                                    <el-option
                                        :key="cost.value"
                                        :label="cost.name"
                                        :value="cost.value"
                                        v-for="cost in costs">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.category_options.component')">
                                <el-input v-model="model.component"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.category_options.keywords')">
                                <el-select
                                    v-model="model.keywords"
                                    multiple
                                    filterable
                                    allow-create
                                    default-first-option
                                    @remove-tag="deleteTag"
                                    class="custom-select"
                                    >
                                    <el-option
                                        v-for="item in tags"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.name">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.priority.label')" :rules="validationRules.priority"
                                      prop="priority">
                                <el-select :placeholder="$t('models.request.priority.label')" class="custom-select"
                                        v-model="model.priority">
                                    <el-option
                                        :key="k"
                                        :label="$t(`models.request.priority.${priority}`)"
                                        :value="parseInt(k)"
                                        v-for="(priority, k) in $constants.service_requests.priority">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.status.label')" :rules="validationRules.status"
                                        prop="status">
                                <el-select :placeholder="$t('models.request.placeholders.status')" class="custom-select"
                                        v-model="model.status">
                                    <el-option
                                        :key="k"
                                        :label="$t(`models.request.status.${status}`)"
                                        :value="parseInt(k)"
                                        v-for="(status, k) in $constants.service_requests.status">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.visibility.label')"
                                        :rules="validationRules.visibility"
                                        prop="visibility"
                            >
                                <el-select
                                    :placeholder="$t('models.request.placeholders.visibility')"
                                    class="custom-select"
                                    v-model="model.visibility">
                                    <el-option
                                        :key="k"
                                        :label="$t(`models.request.visibility.${visibility}`)"
                                        :value="parseInt(k)"
                                        v-for="(visibility, k) in $constants.serviceRequests.visibility">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.due_date')" :rules="validationRules.due_date"
                                        prop="due_date">
                                <el-date-picker
                                    :placeholder="$t('models.request.placeholders.due_date')"
                                    format="dd.MM.yyyy"
                                    style="width: 100%"
                                    type="date"
                                    v-model="model.due_date"
                                    value-format="yyyy-MM-dd"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12" v-if="model.tenant">
                            <el-form-item>
                                <label slot="label">
                                    {{$t('general.tenant')}}
                                </label>
                                <router-link :to="{name: 'adminTenantsEdit', params: {id: model.tenant.id}}">
                                    {{model.tenant.first_name}} {{model.tenant.last_name}}
                                </router-link>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12" v-else>
                            <el-form-item :label="$t('general.tenant')" :rules="validationRules.tenant_id" prop="tenant_id">
                                <el-select
                                    :loading="remoteLoading"
                                    :placeholder="$t('models.request.placeholders.tenant')"
                                    :remote-method="remoteSearchTenants"
                                    filterable
                                    remote
                                    reserve-keyword
                                    style="width: 100%;"
                                    v-model="model.tenant_id">
                                    <el-option
                                        :key="tenant.id"
                                        :label="tenant.name"
                                        :value="tenant.id"
                                        v-for="tenant in tenants"/>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('models.request.prop_title')" :rules="validationRules.title"
                                        prop="title">
                                <el-input type="text" v-model="model.title"/>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item :label="$t('general.description')" :rules="validationRules.description"
                                        prop="description">
                                <el-input
                                    :autosize="{minRows: 5}"
                                    type="textarea"
                                    v-model="model.description">
                                </el-input>
                            </el-form-item>
                        </el-col>
                        <!--                        <el-form-item :label="$t('models.request.is_public')"-->
                        <!--                                      prop="is_public">-->
                        <!--                            <el-switch-->
                        <!--                                v-model="model.is_public"-->
                        <!--                            >-->
                        <!--                            </el-switch>-->
                        <!--                        </el-form-item>-->
                        </el-row>
                    </card>
                </el-form>
            </el-col>
            <el-col :md="12">
                <card :header="$t('models.request.images')">
                    <upload-document @fileUploaded="uploadFiles" class="drag-custom" drag multiple/>
                    <div class="mt15">
                        <request-media :data="media" @deleteMedia="deleteMedia" v-if="media.length"></request-media>
                    </div>
                </card>
            </el-col>
        </el-row>

    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import RequestsMixin from 'mixins/adminRequestsMixin';
    import {displayError} from "helpers/messages";
    import AddActions from 'components/EditViewActions';


    export default {
        name: 'AdminRequestsEdit',
        mixins: [RequestsMixin({
            mode: 'add'
        })],
        components: {
            Heading,
            Card,
            AddActions
        },
        data() {
            return {
                couldSaveWithService: false
            }
        },
        methods: {
            async saveWithService(serviceAttachModel) {
                try {
                    const resp = await this.saveRequest();

                    if (resp.data.id) {
                        this.model.id = resp.data.id;
                        await this.sendServiceMail(serviceAttachModel);
                        this.setSelectedServiceRequest({});
                    }

                } catch (err) {
                    displayError(err);
                } finally {
                    this.loading.state = false;
                }
            },
            showSubcategory() {
                this.showsubcategory = this.model.category_id == 1 ? true : false;
                this.showpayer = this.model.qualification == 5 ? true : false;
            },
            showLocationOrRoom() {
                const subcategory = this.first_layout_subcategories.find(category => {
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
            selectPayer() {
                this.model.payer = '';
                this.showpayer = this.model.qualification == 5 ? true : false;
            },
            async deleteTag(tag) {
                
                const deleteTag = this.alltags.find((item) => {
                    return item.name == tag;
                });

                if(deleteTag != null) {
                    const resp = await this.deleteRequestTag({
                        id: this.$route.params.id,
                        tag_id: deleteTag.id
                    });
                    
                }

                this.tags = this.tags.filter(item => {
                    return item.name != tag;
                });
            },

        },
        created(){
            this.model['priority'] = '';
            this.validationRules['priority'] = [{
                required: true,
                message: this.$t('validation.general.required')
            }];
        }
        
    };
</script>

<style lang="scss" scoped>
    .services-edit {
        .heading {
            margin-bottom: 20px;
        }
    }

    .custom-select {
        display: block;
    }


</style>
<style lang="scss">
    #add_request {
        .el-input__suffix {
            height: 121px;
        }
    }
</style>
<style>
    .el-button > i {
        margin-right: 5px;
    }
</style>
