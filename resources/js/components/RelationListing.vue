<template>
    <div class="listing" v-loading="loading">
        <el-table
            :data="list"
            style="width: 100%"
            @row-click="editLink"
            >
            <el-table-column
                    width="75"
                    align="center"
                    :key="tenantAvatar.prop"
                    :label="tenantAvatar.label"
                    v-for="tenantAvatar in tenantAvatars"
            >
                <template slot-scope="scope">
                    <router-link :to="{name: 'adminTenantsEdit', params: {id: scope.row.tenant.id}}"
                                 class="tenant-link">
                        <el-tooltip
                                :content="`${scope.row.tenant.first_name} ${scope.row.tenant.last_name}`"
                                class="item"
                                effect="light" placement="top"
                        >
                            <avatar :size="30"
                                    :src="'/' + scope.row.tenant.user.avatar"
                                    v-if="scope.row.tenant.user.avatar"></avatar>
                            <avatar :size="28"
                                    backgroundColor="rgb(205, 220, 57)"
                                    color="#fff"
                                    :username="scope.row.tenant.user.first_name ? `${scope.row.tenant.user.first_name} ${scope.row.tenant.user.last_name}`: `${scope.row.tenant.user.name}`"
                                    v-if="!scope.row.tenant.user.avatar"></avatar>
                        </el-tooltip>
                    </router-link>
                </template>
            </el-table-column>
            <el-table-column
                :key="column.prop"
                :label="column.label"
                :prop="column.prop"
                v-for="column in columns"
                v-if="!column.i18n && column.prop !== 'title'"
            >
            </el-table-column>
            <el-table-column
                :key="column.prop"
                :label="column.label"
                v-for="column in columns"
                v-if="!column.i18n && column.prop === 'title'"
        >
            <template slot-scope="scope">
                <div>{{scope.row.title}}</div>
                <div class="category" v-if="scope.row.category.parentCategory">{{scope.row.category.parentCategory.name}}</div>
                <div class="category" v-else>{{scope.row.category.name}}</div>
            </template>
        </el-table-column>
            <el-table-column
                v-if="status.prop === 'status'"
                :key="status.prop"
                :label="status.label"
                v-for="status in statuses"
            >
                <template slot-scope="scope">
                    {{$t(`models.request.status.${$constants.serviceRequests.status[scope.row.status]}`)}}
                </template>
            </el-table-column>
            <el-table-column
                :key="column.prop"
                :label="column.label"
                v-for="column in columns"
                v-if="column.i18n"
            >
                <template slot-scope="scope">
                    <span :style="{background: column.withBadge(scope.row[column.prop])}" class="badge"
                          v-if="column.withBadge">
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
                        &nbsp;{{button.title}}
                    </el-button>
                    <el-tooltip
                        :content="button.title"
                        :key="button.title"
                        class="item" effect="light" placement="top-end"
                        v-for="button in action.buttons"
                        v-if="button.tooltipMode">
                        <el-button
                            :icon="button.icon"
                            :style="button.style"
                            :type="button.type"
                            @click="button.onClick(scope.row)"
                            size="mini"
                        >
                        </el-button>
                    </el-tooltip>
                </template>
            </el-table-column>
        </el-table>
        <div v-if="meta.current_page < meta.last_page">
            <el-button @click="loadMore" size="mini" style="margin-top: 15px" type="text">{{$t('loadMore')}}</el-button>
        </div>
    </div>
</template>

<script>
    import {Avatar} from 'vue-avatar'

    export default {
        components: {
            Avatar,
        },
        props: {
            filter: {
                type: String,
                required: true
            },
            filterValue: {
                type: Number,
                required: true
            },
            fetchAction: {
                type: String,
                required: true
            },
            columns: {
                type: Array,
                default() {
                    return [];
                }
            },
            statuses: {
                type: Array,
                default() {
                    return [];
                }
            },
            tenantAvatars: {
                type: Array,
                default() {
                    return [];
                }
            },
            actions: {
                type: Array,
                default() {
                    return [];
                }
            }
        },
        data() {
            return {
                list: [],
                meta: {},
                loading: false
            }
        },
        async created() {
            await this.fetch();
        },
        methods: {
            async fetch(page = 1) {
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
                    } else {
                        this.list.push(...resp.data.data);
                    }
                } catch (e) {
                    console.log(e);
                } finally {
                    this.loading = false;
                }
            },
            loadMore() {
                if (this.meta.current_page < this.meta.last_page) {
                    this.fetch(this.meta.current_page + 1);
                }
            },
            editLink(row, column, cell, event) {
                if(column.property === 'name')
                {
                    let id = row.id;
                    if(row.type == 'user') {
                        this.$router.push({ name: 'adminPropertyManagersEdit', params: { id } });
                    }
                    else if(row.type == 'provider') {
                        this.$router.push({ name: 'adminServicesEdit', params: { id } });
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .category {
        color: #909399;
    }
    .tenant-link {
        display: inline-block;
        text-decoration: none;
    }
    .badge {
        color: #fff;
        display: flex;
        width: 100px;
        font-size: 12px;
        justify-content: center;
        border-radius: 25px;
    }
</style>
