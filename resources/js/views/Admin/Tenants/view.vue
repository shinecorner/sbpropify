<template>
    <div class="tenants-view">
        <heading :title="$t('models.tenant.view_title')" icon="icon-group">
            <el-form label-position="top" label-width="192px" ref="form">
                <el-form-item>
                    <el-button
                            @click="downloadCredentials"
                            size="small"
                            type="primary"
                            round
                    >
                        {{$t('models.tenant.download_credentials')}}
                    </el-button>
                    <el-button
                            @click="sendCredentials"
                            size="small"
                            type="primary"
                            round
                    >
                        {{$t('models.tenant.send_credentials')}}
                    </el-button>
                    <el-button
                            @click="edit"
                            icon="ti-pencil"
                            round
                            size="small"
                            type="primary"
                    ><span>&nbsp;</span>{{$t('models.tenant.edit')}}
                    </el-button>
                    <el-button
                            @click="goToListing"
                            size="mini"
                            type="warning"
                            round
                    > {{this.$t('actions.close')}}
                    </el-button>
                </el-form-item>
            </el-form>
        </heading>
        <div class="body">
            <el-row :gutter="30">
                <el-col>
                    <el-card class="chart-card">
                        <el-row :gutter="20" class="main-section">
                            <el-col :md="4">
                                <img
                                    src="~img/user-avatar.jpg"
                                    class="user-image"
                                    v-if="model.avatar==null"/>
                                <img
                                        style="width: 100%;"
                                        class="user-image"
                                        :src="`/${user.avatar}?${Date.now()}`"
                                        v-else
                                />
                            </el-col>
                            <el-col :md="7">
                                <h3 class="user-name">{{ model.first_name }} {{ model.last_name }}</h3>
                                <p class="user-info text-secondary" v-if="model.title === titles.company">{{model.company}}</p>
                                <i class="icon-dot-circled" :class="[constants.tenants.status[model.status] === 'active' ? 'icon-success' : 'icon-danger']"></i>
                                {{ $t('models.tenant.status.' + constants.tenants.status[model.status])}}
                            </el-col>
                            <el-col :md="13" class="info">
                                <el-row :gutter="20">

                                    <el-col :sm="8" :xs="12">{{$t('models.tenant.mobile_phone')}}:</el-col>
                                    <el-col :sm="16" :xs="12" class="text-secondary">
                                        {{model.mobile_phone}}
                                    </el-col>

                                    <el-col :sm="8" :xs="12">{{$t('models.tenant.private_phone')}}:</el-col>
                                    <el-col :sm="16" :xs="12" class="text-secondary">
                                        {{ model.private_phone }}
                                    </el-col>

                                    <el-col :sm="8" :xs="12">{{$t('models.tenant.work_phone')}}:</el-col>
                                    <el-col :sm="16" :xs="12" class="text-secondary">
                                        {{ model.work_phone}}
                                    </el-col>

                                    <el-col :sm="8" :xs="12">{{$t('email')}}:</el-col>
                                    <el-col :sm="16" :xs="12" class="text-secondary">
                                       {{ model.email}}
                                    </el-col>

                                    <el-col :sm="8" :xs="12">{{$t('models.tenant.birth_date')}}:</el-col>
                                    <el-col :sm="16" :xs="12" class="text-secondary">{{ new Date(model.birth_date) | formatDate }}&nbsp;</el-col>
                                </el-row>
                            </el-col>
                        </el-row>
                    </el-card>
                </el-col>
                <el-col :md="7" class="left-card">
                   <el-card class="chart-card left-card-data-section">
                        <h3 class="right-card">
                            <i class="ti-user"/>
                            {{$t('models.tenant.rent_contract')}}
                        </h3>
                        <el-row :gutter="20">
                            <el-col :sm="8" :xs="12">{{$t('models.tenant.rent_start')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary" v-if="model.rent_start">
                                {{new Date(model.rent_start) | formatDate }}
                            </el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary" v-else>
                               &#8203;
                            </el-col>

                            <el-col :sm="8" :xs="12">{{$t('models.tenant.rent_end')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary" v-if="model.rent_end">
                                {{  new Date(model.rent_end) | formatDate }}
                            </el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary" v-else>
                                &#8203;
                            </el-col>

                            <el-col v-if="lastMedia" class="media">
                                <a :href="lastMedia.url" target="_blank"><strong>{{lastMedia.name}}</strong></a>
                            </el-col>

                            <el-col v-if="lastMedia">
                                <template v-if="lastMedia && lastMedia.name">
                                    <el-image :src="lastMedia.url" style="width: 100%" v-if="isFileImage(lastMedia)"/>
                                    <embed :src="lastMedia.url" style="width: 100%" v-else/>
                                </template>
                            </el-col>
                        </el-row>
                   </el-card>
                    <el-card class="chart-card left-card-data-section">
                        <h3 class="right-card">
                            <i class="icon-commerical-building icon"/>
                            {{$t('models.tenant.building.name')}}
                        </h3>
                        <el-row :gutter="20">
                            <el-col :sm="8" :xs="12">{{$t('models.tenant.building.name')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary">
                                {{
                                buildings.filter(building => building.id==model.building_id).length>0 ?
                                buildings.filter(building => building.id==model.building_id)[0].name
                                : '&nbsp;'
                                }}
                            </el-col>
                            <el-col :sm="8" :xs="12">{{$t('models.tenant.unit.name')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary">
                                {{
                                units.filter(unit => unit.id==model.unit_id).length>0 ?
                                units.filter(unit => unit.id==model.unit_id)[0].name
                                : '&nbsp;'
                                }}
                            </el-col>

                            <el-col :sm="8" :xs="12">{{$t('models.address.street')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary">
                                {{
                                buildings.filter(building => building.id==model.building_id).length>0 ?
                                buildings.filter(building => building.id==model.building_id)[0].address.street
                                : '&nbsp;'
                                }}
                            </el-col>

                            <el-col :sm="8" :xs="12">{{$t('models.building.house_nr')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary">
                                {{
                                buildings.filter(building => building.id==model.building_id).length>0 ?
                                buildings.filter(building => building.id==model.building_id)[0].address.street_nr
                                : '&nbsp;'
                                }}
                            </el-col>

                            <el-col :sm="8" :xs="12">{{$t('models.address.zip')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary">
                                {{
                                buildings.filter(building => building.id==model.building_id).length>0 ?
                                buildings.filter(building => building.id==model.building_id)[0].address.zip
                                : '&nbsp;'
                                }}
                            </el-col>

                            <el-col :sm="8" :xs="12">{{$t('models.address.city')}}:</el-col>
                            <el-col :sm="16" :xs="12" class="text-secondary">
                                {{
                                buildings.filter(building => building.id==model.building_id).length>0 ?
                                buildings.filter(building => building.id==model.building_id)[0].address.city
                                : '&nbsp;'
                                }}
                            </el-col>
                        </el-row>
                        <el-divider style="margin: 0;"></el-divider>
                        <el-row :gutter="20">
                            <el-col :sm="12" :xs="12">{{$t('models.unit.type.label')}}:</el-col>
                            <el-col :sm="12" :xs="12" class="text-secondary">

                                {{
                                unitTypes.filter(obj => obj.type === unit.type).length > 0 ?
                                $t('models.unit.type.' + unitTypes.filter(obj => obj.type === unit.type)[0].label)
                                : '&nbsp;'
                                }}
                            </el-col>

                            <el-col :sm="12" :xs="12">{{$t('models.unit.room_no')}}:</el-col>
                            <el-col :sm="12" :xs="12" class="text-secondary">
                                {{unit.room_no}}&nbsp;
                            </el-col>

                            <el-col :sm="12" :xs="12">{{$t('models.unit.monthly_rent')}}:</el-col>
                            <el-col :sm="12" :xs="12" class="text-secondary">
                                {{unit.monthly_rent}}&nbsp;
                            </el-col>

                            <el-col :sm="12" :xs="12">{{$t('models.unit.floor')}}:</el-col>
                            <el-col :sm="12" :xs="12" class="text-secondary">
                                {{unit.floor}}&nbsp;
                            </el-col>

                            <el-col :sm="24" :xs="24" v-if="unit.basement">
                                <el-tag size="mini">{{$t('models.unit.basement')}}</el-tag>
                            </el-col>
                            <el-col :sm="24" :xs="24" v-if="unit.attic">
                                <el-tag size="mini">{{$t('models.unit.attic')}}</el-tag>
                            </el-col>
                        </el-row>
                    </el-card>
                </el-col>
                <el-col :md="17">
                    <el-row :gutter="20">
                        <el-col>
                           <el-card class="chart-card">
                                <h3 class="right-card">
                                    <i class="icon-chat-empty icon"/>
                                    {{ $t('models.tenant.requests') }}
                                </h3>
                                <Timeline
                                        :filterValue="model.id"
                                        fetchAction="getRequests"
                                        filter="tenant_id"
                                        v-if="model.id"
                                />
                           </el-card>
                        </el-col>
                        <el-col>
                            <el-card class="chart-card">
                                <h3 class="right-card">
                                    <i class="icon-megaphone-1 icon"/>
                                    {{ $t('models.tenant.posts') }}
                                </h3>
                                <Timeline
                                        :filterValue="user.id"
                                        fetchAction="getPostsTruncated"
                                        filter="user_id"
                                        v-if="!_.isEmpty(user)"
                                />
                            </el-card>
                        </el-col>
                        <el-col>
                            <el-card class="chart-card">
                                <h3 class="right-card">
                                    <i class="icon-basket icon"/>
                                    {{ $t('models.tenant.products') }}
                                </h3>
                                <Timeline
                                        :filterValue="user.id"
                                        fetchAction="getProducts"
                                        filter="user_id"
                                        v-if="!_.isEmpty(user)"
                                />
                            </el-card>
                        </el-col>
                    </el-row>
                </el-col>
            </el-row>
        </div>
    </div>

</template>

<script>
    import Heading from "components/Heading";
    import AdminTenantsMixin from "mixins/adminTenantsMixin";
    import UnitsMixin from 'mixins/adminUnitsMixin';
    import RelationList from "components/RelationListing";
    import Timeline from "components/TenantViewTimeline"
    import {mapActions, mapGetters} from 'vuex';
    import {displayError, displaySuccess} from "helpers/messages";
    import {format} from 'date-fns'

    const mixin = AdminTenantsMixin({
        mode: "view"
    });
    const unitsMixin = UnitsMixin({
        mode: 'add'
    });

    export default {
        mixins: [mixin, unitsMixin],
        components: {
            Heading,
            RelationList,
            Timeline
        },
        data() {
            return {
                requests: [],
                posts: [],
                products: [],

            };
        },
        filters: {
            formatDate(date) {
                return format(date, 'DD.MM.YYYY')
            }
        },
        methods: {
            ...mapActions(['downloadTenantCredentials', 'sendTenantCredentials']),
            edit() {
                this.$router.push({
                    name: "adminTenantsEdit",
                    params: {
                        id: this.$route.params.id
                    }
                });
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
                }
            },
            async sendCredentials() {
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
                }
            },
            goToListing() {
                return this.$router.push({
                    name: 'adminTenants',
                    query: this.queryParams
                })
            },
        },
        computed: {
            ...mapGetters('application', {
                constants: 'constants'
            }),
            lastMedia() {
                return this.model.media[this.model.media.length - 1];
            },
        }
    };

</script>

<style lang="scss" scoped>
   .main-section {
        padding: 8px 0px 0 0 !important;
        margin-left: -5px !important;
    }
    .tenants-view {
        .heading {
            margin-bottom: 20px;
        }

        .body {
            padding: 0 20px;
            .chart-card{
                margin-bottom: 30px !important;
                padding: 10px;
                height: 100%;

                h3 {
                    font-size: 24px;
                    font-weight: 500;
                }

                .right-card {
                    color: var(--text-color);
                    font-size: 18px;
                    font-weight: 400;
                    margin-bottom: 10px;
                    margin-top: 0;
                }

                .user-name {
                    margin-top: 5px;
                    margin-bottom: 0px;
                }

                .user-info {
                    font-size: 13px;
                    margin-top: 0;
                    margin-bottom: 15px;
                }

                .info {
                    border-left: 2px dashed #ccc;
                    padding-left: 30px !important;
                    margin-top: 5px;

                    .el-col {
                        padding-bottom: 10px;
                    }

                    .el-col:nth-last-of-type(1),
                    .el-col:nth-last-of-type(2) {
                        padding-bottom: 0 !important;
                    }
                    a{
                        text-decoration: none;
                        color: #009ce7;
                    }
                }

                .left-card-row {
                    .el-col {
                        font-size: 18px;
                        margin-bottom: 10px;
                    }
                }
                &__body {
                padding: 10px 0 0 0 !important;
            }
            }

            .user-image {
                border-radius: 50%;
                max-height: 150px !important;
                max-width: 150px !important;
            }

            .media {
                margin-top: 20px;
            }

            .media-image {
                margin-top: 30px;
                height: 200px !important;
                max-width: 100% !important;
            }
        }

        .mb-10 {
            margin-bottom: 15px;
        }
        .text-secondary {
            color: #909399;
        }
        .icon-success {
            color: #5fad64;
        }
        .icon-danger {
            color: #dd6161;
        }
    }

</style>
