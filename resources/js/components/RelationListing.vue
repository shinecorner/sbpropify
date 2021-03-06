<template>
    <div class="listing" v-loading="loading">
        <el-table
            :data="list"
            style="width: 100%"
            >
            <div slot="empty">
                <el-alert                                     
                    :title="$t('general.no_data_available')"
                    type="info"
                    show-icon
                    :closable="false"
                >
                </el-alert>
            </div>
            <el-table-column
                :key="column.prop"
                :width="column.width"
                :align="column.align"
                :label="$t(column.label)"
                :prop="column.prop"
                v-for="column in columns"
                v-if="!column.i18n"
            >
                <template slot-scope="scope">
                    <div v-if="column.type === 'requestTitleWithDesc'">
                        <div class="request-title normal">
                            <router-link :to="{name: 'adminRequestsEdit', params: {id: scope.row.id}}">
                                {{scope.row.title}}
                            </router-link>                               
                        </div>
                        <div class="category">
                        <span v-if="scope.row.category.parentCategory">
                            {{scope.row.category.parentCategory.name}} >&nbsp;
                        </span>
                            <span>
                            {{scope.row.category.name}}
                        </span>
                        </div>
                    </div>

                    <div v-else-if="column.type === 'requestStatus'">
                        {{$t(`models.request.status.${$constants.serviceRequests.status[scope.row.status]}`)}}
                    </div>

                    <div v-else-if="column.type === 'requestTenantAvatar'">
                        <router-link v-if="column.prop" :to="{name: 'adminTenantsEdit', params: {id: scope.row[column.prop].id}}"
                                     class="tenant-link">
                            <el-tooltip
                                    :content="`${scope.row[column.prop].first_name} ${scope.row[column.prop].last_name}`"
                                    class="item"
                                    effect="light" placement="top"
                            >
                                <avatar :size="30"
                                        :src="'/' + scope.row[column.prop].user.avatar"
                                        v-if="scope.row[column.prop].user.avatar"></avatar>
                                <avatar :size="28"
                                        backgroundColor="rgb(205, 220, 57)"
                                        color="#fff"
                                        :username="scope.row[column.prop].user.first_name ? `${scope.row[column.prop].user.first_name} ${scope.row[column.prop].user.last_name}`: `${scope.row[column.prop].user.name}`"
                                        v-if="!scope.row[column.prop].user.avatar"></avatar>
                            </el-tooltip>
                        </router-link>
                        <el-tooltip v-else
                                :content="`${scope.row.first_name} ${scope.row.last_name}`"
                                class="item"
                                effect="light" placement="top"
                        >
                            <avatar :size="30"
                                    :src="'/' + scope.row.user.avatar"
                                    v-if="scope.row.user.avatar"></avatar>
                            <avatar :size="28"
                                    backgroundColor="rgb(205, 220, 57)"
                                    color="#fff"
                                    :username="scope.row.user.first_name ? `${scope.row.user.first_name} ${scope.row.user.last_name}`: `${scope.row.user.name}`"
                                    v-if="!scope.row.user.avatar"></avatar>
                        </el-tooltip>
                    </div>

                    <div v-else-if="column.type === 'buildingTenantAvatars'" class="avatars-wrapper">
                        <span class="tenant-item" :key="uuid()" v-for="(tenant) in scope.row[column.prop].slice(0, column.propLimit)">
                              <el-tooltip
                                      :content="tenant.first_name ? `${tenant.first_name} ${tenant.last_name}`: (tenant.user ? `${tenant.user.name}`:`${tenant.name}`)"
                                      class="item"
                                      effect="light" placement="top">
                                  <template v-if="tenant.user">
                                      <avatar :size="28"
                                              :username="tenant.first_name ? `${tenant.first_name} ${tenant.last_name}`: (tenant.user ? `${tenant.user.name}`:`${tenant.name}`)"
                                              backgroundColor="rgb(205, 220, 57)"
                                              color="#fff"
                                              v-if="!tenant.user.avatar"></avatar>
                                      <avatar :size="28" :src="`/${tenant.user.avatar}`" v-else></avatar>
                                  </template>
                                  <template v-else>
                                      <avatar :size="28"
                                              :username="tenant.first_name ? `${tenant.first_name} ${tenant.last_name}`: `${tenant.name}`"
                                              backgroundColor="rgb(205, 220, 57)"
                                              color="#fff"
                                              v-if="!tenant.avatar"></avatar>
                                      <avatar :size="28" :src="`/${tenant.avatar}`" v-else></avatar>
                                  </template>
                              </el-tooltip>
                        </span>
                        <avatar class="avatar-count" :size="28" :username="`+ ${scope.row[column.count]}`"
                                color="#fff"
                                v-if="scope.row[column.count]"></avatar>
                    </div>

                    <div v-else-if="column.type === 'assignProviderManagerAvatars'">
                        <el-tooltip
                                :content="`${scope.row.name}`"
                                class="item"
                                effect="light" placement="top"
                        >
                            <avatar :size="30"
                                    :src="'/' + scope.row.avatar"
                                    v-if="scope.row.avatar"></avatar>
                            <avatar :size="28"
                                    backgroundColor="rgb(205, 220, 57)"
                                    color="#fff"
                                    :username="scope.row.name"
                                    v-if="!scope.row.avatar"></avatar>
                        </el-tooltip>
                    </div>

                    <div v-else-if="column.type === 'assigneesName'" class="normal">
                        <router-link v-if="scope.row.type === 'manager'" :to="{name: 'adminPropertyManagersEdit', params: {id: scope.row.edit_id}}">
                            {{scope.row.name}}
                        </router-link>
                        <router-link v-if="scope.row.type === 'provider'" :to="{name: 'adminServicesEdit', params: {id: scope.row.edit_id}}">
                            {{scope.row.name}}
                        </router-link>
                        <router-link v-if="scope.row.type === 'user'" :to="{name: 'adminUsersEdit', params: {id: scope.row.edit_id}}">
                            {{scope.row.name}}
                        </router-link>
                        <router-link v-if="scope.row.type === 'quarter'" :to="{name: 'adminQuartersEdit', params: {id: scope.row.id}}">
                            {{scope.row.name}}
                        </router-link>
                        <router-link v-if="scope.row.type === 'building'" :to="{name: 'adminBuildingsEdit', params: {id: scope.row.id}}">
                            {{scope.row.name}}
                        </router-link>
                    </div>
                    <div v-else-if="column.type === 'buildingName'" class="normal">                        
                        <router-link :to="{name: 'adminBuildingsEdit', params: {id: scope.row.id}}">
                            {{scope.row.name}}
                        </router-link>                        
                    </div>
                    <div v-else-if="column.type === 'tenantName'" class="normal">                        
                        <router-link :to="{name: 'adminTenantsView', params: {id: scope.row.id}}">
                            {{scope.row.name}}
                        </router-link>                        
                    </div>
                    <div v-else-if="column.type === 'serviceName'" class="normal">                        
                        <router-link :to="{name: 'adminServicesEdit', params: {id: scope.row.id}}">
                            {{scope.row.name}}
                        </router-link>                        
                    </div>
                    <div v-else>
                        {{scope.row[column.prop]}}
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                :key="column.prop"
                :label="$t(column.label)"
                v-for="column in columns"
                v-if="column.i18n"
            >
                <template slot-scope="scope">
                    <span v-if="column.withBadge">
                        <i :class="`icon-dot-circled ${column.withBadge(scope.row[column.prop])}`"></i>
                        {{column.i18n(scope.row[column.prop])}}
                    </span>
                    <template v-else>
                        {{column.i18n(scope.row[column.prop])}}
                    </template>
                </template>
            </el-table-column>
            <el-table-column
                :key="index"
                :width="action.width"
                align="right"
                v-for="(action, index) in actions"
            >
                <template slot-scope="scope">
                    <el-button
                        :icon="button.icon"
                        :key="button.title"
                        :style="button.style"
                        :type="button.type"
                        @click="button.onClick(scope.row)"
                        size="mini"
                        v-for="button in action.buttons"
                        v-if="!button.tooltipMode">
                        <!-- &nbsp;{{$t(button.title)}}-->
                    </el-button>
                    <el-tooltip
                        :content="$t(button.title)"
                        :key="button.title"
                        class="item" effect="light" placement="top-end"
                        v-for="button in action.buttons"
                        v-if="button.tooltipMode">
                        <el-button
                            :icon="button.icon"
                            :style="button.style"
                            :type="button.type"
                            @click="button.onClick(scope.row)"
                            v-if="(button.view == 'building') || (scope.row.type != 'user' && scope.row.type != 'manager') || button.type == 'danger'"
                            size="mini"
                        >
                        </el-button>
                    </el-tooltip>
                </template>
            </el-table-column>
        </el-table>
        <div v-if="meta.current_page < meta.last_page">
            <el-button @click="loadMore" size="mini" style="margin-top: 15px" type="text">{{$t('general.loadMore')}}</el-button>
        </div>
    </div>
