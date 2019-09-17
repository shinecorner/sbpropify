<template>
    <div class="dashboard">
        <!-- <heading icon="ti-home" :title="$t('tenant.my_dashboard')">
            <greeting ref="greeting" class="description" slot="description" />
        </heading> -->
        <ui-heading icon="ti-home" :title="$t('tenant.my_dashboard')">
            <greeting ref="greeting" class="description" slot="description" />
        </ui-heading>
        <ui-divider />
        <div class="row" name="fade" tag="div" ref="widgets">
            <div class="column">
                <weather-card class="widget" />
                <latest-property-managers-card class="widget" />
                <latest-my-neighbours-card class="widget" />
            </div>
            <div class="column">
                <requests-statistics-card class="widget" />
                <latest-requests-card class="widget" @view-detail-request="viewDetailRequest"/>
                <latest-posts-card class="widget" />
            </div>
            <div class="column">
                <latest-products-card class="widget" />
                <rate-card />
            </div>
        </div>
        <ui-drawer :size="448" :visible.sync="visibleDrawer" :z-index="1" direction="right" docked @update:visibleDrawer="resetDataFromDrawer">
            <el-tabs type="card" v-model="activeDrawerTab" stretch v-if="openedRequest">
                <el-tab-pane name="chat" lazy>
                    <div slot="label">
                        <i class="ti-comments"></i>
                        Chat
                    </div>
                    <chat ref="chat" :id="openedRequest.id" type="request" height="100%" max-height="100%" />
                </el-tab-pane>
                <el-tab-pane name="media" lazy>
                    <div slot="label">
                        <i class="ti-gallery"></i>
                        {{$t('tenant.media')}}
                    </div>
                    <ui-media-gallery :files="openedRequest.media.map(({url}) => url)" />
                    <ui-divider class="upload-divider" content-position="left">
                        <i class="el-icon-upload"></i>
                        {{$t('tenant.request_upload_title')}}
                    </ui-divider>
                    
                    <div class="upload-description">
                        <el-alert
                            :title="$t('tenant.request_upload_desc')"
                            type="info"
                            show-icon
                            :closable="false"
                        >
                        </el-alert>
                        
                    </div>
                    <ui-media-uploader v-model="media" :headers="{'Authorization': `Bearer ${authorizationToken}`, 'Accept': 'application/json, text/plain, */*', 'Content-Type': 'application/json;charset=UTF-8'}" :action="`api/v1/requests/${openedRequest.id}/media`" :id="openedRequest.id" :options="{drop: true, draggable: true, multiple: true}" />

                </el-tab-pane>
                <el-tab-pane name="audit" lazy>
                    <div slot="label">
                        <i class="ti-gallery"></i>
                        Audit
                    </div>
                    <audit :id="openedRequest.id" type="request" show-filter />
                </el-tab-pane>
            </el-tabs>
        </ui-drawer>
        <!-- <div :class="[{[$refs.greeting.timeOfDay + '-time']: true}]" v-if="$refs.greeting"></div> -->

    </div>
</template>

