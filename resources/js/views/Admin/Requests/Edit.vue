<template>
    <div class="services-edit mb20" v-if="constants">
        <heading :title="$t('models.request.edit_title')" icon="icon-chat-empty" shadow="heavy">
            <template slot="description" v-if="model.service_request_format">
                <div class="subtitle">{{model.service_request_format}}</div>
            </template>
            <edit-actions :saveAction="submit" :deleteAction="deleteRequest" route="adminRequests"/>
        </heading>
        <div class="crud-view">
            <el-form :model="model" label-position="top" label-width="192px" ref="form">
                <el-row :gutter="20">
                    <el-col :md="12">
                        <card :loading="loading" :header="$t('models.request.request_details')">
                            <el-row :gutter="20">
                                <el-col :md="12">
                                    <el-form-item :label="$t('models.request.category')"
                                                  :rules="validationRules.category"
                                                  prop="category_id">
                                        <el-select :disabled="$can($permissions.update.serviceRequest)"
                                                   :placeholder="$t('models.request.placeholders.category')"
                                                   class="custom-select"
                                                   v-model="model.category_id"
                                                   @change="showFirstLayout">
                                            <el-option
                                                :key="category.id"
                                                :label="category.name"
                                                :value="category.id"
                                                v-for="category in categories">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12"
                                        v-if="this.showfirstlayout == true">
                                    <el-form-item label="Defekt/Mangel">
                                        <el-select :disabled="$can($permissions.update.serviceRequest)"
                                                   placeholder="Select"
                                                   class="custom-select"
                                                   v-model="model.defect"
                                                   @change="showSecondLayout">
                                            <el-option
                                                :key="category.id"
                                                :label="category.name"
                                                :value="category.id"
                                                v-for="category in first_layout_subcategories">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12"
                                        v-if="this.showLiegenschaft == true">
                                    <el-form-item label="Bereich">
                                        <el-select :disabled="$can($permissions.update.serviceRequest)"
                                                   placeholder="Select"
                                                   class="custom-select"
                                                   v-model="model.location">
                                            <el-option value="1">Hauseingang</el-option>
                                            <el-option value="2">Treppenhaus</el-option>
                                            <el-option value="3">Lift</el-option>
                                            <el-option value="4">Tiefgarage</el-option>
                                            <el-option value="5">Waschen/Trocknen</el-option>
                                            <el-option value="6">Technik/Heizung</el-option>
                                            <el-option value="7">Technik/Elektro</el-option>
                                            <el-option value="8">Fassade</el-option>
                                            <el-option value="9">Dach</el-option>
                                            <el-option value="10" selected="">Anderes</el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12"
                                        v-if="this.showUmgebung == true && this.showLiegenschaft == false">
                                    <el-form-item label="Raum">
                                        <el-select :disabled="$can($permissions.update.serviceRequest)"
                                                   placeholder="Select"
                                                   class="custom-select"
                                                   v-model="model.room">
                                            <el-option value="Bad/WC">Bad/WC</el-option>
                                            <el-option value="Du/WC">Du/WC</el-option>
                                            <el-option value="Entrée">Entrée</el-option>
                                            <el-option value="Gang">Gang</el-option>
                                            <el-option value="Keller">Keller</el-option>
                                            <el-option value="Küche">Küche</el-option>
                                            <el-option value="Reduit">Reduit</el-option>
                                            <el-option value="Wohnen">Wohnen</el-option>
                                            <el-option value="Zimmer 1">Zimmer 1</el-option>
                                            <el-option value="Zimmer 2">Zimmer 2</el-option>
                                            <el-option value="Zimmer 3">Zimmer 3</el-option>
                                            <el-option value="Zimmer 4">Zimmer 4</el-option>
                                            <el-option value="Alle">Alle</el-option>
                                            <el-option value="Anderes">Anderes</el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="12"
                                        v-if="model.category_id && selectedCategoryHasQualification(model.category_id)">
                                    <el-form-item :label="$t('models.request.qualification.label')"
                                                  :rules="validationRules.qualification"
                                                  prop="qualification"
                                    >
                                        <el-select :disabled="$can($permissions.update.serviceRequest)"
                                                   :placeholder="$t('models.request.placeholders.qualification')"
                                                   class="custom-select"
                                                   v-model="model.qualification">
                                            <el-option
                                                :key="k"
                                                :label="$t(`models.request.qualification.${qualification}`)"
                                                :value="parseInt(k)"
                                                v-for="(qualification, k) in constants.service_requests.qualification">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row :gutter="20" id="request-summary">
                                <el-col :md="8">
                                    <el-form-item v-if="model.tenant">
                                        <label slot="label">
                                            {{$t('models.request.tenant')}}
                                        </label>
                                        <router-link :to="{name: 'adminTenantsEdit', params: {id: model.tenant.id}}"
                                                     class="tenant-link">
                                            <avatar :size="30"
                                                    :src="'/' + model.tenant.user.avatar"
                                                    v-if="model.tenant.user.avatar"></avatar>
                                            <avatar :size="28"
                                                    :username="model.tenant.user.first_name ? `${model.tenant.user.first_name} ${model.tenant.user.last_name}`: `${model.tenant.user.name}`"
                                                    backgroundColor="rgb(205, 220, 57)"
                                                    color="#fff"
                                                    v-if="!model.tenant.user.avatar"></avatar>
                                            <span>{{model.tenant.first_name}} {{model.tenant.last_name}}</span>
                                        </router-link>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="8">
                                    <el-form-item label="Building">
                                        <strong>{{this.model.building}}</strong>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="8">
                                    <el-form-item label="Creation Datetime">
                                        <strong>{{this.model.created_at}}</strong>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="8" class="summary-item">
                                    <el-form-item :label="$t('models.request.priority.label')">
                                        <strong>{{$constants.service_requests.priority[model.priority]}}</strong>
                                    </el-form-item>
                                </el-col>
                                <el-col :md="8" class="summary-item">
                                    <el-form-item :label="$t('models.request.visibility.label')">
                                        <strong>{{$constants.serviceRequests.visibility[model.visibility]}}</strong>
                                    </el-form-item>
                                </el-col>
                            </el-row>

                            <el-tabs v-model="activeTab1">

                                <el-tab-pane :label="$t('models.request.request_details')" name="request_details">
                                    <el-form-item :label="$t('models.request.prop_title')" :rules="validationRules.title"
                                                  prop="title">
                                        <el-input :disabled="$can($permissions.update.serviceRequest)" type="text"
                                                  v-model="model.title"/>
                                    </el-form-item>
                                    <el-form-item :label="$t('models.request.description')" :rules="validationRules.description"
                                                  prop="description">
                                        <el-input
                                            :autosize="{minRows: 16}"
                                            :disabled="$can($permissions.update.serviceRequest)"
                                            type="textarea"
                                            v-model="model.description">
                                        </el-input>
                                    </el-form-item>
                                </el-tab-pane>

                                <el-tab-pane name="request_images">
                                    <span slot="label">
                                        <el-badge :value="mediaCount" :max="99" class="admin-layout">{{ $t('models.request.images') }}</el-badge>
                                    </span>
                                    <p class="dividerletter">{{$t('models.request.images')}}</p>
                                    <el-divider class="column-divider"></el-divider>
                                    <el-alert
                                        v-if="!media.length || (!model.media && !model.media.length)"
                                        :title="$t('models.request.no_images_message')"
                                        type="info"
                                        show-icon
                                        :closable="false"
                                    >
                                    </el-alert>
                                    <upload-document
                                        @fileUploaded="uploadFiles"
                                        class="drag-custom mt15"
                                        drag
                                        multiple
                                    />
                                    <div class="mt15">
                                        <request-media :data="[...model.media, ...media]" @deleteMedia="deleteMedia"
                                                       v-if="media.length || (model.media && model.media.length)"></request-media>
                                    </div>
                                </el-tab-pane>

                            </el-tabs>

                            <!--                            <el-form-item-->
                            <!--                                :label="$t('models.request.is_public')"-->
                            <!--                                class="switch-item"-->
                            <!--                                prop="is_public"-->
                            <!--                                style=""-->
                            <!--                            >-->
                            <!--                                <el-switch-->
                            <!--                                    :disabled="$can($permissions.update.serviceRequest)"-->
                            <!--                                    style="margin-left: 5px;"-->
                            <!--                                    v-model="model.is_public"-->
                            <!--                                >-->
                            <!--                                </el-switch>-->
                            <!--                            </el-form-item>-->
                            <!--                            <small>{{$t('models.request.public_legend')}}</small>-->
                        </card>
                        <template v-if="$can($permissions.update.serviceRequest)">
                            <card class="mt15" v-if="model.id">
                                <el-divider class="column-divider" content-position="left">
                                    {{$t('models.request.conversation')}}
                                </el-divider>
                                <el-table
                                    :data="conversations"
                                    style="width: 100%">
                                    <el-table-column
                                        :label="$t('models.user.name')"
                                        prop="user.name"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        width="100px"
                                    >
                                        <template slot-scope="scope">
                                            <el-button @click="openConversation(scope.row)" size="mini" type="primary">
                                                {{$t('models.request.open_conversation')}}
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </card>
                            <el-dialog
                                :visible.sync="conversationVisible"
                                width="50%">
                                <chat :id="selectedConversation.id" type="conversation"
                                      v-if="selectedConversation.id" show-templates />
                            </el-dialog>
                        </template>

                    </el-col>
                    <el-col :md="12">
                        <template v-if="$can($permissions.assign.request)">
                            <card :loading="loading" :header="$t('models.request.actions')">
                                <el-row :gutter="10">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.request.status.label')"
                                                      :rules="validationRules.status"
                                                      prop="status">
                                            <el-select :placeholder="$t('models.request.placeholders.status')"
                                                       class="custom-select"
                                                       v-model="model.status">
                                                <el-option
                                                    :key="k"
                                                    :label="$t(`models.request.status.${status}`)"
                                                    :value="parseInt(k)"
                                                    v-for="(status, k) in constants.service_requests.status">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.request.due_date')"
                                                      :rules="validationRules.due_date">
                                            <el-date-picker
                                                :disabled="$can($permissions.update.serviceRequest)"
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
                                </el-row>
                            </card>
                            <card class="mt15" :loading="loading" :header="$t('models.request.assignment')">
                                <assignment-by-type
                                    :resetToAssignList="resetToAssignList"
                                    :assignmentType.sync="assignmentType"
                                    :toAssign.sync="toAssign"
                                    :assignmentTypes="assignmentTypes"
                                    :assign="assignUser"
                                    :toAssignList="toAssignList"
                                    :remoteLoading="remoteLoading"
                                    :remoteSearch="remoteSearchAssignees"
                                />
                                <relation-list
                                    :actions="assigneesActions"
                                    :columns="assigneesColumns"
                                    :filterValue="model.id"
                                    fetchAction="getAssignees"
                                    filter="request_id"
                                    ref="assigneesList"
                                    v-if="model.id"
                                />
                            </card>
                        </template>
                        <!--                    v-if="(!$can($permissions.update.serviceRequest)) || ($can($permissions.update.serviceRequest) && (media.length || (model.media && model.media.length)))"-->
                        <card class="mt15" v-if="model.id">
                            <el-tabs id="comments-card" v-model="activeTab2"  @tab-click="adjustAuditTabPadding">
                                <el-tab-pane :label="$t('models.request.comments')" name="comments">
                                    <chat :id="model.id" type="request" show-templates />
                                </el-tab-pane>
                                <el-tab-pane name="internal-notices">
                                    <span slot="label">
                                        <el-badge value="0" :max="99" class="admin-layout">{{ $t('models.request.internal_notices') }}</el-badge>
                                    </span>
                                </el-tab-pane>
                                <el-tab-pane name="audit" style="height: 400px;overflow:auto;">
                                    <span slot="label">
                                        {{ $t('models.request.audits') }}
                                    </span>
                                    <audit :id="model.id" type="request" showFilter/>
                                </el-tab-pane>
                            </el-tabs>
                        </card>
                    </el-col>
                </el-row>
            </el-form>
        </div>
        <ServiceDialog
            :address="address"
            :conversations="conversations"
            :mailSending="mailSending"
            :managers="model.property_managers"
            :providers="model.service_providers"
            :selectedServiceRequest="selectedServiceRequest"
            :showServiceMailModal="showServiceMailModal"
            :requestData="selectedRequestData"
            @close="closeMailModal"
            @send="sendServiceMail"
            v-if="(model.service_providers && model.service_providers.length) || (model.property_managers && model.property_managers.length)"
        />

    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import RequestsMixin from 'mixins/adminRequestsMixin';
    import ServiceModalMixin from 'mixins/adminServiceModalMixin';
    import {mapActions} from 'vuex';
    import RelationList from 'components/RelationListing';
    import EditActions from 'components/EditViewActions';
    import ServiceDialog from 'components/ServiceAttachModal';
    import {displaySuccess} from "../../../helpers/messages";
    import {Avatar} from 'vue-avatar';
    import Audit from 'components/Audit';
    import AssignmentByType from 'components/AssignmentByType';


    export default {
        name: 'AdminRequestsEdit',
        mixins: [RequestsMixin({
            mode: 'edit'
        }), ServiceModalMixin({
            mode: 'edit'
        })],
        components: {
            Heading,
            Card,
            ServiceDialog,
            RelationList,
            EditActions,
            Avatar,
            Audit,
            AssignmentByType
        },
        data() {
            return {
                activeTab1: 'request_details',
                activeTab2: 'comments',
                conversationVisible: false,
                selectedConversation: {},
                constants: this.$store.getters['application/constants'],
                assigneesColumns: [{
                    prop: 'name',
                    label: this.$t('models.propertyManager.name')
                }, {
                    prop: 'type',
                    label: this.$t('models.request.userType.label'),
                    i18n: this.translateType
                }],
                assigneesActions: [{
                    width: '180px',
                    buttons: [{
                        title: this.$t('models.request.notify'),
                        tooltipMode: true,
                        type: 'success',
                        icon: 'el-icon-message',
                        onClick: this.openNotifyProvider
                    }, {
                        title: this.$t('models.request.unassign'),
                        tooltipMode: true,
                        type: 'danger',
                        icon: 'el-icon-close',
                        onClick: this.notifyUnassignment
                    }]
                }],
                showfirstlayout: false,
                showUmgebung: false,
                showLiegenschaft: false,
                showWohnung: false
            }
        },
        computed: {
            visibilities() {
                if (this.model.tenant && this.model.tenant.building && this.model.tenant.building.district_id) {
                    return this.constants.serviceRequests.visibility;
                } else {
                    return Object.keys(this.constants.serviceRequests.visibility)
                        .filter(key => key != 3)
                        .reduce((obj, key) => {
                            obj[key] = this.constants.serviceRequests.visibility[key];
                            return obj;
                        }, {});
                }
            },
            selectedRequestData() {
                return {
                    tenant: this.model.tenant,
                    service_request_format: this.model.service_request_format,
                    category: (this.model.category.parent_id == null)? this.model.category.name : this.model.category.parentCategory.name + " > " + this.model.category.name
                }
            },
            mediaCount() {
                if(this.model.media) {
                    return this.model.media.length;
                } else {
                    return 0;
                }
            }
        },
        methods: {
            ...mapActions(['unassignAssignee', 'deleteRequest']),
            translateType(type) {
                return this.$t(`models.request.userType.${type}`);
            },
            isDisabled(status) {
                return _.indexOf(this.constants.service_requests.statusByAgent[this.model.status], parseInt(status)) < 0
            },
            notifyUnassignment(provider) {
                this.$confirm(this.$t(`models.request.confirmUnassign.title`), this.$t('models.request.confirmUnassign.warning'), {
                    confirmButtonText: this.$t(`models.request.confirmUnassign.confirmBtnText`),
                    cancelButtonText: this.$t(`models.request.confirmUnassign.cancelBtnText`),
                    type: 'warning'
                }).then(async () => {
                    try {
                        this.loading.status = true;
                        let resp;

                        const payload = {
                            toAssignId: provider.id
                        };

                        
                        resp = await this.unassignAssignee(payload)
                        

                        if (resp && resp.data) {
                            await this.fetchCurrentRequest();
                            this.$refs.assigneesList.fetch();
                            const detachedType = provider.uType === 1 ? 'service' : 'manager';
                            displaySuccess(resp.data);
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
            openNotifyProvider(provider) {
                this.selectedServiceRequest = provider;
                this.showServiceMailModal = true;
            },
            openConversation(row) {
                this.selectedConversation = {};
                this.$nextTick(() => {
                    this.selectedConversation = row;
                    this.conversationVisible = true;
                })
            },
<<<<<<< HEAD
            showFirstLayout() {
                console.log(this.model.category_id);
                if(this.model.category_id == 1) {
                    this.showfirstlayout = true;
                }
            },
            showSecondLayout() {
                console.log(this.model.defect);
                if(this.model.defect == 7) {
                    this.showUmgebung = true;
                }
                else if(this.model.defect == 8) {
                    this.showLiegenschaft = true;
                }
                else if(this.model.defect == 9) {
                    this.showWohnung = true;
=======
            adjustAuditTabPadding(tab){
                // Get the active tab underline
                var active_bar = document.querySelector('#comments-card .el-tabs__active-bar')
                //If the tabs name is internal-notices then modify the width so that it underlines the badge that is positioned absolute
                if(tab.name == 'internal-notices'){
                    setTimeout( () => {
                        active_bar.style.width = '120px'
                    },0)
                }
                //If the tabs name is audit then move the active bar so that it is right under the audit tab-pane
                if(tab.name == 'audit'){
                    setTimeout( () => {
                        active_bar.style.transform = 'translateX(265px)'
                    },0)
>>>>>>> 06441aa5a31b9912096313dd79270630d2c816a6
                }
            }
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

<style lang="scss">
    .switch-item {
        display: flex;
        margin: 0;
        padding: 0;

        .el-form-item__label, .el-form-item__content {
            line-height: 20px;
        }
    }

    .admin-layout .el-badge__content.is-fixed {
        top: 19px;
        right: -5px;
        background-color: #6AC06F;
        margin-left: 5px;
        height: 18px;
        width: 6px;
    }
    #tab-audit{
        padding-left:40px;
    }

    #request-summary {
        background-color: #F3F3F3;
        padding: 2%;
        margin-left: 0px !important;
        margin-right: 0px !important;
        .el-form-item {
            margin-bottom: 0px !important;
            .el-form-item__content {
                line-height: 28px !important;
            }
        }
        .summary-item {
            margin-top: 10px;
            .el-form-item {
                margin-bottom: 0px !important;
                .el-form-item__content {
                    line-height: 28px !important;
                }
            }
        }
    }

</style>
