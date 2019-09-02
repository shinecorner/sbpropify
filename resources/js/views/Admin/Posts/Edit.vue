<template>
    <div id="post-edit-view" class="units-edit mb20">
        <heading :title="$t('models.post.edit_title')" icon="icon-megaphone-1" shadow="heavy" style="margin-bottom: 20px;">
            <edit-actions :saveAction="submit" :deleteAction="deletePost" route="adminPosts"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-form :model="model" label-position="top" label-width="192px" ref="form">
                <el-col :md="12">                
                    <el-card :loading="loading" class="mb20">
                        <el-row :gutter="20" class="mb20">
                            <el-col :lg="8">
                                <el-form-item :label="$t('models.post.type.label')">
                                    <el-select style="display: block" v-model="model.pinned">
                                        <el-option
                                            :label="$t(`models.post.type.article`)"
                                            :value="false"
                                        >
                                        </el-option>
                                        <el-option
                                            :label="$t(`models.post.type.pinned`)"
                                            :value="true"
                                        >
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :lg="8" v-if="!model.pinned">
                                <el-form-item :label="$t('models.post.status.label')">
                                    <el-select style="display: block" v-model="model.status">
                                        <el-option
                                            :key="key"
                                            :label="$t(`models.post.status.${status}`)"
                                            :value="parseInt(key)"
                                            v-for="(status, key) in postConstants.status">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :lg="8" v-if="model.pinned">
                                <el-form-item :label="$t('models.post.category.label')">
                                    <el-select style="display: block" v-model="model.category">
                                        <el-option
                                            :key="key"
                                            :label="$t(`models.post.category.${category}`)"
                                            :value="parseInt(key)"
                                            v-for="(category, key) in postConstants.category">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :lg="8" v-else>
                                <el-form-item :label="$t('models.post.visibility.label')">
                                    <el-select style="display: block" v-model="model.visibility">
                                        <el-option
                                            :key="key"
                                            :label="$t(`models.post.visibility.${visibility}`)"
                                            :value="parseInt(key)"
                                            v-for="(visibility, key) in postConstants.visibility">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-tabs v-if="model.pinned" v-model="activeTab1">
                            <el-tab-pane :label="$t('general.actions.view')" name="details">
                                <el-form-item :label="$t('models.post.title_label')" :rules="validationRules.title"
                                            prop="title">
                                    <el-input type="text" v-model="model.title"></el-input>
                                </el-form-item>
                                <el-form-item :label="$t('general.content')" :rules="validationRules.content"
                                            prop="content">
                                    <el-input
                                        :autosize="{minRows: 5}"
                                        type="textarea"
                                        v-model="model.content">
                                    </el-input>
                                </el-form-item>
                                <el-form-item :label="$t('models.post.images')">
                                    <upload-document @fileUploaded="uploadFiles" class="drag-custom" drag multiple/>
                                    <div class="mt15" v-if="media.length || (model.media && model.media.length)">
                                        <request-media :data="[...model.media, ...media]" @deleteMedia="deleteMedia"
                                                       v-if="media.length || (model.media && model.media.length)"></request-media>
                                    </div>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane :label="$t('models.post.comments')" name="comments">
                                <chat class="edit-post-chat" :id="model.id" size="480px" type="post"/>
                            </el-tab-pane>
                        </el-tabs>
                        
                        <template v-if="!model.pinned">
                            <el-form-item :label="$t('general.content')" :rules="validationRules.content"
                                        prop="content">
                                <el-input
                                    :autosize="{minRows: 5}"
                                    type="textarea"
                                    v-model="model.content">
                                </el-input>
                            </el-form-item>
                            <el-form-item :label="$t('models.post.images')"
                            >
                                <upload-document @fileUploaded="uploadFiles" class="drag-custom" drag multiple/>
                                <div class="mt15" v-if="media.length || (model.media && model.media.length)">
                                    <request-media :data="[...model.media, ...media]" @deleteMedia="deleteMedia"
                                                       v-if="media.length || (model.media && model.media.length)"></request-media>
                                </div>
                            </el-form-item>
                        </template>                        
                    </el-card>

                    <el-card :loading="loading" v-if="!model.pinned && (!model.tenant)">
                        <div slot="header" class="clearfix">
                            <span>{{$t('general.assignment')}}</span>
                        </div>
                        <assignment-by-type
                            :resetToAssignList="resetToAssignList"
                            :assignmentType.sync="assignmentType"
                            :toAssign.sync="toAssign"
                            :assignmentTypes="assignmentTypes"
                            :assign="attachBuilding"
                            :toAssignList="toAssignList"
                            :remoteLoading="remoteLoading"
                            :remoteSearch="remoteSearchBuildings"
                        />
                        <relation-list
                            :actions="assignmentsActions"
                            :columns="assignmentsColumns"
                            :filterValue="model.id"
                            fetchAction="getPostAssignments"
                            filter="post_id"
                            ref="assignmentsList"
                            v-if="model.id"
                        />

                    </el-card>                
                </el-col>
                <el-col :md="12">
                    <el-card :loading="loading" class="contact-info-card">
                        <el-row  :gutter="30" class="contact-info-card-row">
                            <el-col class="contact-info-card-col" :md="8">
                                <div class="contact-info-title">
                                    <span class="custom-label">
                                        <i class="icon-user"></i>&nbsp;{{$t('general.user')}}
                                    </span>
                                </div>
                                <div class="contact-info-content">
                                    <span v-if="model.user">
                                        <router-link :to="{name: 'adminUsersEdit', params: {id: model.user.id}}" class="tenant-link">
                                            <avatar :size="30"
                                                    :src="'/' + model.user.avatar"
                                                    v-if="model.user.avatar"></avatar>
                                            <avatar :size="28"
                                                    :username="model.user.first_name ? `${model.user.first_name} ${model.user.last_name}`: `${model.user.name}`"
                                                    backgroundColor="rgb(205, 220, 57)"
                                                    color="#fff"
                                                    v-if="!model.user.avatar"></avatar>
                                            <span>{{model.user.name}}</span>
                                        </router-link>
                                    </span>
                                </div>
                            </el-col>                            
                            <el-col class="contact-info-card-col" :md="8">
                                <div class="contact-info-title">
                                    <span class="custom-label">
                                        <i class="icon-paper-plane"></i>&nbsp;{{$t('models.post.published_at')}}
                                    </span>
                                </div>
                                <div class="contact-info-content" v-if="model.published_at">
                                    <span class="custom-value">
                                        {{this.formatDatetime(model.published_at)}}
                                    </span>
                                </div>
                                <div class="contact-info-content" v-else>
                                    <span class="custom-value">-</span>
                                </div>
                            </el-col>
                            <el-col class="contact-info-card-col" :md="8">
                                <div class="contact-info-title">
                                    <span class="custom-label">
                                        <i class="icon-chat"></i>&nbsp;{{$t('models.post.comments')}}
                                    </span>
                                </div>
                                <div class="contact-info-content">
                                    <span class="custom-value">
                                        {{model.comments_count}}
                                    </span>
                                </div>
                            </el-col>
                        </el-row>     
                        <el-row  :gutter="30" class="contact-info-card-row">
                            <el-col class="contact-info-card-col" :md="8">
                                <div class="contact-info-title">
                                    <span class="custom-label">
                                        <i class="icon-eye"></i>&nbsp;{{$t('models.post.views')}}
                                    </span>
                                </div>
                                <div class="contact-info-content">
                                    <span class="custom-value">
                                        {{model.views}}
                                    </span>
                                </div>
                            </el-col>
                            <el-col class="contact-info-card-col" :md="8">
                                <div class="contact-info-title">
                                    <span class="custom-label">
                                        <i class="icon-thumbs-up"></i>&nbsp;{{$t('models.post.likes')}}
                                    </span>
                                </div>
                                <div class="contact-info-content">
                                    <span class="custom-value">
                                        {{model.likes_count}}
                                    </span>   
                                </div> 
                            </el-col>
                            <el-col v-if="model.pinned" class="contact-info-card-col" :md="8">
                                <div class="contact-info-title">
                                    <span class="custom-label">
                                        <i class="icon-users"></i>&nbsp;&nbsp;{{$t('general.recipients')}}
                                    </span>
                                </div>
                                <div class="contact-info-content">
                                    <span class="custom-value">
                                        {{model.tenant}}
                                    </span>
                                </div> 
                            </el-col>
                        </el-row>                                                    
                    </el-card>

                    <el-card v-if="model.pinned" :loading="loading" class="mt15">
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('models.post.execution_interval.start')"
                                                prop="execution_start">
                                    <el-date-picker
                                        :picker-options="{disabledDate: disabledExecutionStart}"
                                        format="dd.MM.yyyy HH:mm"
                                        style="width: 100%"
                                        type="datetime"
                                        v-model="model.execution_start"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                    >
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('models.post.execution_interval.end')"
                                                prop="execution_end">
                                    <el-date-picker
                                        :picker-options="{disabledDate: disabledExecutionEnd}"
                                        format="dd.MM.yyyy HH:mm"
                                        style="width: 100%"
                                        type="datetime"
                                        v-model="model.execution_end"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                        @change="setPinnedTo"
                                    >
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('models.post.pinned_to')"
                                                :rules="validationRules.pinned_to"
                                                prop="pinned_to">
                                    <el-date-picker
                                        format="dd.MM.yyyy HH:mm"
                                        style="width: 100%"
                                        type="datetime"
                                        v-model="model.pinned_to"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                    >
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-form-item :label="$t('models.post.notify_email')" prop="notify_email" v-if="model.notify_email == false"
                                        style="display: flex">
                            <el-switch style="margin-left: 10px" v-model="model.notify_email">
                            </el-switch>
                        </el-form-item>
                    </el-card>

                    <el-card :loading="loading" v-if="model.pinned && (!model.tenant)" class="mt15">
                        <el-row :gutter="10">
                            <el-col :lg="6">
                                <el-select @change="resetToAssignList"
                                           class="custom-select"
                                           v-model="assignmentType"
                                >
                                    <el-option
                                        :key="type"
                                        :label="$t(`general.assignmentTypes.${type}`)"
                                        :value="type"
                                        v-for="(type) in assignmentTypes">
                                    </el-option>
                                </el-select>
                            </el-col>
                            <el-col :lg="12" :xl="14">
                                <el-select
                                    :loading="remoteLoading"
                                    :placeholder="$t('general.placeholders.search')"
                                    :remote-method  ="remoteSearchBuildings"
                                    class="custom-remote-select"
                                    filterable
                                    remote
                                    reserve-keyword
                                    style="width: 100%;"
                                    v-model="toAssign"
                                >
                                    <div class="custom-prefix-wrapper" slot="prefix">
                                        <i class="el-icon-search custom-icon"></i>
                                    </div>
                                    <el-option
                                        :key="building.id"
                                        :label="building.name"
                                        :value="building.id"
                                        v-for="building in toAssignList"/>
                                </el-select>
                            </el-col>
                            <el-col :lg="6" :xl="4">
                                <el-button :disabled="!toAssign" @click="attachBuilding" class="full-button"
                                           icon="ti-save" type="primary">
                                    {{$t('general.assign')}}
                                </el-button>
                            </el-col>
                        </el-row>
                        <relation-list
                            :actions="assignmentsActions"
                            :columns="assignmentsColumns"
                            :filterValue="model.id"
                            fetchAction="getPostAssignments"
                            filter="post_id"
                            ref="assignmentsList"
                            v-if="model.id"
                        />
                    </el-card>
                    
                    <el-card v-if="model.pinned" :loading="loading" class="mt15">
                        <el-row :gutter="10">
                            <el-col :lg="18" :xl="20">
                                <el-select
                                    :loading="remoteLoading"
                                    :placeholder="$t('models.post.placeholders.search_provider')"
                                    :remote-method="remoteSearchProviders"
                                    class="custom-remote-select"
                                    filterable
                                    remote
                                    reserve-keyword
                                    style="width: 100%;"
                                    v-model="toAssignProvider"
                                >
                                    <div class="custom-prefix-wrapper" slot="prefix">
                                        <i class="el-icon-search custom-icon"></i>
                                    </div>
                                    <el-option
                                        :key="provider.id"
                                        :label="provider.name"
                                        :value="provider.id"
                                        v-for="provider in toAssignProviderList"/>
                                </el-select>
                            </el-col>
                            <el-col :lg="6" :xl="4">
                                <el-button :disabled="!toAssignProvider" @click="attachProvider" class="full-button"
                                            icon="ti-save" type="primary">
                                    {{$t('general.assign')}}
                                </el-button>
                            </el-col>
                        </el-row>
                        <relation-list
                            :actions="assignmentsProviderActions"
                            :columns="assignmentsProviderColumns"
                            :filterValue="model.id"
                            fetchAction="getServices"
                            filter="post_id"
                            ref="assignmentsProviderList"
                            v-if="model.id"
                        />
                    </el-card>

                    <el-card class="mt15" v-if="model.id && !model.pinned">
                        <div slot="header" class="clearfix">
                            <span>{{$t('models.post.comments')}}</span>
                        </div>
                        <chat class="edit-post-chat" :id="model.id" size="480px" type="post"/>
                    </el-card>
                </el-col>
            </el-form>
        </el-row>

    </div>
