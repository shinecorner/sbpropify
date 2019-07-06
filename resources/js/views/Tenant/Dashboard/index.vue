<template>
    <div class="dashboard">
        <el-card v-sticky="{stickyTop: -32}">
            <heading icon="ti-home" title="My dashboard">
                <div slot="description">
                    <greeting/>
                </div>
            </heading>
        </el-card>
        <el-divider/>
        <el-row :gutter="24">
            <el-col :md="8">
                <el-row :gutter="24">
                    <el-col :md="24" :sm="24" :xs="24">
                        <weather/>
                    </el-col>
                    <el-col :md="24" :sm="24" :xs="24">
                        <property-managers/>
                    </el-col>
                    <el-col :md="24" :sm="24" :xs="24">
                        <my-neighbours/>
                    </el-col>
                </el-row>
            </el-col>
            <el-col :md="8">
                <el-row :gutter="24">
                    <el-col :md="24" :sm="24" :xs="24">
                        <requests-statistics/>
                    </el-col>
                    <el-col :md="24" :sm="24" :xs="24">
                        <latest-requests/>
                    </el-col>
                    <el-col :md="24" :sm="24" :xs="24">
                        <latest-news/>
                    </el-col>
                </el-row>
            </el-col>
            <el-col :md="8">
                <el-row :gutter="24">
                    <el-col :md="24" :sm="24" :xs="24">
                        <latest-products :limit="4"/>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import Heading from 'components/Heading'
    import Greeting from 'components/Greeting'
    import Weather from 'components/tenant/WeatherWidget'
    import LatestNews from 'components/tenant/LatestNewsWidget'
    import MyNeighbours from 'components/tenant/MyNeighboursWidget'
    import LatestRequests from 'components/tenant/LatestRequestsWidget'
    import LatestProducts from 'components/tenant/LatestProductsWidget'
    import PropertyManagers from 'components/tenant/PropertyManagersWidget'
    import RequestsStatistics from 'components/tenant/RequestsStatisticsWidget'
    import VueSticky from 'vue-sticky'

    export default {
        components: {
            Heading,
            Greeting,
            Weather,
            LatestNews,
            MyNeighbours,
            LatestRequests,
            LatestProducts,
            PropertyManagers,
            RequestsStatistics
        },
        directives: {
            sticky: VueSticky
        },
    }
</script>

<style lang="scss" scoped>
    .dashboard {
        height: 100% !important;
        margin: -2em;
        padding: 2em;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;

        > .el-card {
            :global(.el-card__body) {
                padding: 12px 16px;

                .heading div {
                    color: darken(#fff, 40%);
                }
            }
        }

        .el-row {
            .el-col {
                &:not(:last-child) {
                    margin-bottom: 24px;
                }
            }

            &:not(:last-child) {
                margin-bottom: 24px;
            }
        }
    }
</style>
