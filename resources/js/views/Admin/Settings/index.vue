<template>
    <div class="settings">
        <heading :title="$t('models.realEstate.title')" class="custom-heading" icon="ti-settings" shadow="heavy" />

        <el-tabs class="settings-tabs" tab-position="left" v-model="activeName">
            <el-tab-pane name="settings">
                <template slot="label"><i class="icon icon-cog"></i>{{$t('models.realEstate.settings')}}</template>

                <div class="dashboard-tabpanel dashboard-tabpanel_left">
                    <el-tabs type="border-card" v-model="activeSettingsName">
                        <el-tab-pane :label="$t('models.realEstate.settings')" name="settings_settings">
                            <el-button class="save-tab" @click="saveRealEstate('realEstateSettingsForm')" icon="ti-save" type="primary">
                                {{$t('general.actions.save')}}
                            </el-button>
                            <el-form :model="model" :rules="validationRules"
                                     ref="realEstateSettingsForm">
                                <el-row :gutter="20">
                                    <el-col :md="12">

                                        <el-card :header="$t('general.actions.view')">
                                            <el-row :gutter="20">
                                                <el-col :md="12">
                                                    <el-form-item :label="$t('general.name')" :rules="validationRules.name" prop="name">
                                                        <el-input type="text" v-model="model.name"></el-input>
                                                    </el-form-item>
                                                </el-col>
                                                <el-col :md="12">
                                                    <el-form-item :label="$t('general.email')" :rules="validationRules.email" prop="email">
                                                        <el-input type="email" v-model="model.email"></el-input>
                                                    </el-form-item>
                                                </el-col>
                                            </el-row>
                                            <el-row :gutter="20">
                                                <el-col :md="12">
                                                    <el-form-item :label="$t('general.phone')" prop="phone">
                                                        <el-input type="string" v-model="model.phone"></el-input>
                                                    </el-form-item>
                                                </el-col>
                                                <el-col :md="12">
                                                    <el-form-item :label="$t('models.address.street')" :rules="validationRules.street"
                                                                  prop="address.street">
                                                        <el-input autocomplete="off" type="text" v-model="model.address.street"></el-input>
                                                    </el-form-item>
                                                </el-col>
                                            </el-row>
                                            <el-row :gutter="20">
                                                <el-col :md="4">
                                                    <el-form-item :label="$t('general.zip')" :rules="validationRules.zip" prop="address.zip">
                                                        <el-input autocomplete="off" type="text" v-model="model.address.zip"></el-input>
                                                    </el-form-item>
                                                </el-col>
                                                <el-col :md="8">
                                                    <el-form-item :label="$t('general.city')" :rules="validationRules.city"
                                                                  prop="address.city">
                                                        <el-input autocomplete="off" type="text" v-model="model.address.city"></el-input>
                                                    </el-form-item>
                                                </el-col>
                                                <el-col :md="12">
                                                    <el-form-item :rules="validationRules.state_id"
                                                                  prop="address.state.id">
                                                        <label class="card-label">{{$t('models.address.state.label')}}</label>
                                                        <el-select :placeholder="$t('models.address.state.label')" style="display: block"
                                                                   v-model="model.address.state.id">
                                                            <el-option :key="state.id" :label="state.name" :value="state.id"
                                                                       v-for="state in states"></el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </el-col>
                                            </el-row>
                                        </el-card>

                                        <el-card :header="$t('models.realEstate.pdf')">
                                            <el-form-item class="switcher" prop="blank_pdf">
                                                <label class="switcher__label">
                                                    {{$t('models.realEstate.blank_pdf')}}
                                                    <span class="switcher__desc">{{$t('models.realEstate.blank_pdf_desc')}}</span>
                                                </label>
                                                <el-switch v-model="model.blank_pdf"/>
                                            </el-form-item>
                                            <el-form-item prop="model.pdf_font_family">
                                                <label class="card-label">
                                                    {{$t('models.realEstate.font_family')}}
                                                </label>
                                                <el-select
                                                           style="display: block"
                                                           v-model="model.pdf_font_family">
                                                    <el-option :key="font.id"
                                                               :style="`font-family: '${font.label}';`"
                                                               :label="font.label"
                                                               :value="font.label"
                                                               v-for="font in fonts"></el-option>
                                                </el-select>
                                            </el-form-item>
                                        </el-card>
                                    </el-col>
                                    <el-col :md="12">
                                    <!--                        <el-card class="mb20">-->
                                    <!--                            <el-form :model="model" size="mini"-->
                                    <!--                            >-->
                                    <!--                                <div :key="schedule.day" :md="12"-->
                                    <!--                                     class="day-wrapper mb20" v-for="schedule in model.opening_hours ">-->
                                    <!--                                    <div class="day-name">-->
                                    <!--                                        <div class="group-name">{{$t(`general.days.${schedule.day}`)}}</div>-->
                                    <!--                                        <el-switch-->
                                    <!--                                            size="mini"-->
                                    <!--                                            v-model="schedule.closed"-->
                                    <!--                                        >-->
                                    <!--                                        </el-switch>-->
                                    <!--                                    </div>-->
                                    <!--                                    <el-time-picker-->
                                    <!--                                        :end-placeholder="$t('models.realEstate.endTime')"-->
                                    <!--                                        :range-separator="$t('models.realEstate.to')"-->
                                    <!--                                        :start-placeholder="$t('models.realEstate.startTime')"-->
                                    <!--                                        format="HH:mm"-->
                                    <!--                                        is-range-->
                                    <!--                                        style="width: 100%"-->
                                    <!--                                        v-model="schedule.time"-->
                                    <!--                                        value-format="HH:mm">-->
                                    <!--                                    </el-time-picker>-->
                                    <!--                                </div>-->
                                    <!--                            </el-form>-->
                                    <!--                        </el-card>-->

                                    <el-card :header="$t('models.realEstate.settings')">
                                        <!-- <el-form-item :label="$t('models.realEstate.quarter_enable')" prop="quarter_enable">
                                            <el-switch v-model="model.quarter_enable"/>
                                        </el-form-item>
                                        <el-form-item :label="$t('models.realEstate.marketplace_approval_enable')"
                                                      prop="marketplace_approval_enable">
                                            <el-switch v-model="model.marketplace_approval_enable"/>
                                        </el-form-item> -->
                                        <el-form-item class="switcher"
                                                      prop="news_approval_enable">
                                            <label class="switcher__label">
                                                {{$t('models.realEstate.news_approval_enable')}}
                                                <span class="switcher__desc">{{$t('models.realEstate.news_approval_enable_desc')}}</span>
                                            </label>
                                            <el-switch v-model="model.news_approval_enable"/>
                                        </el-form-item>
                                        <el-form-item class="switcher"
                                                      prop="contact_enable">
                                            <label class="switcher__label">
                                                {{$t('models.realEstate.contact_enable')}}
                                                <span class="switcher__desc">{{$t('models.realEstate.contact_enable_desc')}}</span>
                                            </label>
                                            <el-switch v-model="model.contact_enable"/>
                                        </el-form-item>
                                        <el-row :gutter="20">
                                            <el-col :md="12">
                                                <el-form-item :label="$t('models.realEstate.comment_update_timeout')"
                                                              :rules="validationRules.comment_update_timeout"
                                                              prop="comment_update_timeout">
                                                    <el-input autocomplete="off" type="number"
                                                              v-model="model.comment_update_timeout"></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-card>

                                    <el-card :header="$t('models.realEstate.smtp')">
                                        <el-row :gutter="20">
                                            <el-col :md="12">
                                                <el-form-item :label="$t('models.realEstate.mail_from_name.label')"
                                                              prop="mail_from_name"
                                                              :rules="validationRules.mail_from_name"
                                                >
                                                    <el-input autocomplete="off" type="text"
                                                              v-model="model.mail_from_name"></el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :md="12">
                                                <el-form-item :label="$t('models.realEstate.mail_from_address.label')"
                                                              prop="mail_from_address"
                                                              :rules="validationRules.mail_from_address"
                                                >
                                                    <el-input autocomplete="off" type="text"
                                                              v-model="model.mail_from_address"></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                            <el-col :md="12">
                                                <el-form-item :label="$t('models.realEstate.mail_host.label')"
                                                              prop="mail_host"
                                                              :rules="validationRules.mail_host"
                                                >
                                                    <el-input autocomplete="off"
                                                              type="url"
                                                              v-model="model.mail_host"
                                                              class="dis-autofill"
                                                              readonly
                                                              onfocus="this.removeAttribute('readonly');"
                                                    ></el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :md="12">
                                                <el-form-item :label="$t('models.realEstate.mail_port.label')"
                                                              prop="mail_port"
                                                              :rules="validationRules.mail_port"
                                                >
                                                    <el-input autocomplete="off" type="text"
                                                              v-model="model.mail_port"></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                            <el-col :md="12">
                                                <el-form-item required
                                                >
                                                    <label class="card-label">{{$t('models.realEstate.mail_encryption')}}</label>
                                                    <el-select :placeholder="$t('models.realEstate.mail_encryption')" style="display: block"
                                                               v-model="model.mail_encryption">
                                                        <el-option :key="item.id"
                                                                   :label="item"
                                                                   :value="item"
                                                                   v-for="item in mailEncryption"></el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :md="12">
                                                <el-form-item :label="$t('models.realEstate.mail_username.label')"
                                                              prop="mail_username"
                                                              :rules="validationRules.mail_username"
                                                >
                                                    <el-input autocomplete="off" type="text"
                                                              v-model="model.mail_username"></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                                <el-col :md="12">
                                                    <el-form-item :label="$t('models.realEstate.mail_password.label')"
                                                                  :rules="validationRules.mail_password"
                                                                  prop="mail_password"
                                                    >
                                                        <el-input autocomplete="new-password"
                                                                  show-password
                                                                  v-model="model.mail_password"
                                                        ></el-input>
                                                    </el-form-item>
                                                </el-col>
                                                <el-col :md="12">
                                                </el-col>
                                            </el-row>
                                    </el-card>
                                </el-col>
                                </el-row>
                            </el-form>
                        </el-tab-pane>
                        <el-tab-pane :label="$t('models.realEstate.micro_apps')" name="microApps">
                            <el-button class="save-tab" @click="saveRealEstate('microAppsSettingsForm')" icon="ti-save"
                                       type="primary">
                                {{$t('general.actions.save')}}
                            </el-button>
                            <el-form :model="model" :rules="validationRules"
                                     ref="microAppsSettingsForm">
                                <el-card class="marketplace-card">
                                    <el-row :gutter="20">
                                        <el-col :md="8">
                                            <el-form-item class="switcher"
                                                          prop="contact_enable">
                                                <label class="switcher__label">
                                                    {{$t('models.realEstate.iframe_enable')}}
                                                    <span class="switcher__desc">{{$t('models.realEstate.iframe_enable_desc')}}</span>
                                                </label>
                                                <el-switch v-model="model.iframe_enable"/>
                                            </el-form-item>
                                            <el-form-item :label="$t('models.realEstate.iframe_url.label')"
                                                          :rules="validationRules.iframe_url"
                                                          prop="iframe_url"
                                                          v-if="model.iframe_enable">
                                                <el-input autocomplete="off" type="text"
                                                          v-model="model.iframe_url"></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="8">
                                            <el-form-item :label="$t('models.realEstate.gocaution')">
                                                <div>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid, delectus doloribus iusto molestias quam.
                                                </div>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :md="8">
                                            <el-form-item :label="$t('models.realEstate.cleanify_email')"
                                                          :rules="validationRules.cleanify_email" prop="cleanify_email">
                                                <el-input type="email" v-model="model.cleanify_email"></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                </el-card>
                            </el-form>
                        </el-tab-pane>
                        <el-tab-pane :label="$t('models.realEstate.theme')" name="theme">
                            <el-button class="save-tab" @click="saveRealEstate('themeSettingsForm')" icon="ti-save"
                                       type="primary">
                                {{$t('general.actions.save')}}
                            </el-button>
                            <el-form :model="model" :rules="validationRules"
                                     ref="themeSettingsForm">
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-card>
                                            <el-form-item :label="$t('models.user.logo')">
                                                <!-- <cropper @cropped="setLogoUpload"/> -->
                                                <!-- <img :src="realEstateLogo" ref="realEstateLogo"
                                                     v-show="realEstateLogo || model.logo_upload"
                                                     width="300px"> -->
                                                <upload-avatar @imageUploaded="setAvatarLogoUpload"/>
                                                <img :src="logo_upload_img"
                                                     v-show="logo_upload_img"
                                                     >
                                                <img :src="realEstateLogo" ref="realEstateLogo"
                                                     v-show="realEstateLogo && !logo_upload_img"
                                                    >
                                                
                                            </el-form-item>
                                            <el-form-item :label="$t('models.user.circle_logo')">
                                                <upload-avatar @imageUploaded="setCircleLogoUpload"/>
                                                <img :src="circle_logo_upload_img"
                                                     v-show="circle_logo_upload_img"
                                                    >
                                                <img :src="realEstateCircleLogo" ref="realEstateCircleLogo"
                                                     v-show="realEstateCircleLogo && !circle_logo_upload_img"
                                                    >
                                            </el-form-item>
                                            <!-- <el-form-item :label="$t('models.user.favicon_icon')">
                                                <upload-avatar @imageUploaded="setFaviconIconUpload"/>
                                                <img :src="favicon_icon_upload_img"
                                                     v-show="favicon_icon_upload_img"
                                                    >
                                                <img :src="realEstateFaviconIcon" ref="realEstateFaviconIcon"
                                                     v-show="realEstateFaviconIcon && !favicon_icon_upload_img"
                                                    >
                                            </el-form-item> -->
                                            <el-form-item :label="$t('models.user.tenant_logo')">
                                                <upload-avatar @imageUploaded="setTenantLogoUpload"/>
                                                <img :src="tenant_logo_upload_img"
                                                     v-show="tenant_logo_upload_img"
                                                    >
                                                <img :src="realEstateTenantLogo" ref="realEstateTenantLogo"
                                                     v-show="realEstateTenantLogo && !tenant_logo_upload_img"
                                                     >
                                            </el-form-item>
                                            <el-form-item :label="$t('models.realEstate.primary_color')">
                                                <el-color-picker
                                                        size="medium"
                                                        v-model="model.primary_color"></el-color-picker>
                                            </el-form-item>
                                            <!-- <el-form-item :label="$t('models.realEstate.accent_color')">
                                                <el-color-picker
                                                        size="medium"
                                                        v-model="model.accent_color">
                                                </el-color-picker>
                                            </el-form-item> -->
                                        </el-card>
                                    </el-col>
                                </el-row>
                            </el-form>
                        </el-tab-pane>
                    </el-tabs>
                </div>

            </el-tab-pane>
            <el-tab-pane name="requests">
                <template slot="label"><i class="icon icon-chat-empty"></i>{{$t('general.requests')}}</template>

