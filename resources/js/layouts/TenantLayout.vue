<template>
    <div v-loading="loading" v-if="loading" :element-loading-background="loadingBackground" style="width: 100%; height: 100%;"></div>
    <div :class="['layout', {[sidebarDirection]: true}, {md: el.is.md}]" v-else>
        <div class="header">
            <div class="item">
                <img src="~img/logo3.png" v-show="!tenant_logo_src"/>
                <img :src="tenant_logo_src" v-show="tenant_logo_src"/>
            </div>
            <div class="item spacer"></div>
            <!-- <div class="item">
                <quick-links :data="quickLinks" />
            </div> -->
            <div class="item">
                <locale-switcher />
            </div>
            <div class="item divider" :style="[el.is.md && {'display': 'none'}]"></div>
            <div class="item">
                <el-badge type="danger" :value="unreadNotifications.length" :max="9" :hidden="!unreadNotifications.length">
                    <el-button icon="icon-bell-alt" circle @click="openNotificationsDrawer()" />
                </el-badge>
            </div>
            <div class="item">
                <user @avatar-click="openSettingsDrawer()" :only-avatar="el.is.md" />
            </div>
            <div class="item">
                <el-tooltip :content="$t('layouts.tenant.menu.logout')" effect="dark" placement="bottom">
                    <el-button size="small" type="danger" icon="ti-power-off" circle @click="logout" />
                </el-tooltip>
            </div>
        </div>
        <div ref="container" class="container">
            <div ref="content" id="layout-content" :class="['content', {'fill': !visibleSidebar}]">
                <sidebar ref="sidebar" :key="sidebarKey" :routes="routes" :visible.sync="visibleSidebar" :direction="sidebarDirection" :show-toggler="false" />
                <transition @enter="onEnterTransition" @leave="onLeaveTransition" mode="out-in" :css="false" appear>
                    <router-view class="view" />
                </transition>
            </div>
            <ui-drawer :visible.sync="visibleDrawer" :z-index="1" direction="right" docked>
                <el-tabs v-model="drawerTabsModel" type="card" stretch>
                    <el-tab-pane name="notifications">
                        <div slot="label"><i class="icon-bell"></i> {{$t('tenant.notification_label')}}</div>
                        <user-notifications />
                    </el-tab-pane>
                    <el-tab-pane name="settings">
                        <div slot="label"><i class="icon-cog"></i> {{$t('tenant.settings')}}</div>
                        <user-settings />
                    </el-tab-pane>
                </el-tabs>
            </ui-drawer>
        </div>
    </div>
</template>

