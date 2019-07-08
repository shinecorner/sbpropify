<template>
    <div class="layout">
        <el-menu mode="horizontal" background-color="#fff">
            <!-- <el-menu-item class="toggler">
                <div :class="['button', {'active': visibleSidebar}]" @click="toggleSidebar">
                    <span class="lines"></span>
                </div>
            </el-menu-item>
            <el-menu-item>
                <el-divider direction="vertical" />
            </el-menu-item> -->
            <el-menu-item class="logo">
                <img src="~img/logo3.png" />
            </el-menu-item>
            <el-menu-item class="user">
                <user/>
            </el-menu-item>
            <el-menu-item>
                <el-tooltip content="Logout" effect="dark" placement="bottom">
                    <el-button @click="logout" circle icon="ti-power-off" size="mini" type="danger"/>
                </el-tooltip>
            </el-menu-item>
        </el-menu>
        <sidebar :routes="routes" :visible="visibleSidebar" />
        <div :class="['content', {'fill': !visibleSidebar}]">
            <transition name="sliding" mode="out-in">
                <router-view/>
            </transition>
        </div>
        <media-gallery id="gallery" />
    </div>
</template>


<script>
import AppMenu from 'components/tenant/AppMenu';
import Sidebar from 'components/tenant/Sidebar';
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
        Sidebar,
        User,
        VRouterTransition,
        MediaGallery
    },
    data() {
        return {
            visibleSidebar: true,
            visibleToggler: false
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
        }
    },
    computed: {
        ...mapGetters([
            'realEstate'
        ]),

        breakpoints () {
            return {
                md: el => {
                    if (el.width <= 828) {
                        this.sidebarCompact = true
                        // this.visibleToggler = true

                        // // this.sidebarKey = 'mobile'
                        // // this.sidebarDrawableContent = '#content'
                        
                        // if (this.visibleSidebar) {
                        //     this.visibleSidebar = false
                        // }

                    } else {
                        this.sidebarCompact = false
                        // this.visibleToggler = false

                        // // this.sidebarKey = 'desktop'
                        // // this.sidebarDrawableContent = null

                        // if (!this.visibleSidebar) {
                        //     this.visibleSidebar = true
                        // }

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
    }
}
</script>

<style lang="scss" scoped>
    .layout {
        height: 100%;

        .el-menu {
            width: 100%;
            padding: 0 16px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            box-sizing: border-box;
            box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76);

            .el-menu-item {
                padding: 8px;
                height: 64px;
                line-height: 64px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: none !important;
                border-bottom-style: none !important;

                &.toggler {
                    width: 80px;

                    .button {
                        height: 32px;
                        padding: 8px;
                        background-color: #fff;
                        border-radius: 50%;
                        border: 3px #6AC06F solid;
                        cursor: pointer;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        transition: .48s;
                        width: 32px;
                        filter: opacity(.8);
                        transition: filter .56s cubic-bezier(.51,.92,.24,1.15);

                        &:hover {
                            filter: opacity(1);
                        }
    
                        &.active .lines {
                            transform: scale3d(0.8, 0.8, 0.8);
    
                            &:before,
                            &:after {
                                top: 0;
                                width: 24px;
                            }
    
                            &:before {
                                transform: rotate3d(0, 0, 1, 45deg);
                            }
    
                            &:after {
                                transform: rotate3d(0, 0, 1, -45deg);
                            }
                        }
    
                        .lines {
                            display: inline-block;
                            height: 6px;
                            width: 32px;
                            border-radius: 2px;
                            transition: .48s;
                            background: #6AC06F;
                            position: relative;
    
                            &:before,
                            &:after {
                                content: '';
                                height: 6px;
                                width: 32px;
                                display: inline-block;
                                border-radius: 3px;
                                transition: .48s;
                                background: #6AC06F;
                                position: absolute;
                                left: 0;
                                transform-origin: 3px center;
                                width: 100%;
                            }
    
                            &:before{
                                top: 10px;
                            }
    
                            &:after {
                                top: -10px;
                            }
                        }
                    }
                }

                &.logo {
                    margin-right: auto;

                    img {
                        height: 100%;
                    }
                }

                .el-divider {
                    height: 32px;
                }
            }
        }

        .sidebar {
            position: fixed;
            top: 65px;
            height: calc(100% - 65px);
            z-index: 1;
        }

        .content {
            background-color: #F2F4F9;
            height: calc(100% - 65px);
            display: table;
            z-index: 0;
            box-sizing: border-box;
            transition-duration: .96s;
            transition-property: width, filter, left !important;
            transition-timing-function: cubic-bezier(.51,.92,.24,1.15);
            position: absolute;
            top: 65px;
            left: 0;

            &.fill {
                width: 100%;
                left: 0;
            }

            &:not(.fill) {
                width: calc(100% - 112px);
                left: 112px;
            }

            .sliding-enter-active,
            .sliding-leave-active {
                height: 100%;
                transition-duration: .48s;
                transition-property: filter, transform;
                transition-timing-function: cubic-bezier(.51,.92,.24,1.15);
            }

            .sliding-enter {
                filter: opacity(0);
                transform: scale3d(1, 1, 1) translate3d(112px, 0, 0);
            }
            
            .sliding-leave-active {
                filter: opacity(0);
                transform: scale3d(1.16, 1.16, 1.16) translate3d(-112px, 0, 0);
            }

            > div {
                will-change: transform;
                padding: 24px;
                height: 100%;
            }
        }
    }
</style>


