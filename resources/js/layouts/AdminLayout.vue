<template>
    <el-container class="admin-layout" direction="vertical">
        <a-header>
            <router-link :to="{name: ''}" class="header-link">
                <div  v-bind:class="[{ active: showMenu }, language]" @click='toggleShow' >
                    <div class="language-iconBorder">
                        <div class="language-checked-img">
                            <span v-bind:class="selectedFlag"></span>
                        </div>
                    </div>
                    <div class="language-check-box">
                        <div class="language-check-box-title">
                            {{$t('chooseLanguage')}}
                        </div>
                        <div class="language-check-box-body">
                            <ul class="language-check-box-body-item" v-for='language in this.languages' @click='itemClicked(language.symbol, language.flag)'>
                                <li>
                                    <span  v-bind:class="language.flag"></span>
                                    <p>{{language.name}}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </router-link>

            <div class="user-params" @click="toggleUserDropdown">
                <div class="user-params-img" :style="`background-image: url('${user.avatar}')`"></div>
                <span class="user-params-name">{{user.name}} <i class="el-submenu__icon-arrow el-icon-arrow-down" :class="{'user-params-name-rotateIcon': userDropdownVisibility}"></i></span>
            </div>

            <div class="dropdown">
               <transition name="slide-fade">
                   <ul class="dropdown-list" v-if="userDropdownVisibility">
                       <li class="dropdown-list-item" @click="toggleUserDropdown">
                           <router-link :to="{name: 'adminProfile'}" class="dropdown-list-item-link"
                                        :class="{'active': activeDropdownMenuItem}"
                                        @click="selectDropdownMenu">
                               <i class="ti-user"/>
                               {{$t('menu.profile')}}
                           </router-link>
                       </li>
                       <li class="dropdown-list-item" @click="toggleUserDropdown">
                           <template v-if="$can($permissions.view.realEstate)">
                               <router-link :to="{name: 'adminSettings'}" class="dropdown-list-item-link"
                                            :class="{'active': activeDropdownMenuItem}"
                                            @click="selectDropdownMenu">
                                   <i class="ti-settings"/>
                                   {{$t('menu.settings')}}
                               </router-link>
                           </template>
                       </li>
                       <li class="dropdown-list-item">
                           <el-button @click="handleLogout" type="text">
                               <div class="logout-button">
                                   <i class="ti-power-off"/>
                                   {{$t('menu.logout')}}
                               </div>
                           </el-button>
                       </li>
                   </ul>
               </transition>
            </div>
        </a-header>
        <el-container>
            <a-sidebar :links="links">
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
    import VRouterTransition from 'v-router-transition';
    import {mapActions, mapState} from "vuex";

    export default {
        name: 'AdminLayout',
        components: {
            AHeader,
            ASidebar,
            AFooter,
            VRouterTransition
        },

        data() {
            return {
                fullScreenText: 'Enter fullscreen mode',
                showMenu: false,
                userDropdownVisibility: false,
                language: "language",
                activeLanguage: 'Piano',
                selectedFlag: '',
                activeDropdownMenuItem: false,
                languages: [
                    {name: 'Français', symbol: 'fr', flag: 'flag-icon flag-icon-fr'},
                    {name: 'Italiano', symbol: 'it', flag: 'flag-icon flag-icon-it'},
                    {name: 'Deutsch', symbol: 'de', flag: 'flag-icon flag-icon-de'},
                    {name: 'English', symbol: 'en', flag: 'flag-icon flag-icon-us'}
                ]
            }
        },

        computed: {
            ...mapState({
                user: ({users}) => users.loggedInUser
            }),
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

            handleLogout() {
                this.$confirm('You will be logged out.', 'Are you sure?', {
                    type: 'warning'
                }).then(() => {
                    this.logout()
                        .then(() => this.$router.push({name: 'login'}))
                        .catch(err => {
                            displayError(err);
                        });
                }).catch(() => {
                    this.toggleUserDropdown();
                });
            },

            toggleShow: function() {
                this.showMenu = !this.showMenu;
            },

            itemClicked: function(item, flag) {
                this.toggleShow();
                this.onClick(item, flag);
            },

            changeLanguage: function(language) {
                this.activeLanguage = language;
            },

            onClick(language, flag){
                this.$i18n.locale = language;
                this.selectedFlag = flag;

                console.log('language --- ', this.$i18n.locale);

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

            toggleUserDropdown(){
                this.userDropdownVisibility = !this.userDropdownVisibility;
            },

            disableRightClick(){
                document.querySelector('body').oncontextmenu = function(){
                    return false;
                }
            },

            selectDropdownMenu(){
                this.activeDropdownMenuItem = !this.activeDropdownMenuItem;
            }

        },

        mounted(){
            this.init();

            // this.disableRightClick(); // If this function is enabled, the ability to use the right mouse button will be disabled in the Admin panel

            this.$store.subscribe((mutation, state) => {
                if(mutation.type === "SET_LOGGED_IN_USER"){

                    if(this.user.settings.language === 'en'){
                        this.selectedFlag = `flag-icon flag-icon-us`;
                    }else {
                        this.selectedFlag = `flag-icon flag-icon-${mutation.payload.settings.language}`;
                    }
                }
            });
        },


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

        .user-params{
            display: flex;
            align-items: center;
            &-img{
                width: 35px;
                height: 35px;
                border: solid #c2c2c2 1px;
                border-radius: 50%;
            }

            &-name{
                margin-left: 10px;
                margin-right: 25px;
                display: flex;
                width: auto;
                align-items: center;

                &-rotateIcon{
                    transform: rotate(180deg);
                }
            }
        }


        .language{
            position: relative;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 30px;

            &:after{
                content: "";
                position: absolute;
                right: -15px;
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
                    padding: 15px 30px;
                    background: #525560;
                    color: #fff;
                }

                .language-check-box-body-item{
                    padding: 0;
                    margin: 0;

                    li{
                        display: flex;
                        justify-content: flex-start;
                        align-items: center;
                        padding: 10px 20px;
                        transition: .4s;


                        &:hover{
                            background: #69c06f;

                            p{
                                color: #fff;
                            }
                        }

                        span{
                            margin: 0 20px 0 0 ;
                        }

                        p{
                            margin: 0;
                        }
                    }
                }
            }

        }
    }
</style>
