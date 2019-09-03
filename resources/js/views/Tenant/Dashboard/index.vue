<template>
    <div class="dashboard">
        <heading icon="ti-home" title="My dashboard">
            <greeting ref="greeting" class="description" slot="description" />
        </heading>
        <el-divider />
        <div class="row" name="fade" tag="div" ref="widgets">
            <div class="column">
                <weather-card class="widget" />
                <latest-property-managers-card class="widget" />
                <latest-my-neighbours-card class="widget" />
            </div>
            <div class="column">
                <requests-statistics-card class="widget" />
                <latest-requests-card class="widget" />
                <latest-posts-card class="widget" />
            </div>
            <div class="column">
                <latest-products-card class="widget" />
                <rate-card />
            </div>
        </div>
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
