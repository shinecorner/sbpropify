<template>
    <el-container class="admin-layout" direction="vertical">
        <a-header>
            <router-link :to="{name: 'adminProfile'}" class="header-link">
                <i class="ti-user"/>
                {{$t('menu.profile')}}
            </router-link>
            <template v-if="$can($permissions.view.realEstate)">
                <router-link :to="{name: 'adminSettings'}" class="header-link">
                    <i class="ti-settings"/>
                    {{$t('menu.settings')}}
                </router-link>
            </template>
            <el-button @click="handleLogout" type="text">
                <div class="logout-button">
                    <i class="ti-power-off"/>
                    {{$t('menu.logout')}}
                </div>
            </el-button>
        </a-header>
        <el-container>
            <a-sidebar :links="links">
                <a-user/>
            </a-sidebar>
            <el-main sticky-container>
                <v-router-transition transition="slide-left">
                    <router-view/>
                </v-router-transition>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
    import AHeader from 'components/AdminHeader';
    import ASidebar from 'components/AdminSidebar';
    import AUser from 'components/AdminSidebarUser';
    import VRouterTransition from 'v-router-transition';
    import {mapActions} from "vuex";

    export default {
        name: 'AdminLayout',
        components: {
            AHeader,
            ASidebar,
            AUser,
            VRouterTransition
        },
        data() {
            return {
                fullScreenText: 'Enter fullscreen mode'
            }
        },
        computed: {
            links() {
                return [{
                    icon: 'ti-home',
                    title: 'Dashboard',
                    route: {
                        name: 'adminDashboard'
                    }
                }, {
                    icon: 'ti-user',
                    title: this.$t('menu.buildings'),
                    permission: this.$permissions.list.user,
                    children: [{
                        title: this.$t('menu.all_buildings'),
                        icon: 'ti-home',
                        permission: this.$permissions.list.building,
                        route: {
                            name: 'adminBuildings'
                        }
                    }, {
                        title: this.$t('menu.units'),
                        icon: 'ti-home',
                        permission: this.$permissions.list.unit,
                        route: {
                            name: 'adminUnits'
                        }
                    }, {
                        title: this.$t('menu.districts'),
                        icon: 'ti-home',
                        permission: this.$permissions.list.district,
                        route: {
                            name: 'adminDistricts'
                        }
                    }]
                }, {
                    icon: 'ti-user',
                    title: this.$t('menu.requests'),
                    permission: this.$permissions.list.request,
                    children: [{
                        icon: 'ti-user',
                        title: this.$t('menu.all_requests'),
                        permission: this.$permissions.list.request,
                        route: {
                            name: 'adminRequests'
                        }
                    }, {
                        icon: 'ti-announcement',
                        title: this.$t('menu.activity'),
                        nestedItem: true,
                        permission: this.$permissions.list.audit,
                        route: {
                            name: 'adminRequestsActivity'
                        }
                    }, {
                        icon: 'ti-user',
                        title: this.$t('menu.services'),
                        permission: this.$permissions.list.provider,
                        nestedItem: true,
                        route: {
                            name: 'adminServices'
                        }
                    }]
                }, {
                    title: this.$t('menu.posts'),
                    icon: 'ti-announcement',
                    permission: this.$permissions.list.post,
                    route: {
                        name: 'adminPosts'
                    }
                }, {
                    title: this.$t('menu.products'),
                    icon: 'ti-announcement',
                    permission: this.$permissions.list.product,
                    route: {
                        name: 'adminProducts'
                    }
                }, {
                    icon: 'ti-user',
                    title: this.$t('menu.users'),
                    permission: this.$permissions.list.user,
                    children: [{
                        title: this.$t('menu.tenants'),
                        icon: 'ti-user',
                        permission: this.$permissions.list.tenant,
                        route: {
                            name: 'adminTenants'
                        }
                    }, {
                        icon: 'ti-user',
                        title: this.$t('menu.propertyManagers'),
                        permission: this.$permissions.list.propertyManager,
                        route: {
                            name: 'adminPropertyManagers'
                        }
                    }, {
                        title: this.$t('menu.admins'),
                        route: {
                            name: 'adminUsers',
                            query: {
                                role: 'administrator'
                            }
                        }
                    }, {
                        title: this.$t('menu.super_admins'),
                        route: {
                            name: 'adminUsers',
                            query: {
                                role: 'super_admin'
                            }
                        }
                    }]
                }];
            }
        },
        methods: {
            ...mapActions(['logout']),
            toggleFullscreen() {
                if (document.fullscreenElement) {
                    this.fullScreenText = 'Enter fullscreen mode';

                    document.exitFullscreen();
                } else {
                    this.fullScreenText = 'Exit fullscreen mode';

                    document.documentElement.requestFullscreen();
                }
            },
            handleLogout() {
                this.$confirm('You will be logged out.', 'Are you sure?', {
                    type: 'warning'
                }).then(() => {
                    this.logout()
                        .then(() => this.$router.push({name: 'login'}))
                        .catch(err => displayError(err));
                }).catch(() => {
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-container {
        background-color: #F2F4F9;
        height: 100%;

        .el-main {
            padding: 0;
            height: 100%;
            overflow: auto;
            flex-basis: 0;
            overflow-x: hidden;

            .el-breadcrumb {
                background-color: #fff;
                padding: 1em;
                margin: -30px;
                margin-bottom: 2em;
                box-shadow: 0 1px 3px transparentize(#000, .88),
                0 1px 2px transparentize(#000, .76);
                position: relative;
                top: -2px;
            }

            // causes a bug
            // > * {
            //     height: 100% !important;
            // }

        }
    }
</style>
