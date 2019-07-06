<template>
    <el-container direction="vertical">
        <app-menu>
            <el-menu-item class="toggler" slot="prefix" index="toggle" v-if="visibleToggler">
                <el-button class="toggle" type="text" @click="toggleSidebar">
                    <i class="el-icon-menu"></i>
                </el-button>
            </el-menu-item>
            <el-menu-item class="user" index="user">
                <user/>
            </el-menu-item>
            <el-menu-item index="logout">
                <el-tooltip content="Logout" effect="dark" placement="bottom">
                    <el-button @click="logout" circle icon="ti-power-off" size="mini" type="danger"/>
                </el-tooltip>
            </el-menu-item>
            <el-menu-item index="fullscreen">
                <el-tooltip :content="fullScreenText" effect="dark" placement="bottom">
                    <el-button @click="toggleFullscreen" circle icon="ti-fullscreen" size="mini"/>
                </el-tooltip>
            </el-menu-item>
        </app-menu>
        <el-container>
            <app-sidebar :key="sidebarKey" :routes="routes" :drawable="sidebarDrawableContent" :visible.sync="visibleSidebar" />
            <el-main id="container" :class="[{md: el.is.md}]">
                <v-router-transition transition="slide-left">
                    <router-view/>
                </v-router-transition>
            </el-main>
            <media-gallery id="gallery" />
        </el-container>
    </el-container>
</template>


<script>
    import AppMenu from 'components/tenant/AppMenu';
    import AppSidebar from 'components/tenant/AppSidebar';
    import User from 'components/tenant/User';
    import {mapActions, mapGetters} from 'vuex';
    import VRouterTransition from 'v-router-transition';
    import {displayError} from "helpers/messages"
    import MediaGallery from 'components/MediaGallery'
    import {ResponsiveMixin} from 'vue-responsive-components'

    export default {
        mixins: [
            ResponsiveMixin
        ],
        components: {
            AppMenu,
            AppSidebar,
            User,
            VRouterTransition,
            MediaGallery
        },
        data() {
            return {
                iconSidebar: 'ti-layout-width-full',
                fullScreenText: 'Enter fullscreen mode',
                visibleSidebar: true,
                visibleToggler: false,
                sidebarDrawableContent: null,
                sidebarKey: 'desktop'
            }
        },
        created() {
            this.getRealEstate();
        },
        methods: {
            ...mapActions(['getRealEstate']),
            toggleSidebar() {
                this.visibleSidebar = !this.visibleSidebar;
            },
            toggleFullscreen() {
                if (document.fullscreenElement) {
                    this.fullScreenText = 'Enter fullscreen mode';

                    document.exitFullscreen();
                } else {
                    this.fullScreenText = 'Exit fullscreen mode';

                    document.documentElement.requestFullscreen();
                }
            },
            logout() {
                this.$confirm('Please proceed with caution.', 'Are you sure?', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    roundButton: true
                }).then(() => {
                    this.$store.dispatch('logout')
                        .then(() => this.$router.push({name: 'login'}))
                        .catch(err => displayError(err));
                }).catch(() => {
                });
            },
            filterRouteConditionals(route) {
                if (!route.realEstateCondition && !route.children) {
                    return route;
                }

                if (route.realEstateCondition && !_.isEmpty(this.realEstate) && this.realEstate[route.realEstateCondition]) {
                    return route;
                }

                if (route.children) {
                    route.children = route.children.filter(childRoute => {
                        if (!childRoute.realEstateCondition) {
                            return childRoute;
                        }

                        if (childRoute.realEstateCondition && !_.isEmpty(this.realEstate) && this.realEstate[childRoute.realEstateCondition]) {
                            return childRoute;
                        }
                    });

                    return route;
                }
            },
            handleResize () {
                console.log('resize')
            }
        },
        computed: {
            ...mapGetters([
                'getSidebarLevel',
                'realEstate'
            ]),

            breakpoints () {
                return {
                    md: el => {
                        if (el.width <= 828) {
                            this.visibleToggler = true

                            this.sidebarKey = 'mobile'
                            this.sidebarDrawableContent = '#container'
                            
                            if (this.visibleSidebar) {
                                this.visibleSidebar = false
                            }

                        } else {
                            this.visibleToggler = false

                            this.sidebarKey = 'desktop'
                            this.sidebarDrawableContent = null

                            if (!this.visibleSidebar) {
                                this.visibleSidebar = true
                            }

                        }
                    }
                }
            },



            routes() {
                const routes = [{
                    icon: 'ti-home',
                    title: 'Dashboard',
                    route: {
                        name: 'tenantDashboard'
                    }
                }, {
                    icon: 'ti-user',
                    title: 'My tenancy',
                    children: [{
                        icon: 'ti-files',
                        title: 'My personal data',
                        route: {
                            name: 'tenantMyPersonal'
                        }
                    }, {
                        icon: 'ti-pin-alt',
                        title: 'My recent contract',
                        route: {
                            name: 'tenantMyContracts'
                        }
                    }, {
                        icon: 'ti-book',
                        title: 'Documents',
                        route: {
                            name: 'tenantMyDocuments'
                        }
                    }, {
                        icon: 'ti-user',
                        title: 'Contact persons',
                        route: {
                            name: 'tenantMyContacts'
                        },
                        realEstateCondition: 'contact_enable'
                    }]
                }, {
                    icon: 'ti-announcement',
                    title: 'News',
                    route: {
                        name: 'tenantPosts'
                    }
                }, {
                    icon: 'ti-comments',
                    title: 'Requests',
                    route: {
                        name: 'tenantRequests'
                    }
                }, {
                    icon: 'ti-shopping-cart',
                    title: 'Marketplace',
                    route: {
                        name: 'tenantMarketplace'
                    }
                }, {
                    icon: 'el-icon-brush',
                    title: 'Cleanify',
                    route: {
                        name: 'cleanifyRequest'
                    }
                }, {
                    icon: 'ti-settings',
                    title: 'Settings',
                    positionedBottom: true,
                    route: {
                        name: 'tenantSettings'
                    }
                }]
                    .filter(this.filterRouteConditionals);

                return routes;
            }
        },
        watch: {
            visible: function (newVal, oldVal) {
                if (newVal) {
                    this.iconSidebar = 'ti-layout-width-full';
                } else {
                    this.iconSidebar = 'ti-layout-tab-v';
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-menu {
        .el-menu-item {
            background: none !important;
            border-bottom-style: none !important;
            padding: 0 .5em;

            &.toggler {
                .el-button i {
                    font-size: 24px;
                    margin: 0;
                }
            }

            :global(i) {
                color: inherit;
            }

            &:global(.user) {
                display: flex;
                align-items: center;
            }
        }
    }

    .el-container {
        background-color: #F2F4F9;
        height: 100%;
        position: relative;

        &.is-vertical {
            display: flex;
            flex-direction: column;
        }

        .main-button {
            margin: 0 -8px;
            border-style: none;

            :global(i) {
                font-size: 2em;
            }
        }

        .el-main {
            padding: 2em;
            height: 100%;
            overflow: auto;
            flex-basis: 0;
            overflow-x: hidden;

            > * {
                // height: auto !important;
            }
        }
    }
</style>
