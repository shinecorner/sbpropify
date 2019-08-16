<template>
    <div class="services-edit">
        <heading :title="$t('models.propertyManager.edit_title')" :subtitle="model.property_manager_format" icon="icon-users" shadow="heavy">
            <edit-actions :saveAction="submit" :deleteAction="deletePropertyManager" route="adminPropertyManagers"/>
        </heading>
        <div class="crud-view">
            <el-form :model="model" label-position="top" label-width="192px" ref="form">
                <el-row :gutter="20">
                    <el-col :md="12">
                        <el-tabs type="border-card" v-model="activeTab">
                            <el-tab-pane :label="$t('models.propertyManager.details_card')" name="details">
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.title')" :rules="validationRules.title"
                                                    prop="title">
                                            <el-select style="display: block" v-model="model.title">
                                                <el-option
                                                    :key="title"
                                                    :label="$t(`models.propertyManager.titles.${title}`)"
                                                    :value="title"
                                                    v-for="title in titles">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.firstName')"
                                                      :rules="validationRules.first_name"
                                                      prop="first_name">
                                            <el-input type="text" v-model="model.first_name"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.lastName')"
                                                      :rules="validationRules.last_name"
                                                      prop="last_name">
                                            <el-input type="text" v-model="model.last_name"/>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.profession')"
                                                      :rules="validationRules.profession"
                                                      prop="profession">
                                            <el-input type="text" v-model="model.profession"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>


                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.phone')" prop="user.phone">
                                            <el-input type="text" v-model="model.user.phone"/>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.email')"
                                                      :rules="validationRules.email"
                                                      prop="user.email">
                                            <el-input type="email" v-model="model.user.email"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :gutter="20">
                                    <el-col :md="24">
                                        <el-form-item :label="$t('models.propertyManager.slogan')"
                                                      :rules="validationRules.slogan"
                                                      prop="slogan">
                                            <el-input type="text" v-model="model.slogan"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                            </el-tab-pane>
                            <el-tab-pane :label="$t('models.propertyManager.profile_card')" name="profile">
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.password')"
                                                      :rules="validationRules.password"
                                                      autocomplete="off"
                                                      prop="user.password">
                                            <el-input type="password" v-model="model.user.password"/>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.confirm_password')"
                                                      :rules="validationRules.password_confirmation"
                                                      prop="user.password_confirmation">
                                            <el-input type="password" v-model="model.user.password_confirmation"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-form-item :label="$t('models.user.profile_image')">
                                    <cropper :resize="false" :viewportType="'circle'" @cropped="cropped"/>
                                    <img :src="`/${model.user.avatar}?${Date.now()}`"
                                         style="width: 100%;max-width: 200px;"
                                         v-if="!avatar.length && model.user.avatar">
                                </el-form-item>
                                <el-form-item :label="$t('models.tenant.language')" :rules="validationRules.language" 
                                        prop="settings.language">
                                    <select-language :model.sync="model.settings.language"/>
                                </el-form-item>
                            </el-tab-pane>
                            <el-tab-pane :label="$t('models.propertyManager.social_card')" name="social">
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.linkedin_url')"
                                                      :rules="validationRules.linkedin_url"
                                                      prop="linkedin_url">
                                            <el-input type="text" v-model="model.linkedin_url">
                                                <template slot="prepend"><i class="icon-linkedin"></i></template>
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.propertyManager.xing_url')"
                                                      :rules="validationRules.xing_url"
                                                      prop="xing_url">
                                            <el-input type="text" v-model="model.xing_url">
                                                <template slot="prepend"><i class="icon-xing"></i></template>
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-tab-pane>
                        </el-tabs>
                    </el-col>
                    <el-col :md="12">
                        <card :loading="loading">
                            <el-divider class="column-divider" content-position="left">
                                {{$t('models.post.assignment')}}
                            </el-divider>
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
                                fetchAction="getAssignments"
                                filter="manager_id"
                                ref="assignmentsList"
                                v-if="model.id"
                            />
                        </card>
                        <card :loading="loading" class="mt15">
                            <el-divider class="column-divider" content-position="left">
                                {{$t('models.propertyManager.requests')}}
                            </el-divider>

                            <relation-list
                                :actions="requestActions"
                                :columns="requestColumns"
                                :filterValue="model.user.id"
                                fetchAction="getRequests"
                                filter="assignee_id"
                                v-if="model.user && model.user.id"
                            />
                        </card>
                    </el-col>
                </el-row>
            </el-form>
        </div>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import PropertyManagersMixin from 'mixins/adminPropertyManagersMixin';
    import Cropper from 'components/Cropper';
    import RelationList from 'components/RelationListing';
    import EditActions from 'components/EditViewActions';
    import {mapGetters, mapActions} from 'vuex';
    import globalFunction from "helpers/globalFunction";
    import SelectLanguage from 'components/SelectLanguage';
    import AssignmentByType from 'components/AssignmentByType';

    export default {
        name: 'AdminPropertyManagersEdit',
        mixins: [globalFunction, PropertyManagersMixin({
            mode: 'edit'
        })],
        components: {
            Heading,
            Card,
            Cropper,
            RelationList,
            EditActions,
            SelectLanguage,
            AssignmentByType
        },
        data() {
            return {
                activeTab: "details",
                requestColumns: [{
                    prop: 'category.name',
                    label: this.$t('models.request.category')
                }, {
                    prop: 'status',
                    withBadge: this.requestStatusBadge,
                    label: this.$t('models.request.status.label'),
                    i18n: this.translateRequestStatus
                }],
                requestActions: [{
                    width: '90px',
                    buttons: [{
                        icon: 'ti-pencil',
                        title: this.$t('models.request.edit'),
                        onClick: this.requestEditView
                    }]
                }],
                assignmentsColumns: [{
                    prop: 'name',
                    label: this.$t('models.district.name')
                }, {
                    prop: 'type',
                    label: this.$t('models.propertyManager.assignType'),
                    i18n: this.translateType
                }],
                assignmentsActions: [{
                    width: '180px',
                    buttons: [{
                        title: this.$t('models.propertyManager.unassign'),
                        type: 'danger',
                        onClick: this.notifyUnassignment
                    }]
                }]
            }
        },
        methods: {
            ...mapActions(['deletePropertyManager']),
            requestEditView(row) {
                this.$router.push({
                    name: 'adminRequestsEdit',
                    params: {
                        id: row.id
                    }
                })
            },
            translateType(type) {
                return this.$t(`models.propertyManager.assignmentTypes.${type}`);
            },
            translateRequestStatus(status) {
                return this.$t(`models.request.status.${this.requestStatusConstants[status]}`);
            },
            notifyUnassignment(row) {
                this.$confirm(this.$t(`models.propertyManager.confirmUnassign.title`), this.$t('models.propertyManager.confirmUnassign.warning'), {
                    confirmButtonText: this.$t(`models.propertyManager.confirmUnassign.confirmBtnText`),
                    cancelButtonText: this.$t(`models.propertyManager.confirmUnassign.cancelBtnText`),
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

            requestStatusBadge(status) {                
                return this.getRequestStatusColor(status);
            },
        },
        computed: {
            ...mapGetters('application', {
                constants: 'constants'
            }),
            requestStatusConstants() {
                return this.constants.serviceRequests.status
            }
        }
    }
</script>

<style lang="scss" scoped>
    .services-edit {
        .heading {
            margin-bottom: 20px;
        }
    }
</style>