</template>

<script>
    import EditActions from 'components/EditViewActions';
    import PostsMixin from 'mixins/adminPostsMixin';
    import FormatDateTimeMixin from 'mixins/formatDateTimeMixin'
    import RelationList from 'components/RelationListing';
    import {displayError, displaySuccess} from "helpers/messages";
    import {mapActions} from 'vuex';
    import {Avatar} from 'vue-avatar'
    import AssignmentByType from 'components/AssignmentByType';

    const mixin = PostsMixin({mode: 'edit'});

    export default {
        mixins: [mixin, FormatDateTimeMixin],
        components: {
            EditActions,
            RelationList,
            Avatar,
            AssignmentByType
        },
        data() {
            return {
                assignmentsColumns: [{
                    prop: 'name',
                    label: this.$t('general.name')
                }, {
                    prop: 'type',
                    label: this.$t('models.post.assignType'),
                    i18n: this.translateType
                }],
                assignmentsActions: [{
                    width: '180px',
                    buttons: [{
                        title: 'general.unassign',
                        type: 'danger',
                        onClick: this.notifyUnassignment
                    }]
                }],
                assignmentsProviderColumns: [{
                    prop: 'name',
                    label: this.$t('general.name')
                }],
                assignmentsProviderActions: [{
                    width: '180px',
                    buttons: [{
                        title: 'general.unassign',
                        type: 'danger',
                        onClick: this.notifyProviderUnassignment
                    }]
                }],
                activeTab1: "details"
            }
        },
        methods: {
            ...mapActions(['unassignPostBuilding', 'unassignPostDistrict', 'unassignPostProvider', 'deletePost']),
            disabledExecutionStart(date) {
                const d = new Date(date).getTime();
                const executionEnd = new Date(this.model.execution_end).getTime();
                return executionEnd > 0 && d > executionEnd;
            },
            disabledExecutionEnd(date) {
                const d = new Date(date).getTime();
                const executionStart = new Date(this.model.execution_start).getTime();
                return d <= executionStart;
            },
            notifyUnassignment(row) {
                this.$confirm(this.$t(`general.swal.confirmChange.title`), this.$t('general.swal.confirmChange.warning'), {
                    confirmButtonText: this.$t(`general.swal.confirmChange.confirmBtnText`),
                    cancelButtonText: this.$t(`general.swal.confirmChange.cancelBtnText`),
                    type: 'warning'
                }).then(async () => {
                    try {
                        this.loading.status = true;

                        await this.unassign(row);

                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.loading.status = false;
                    }
                }).catch(async () => {
                    this.loading.status = false;
                });
            },
            async unassign(toUnassign) {
                let resp;
                if (toUnassign.aType == 1) {
                    resp = await this.unassignPostBuilding({
                        id: this.model.id,
                        toAssignId: toUnassign.id
                    })
                } else {
                    resp = await this.unassignPostDistrict({
                        id: this.model.id,
                        toAssignId: toUnassign.id
                    })
                }

                if (resp) {
                    await this.fetchCurrentPost();
                    this.$refs.assignmentsList.fetch();

                    this.toAssign = '';

                    const type = toUnassign.aType == 1 ? 'building' : 'district';
                    displaySuccess(resp)
                }
            },
            async unassignProvider(toUnassign) {
                const resp = await this.unassignPostProvider({
                    id: this.model.id,
                    toAssignId: toUnassign.id
                });

                await this.fetchCurrentPost();
                this.$refs.assignmentsProviderList.fetch();

                this.toAssignProvider = '';
                displaySuccess(resp)
            },
            notifyProviderUnassignment(row) {
                this.$confirm(this.$t(`general.swal.confirmChange.title`), this.$t('general.swal.confirmChange.warning'), {
                    confirmButtonText: this.$t(`general.swal.confirmChange.confirmBtnText`),
                    cancelButtonText: this.$t(`general.swal.confirmChange.cancelBtnText`),
                    type: 'warning'
                }).then(async () => {
                    try {
                        this.loading.status = true;

                        await this.unassignProvider(row);

                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.loading.status = false;
                    }
                }).catch(async () => {
                    this.loading.status = false;
                });
            },
            setPinnedTo(val) {
                this.$set(this.model, 'pinned_to', val)
            }
        }
    }