</template>

<script>
    import {Avatar} from 'vue-avatar'
    import uuid from 'uuid/v1'

    export default {
        components: {
            Avatar,
        },
        props: {
            filter: {
                type: [String, Boolean],
                required: true
            },
            filterValue: {
                type: [Number, Boolean],
                required: true
            },
            fetchAction: {
                type: [String, Boolean],
                required: true
            },
            columns: {
                type: Array,
                default() {
                    return [];
                }
            },
            fetchStatus: {
                type: Boolean,
                default: () => true
            },
            actions: {
                type: Array,
                default() {
                    return [];
                }
            },
            addedAssigmentList: {
                type: Array
            }
        },
        data() {
            return {
                list: [],
                meta: {},
                loading: false,
                uuid,
            }
        },
        async created() {
            if (!this.fetchStatus) {
                this.list = this.addedAssigmentList;
            } else {
                await this.fetch();
            }
        },
        async mounted() {
            if (!this.fetchStatus) {
                this.$root.$on('changeLanguage', () => this.fetch());
            }
        },
        watch: {
            addedAssigmentList: {
                immediate: true,
                handler() {
                    this.list = this.addedAssigmentList
                }
            }
        },
        methods: {
            async fetch(page = 1) {
                if (!this.fetchStatus) return;
                this.loading = true;
                try {
                    const resp = await this.$store.dispatch(this.fetchAction, {
                        [this.filter]: this.filterValue,
                        per_page: 5,
                        page
                    });
                    this.meta = _.omit(resp.data, 'data');
                    if (page === 1) {
                        this.list = resp.data.data;
                        if(this.fetchAction == 'getUnits') {
                            this.unitsTypeLabelMap();
                        }
                    } else {
                        this.list.push(...resp.data.data);
                        if(this.fetchAction == 'getUnits') {
                            this.unitsTypeLabelMap();
                        }
                    }
                } catch (e) {
                    console.log(e);
                } finally {
                    this.loading = false;
                }
            },
            unitsTypeLabelMap() {
                this.list.map((unit) => {
                    if(unit.type == 1)
                        unit.typeLabel = this.$t('models.unit.type.apartment');
                    else
                        unit.typeLabel = this.$t('models.unit.type.business');
                })
            },
            loadMore() {
                if (this.fetchStatus && this.meta.current_page < this.meta.last_page) {
                    this.fetch(this.meta.current_page + 1);
                }
            }
        }
    }