<script>
    import Sidebar from 'components/tenant/Sidebar'
    import {mapGetters} from 'vuex';
    import {VueResponsiveComponents, ResponsiveMixin} from 'vue-responsive-components'


    export default {
        mixins: [ResponsiveMixin],
        components: {
            Sidebar,
            User: () => ({
                component: import(/* webpackChunkName: "userNotifications" */ 'components/tenant/User'),
                delay: 0,
                timeout: 8000
            }),
            UserNotifications: () => ({
                component: import(/* webpackChunkName: "userNotifications" */ 'components/tenant/UserNotifications'),
                delay: 0,
                timeout: 8000
            }),
            UserSettings: () => ({
                component: import(/* webpackChunkName: "userSettings" */ 'components/tenant/UserSettings'),
                delay: 0,
                timeout: 8000
            })
        },
        data() {
            return {
                visibleSidebar: true,
                visibleDrawer: false,
                drawerTabsModel: 'notifications',
                Settings: {},
                loading: true,
                showFirst: true,
                sidebarDirection: 'vertical',
                origin: null,
                loadingBackground: null,
                sidebarKey: 'vertical',
                tenant_logo_src: '',
                quickLinks: [{
                    icon: 'icon-megaphone-1',
                    title: 'tenant.add_pinboard',
                    route: {
                        name: 'tenantPinboards'
                    }
                }, {
                    icon: 'icon-chat-empty',
                    title: 'tenant.add_request',
                    route: {
                        name: 'tenantRequests'
                    }
                }, {
                    icon: 'icon-basket',
                    title: 'tenant.add_listing',
                    route: {
                        name: 'tenantListing'
                    }
                }],
                routes: [{
                    icon: 'icon-th',
                    title: 'layouts.tenant.sidebar.dashboard',
                    route: {
                        name: 'tenantDashboard'
                    }
                }, 
                {
                    icon: 'icon-vcard',
                    title: 'layouts.tenant.sidebar.myTenancy',
                    children: [{
                        icon: 'icon-user',
                        title: 'layouts.tenant.sidebar.myPersonalData',
                        route: {
                            name: 'tenantMyPersonal'
                        }
                    }, {
                        icon: 'icon-handshake-o',
                        title: 'layouts.tenant.sidebar.myRecentContract',
                        route: {
                            name: 'tenantMyContracts'
                        }
                    }, {
                        icon: 'icon-doc-text',
                        title: 'layouts.tenant.sidebar.myDocuments',
                        route: {
                            name: 'tenantMyDocuments'
                        }
                        // do not show if no documents
                    }, {
                        icon: 'icon-contacts',
                        title: 'layouts.tenant.sidebar.myContactPersons',
                        route: {
                            name: 'tenantMyContacts'
                        },
                        visible: this.Settings && this.Settings.contact_enable // OR no service partners for the building
                    }, {
                        icon: 'icon-users',
                        title: 'tenant.property_managers',
                        route: {
                            name: 'tenantPropertyManagers'
                        }
                    }, {
                        icon: 'icon-group',
                        title: 'tenant.my_neighbours',
                        route: {
                            name: 'tenantMyNeighbours'
                        }
                    }]
                }, {
                    icon: 'icon-megaphone-1',
                    title: 'layouts.tenant.sidebar.pinboard',
                    route: {
                        name: 'tenantPinboards'
                    }
                }, {
                    icon: 'icon-chat-empty',
                    title: 'layouts.tenant.sidebar.requests',
                    route: {
                        name: 'tenantRequests'
                    }
                }, {
                    icon: 'icon-basket',
                    title: 'layouts.tenant.sidebar.listings',
                    route: {
                        name: 'tenantListing'
                    }
                }, {
                    icon: 'icon-water',
                    title: 'Cleanify',
                    route: {
                        name: 'cleanifyRequest'
                    },
                }, {
                    icon: 'icon-cog',
                    title: 'layouts.tenant.sidebar.settings',
                    positionedBottom: true,
                    route: {
                        name: 'tenantSettings'
                    }
                }]
            }
        },
        computed: {
            tenant_logo() {
                if(localStorage.getItem('tenant_logo_src') != this.$constants.logo.tenant_logo ) {
                    localStorage.setItem('tenant_logo_src', this.$constants.logo.tenant_logo);
                }

                return localStorage.getItem('tenant_logo_src') ? `/${localStorage.getItem('tenant_logo_src')}` : '';
            },
        },
        methods: {
            test () {
                this.$refs.sidebar.$forceUpdate()
            },
            onEnterTransition(el, done) {
                this.$anime({
                    targets: el,
                    scale: [.92, 1],
                    duration: 480,
                    translateX: ['100%', 0],
                    translateZ: 0,
                    easing: 'easeInOutCirc',
                    begin: () => this.$refs.container.style.overflow = 'hidden',
                    complete: () => {
                        this.$refs.container.style.overflow = ''

                        done()
                    }
                })
            },
            onLeaveTransition(el, done) {
                this.$anime({
                    targets: el,
                    opacity: [1, 0],
                    translateX: [0, '-100%'],
                    translateZ: 0,
                    duration: 720,
                    easing: 'easeInOutCirc',
                    complete: done
                })
            },
            logout () {
                // this.$confirm(this.$t('tenant.logout'), this.$t('tenant.logout_confirm'), {
                //     type: 'warning',
                //     roundButton: true
                // }).then(async () => {
                //     await this.$store.dispatch('logout')

                //     this.$router.push({name: 'login'})
                // })
                this.$store.dispatch('logout')
                    .then(() => {
                        this.$router.push({name: 'login'});
                    })
                    .catch(err => {
                        displayError(err);
                    });
                
                
            },
            toggleDrawer () {
                this.visibleDrawer = !this.visibleDrawer
            },
            openNotificationsDrawer () {
                if (!this.visibleDrawer || this.drawerTabsModel === 'notifications') {
                    this.toggleDrawer()
                }

                this.drawerTabsModel = 'notifications'
            },
            openSettingsDrawer () {
                if (!this.visibleDrawer || this.drawerTabsModel === 'settings') {
                    this.toggleDrawer()
                }

                this.drawerTabsModel = 'settings'
            }
        },
        computed: {
            ...mapGetters('notifications', {
                unreadNotifications: 'unread'
            }),

            breakpoints () {
                return {
                    md: el => {
                        if (el.width <= 828) {
                            if (this.sidebarDirection === 'vertical') {
                                this.sidebarDirection = 'horizontal'
                            }
                            return true
                        } else {
                            if (this.sidebarDirection === 'horizontal') {
                                this.sidebarDirection = 'vertical'
                            }
                        }
                    }
                }
            },
        },
        beforeCreate() {
            document.getElementById('viewport').setAttribute('content', 'width=device-width, initial-scale=1.0')
        },
        created () {
            this.loadingBackground = getComputedStyle(document.documentElement).getPropertyValue('--color-main-background-base')
        },
        async mounted () {
            this.loading = true
            this.tenant_logo_src = "/" + this.$constants.logo.tenant_logo;
            await this.$store.dispatch('getSettings').then((resp) => {
                this.Settings = resp.data;
                    if( resp.data.cleanify_enable == false )
                    {
                        this.routes = this.routes.filter((item) => { 
                            if(item.route && item.route.name == "cleanifyRequest")
                                return false;
                            return true;
                        });
                    }
                }).catch((error) => {
            });

            this.loading = false
        }
    }