<!--                <heading :title="$t('general.requests')" class="custom-heading" icon="ti-settings" shadow="heavy" />-->

                <div class="dashboard-tabpanel dashboard-tabpanel_left">
                    <el-tabs type="border-card" v-model="activeRequestName">
<!--                        <el-tab-pane :label="$t('models.realEstate.categories')" name="categories">-->
<!--                            <CategoriesListing/>-->
<!--                        </el-tab-pane>-->
                        <el-tab-pane :label="$t('models.realEstate.templates')" name="templates">
                            <TemplatesListing/>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </el-tab-pane>
            <el-tab-pane name="tenants">
                <template slot="label"><i class="icon icon-group"></i>{{$t('models.realEstate.tenants_portal')}}</template>

                <div class="dashboard-tabpanel dashboard-tabpanel_left">
                    <el-tabs type="border-card" v-model="activeTenantsName">
                        <el-tab-pane :label="$t('models.realEstate.login_variations')" name="login_variations">
                            <el-button class="save-tab" @click="saveRealEstate('tenantsLoginVariationsForm')" icon="ti-save"
                                       type="primary">
                                {{$t('general.actions.save')}}
                            </el-button>

                            <el-form :model="model" :rules="validationRules"
                                     ref="tenantsLoginVariationsForm">

                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-card>
                                            <el-radio-group class="login-radio-group" v-model="model.login_variation">
                                                <el-row :gutter="20">
                                                    <el-col :md="12">
                                                        <el-radio class="login-radio" :label="1">
                                                            <div class="login-card">
                                                                <div class="login-card__img"></div>
                                                                <div class="login-card__content">
                                                                    <div class="login-card__title">{{$t('models.realEstate.login_variation')}} 1</div>
                                                                </div>
                                                            </div>
                                                        </el-radio>
                                                    </el-col>
                                                    <el-col :md="12">
                                                        <el-radio class="login-radio" :label="2">
                                                            <div class="login-card">
                                                                <div class="login-card__img"></div>
                                                                <div class="login-card__content">
                                                                    <div class="login-card__title">{{$t('models.realEstate.login_variation')}} 2</div>
                                                                </div>
                                                            </div>
                                                        </el-radio>
                                                    </el-col>
                                                </el-row>
                                            </el-radio-group>
                                            <el-form-item v-if="model.login_variation === 1"
                                                          class="switcher mt-20"
                                                          prop="login_variation_1_slider"
                                            >
                                                <label class="switcher__label">{{$t('models.realEstate.login_variation_slider')}}</label>
                                                <el-switch v-model="model.login_variation_1_slider"/>
                                            </el-form-item>
                                            <el-form-item v-if="model.login_variation === 2"
                                                          class="switcher mt-20"
                                                          prop="login_variation_2_slider"
                                            >
                                                <label class="switcher__label">{{$t('models.realEstate.login_variation_slider')}}</label>
                                                <el-switch v-model="model.login_variation_2_slider"/>
                                            </el-form-item>
                                            
                                        </el-card>
                                    </el-col>
                                </el-row>
                            </el-form>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script>
    import Heading from 'components/Heading';
    import Cropper from 'components/Cropper';
    import UploadAvatar from 'components/UploadAvatar';
    import {mapActions} from 'vuex';
    import {displayError, displaySuccess} from 'helpers/messages';
    import CategoriesListing from './Categories'
    import TemplatesListing from '../Templates'

    export default {
        name: 'AdminProfile',
        components: {
            Heading,
            Cropper,
            UploadAvatar,
            CategoriesListing,
            TemplatesListing
        },
        data() {
            return {
                model: {
                    name: '',
                    email: '',
                    phone: '',
                    blank_pdf: true,
                    quarter_enable: true,
                    logo: '',
                    circle_logo: '',
                    favicon_icon: '',
                    tenant_logo: '',
                    logo_upload: '',
                    tenant_logo: '',
                    circle_logo_upload: '',
                    favicon_icon_upload: '',
                    tenant_logo_upload: '',
                    tenant_logo_upload: '',
                    marketplace_approval_enable: true,
                    news_approval_enable: false,
                    comment_update_timeout: 60,
                    iframe_url: '',
                    mail_from_name: '',
                    mail_from_email: '',
                    mail_host: '',
                    mail_port: '',
                    mail_username: '',
                    mail_password: '',
                    cleanify_email: '',
                    address: {
                        state: {}
                    },
                    contact_enable: false,
                    accent_color: '',
                    primary_color: '',
                    login_variation: '',
                    login_variation_2_slider: false,
                    pdf_font_family: '',
                },
                logo_upload_img: '',
                circle_logo_upload_img: '',
                favicon_icon_upload_img: '',
                tenant_logo_upload_img: '',
                activeName: 'settings',
                activeSettingsName: 'settings_settings',
                activeRequestName: 'templates',
                activeTenantsName: 'login_variations',
                states: [],
                mailEncryption: [
                    'tls',
                    'ssl'
                ],
                fonts: [{
                    label: 'Arial'
                }, {
                    label: 'Times New Roman'
                }]
            }
        },
        async created() {
            await this.fetchRealEstate();
            

            if (this.$route.query.tab) {
                this.goToTab(this.$route.query.tab);
            }
        },
        mounted() {
            this.model.accent_color = this.model.accent_color ?
                this.model.accent_color :
                this.$constants.colors.accent_color;

            this.model.primary_color = this.model.primary_color ?
                this.model.primary_color :
                this.$constants.colors.primary_color;

            this.$root.$on('changeLanguage', () => this.fetchRealEstate());
        },
        computed: {
            realEstateLogo() {
                return this.model.logo ? `/${this.model.logo}?${Date.now()}` : '';
            },
            realEstateCircleLogo() {
                return this.model.circle_logo ? `/${this.model.circle_logo}?${Date.now()}` : '';
            },
            realEstateFaviconIcon() {
                return this.model.favicon_icon ? `/${this.model.favicon_icon}?${Date.now()}` : '';
            },
            realEstateTenantLogo() {
                return this.model.tenant_logo ? `/${this.model.tenant_logo}?${Date.now()}` : '';
            },
            validationRules() {
                setTimeout(() => {this.validateForm('realEstateSettingsForm')}, 0);
                return {
                    email: [{
                        required: true,
                        message: this.$t("general.email_validation.required")
                    },
                        {
                            type: 'email',
                            message: this.$t("general.email_validation.email")
                        }
                    ],
                    name: [{
                        required: true,
                        message: this.$t("models.user.validation.name.required")
                    }],
                    iframe_url: [{
                        type: 'url',
                        message: this.$t("models.realEstate.iframe_url.validation")
                    }],
                    cleanify_email: [{
                        type: 'email',
                        message: this.$t("general.email_validation.email")
                    }],
                    mail_from_name: [{
                        required: true,
                        message: this.$t("models.realEstate.mail_from_name.validation")
                    }],
                    mail_from_address: [{
                        required: true,
                        message: this.$t("models.realEstate.mail_from_address.required")
                    },
                        {
                            type: 'email',
                            message: this.$t("models.realEstate.mail_from_address.email")
                        }
                    ],
                    mail_host: [{
                        required: true,
                        message: this.$t("models.realEstate.mail_host.validation")
                    }],
                    mail_port: [{
                        required: true,
                        message: this.$t("models.realEstate.mail_port.validation")
                    }],
                    mail_username: [{
                        required: true,
                        message: this.$t("models.realEstate.mail_username.validation")
                    }],
                    mail_password: [{
                        required: true,
                        message: this.$t("models.realEstate.mail_password.validation")
                    }]
                }
            }
        },
        methods: {
            ...mapActions(['getRealEstate', 'updateRealEstate', 'getStates']),
            goToTab(tabName) {
                this.activeName = tabName;
            },
            validateForm(formName) {
                this.$refs[formName].clearValidate();
            },
            fetchRealEstate() {
                this.getStates().then((resp) => {
                    this.states = resp.data;
                });
                this.getRealEstate().then((resp) => {
                    this.model = Object.assign({}, this.model, resp.data);
                    this.$root.$emit('fetch_logo', this.model.logo);
                    try {
                        this.$set(this.model, 'opening_hours', JSON.parse(this.model.opening_hours));
                    } catch (e) {

                    }

                }).catch((error) => {
                    displayError(error);
                });
            },
            saveRealEstate(form) {
                this.$refs[form].validate((valid) => {
                    if (valid) {
                        this.updateRealEstate(this.model).then((resp) => {
                            this.fetchRealEstate();
                            displaySuccess(resp);
                            
                        }).catch((error) => {
                            displayError(error);
                        });
                    }
                });
            },
            setLogoUpload(image) {
                this.model.logo_upload = image;
            },
            setAvatarLogoUpload(image) {
                this.model.logo_upload = image;
                this.logo_upload_img = "data:image/png;base64," + image;
            },
            setCircleLogoUpload(image) {
                this.model.circle_logo_upload = image;
                this.circle_logo_upload_img = "data:image/png;base64," + image;
            },
            setFaviconIconUpload(image) {
                this.model.favicon_icon_upload = image;
                this.favicon_icon_upload_img = "data:image/png;base64," + image;
            },
            setTenantLogoUpload(image) {
                this.model.tenant_logo_upload = image;
                this.tenant_logo_upload_img = "data:image/png;base64," + image;
            },
        },
        watch: {
            activeName(newTab, oldTab) {
                this.$router.push({
                    name: 'adminSettings',
                    query: {
                        tab: newTab
                    }
                });
            }
        }
    }