</script>
<style lang="scss">
    .el-table .cell, .el-table th div{
        overflow: hidden;
        text-overflow: unset;
    }
    .el-table__empty-text{
        width: 100%;
        .el-alert{
            padding: 0 0;
        }
        .el-alert--info.is-light{
            padding-left: 35%;
        }

    }    
</style>
<style lang="scss" scoped>    
    .request-title {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    .category {
        color: #909399;
    }
    .avatars-wrapper {
        display: inline-flex;
        .tenant-item,
        .avatar-count{
            &:not(:first-child) {
                margin-left: 2px;
            }
        }
    }
    .tenant-link {
        display: inline-block;
        text-decoration: none;
    }
    .tenant-item {
        display: inline-block;
    }
    .badge {
        color: #fff;
        display: flex;
        width: 100px;
        font-size: 12px;
        justify-content: center;
        border-radius: 25px;
    }
    .icon-success {
        color: #5fad64;
    }
    .icon-danger {
         color: #dd6161;
    }
    .request {
        .listing {
            .normal {
                color: var(--primary-color);
                a {
                    text-decoration: none;
                    color:var(--primary-color);

                    &:hover {
                        color:var(--primary-color-lighter);
                    }
                }
                &:hover {
                    text-decoration: none;
                    color:var(--primary-color-lighter);
                }
            }
        }
    }
    .normal {
        color: var(--primary-color);
        a {
            text-decoration: none;
            color:var(--primary-color);

            &:hover {
                color:var(--primary-color-lighter);
            }
        }
        &:hover {
            text-decoration: none;
            color:var(--primary-color-lighter);
        }
    }
</style>
