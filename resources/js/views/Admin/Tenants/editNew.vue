<template>
    <div class="tenants-edit mb20 tenants-edit-new">
        <heading :title="$t('models.tenant.edit_title')" icon="icon-group">
            <edit-actions :saveAction="submit" route="adminTenants"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-col>
                <el-form :model="model" label-position="top" label-width="192px" ref="form">
                    <el-row  :gutter="20">
                        <el-col>
                          <el-card class="chart-card">
                                <el-row :gutter="20">
                                    <h3 class="chart-card-header">
                                        <i class="ti-user"/>
                                        {{ $t('models.tenant.personal_details_card') }}
                                    </h3>
                                </el-row>
                                <el-row :gutter="20">
                                    <el-col :md="4">
                                        <cropper :resize="false" :viewportType="'circle'" @cropped="cropped"/>

                                        <img :src="`/${user.avatar}?${Date.now()}`"
                                             class="user-image"
                                             v-if="avatar.length == 0 && user.avatar">

                                    </el-col>
                                    <el-col :md="10">
                                        <el-row :gutter="20" class="mb20">
                                            <el-col :md="12" >
                                                <el-form-item :label="$t('models.tenant.title')" :rules="validationRules.title"
                                                              prop="title">
                                                    <el-select placeholder="Select" style="display: block" v-model="model.title">
                                                        <el-option
                                                                :key="title"
                                                                :label="$t(`models.tenant.titles.${title}`)"
                                                                :value="title"
                                                                v-for="title in titles">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :md="12" class="right-col">
                                                <el-form-item :label="$t('models.tenant.company')" :rules="validationRules.company"
                                                              prop="company"
                                                              v-if="model.title === titles.company">
                                                    <el-input autocomplete="off" type="text" v-model="model.company"></el-input>
                                                </el-form-item>
                                            </el-col>

                                            <el-col :md="12" class="left-col">
                                                <el-form-item :label="$t('models.tenant.first_name')"
                                                              :rules="validationRules.first_name"
                                                              prop="first_name">
                                                    <el-input autocomplete="off" type="text" v-model="model.first_name"></el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :md="12" class="right-col">
                                                <el-form-item :label="$t('models.tenant.last_name')"
                                                              :rules="validationRules.last_name"
                                                              prop="last_name">
                                                    <el-input autocomplete="off" type="text" v-model="model.last_name"></el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :md="12" class="left-col">
                                                <el-form-item :label="$t('models.tenant.birth_date')"
                                                              :rules="validationRules.birth_date"
                                                              prop="birth_date">
                                                    <el-date-picker
                                                            :placeholder="$t('models.tenant.birth_date')"
                                                            format="dd.MM.yyyy"
                                                            style="width: 100%;"
                                                            type="date"
                                                            v-model="model.birth_date"
                                                            value-format="yyyy-MM-dd"/>
                                                </el-form-item>
                                            </el-col>

                                        </el-row>
                                    </el-col>
                                    <el-col :md='10' class="user-info">
                                  
                                    </el-col>
                                </el-row>
                          </el-card>
                        </el-col>
                        <el-col :md="12">
                           <el-card class="chart-card">
                                <el-row :gutter="20">
                                    <h3 class="chart-card-header">
                                        <i class="ti-user"/>
                                        {{ $t('models.tenant.contact_info_card') }}
                                    </h3>
                                    <el-col :md='12'>
                                        <el-form-item :label="$t('models.tenant.mobile_phone')" prop="mobile_phone">
                                            <el-input autocomplete="off" type="text"
                                                      v-model="model.mobile_phone"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md='12'>
                                        <el-form-item :label="$t('models.tenant.private_phone')" prop="private_phone">
                                            <el-input autocomplete="off" type="text"
                                                      v-model="model.private_phone"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md='12'>
                                        <el-form-item :label="$t('models.tenant.work_phone')" prop="work_phone">
                                            <el-input autocomplete="off" type="text" v-model="model.work_phone"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md='12'>

                                    </el-col>
                                </el-row>
                           </el-card>
                        </el-col>
                        <el-col :md='12'>
                            <el-card class="chart-card">
                                <el-row :gutter="20">
                                    <h3 class="chart-card-header">
                                        <i class="ti-user"/>
                                        {{ $t('models.tenant.account_info_card') }}
                                    </h3>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('email')" :rules="validationRules.email" prop="email">
                                            <el-input autocomplete="off" type="email" v-model="model.email"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.status.label')"
                                                      :rules="validationRules.status"
                                                      prop="status">
                                            <el-select style="display: block" v-model="model.status">
                                                <el-option
                                                        :key="k"
                                                        :label="$t(`models.tenant.status.${status}`)"
                                                        :value="parseInt(k)"
                                                        v-for="(status, k) in constants.tenants.status">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="20">
                                    <el-col :md="12">
                                        <el-form-item :label="$t('password')" :rules="validationRules.password"
                                                      prop="password">
                                            <el-input autocomplete="off" type="password"
                                                      v-model="model.password"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('confirm_password')"
                                                      :rules="validationRules.password_confirmation"
                                                      prop="password_confirmation">
                                            <el-input autocomplete="off" type="password"
                                                      v-model="model.password_confirmation"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-card>
                        </el-col>
                    </el-row>
                </el-form>
                <el-row :gutter="20">
                    <el-col :md="12">
                       <el-card class="chart-card">
                            <el-form :model="model" label-position="top" label-width="192px" ref="form">
                                <el-row :gutter="20">
                                    <h3 class="chart-card-header">
                                        <i class="icon-handshake-o ti-user icon "/>
                                         &nbsp;{{ $t('models.tenant.rent_contract') }}
                                    </h3>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.rent_start')"
                                                      prop="rent_start">
                                            <el-date-picker
                                                    :picker-options="{disabledDate: disabledRentStart}"
                                                    :placeholder="$t('models.tenant.rent_start')"
                                                    format="dd.MM.yyyy"
                                                    style="width: 100%;"
                                                    type="date"
                                                    v-model="model.rent_start"
                                                    value-format="yyyy-MM-dd"/>
                                        </el-form-item>
                                    </el-col>

                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.rent_end')"
                                                      prop="rent_end">
                                            <el-date-picker
                                                    :picker-options="{disabledDate: disabledRentEnd}"
                                                    :placeholder="$t('models.tenant.rent_end')"
                                                    format="dd.MM.yyyy"
                                                    style="width: 100%;"
                                                    type="date"
                                                    v-model="model.rent_end"
                                                    value-format="yyyy-MM-dd"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-form-item>
                                    <el-row :gutter="20">
                                        <el-col :md="12">
                                            <upload-document @fileUploaded="contractUploaded" class="drag-custom" drag/>
                                        </el-col>
                                        <el-col :md="12">
                                            <el-row :gutter="20" class="list-complete-item" justify="center"
                                                    style="margin-bottom: 1em;"
                                                    type="flex"
                                                    v-if="lastMedia && lastMedia.name">
                                                <el-col :span="18">
                                                    <a :href="lastMedia.url" target="_blank"><strong>{{ lastMedia.name}}</strong></a>
                                                </el-col>
                                                <el-col :span="6">
                                                    <el-button @click="deleteMedia" icon="ti-trash" size="mini"
                                                               type="danger"/>
                                                </el-col>
                                            </el-row>
                                            <template v-if="lastMedia && lastMedia.name">
                                                <el-image :src="lastMedia.url" style="width: 100%"
                                                          v-if="isFileImage(lastMedia)"/>
                                                <embed :src="lastMedia.url" style="width: 100%" v-else/>
                                            </template>
                                        </el-col>
                                    </el-row>
                                </el-form-item>
                            </el-form>
                       </el-card>
                    </el-col>
                    <el-col :md="12">
                        <el-card class="chart-card">
                            <el-form :model="model" label-position="top" label-width="192px" ref="form">
                                <el-row :gutter="20">
                                    <h3 class="chart-card-header">
                                        <i class="icon-commerical-building icon"/>
                                        {{ $t('models.tenant.building.name') }}
                                    </h3>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.search_building')" prop="building_id">
                                            <el-select
                                                    :loading="remoteLoading"
                                                    :placeholder="$t('models.tenant.search_building')"
                                                    :remote-method="remoteSearchBuildings"
                                                    :rules="validationRules.building_id"
                                                    @change="searchUnits"
                                                    filterable
                                                    remote
                                                    reserve-keyword
                                                    style="width: 100%;"
                                                    v-model="model.building_id">
                                                <el-option
                                                        :label="`--${$t('models.tenant.no_building')}--`"
                                                        value=""
                                                />
                                                <el-option
                                                        :key="building.id"
                                                        :label="building.name"
                                                        :value="building.id"
                                                        v-for="building in buildings"/>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="12">
                                        <el-form-item :label="$t('models.tenant.unit.name')" prop="unit_id"
                                                      v-if="model.building_id">
                                            <el-select :placeholder="$t('models.tenant.search_unit')" style="display: block"
                                                       v-model="model.unit_id">
                                                <el-option
                                                        :key="unit.id"
                                                        :label="unit.name"
                                                        :value="unit.id"
                                                        v-for="unit in units">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-form>
                        </el-card>
                    </el-col>
                </el-row>

            </el-col>
        </el-row>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import RawGridStatisticsCard from 'components/RawGridStatisticsCard';
    import CircularProgressStatisticsCard from 'components/CircularProgressStatisticsCard';
    import ColoredStatisticsCard from 'components/ColoredStatisticsCard.vue';
    import ProgressStatisticsCard from 'components/ProgressStatisticsCard.vue';
    import AdminTenantsMixin from 'mixins/adminTenantsMixin';
    import UploadDocument from 'components/UploadDocument';
    import {mapActions, mapGetters} from 'vuex';
    import {displayError, displaySuccess} from "helpers/messages";
    import Cropper from 'components/Cropper';
    import EditActions from 'components/EditViewActions';

    const mixin = AdminTenantsMixin({
        mode: 'edit'
    });

    export default {
        mixins: [mixin],
        components: {
            Heading,
            Card,
            RawGridStatisticsCard,
            CircularProgressStatisticsCard,
            ColoredStatisticsCard,
            ProgressStatisticsCard,
            UploadDocument,
            Cropper,
            EditActions
        },
        data() {
            return {
                avatar: '',
            }
        },
        methods: {
            pickFile(){
                this.$refs.userImage.click()
            },
            onFilePicked(e){
                const files = e.target.files
                if(files[0]!==undefined){
                    this.model.avatar = files[0]
                    const fr = new FileReader()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.avatar = fr.result
                    })

                }
            },
            cropped(d) {
                this.avatar = d
            },
            ...mapActions(['deleteMediaFile', 'downloadTenantCredentials', 'sendTenantCredentials']),
            deleteMedia() {
                this.deleteMediaFile({
                    id: this.model.id,
                    media_id: this.lastMedia.id
                }).then(r => {
                    displaySuccess(r);

                    this.model.media.splice(-1, 1);
                }).catch(err => {
                    displayError(err);
                });
            },
            requestEditView(request) {
                this.$router.push({
                    name: 'adminRequestsEdit',
                    params: {
                        id: request.id
                    }
                })
            },
            postEditView(post) {
                this.$router.push({
                    name: 'adminPostsEdit',
                    params: {
                        id: post.id
                    }
                })
            },
            productEditView(product) {
                this.$router.push({
                    name: 'adminProductsEdit',
                    params: {
                        id: product.id
                    }
                })
            },
            async downloadCredentials() {
                this.loading.state = true;
                try {
                    const resp = await this.downloadTenantCredentials({id: this.model.id});
                    if (resp && resp.data) {
                        const url = window.URL.createObjectURL(new Blob([resp.data], {type: resp.headers['content-type']}));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', resp.headers['content-disposition'].split('filename=')[1]);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(url);
                    }
                } catch (e) {
                    displayError({
                        success: false,
                        message: this.$t('models.tenant.credentials_download_failed')
                    })
                } finally {
                    this.loading.state = false;
                }
            },
            async sendCredentials() {
                this.loading.state = true;
                try {
                    const resp = await this.sendTenantCredentials({id: this.model.id});
                    if (resp && resp.data) {
                        displaySuccess({
                            success: true,
                            message: this.$t('models.tenant.credentials_sent')
                        });
                    }
                } catch (e) {
                    displayError({
                        success: true,
                        message: this.$t('models.tenant.credentials_send_fail')
                    });
                } finally {
                    this.loading.state = false;
                }
            },
            requestStatusBadge(status) {
                const colorObject = {
                    1: '#bbb',
                    2: '#ebb563',
                    3: '#ebb563',
                    4: '#67C23A',
                    5: '#ebb563',
                    6: '#67C23A'
                };

                return colorObject[status];
            },
            requestStatusLabel(status) {
                return this.$t(`models.request.status.${this.requestStatusConstants[status]}`)
            },
        },
        computed: {
            ...mapGetters('application', {
                constants: 'constants'
            }),
            lastMedia() {
                return this.model.media[this.model.media.length - 1];
            },
            requestStatusConstants() {
                return this.constants.serviceRequests.status
            }
        }
    }
</script>
<style lang="scss">
    .tenants-edit-new{

        .chart-card{

            .left-col{
                padding-left: 10px!important;
            }

            .right-col{
                padding-right: 10px!important;
            }
        }

        .user-image{
            max-width: 170px;
        }

        .chart-card-header{
            font-size: 18px;
            font-weight: 400;
            padding: 0 10px 20px;
            margin: 0;

            h3 {
                font-size: 24px;
                font-weight: 500;
            }

        }
    }
</style>

<style lang="scss" scoped>
    .tenants-edit {
        .heading {
            margin-bottom: 20px;
        }

        .chart-card{
            margin-bottom: 30px!important;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ededed;
            border-radius: 4px;
            box-shadow: 0 1px 1px 0 transparentize(#000, .2);
        }
        .user-info {
            border-left: 2px dashed #ccc;
        }
        > .el-row > .el-col {
            &:first-of-type .el-card:not(:last-of-type) {
                margin-bottom: 2em;
            }

            &:last-of-type {
                > *:not(:last-of-type) {
                    margin-bottom: 1em;
                }
            }
        }
        .edit-user-image{
            position: absolute;
            right: 0;
            bottom: 5px;
            font-size: 18px;
            background-color: transparentize(#000, .5);
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }
    }
</style>