</script>

<style lang="scss" scope>
    .custom-select {
        display: block;
    }
    .contact-info-title {
        display: flex;
        justify-content: center;
        .custom-label {
            color: #6AC06F;
            display: inline-block;
            margin-bottom: 10px;
        }
    }
    .contact-info-content {
        display: flex;
        justify-content: center;
        .custom-value {        
            line-height: 28px;
        }
    }

    .mb20 {
        margin-bottom: 20px;
    }
    
    .contact-info-card {
        .contact-info-card-row {
            display: flex;
            border-bottom: 1px solid #EBEEF5;
            margin-left: 0 !important;
            margin-right: 0 !important;
            &:first-child {
                .contact-info-card-col {
                    padding-top: 0;
                }
            }
            &:last-child {
                border-bottom: 0;
                .contact-info-card-col {
                    padding-bottom: 0;
                }
            }
            .contact-info-card-col {
                &:first-child {
                    padding-left: 0 !important;
                }
                &:last-child {
                    padding-right: 0 !important;
                }
            }
        }
        
        .contact-info-card-col {
            border-right: 1px solid #EBEEF5;
            min-height: 57px;
            padding-bottom: 10px;
            padding-top: 10px;
            &:last-child {
                border: none;
            }
        }
    }

    .tenant-link {
        display: flex;
        align-items: center;
        color: #6AC06F;
        text-decoration: none;

        & > span {
            margin-left: 5px;
        }
    }
</style>

<style>

    #post-edit-view .el-card__body .el-form-item:last-child {
        margin-bottom: 0;
    }

    .edit-post-chat .add-comment {
        margin-bottom: 0 !important;
    }
</style>    