</script>

<style lang="scss">
    .dashboard-tabpanel{
        .el-tabs--border-card > .el-tabs__header .el-tabs__item{
            flex-basis: 0;
            -webkit-box-flex: 1;
            flex-grow: 1;
            text-align: center;
            color: #495057;
            cursor: pointer;
            font-weight:400;
            -webkit-box-align: center;
            align-items: center;
            text-align: center;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 0 13px !important;

            &.is-active, &:hover{
                background: var(--primary-color);
                //border-radius: 120px;
                border-right-color: none;
                border-left-color: none;
                -ms-flex-positive: 1;
                color: #fff !important;
                transition: background-color .3s ease,color .3s ease !important;
            }

            &:hover{
                background: var(--primary-color-lighter);;
            }

            &:first-child {
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
            }

            &:last-child {
                border-top-right-radius: 5px;
                border-bottom-right-radius: 5px;
            }
        }
        .el-tabs__nav {
            float: none;
            text-align: center;
            border-radius: 120px;
            padding: .75rem;
            display: flex;
            flex-wrap: wrap;
            width: fit-content;
            margin: 1.5rem 0 1.5em auto;

            @media screen and (max-width: 1000px) {
                margin: 1.5rem auto;
            }
        }
        .el-tabs--border-card{
            background:none;
        }
        .el-tabs--border-card{
            border: none;
            background: none;
            box-shadow: none;
        }
        .el-tabs--border-card > .el-tabs__header{
            border-bottom: none !important;
            background: none !important;
        }
        .chart-card{
            //height: 420px;

            overflow: visible;

            .el-card__header {
                padding: 15px;
                font-size: 15px;
            }

            .dashboard-table {
                position: relative;

                .link-container {
                    position: absolute;
                    top: -55px;
                    right: 0px;
                    text-align: right;
                    padding: 20px 15px;
                    font-size: 14px;

                    a {
                        text-decoration: none;
                        color: #525252;

                        &:hover {
                            color: #303133;
                        }
                    }
                }
            }

            .chart-filter {
                display: flex;
                align-items: center;

                &.in-toolbar {
                    position: absolute;
                    top: -42px;
                    right: 50px;

                    background-color: transparent;
                    border-bottom: none;
                    padding: 0;
                }

                .el-radio-button__inner {
                    padding: 8px 12px;
                    font-weight: 400;
                }

                .el-date-editor {
                    width: 135px;

                    .el-input__inner {
                        height: 33px;
                        line-height: 33px;
                    }

                    .el-input__icon {
                        display: flex;
                        justify-content: center;
                        align-items: center;

                        &.el-range__close-icon {
                            display: none;
                        }
                    }
                }

                .el-date-editor--week {
                    width: 160px;

                    input {
                        text-align: center;
                        padding-right: 10px;
                    }

                    .el-input__suffix {
                        display: none;
                    }
                }

                .el-range-editor {
                    width: 250px;
                    padding: 0 0 0 7px;
                    height: 32px;
                    line-height: 32px;

                    .el-range-separator {
                        width: 6%;
                    }
                }
            }

            .apexcharts-toolbar {
                // margin-top: -88px;
                margin-top: -38px;
                margin-right: 7px;
                .apexcharts-menu.open {
                    right: 7px;
                }
            }

            .apexcharts-legend.center.position-bottom {
                padding-top: 10px;
            }

            .el-tabs {
                .el-tabs__header {
                    margin-bottom: 0;
                    .el-tabs__nav {
                        margin: 0;
                        padding: 6px 0;
                        margin-left: 15px;

                        .el-tabs__item {
                            font-size: 15px;
                            font-weight: 400;
                        }
                    }
                }

                .el-tabs__content {
                    overflow: visible;
                }
            }
        }
    }

    .mt-20 {
        margin-top: 20px;
    }

    .settings-tabs.el-tabs.el-tabs--left {
        overflow: auto;
        height: calc(100% - 100px);
        > .el-tabs__header.is-left {
            margin-top: 20px;
            margin-left: 20px;
            position: sticky;
            top: 0;
            min-width: 200px;
            height: 100%;
            box-shadow: inset 7px 0 5px -7px rgba(0,0,0,0.2);
            border-radius: 10px;
            background: #fff;
            .el-tabs__nav-wrap {
                &:after {
                    background: transparent;
                }
            }
            .el-tabs__active-bar {
                display: none;
            }
            .el-tabs__item.is-left {
                height: 50px;
                line-height: 50px;
                border-bottom: 1px #ebebeb solid;
                text-align: left;
                .icon {
                    margin-right: 8px;
                }
                &:hover {
                    background: var(--primary-color-lighter);
                }
            }
        }
    }

    .dashboard-tabpanel_left {
        .el-tabs__nav {
            margin: 1.5rem auto 1.5em 0;
        }
        .el-tabs__content {
            overflow: visible;
        }
        .save-tab {
            position: absolute;
            top: -72px;
            right: 20px;
        }
    }

    .switcher {
        .el-form-item__content {
            display: flex;
            align-items: center;
        }
        &__label {
            line-height: 1.4em;
            color: #606266;
        }
        &__desc {
            margin-top: 0.5em;
            display: block;
            font-size: 0.9em;
        }
        .el-switch {
            margin-left: auto;
        }
    }

    .el-radio-group.login-radio-group {
        display: block;
    }

    .el-radio.login-radio {
        display: block;
        .el-radio__input {
            display: none;
        }
        .el-radio__label {
            display: block;
            padding: 0;
        }
        &.is-checked {
            .login-card {
                box-shadow: none;
                border: 1px var(--primary-color) solid;
            }
        }
    }

    .login-card {
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        border: 1px #e0e0e0 solid;
        border-radius: 6px;
        transition: all 0.3s;
        &__img {
            min-height: 100px;
            overflow: hidden;
            border-bottom: 1px #e0e0e0 solid;
        }
        &__content {
            padding: 8px;
            white-space: normal;
        }
        &__title {
            line-height: 1.4em;
            font-weight: bold;
        }
    }

    .dis-autofill input {
        cursor: text;
    }

    .settings {
        min-height: calc(100% - 56px - 2rem);

        .requestCategories {
            .heading {
                padding: 0;
                position: absolute;
                top: -82px;
                right: 20px;
            }
            .list-table {
                padding: 0;
            }
        }

        .templates {
            .list-table {
                padding: 0;
            }
        }

        .custom-heading {
            margin-bottom: 20px;
        }

        .el-card {
            border-radius: 6px;
            box-shadow: 0 1px 3px transparentize(#000, .88),
            0 1px 2px transparentize(#000, .76);
            position: relative;

            + .el-card {
                margin-top: 20px;
            }

            .el-form {
                /*max-width: 512px;*/

                .el-button :global([class*="ti"]) {
                    margin-right: 8px;
                }
            }

            .card-label {
                float: none;
                text-align: left;
                color: #606266;
                line-height: 40px;
            }

            .el-form-item:only-child {
                margin-bottom: 0;
            }
        }
    }

    .group-name {
        text-align: left;
        padding-right: 10px;
        box-sizing: border-box;
        font-size: 16px;
        font-weight: bold;
        color: #6AC06F;
        text-transform: capitalize;
        width: 100px;
    }

    .day-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .day-name {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .marketplace-card .el-form-item {
        .el-form-item__label {
            display: block;
            margin-bottom: 5px;
            line-height: 20px;
            float: none;
            text-align: left;
        }
        .el-form-item__content {
            line-height: 28px;
        }
    }

</style>
