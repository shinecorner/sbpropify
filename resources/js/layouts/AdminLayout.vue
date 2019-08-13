<template>
    <el-container class="admin-layout" direction="vertical">
        <a-header :toggleSidebar="toggleSidebar">
            <div class="header-link">
                <div  v-bind:class="[{ active: showMenu }, language]">
                    <div class="language-iconBorder" @click="toggleShow">
                        <div class="language-checked-img">
                            <span v-bind:class="selectedFlag"></span>
                        </div>
                    </div>
                    <div class="language-check-box">
                        <div class="language-check-box-title">
                            {{$t('general.chooseLanguage')}}
                        </div>
                        <div class="language-check-box-body">
                            <ul class="language-check-box-body-item" v-for='language in this.languages' :key="language.symbol" @click='itemClicked(language.symbol, language.flag)'>
                                <li>
                                    <span v-bind:class="language.flag"></span>
                                    <p>{{language.name}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="dropdown" class="dropdown-menu" ref="prev">
                <el-dropdown trigger="click">
                    <div>
                        <avatar :src="user.avatar" :name="user.name" :size="33" />
                        <span class="el-dropdown-link">
                            {{user.name}}<i class="el-icon-arrow-down el-icon--right"></i>
                        </span>
                        
                        <el-dropdown-menu slot="dropdown" :style="dropmenuwidth" @click.native="removeMenuActive">
                                <router-link :to="{name: 'adminProfile'}" class="el-menu-item-link">
                                    <el-dropdown-item>
                                        <i class="icon-user"/>
                                        {{$t('menu.profile')}}
                                    </el-dropdown-item>
                                </router-link>
                                <template v-if="$can($permissions.view.realEstate)">
                                    <router-link :to="{name: 'adminSettings'}" class="el-menu-item-link">
                                        <el-dropdown-item>
                                            <i class="icon-cog"/>
                                            {{$t('menu.settings')}}
                                        </el-dropdown-item>
                                    </router-link>
                                </template>
                                <el-dropdown-item id="logout" @click.native="handleLogout">
                                    <i class="icon-logout"/>
                                    {{$t('menu.logout')}}
                                </el-dropdown-item>
                        </el-dropdown-menu>
                    </div>
                </el-dropdown>
            </div>
        </a-header>
        <el-container>
            <a-sidebar :links="links" :collapsed="isCallapsed">
            </a-sidebar>
            <el-main sticky-container>
                <v-router-transition transition="slide-left">
                    <router-view/>
                </v-router-transition>
                <a-footer />
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
    import AHeader from 'components/AdminHeader';
    import ASidebar from 'components/AdminSidebar';
    import AFooter from 'components/AdminFooter';
    import Avatar from 'components/Avatar';
    import VRouterTransition from 'v-router-transition';
    import {mapActions, mapState} from "vuex";
    import { EventBus } from '../event-bus.js';

    export default {
        name: 'AdminLayout',
        components: {
            AHeader,
            ASidebar,
            AFooter,
            Avatar,
            VRouterTransition
        },

        data() {
            return {
                fullScreenText: 'Enter fullscreen mode',
                showMenu: false,
                language: "language",
                activeLanguage: 'Piano',
                selectedFlag: '',

                activeIndex: '1',
                activeIndex2: '1',

                languages: [],

                isCallapsed: false,
                dropdownwidth: 0,
                currActive: '',
                requests: [],
                requests_num: null
            }
        },

        computed: {
            ...mapState({
                user: ({users}) => users.loggedInUser
            }),
            links() {
                return [{
                    icon: 'icon-chart-bar',
                    title: 'Dashboard',
                    route: {
                        name: 'adminDashboard'
                    }
                }, {
                    icon: 'icon-commerical-building',
                    title: this.$t('menu.buildings'),
                    permission: this.$permissions.list.user,
                    children: [{
                        title: this.$t('menu.all_buildings'),
                        permission: this.$permissions.list.building,
                        route: {
                            name: 'adminBuildings'
                        }
                    }, {
                        title: this.$t('menu.units'),
                        permission: this.$permissions.list.unit,
                        route: {
                            name: 'adminUnits'
                        }
                    }, {
                        title: this.$t('menu.districts'),
                        permission: this.$permissions.list.district,
                        route: {
                            name: 'adminDistricts'
                        }
                    }]
                }, {
                    icon: 'icon-chat-empty',
                    title: this.$t('menu.requests'),
                    permission: this.$permissions.list.request,
                    children: [{
                        title: this.$t('menu.all_requests'),
                        permission: this.$permissions.list.request,
                        value: this.requests_num,
                        route: {
                            name: 'adminRequests'
                        }
                    },  {
                        title: this.$t('layouts.tenant.sidebar.myRequests'),
                        permission: this.$permissions.list.request,
                        value: 1,
                        route: {
                            name: ''
                        }
                    },  {
                        title: this.$t('layouts.tenant.sidebar.myPendingRequests'),
                        permission: this.$permissions.list.request,
                        value: 3,
                        route: {
                            name: ''
                        }
                    },  {
                        title: this.$t('layouts.tenant.sidebar.notAssigned'),
                        permission: this.$permissions.list.request,
                        value: 4,
                        route: {
                            name: ''
                        }
                    },  {
                        title: this.$t('layouts.tenant.sidebar.allPendingRequests'),
                        permission: this.$permissions.list.request,
                        value: 5,
                        route: {
                            name: ''
                        }
                    }]
                }, {
                    icon: 'icon-gauge-1',
                    title: this.$t('menu.activity'),
                    permission: this.$permissions.list.audit,
                    route: {
                        name: 'adminRequestsActivity'
                    }
                },
                {
                    title: this.$t('menu.tenants'),
                    icon: 'icon-group',
                    permission: this.$permissions.list.tenant,
                    route: {
                        name: 'adminTenants'
                    }
                }, {
                    icon: 'icon-users',
                    title: this.$t('menu.propertyManagers'),
                    permission: this.$permissions.list.propertyManager,
                    route: {
                        name: 'adminPropertyManagers'
                    }
                }, {
                    icon: 'icon-tools',
                    title: this.$t('menu.services'),
                    permission: this.$permissions.list.provider,
                    route: {
                        name: 'adminServices'
                    }
                }, {
                    title: this.$t('menu.posts'),
                    icon: 'icon-megaphone-1',
                    permission: this.$permissions.list.post,
                    route: {
                        name: 'adminPosts'
                    }
                }, {
                    title: this.$t('menu.products'),
                    icon: 'icon-basket',
                    permission: this.$permissions.list.product,
                    route: {
                        name: 'adminProducts'
                    }
                }, {
                    icon: 'icon-user',
                    title: this.$t('menu.users'),
                    permission: this.$permissions.list.user,
                    children: [{
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
            },
            dropmenuwidth () {
                return `width: ${this.dropdownwidth + 12}px;`
            }
        },

        methods: {
            ...mapActions(['logout']),
            ...mapActions(['updateSettings']),

            toggleFullscreen() {
                if (document.fullscreenElement) {
                    this.fullScreenText = 'Enter fullscreen mode';

                    document.exitFullscreen();
                } else {
                    this.fullScreenText = 'Exit fullscreen mode';

                    document.documentElement.requestFullscreen();
                }
            },

            toggleSidebar() {
                this.isCallapsed = !this.isCallapsed;
            },

            handleLogout() {
                this.$confirm(this.$t('general.swal.logout_confirm'), this.$t('general.swal.delete.title'), {
                    type: 'warning'
                }).then(() => {
                    //this.$router.push({name: 'login'});
                    this.logout()
                        .then(() => {
                            this.$router.push({name: 'login'});
                        })
                        .catch(err => {
                            displayError(err);
                        });
                }).catch(() => {

                });
            },

            removeMenuActive() {
                while( this.$el.querySelector('.content .is-active') != null) 
                {
                    this.$el.querySelector('.content .is-active').classList.remove('is-active');
                }
            },

            toggleShow: function() {
                this.showMenu = !this.showMenu;
            },

            itemClicked: function(item, flag) {
                // this.toggleShow();
                this.onClick(item, flag);
                //this.$router.push({ name: 'adminBuildings' });
                //this.$router.push({ path: `/` })
                //this.$router.push({ path: `/admin/buildings` })
            },

            changeLanguage: function(language) {
                this.activeLanguage = language;
            },

            onClick(language, flag){
                this.$i18n.locale = language;
                this.selectedFlag = flag;

                //console.log('language --- ', this.$i18n.locale);

                this.toggleShow();

                this.saveLangParamsInLocalStorage();
            },

            init(){
                if(!localStorage.getItem('locale')){
                    if(this.user.settings.language === 'en'){
                        this.selectedFlag = `flag-icon flag-icon-us`;
                    }else {
                        this.selectedFlag = `flag-icon flag-icon-${this.user.settings.language}`;
                    }
                } else {
                    this.selectedFlag = localStorage.getItem('selectedFlag');
                    this.$i18n.locale = localStorage.getItem('locale');
                }
            },

            saveLangParamsInLocalStorage(){
                localStorage.setItem('locale', this.$i18n.locale);
                localStorage.setItem('selectedFlag', this.selectedFlag);
            },

            getDropdownWidth() {
                this.dropdownwidth = this.$refs.prev.clientWidth;
            },

        },

        mounted(){
            this.init();

            EventBus.$on('profile-username-change', () => {
                this.dropdownwidth = this.$refs.prev.clientWidth;
            });

            this.getDropdownWidth();
            
            let languagesObject = this.$constants.app.languages;
            let languagesArray = Object.keys(languagesObject).map(function(key) {
                return [String(key), languagesObject[key]];
            });

            this.languages = languagesArray.map(item => { 
                let flag_class = 'flag-icon flag-icon-';
                let flag = flag_class + item[0];
                if( item[0] == 'en')
                {
                    flag = flag_class + 'us'
                }
                return {
                    name: item[1],
                    symbol: item[0],
                    flag: flag
                }
            });
            
        },
        async created(){
            const requests = await this.axios.get('requests?&page=1&per_page=20');
            this.requests_num = requests.data.data.total;
        }


    }
</script>
<style lang="scss" scoped>
    .el-button {
        padding: 0px !important;
        width: 100%;
        + .el-button {
            margin-left: 0px !important;
        }
    }
    .el-button--text {
        color: #909399 !important;
        width: 100%;
        text-align: left;
    }
    .el-dropdown-menu {
        margin: 16px 8px 16px 0px !important;
        .el-dropdown-menu__item {
            padding: 0px 12px !important;
            text-align: left;
            color: #909399;
            &:hover {
                color: #909399;
            }
        }
    }
</style>

<style lang="scss" scoped>

    .el-container {
        background-color: #F2F4F9;
        height: 100%;

        .el-main {
            padding: 0;
            height: 100%;
            overflow: hidden;
            flex-basis: 0;
            overflow-y: auto;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

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

        .user-params{
            display: flex;
            align-items: center;
            position: relative;
            width: 100%;

            &-img{
                width: 33px;
                height: 33px;
                border: solid #c2c2c2 1px;
                border-radius: 50%;
            }

            &-wrap{
                display: flex;
                align-items: center;
                padding-left: 15px;

                &-icon{
                    position: static;
                    margin-top: 0;
                    margin-left: 10px;
                }
            }

            &-name{
                display: flex;
                width: auto;

                &-rotateIcon{
                    transform: rotate(180deg);
                }
            }
        }
        .dropdown-menu {
            min-width: 118px;
            cursor: pointer;
            .avatar {
                margin-right: 3%;
                border: solid #c2c2c2 2px;
                background-color: rgb(205, 220, 57)!important;
                color: white !important;
            }
            .el-dropdown-link {
                color: #909399;
                .el-icon-arrow-down {
                    font-size: 12px;
                }
            }
        }

        .language {
            position: relative;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 40px;

            &:after{
                content: "";
                position: absolute;
                right: -21px;
                height: 90%;
                width: 1px;
                background: #c2c2c2;;
            }


            &.active{
                background: #ececec;


                .language-check-box{
                    top: 45px;
                    pointer-events: auto;
                    opacity: 1;
                }
            }

            &-iconBorder{
                width: 35px;
                height: 35px;
                border-radius: 50%;
                background: #eee;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: 0.2s ease-in;
                cursor: pointer;

                &:hover{
                    background: #B4B4B4;
                }
            }

            .language-checked-img{
                width: 25px;
                height: 25px;
                border-radius: 50%;
                overflow: hidden;
                position: relative;

                span{
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    object-fit: cover;
                    display: block;
                    background-size: cover;
                }
            }

            .language-check-box{
                position: absolute;
                top: 25px;
                left: -70px;
                z-index: 5;
                background: white;
                box-shadow: 0 2px 5px rgba(34,34,34,.4);
                border-radius: .4rem;
                overflow: hidden;
                opacity: 0;
                pointer-events: none;
                transition: .2s;

                .language-check-box-title{
                    cursor: default;
                    padding: 15px 30px;
                    background: #525560;
                    color: #fff;
                }

                .language-check-box-body-item{
                    padding: 0;
                    margin: 0;
                    cursor: pointer;
                    li{
                        display: flex;
                        justify-content: flex-start;
                        align-items: center;
                        padding: 10px 20px;
                        transition: .4s;


                        &:hover{
                            background-color: #f0f9f1;
                        }

                        span{
                            margin: 0 20px 0 0 ;
                        }

                        p{
                            margin: 0;
                            color: #303133;
                        }
                    }
                }
            }

        }
    }
</style>