<script>
    import Heading from 'components/Heading'
    import Greeting from 'components/Greeting'

    import WeatherCardLoader from 'components/tenant/WeatherCard/Loader'
    import WeatherCardErrorFallback from 'components/tenant/WeatherCard/Error'

    import LatestPropertyManagersCardLoader from 'components/tenant/LatestPropertyManagersCard/Loader'
    import LatestPropertyManagersCardErrorFallback from 'components/tenant/LatestPropertyManagersCard/Error'

    import RequestsStatisticsCardLoader from 'components/tenant/RequestsStatisticsCard/Loader'
    import RequestsStatisticsCardErrorFallback from 'components/tenant/RequestsStatisticsCard/Error'

    import LatestPostsCardLoader from 'components/tenant/LatestPostsCard/Loader'
    import LatestPostsCardErrorFallback from 'components/tenant/LatestPostsCard/Loader'

    import LatestRequestsCardLoader from 'components/tenant/LatestRequestsCard/Loader'
    import LatestRequestsCardErrorFallback from 'components/tenant/LatestRequestsCard/Loader'

    import {TweenMax, Elastic} from 'gsap'

    export default {
        components: {
            Heading,
            Greeting,
            rateCard: () => ({
                component: import(/* webpackChunkName: "rateCard" */ 'components/tenant/RateCard'),
                delay: 0,
                timeout: 8000
            }),
            latestPostsCard: () => ({
                component: import(/* webpackChunkName: "latestPostsCard" */ 'components/tenant/LatestPostsCard'),
                loading: LatestPostsCardLoader,
                error: LatestPostsCardErrorFallback,
                delay: 0,
                timeout: 8000
            }),
            latestProductsCard: () => ({
                component: import(/* webpackChunkName: "latestProductsCard" */ 'components/tenant/LatestProductsCard'),
                delay: 0,
                timeout: 8000
            }),
            latestPropertyManagersCard: () => ({
                component: import(/* webpackChunkName: "latestPropertyManagersCard" */ 'components/tenant/LatestPropertyManagersCard'),
                loading: LatestPropertyManagersCardLoader,
                error: LatestPropertyManagersCardErrorFallback,
                delay: 0,
                timeout: 8000
            }),
            latestRequestsCard: () => ({
                component: import(/* webpackChunkName: "latestRequestsCard" */ 'components/tenant/LatestRequestsCard'),
                loading: LatestRequestsCardLoader,
                error: LatestRequestsCardErrorFallback,
                delay: 0,
                timeout: 8000
            }),
            latestMyNeighboursCard: () => ({
                component: import(/* webpackChunkName: "latestMyNeighboursCard" */ 'components/tenant/LatestMyNeighboursCard'),
                delay: 0,
                timeout: 8000
            }),
            requestsStatisticsCard: () => ({
                component: import(/* webpackChunkName: "requestsStatisticsCard" */ 'components/tenant/RequestsStatisticsCard'),
                loading: RequestsStatisticsCardLoader,
                error: RequestsStatisticsCardErrorFallback,
                delay: 0,
                timeout: 8000
            }),
            weatherCard: () => ({
                component: import(/* webpackChunkName: "weatherCard" */ 'components/tenant/WeatherCard'),
                loading: WeatherCardLoader,
                error: WeatherCardErrorFallback,
                delay: 0,
                timeout: 8000
            }),
        },
        data () {
            return {
                loading: false,
                media: [],
                openedRequest: null,
                visibleDrawer: false,
                activeDrawerTab: 'chat',
                activeDrawerMediaTab: 0,
            }
        },
        methods: {
            resetDataFromDrawer () {
                this.activeDrawerTab = 'chat'
                this.openedRequest = null
            },
            viewDetailRequest(evt, request) {
                this.activeDrawerTab = 'chat'
                this.openedRequest = request

                this.visibleDrawer = !this.visibleDrawer
            }
        },
        mounted () {
            // TweenMax.staggerFrom(, 2, {scale:0.5, opacity:0, delay:0.5, ease:Elastic.easeOut, force3D:true}, 0.2)
        }
    }
</script>

<style lang="scss" scoped>
    .dashboard {
        .heading {
            .description {
                color: darken(#fff, 40%);
            }
        }

        .el-divider {
            background: linear-gradient(to right, var(--border-base-color), transparent 56%);
        }

        &:before {
            content: '';
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-image: url('~img/5d2212060e9f6.png');
            background-position: 0 -10em;
            background-repeat: no-repeat;
            background-attachment: fixed;
            pointer-events: none;
            z-index: -1;
            filter: opacity(.16);
        }

        .row {
            display: grid;
            grid-gap: 12px;
            grid-template-columns: repeat(auto-fill, minmax(448px, 1fr));

            .column {
                display: grid;
                grid-gap: 12px;
                grid-auto-rows: min-content;
                will-change: transform;

                .el-card,
                .ui-card {
                    background-color: transparentize(#fff, .28);
                    will-change: width, height, transform;
                }
            }
        }
    }
</style>