</script>

<style lang="scss" scoped>
    .layout {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: var(--color-main-background-base);
        display: flex;
        flex-direction: column;

        &.md .container .content {
            flex-direction: column;
        }

        &:not(.md) .container .content .sidebar {
            padding-right: 0 !important;
        }

        .header {
            height: 64px;
            padding: 0 16px;
            flex-shrink: 0;
            background-color: #fff;
            display: flex;
            align-items: center;
            border-bottom: 1px var(--border-color-base) solid;
            box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76);
            z-index: 2;

            .item {
                height: 100%;
                display: flex;
                align-items: center;
                box-sizing: border-box;

                &:not(.divider) {
                    padding: 6px;
                }

                &.spacer {
                    flex: 1;
                }

                &.divider {
                    background-color: var(--border-color-base);
                    width: 1px;
                    height: 28px;
                    margin: 0 8px;
                }

                .el-badge {
                    :global(.el-badge__content) {
                        margin: 6px;
                    }
                }

                img {
                    height: 100%;
                }
            }
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            overflow: hidden;

            .content {
                width: 100%;
                display: flex;

                .view {
                    width: 100%;
                    height: 100%;
                    padding: 16px;
                    overflow-y: auto;
                    box-sizing: border-box;
                }
            }

            .ui-drawer {
                .el-tabs {
                    height: 100%;
                    display: flex;
                    flex-direction: column;

                    &.el-tabs--card :global(.el-tabs__header) {
                        :global(.el-tabs__nav-wrap) {
                            :global(.el-tabs__nav-scroll) {
                                :global(.el-tabs__nav) {
                                    border: 0;
                                }
                            }
                        }
                    }

                    :global(.el-tabs__header) {
                        margin-bottom: 0;
                    }

                    :global(.el-tabs__content) {
                        padding: 16px;
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        overflow-y: auto;

                        // :global(.el-tab-pane) {
                        //     height: 100%;
                        //     &, > * {
                        //         height: 100%;
                        //     }
                        // }
                    }
                }
            }
        }
    }

    @media only screen and (max-width: 676px) {
        .layout {
            .header {
                .item {
                    &:first-child {
                        padding: 8px;
                        padding-left: 0;
                    }
                }
            }
        }
    }
</style>


