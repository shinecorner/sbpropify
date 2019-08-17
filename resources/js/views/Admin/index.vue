<template>
    <div style="flex-grow: 1;">
        <heading class="custom-heading" :icon="headingIcon" :title="$t(`menu.${activeName}`)" shadow="heavy" />
        <el-row :gutter="20" class="dashboard" style="margin-bottom: 24px;" type="flex">
            <el-col class="dashboard-tabpanel">
                <el-tabs type="border-card" @tab-click="handleTabClick" v-model="activeName">
                    <el-tab-pane :label="$t('menu.requests')" name="requests">
                        <el-row type="flex">
                            <el-col :span="24">
                                <dashboard-statistics-card :totalRequest="totalRequest" :data="reqStatusCount" :avgReqDuration="avgReqDuration" :animationTrigger="activeName"></dashboard-statistics-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.requests_by_creation_date')">
                                    <chart-stacked-column type="request_by_creation_date" :startDate="startDates.requests"></chart-stacked-column>
                                </el-card>
                            </el-col>
                         </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.requests_by_status')">
                                    <chart-pie-and-donut type="request_by_status" :colNum="3" :startDate="startDates.requests"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.requests_by_category')">
                                    <chart-pie-and-donut type="request_by_category" :colNum="3" :startDate="startDates.requests"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.requests_by_assigned_status')">
                                    <chart-pie-and-donut type="request_by_assigned_status" :colNum="3" :startDate="startDates.requests"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card">
                                    <el-tabs v-model="activeChart" @tab-click="handleHeatmapTabClick">
                                        <el-tab-pane :label="$t('dashboard.week_hour')" name="week">
                                            <div class="chart-filter in-toolbar">              
                                                <el-date-picker
                                                    v-model="weekSelected"
                                                    type="week"
                                                    :format="$t('general.date_range.week') + ' WW.yyyy'"
                                                    value-format="dd.MM.yyyy"
                                                    :placeholder="$t('general.date_range.peek_week')"
                                                    popper-class="custom-week-panel"
                                                >
                                                </el-date-picker>
                                            </div>
                                            <chart-heat-map type="week-hour" :tab="activeChart" :week="weekSelected"></chart-heat-map>
                                        </el-tab-pane>
                                        <el-tab-pane :label="$t('dashboard.month_date')" name="month">
                                            <chart-heat-map type="month-date" :tab="activeChart"></chart-heat-map>
                                        </el-tab-pane>
                                    </el-tabs>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="12">
                                <el-card class="chart-card" :header="$t('dashboard.requests.property_managers')">
                                    <dashboard-managers-list type="property-managers"></dashboard-managers-list>
                                </el-card>
                            </el-col>
                            <el-col :span="12">
                                <el-card class="chart-card" :header="$t('dashboard.requests.service_partners')">
                                    <dashboard-services-list type="service-partners"></dashboard-services-list>
                                </el-card>
                            </el-col>
                        </el-row>
                     
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.buildings')" name="buildings">
                        <el-row type="flex">
                            <el-col :span="24">
                                <buildings-statistics-card :data="buildingStatistics" :animationTrigger="activeName"></buildings-statistics-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.buildings.buildings_by_creation_date')">
                                    <chart-column-line type="buildings_by_creation_date" :startDate="startDates.buildings"></chart-column-line>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.buildings.buildings_map')">
                                    <dashboard-google-map type="buildings"></dashboard-google-map>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="16">
                                <el-card class="chart-card" :header="$t('dashboard.buildings.latest_buildings')">
                                    <dashboard-latest-buildings type="buildings"></dashboard-latest-buildings>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.buildings.buildings_by_state')">
                                    <chart-pie-and-donut type="buildings_by_state" :cented="true" :colNum="3" :startDate="startDates.requests"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                        </el-row>
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.news')" name="news">
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.news_by_creation_date')">
                                    <chart-stacked-column type="news_by_creation_date" :startDate="startDates.posts"></chart-stacked-column>
                                </el-card>
                            </el-col>
                         </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.news_by_status')">
                                    <chart-pie-and-donut type="news_by_status" :colNum="3" :startDate="startDates.posts"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.news_by_type')">
                                    <chart-pie-and-donut type="news_by_type" :colNum="3" :startDate="startDates.posts"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="16">
                                <el-card class="chart-card" :header="$t('dashboard.news.latest_news')">
                                    <dashboard-latest-news type="latest_news"></dashboard-latest-news>
                                </el-card>
                            </el-col>
                        </el-row>
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.marketplace')" name="marketplace">
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.products_by_creation_date')">
                                    <chart-stacked-column type="products_by_creation_date" :startDate="startDates.products"></chart-stacked-column>
                                </el-card>
                            </el-col>
                         </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.products_by_type')">
                                    <chart-pie-and-donut type="products_by_type" :colNum="3" :startDate="startDates.products"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="16">
                                <el-card class="chart-card" :header="$t('dashboard.latest_products')">
                                    <dashboard-latest-products type="latest_products"></dashboard-latest-products>
                                </el-card>
                            </el-col>
                        </el-row>
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.tenants')" name="tenants">
                        <el-row type="flex">
                            <el-col :span="24">
                                <tenants-statistics-card :data="tenantsStatistics" :animationTrigger="activeName"></tenants-statistics-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.tenants_by_creation_date')">
                                    <chart-stacked-column type="tenants_by_creation_date" :startDate="startDates.tenants"></chart-stacked-column>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.tenants_by_request_status')">
                                    <chart-pie-and-donut type="tenants_by_request_status" :colNum="3" :startDate="startDates.tenants"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.tenants_by_status')">
                                    <chart-pie-and-donut type="tenants_by_status" :colNum="3" :startDate="startDates.tenants"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.tenants_by_language')">
                                    <chart-pie-and-donut type="tenants_by_language" :colNum="3" :startDate="startDates.tenants"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="16">
                                <el-card class="chart-card" :header="$t('dashboard.tenants.latest_tenants')">
                                    <dashboard-latest-tenants type="tenants"></dashboard-latest-tenants>
                                </el-card>
                            </el-col>
                             <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.tenants_by_device')">
                                    <chart-users-by-device type="tenants_by_device" :colNum="3" :startDate="startDates.tenants"></chart-users-by-device>
                                </el-card>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.tenants_by_title')">
                                    <chart-pie-and-donut type="tenants_by_title" :colNum="3" :startDate="startDates.tenants" :centered="true"></chart-pie-and-donut>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card class="chart-card col-3" :header="$t('dashboard.tenants_by_gender')">
                                    <chart-tenants-by-gender type="tenants_by_gender" :startDate="startDates.tenants"></chart-tenants-by-gender>
                                </el-card>
                            </el-col>
                           
                        </el-row>
                     
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import axios from '@/axios';
    import DashboardStatisticsCard from 'components/DashboardStatisticsCard';
    import ChartStackedColumn from 'components/ChartStackedColumn';
    import ChartPieAndDonut from 'components/ChartPieAndDonut'; 
    import ChartHeatMap from 'components/ChartHeatMap';
    import Heading from 'components/Heading';
    import RawGridStatisticsCard from 'components/RawGridStatisticsCard';
    import ColoredStatisticsCard from 'components/ColoredStatisticsCard.vue';
    import ProgressStatisticsCard from 'components/ProgressStatisticsCard.vue';
    import CircularProgressStatisticsCard from 'components/CircularProgressStatisticsCard.vue';

    import BuildingsStatisticsCard from 'components/BuildingsStatisticsCard';
    import ChartColumnLine from 'components/ChartColumnLine';
    import ChartUsersByDevice from 'components/ChartUsersByDevice';
    import ChartTenantsByGender from 'components/ChartTenantsByGender';
    import TenantsStatisticsCard from 'components/TenantsStatisticsCard';

    import DashboardLatestProducts from 'components/DashboardLatestProducts';
    import DashboardGoogleMap from 'components/DashboardGoogleMap';
    import DashboardLatestBuildings from 'components/DashboardLatestBuildings';
    import DashboardLatestTenants from 'components/DashboardLatestTenants';
    import DashboardManagersList from 'components/DashboardManagersList';
    import DashboardServicesList from 'components/DashboardServicesList';
    import DashboardLatestNews from 'components/DashboardLatestNews';

    export default {
        name: 'AdminDashboard',
        components: {
            Heading,
            DashboardStatisticsCard,
            ColoredStatisticsCard,
            ProgressStatisticsCard,
            CircularProgressStatisticsCard,
            ChartStackedColumn,
            ChartPieAndDonut,
            ChartHeatMap,
            BuildingsStatisticsCard,
            ChartColumnLine,
            ChartTenantsByGender,
            ChartUsersByDevice,
            TenantsStatisticsCard,
            DashboardLatestProducts,
            DashboardGoogleMap,
            DashboardLatestBuildings,
            DashboardLatestTenants,
            DashboardManagersList,
            DashboardServicesList,
            DashboardLatestNews
        },
        data() {
            return {
                totalRequest: "0",
                avgReqDuration: '',                
                chartDataReqByHour:{
                    xData: [],
                    yData: []
                },
                chartOptionsTotalReqByCreationDate: {},
                reqStatusCount: {},
                buildingStatistics: {},
                tenantsStatistics: {},
                statistics: [{
                    icon: 'ti-shopping-cart',
                    color: '#f06292',
                    value: 648,
                    description: 'Requests open'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#26c6da',
                    value: '47.5k',
                    description: 'Requests pending'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#9575cd',
                    value: 764,
                    description: 'Requests done'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#1a237e',
                    value: 256,
                    description: 'Requests archived'
                }],
                liteStatistics: [{
                    icon: 'ti-shopping-cart',
                    color: '#9575cd',
                    value: 764,
                    description: 'Daily earnings'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#1a237e',
                    value: 256,
                    description: 'Products'
                }],
                headingIcon: 'icon-chat-empty',
                activeName: 'requests',
                activeChart: 'week',
                weekSelected: null,
                startDates: {
                    requests: '',
                    buildings: '',
                    posts: '',
                    products: '',
                    tenants: ''
                },
            }
        },
        computed: {
        },
        methods: {
            getReqStatastics() {
                let that = this;

                return axios.get('admin/statistics')
                .then(function (response) {
                    that.reqStatusCount = response.data.data.requests_per_status;

                    that.totalRequest = response.data.data.total_requests;
                    that.avgReqDuration = response.data.data.avg_request_duration;

                    that.buildingStatistics = {
                        total_buildings: response.data.data.total_buildings,
                        card_data: response.data.data.buildings_per_status
                    };

                    that.tenantsStatistics = {
                        total_tenants: response.data.data.total_tenants,
                        card_data: response.data.data.tenants_per_status
                    };
                    that.startDates = response.data.data.all_start_dates;
                }).catch(function (error) {
                    console.log(error);
                })
            },

            handleTabClick(tab, event) {
                const icons = {
                    'requests': 'icon-chat-empty',
                    'buildings': 'icon-commerical-building',
                    'news': 'icon-megaphone-1',
                    'marketplace': 'icon-basket',
                    'tenants': 'icon-group'
                };
                this.headingIcon = icons[tab.name];
            },
            handleHeatmapTabClick(tab, event) {
                
            }
        },
        created(){
            this.getReqStatastics();
        }
    }
</script>


<style lang="scss" scoped>
    .custom-heading {
        margin-bottom: 2em;
    }
    .dashboard{
        padding: 5px;
    }
</style>
<style lang="scss">
.el-row.dashboard {
    margin-top: -110px;

    @media screen and (max-width: 1000px) {
        margin-top: 0;
    }
}
.dashboard-tabpanel{
    .el-tabs--border-card > .el-tabs__header .el-tabs__item{
        flex-basis: 0;
        -webkit-box-flex: 1;    
        flex-grow: 1;
        text-align: center;
        color: #495057;    
        cursor: pointer;    
        font-weight:400;    
        -webkit-box-align: center;
        align-items: center;
        text-align: center;
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 0 13px !important;

        &.is-active, &:hover{
            background: #6AC06F;
            //border-radius: 120px;
            border-right-color: none;
            border-left-color: none;
            -ms-flex-positive: 1;
            color: #fff !important;
            transition: background-color .3s ease,color .3s ease !important;
        }

        &:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        &:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    }
    .el-tabs__nav {
        float: none;
        text-align: center;
        border-radius: 120px;
        padding: .75rem;    
        display: flex;
        flex-wrap: wrap;
        width: fit-content;
        margin: 1.5rem 0 1.5em auto;

        @media screen and (max-width: 1000px) {
            margin: 1.5rem auto;
        }
    }
    .el-tabs--border-card{
        background:none;
    }
    .el-tabs--border-card{
        border: none;
        background: none;
        box-shadow: none;
    }
    .el-tabs--border-card > .el-tabs__header{
        border-bottom: none !important;
        background: none !important;    
    }
    .chart-card{
        //height: 420px;

        overflow: visible;

        .el-card__header {
            padding: 15px;
            font-size: 15px;
        }

        .dashboard-table {
            position: relative;

            .link-container {
                position: absolute;
                top: -55px;
                right: 0px;
                text-align: right;
                padding: 20px 15px;
                font-size: 14px;

                a {
                    text-decoration: none;
                    color: #525252;

                    &:hover {
                        color: #303133;
                    }
                }
            }
        }

        .chart-filter {
            display: flex;
            align-items: center;

            &.in-toolbar {
                position: absolute;
                top: -42px;
                right: 50px;

                background-color: transparent;
                border-bottom: none;
                padding: 0;
            }

            .el-radio-button__inner {
                padding: 8px 12px;
            }

            .el-date-editor {
                width: 135px;

                .el-input__inner {
                    height: 33px;
                    line-height: 33px;
                }

                .el-input__icon {
                    display: flex;
                    justify-content: center;
                    align-items: center;

                    &.el-range__close-icon {
                        display: none;
                    }
                }
            }

            .el-date-editor--week {
                width: 160px;

                input {
                    text-align: center;
                    padding-right: 10px;
                }

                .el-input__suffix {
                    display: none;
                }
            }

            .el-range-editor {
                width: 250px;
                padding: 0 0 0 7px;
                height: 32px;
                line-height: 32px;

                .el-range-separator {
                    width: 6%;
                }
            }
        }

        .apexcharts-toolbar {
            // margin-top: -88px;
            margin-top: -38px;
            margin-right: 7px;
            .apexcharts-menu.open {
                right: 7px;
            }
        }

        .apexcharts-legend.center.position-bottom {
            padding-top: 10px;
        }

        .el-tabs {
            .el-tabs__header {
                margin-bottom: 0;
                .el-tabs__nav {
                    margin: 0;
                    padding: 6px 0;
                    margin-left: 15px;

                    .el-tabs__item {
                        font-size: 16px;
                    }
                }
            }

            .el-tabs__content {
                overflow: visible;
            }
        }
    }
}
.chart-card .el-card__body{
    padding: 0 0 0 0;
}
.chart-filter{
    background-color: #fbfbfb; 
    border-bottom: 1px solid #e1e5eb; 
    padding: .5rem 14px;
}

.dashboard .box-card-count{
    .el-card__body{
        height: 100%;
    }
    .total-box-card-header{
    clear: both;
    padding: 15px 20px 5px 20px;
    opacity: 0.5;
    text-transform: uppercase;
    text-align: center;
    border-bottom: none;
    box-sizing: border-box;
    font-size: 13px;
  }  
  .total-box-card-body{
    clear: both;
    padding: 5px 20px 15px 20px;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1;
    text-align: center;
  }
  .el-divider--horizontal{
    margin: 0 0;
  }
}
.dashboard .box-card{ 
    border: none;
    border-bottom: 4px solid transparent;  
    
    .el-card__header {        
        padding: 20px 20px 0px 20px;       
        opacity: 0.5;     
        text-transform: uppercase;        
        border-bottom: none;
        font-size: 13px;
    }
    .box-card-body{
        display: flex;        
        .box-card-count{
            padding: 8px 20px 12px 20px;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1;
            text-align: left;            
            float: left;
        }
        .box-card-progress{            
            float: left;
            margin-left: auto;
            padding: 0 15px 0 0;
            position: relative;
            top: -27px;
            margin-bottom: -27px;

            .el-progress__text {
                font-size: 13px !important;
            }
        }
    }
}
.el-picker-panel.custom-week-panel {
    line-height: normal;
    width: min-content;

    .el-picker-panel__body-wrapper {
        .el-date-picker__header {
            margin: 10px 7px 0px;

            .el-picker-panel__icon-btn {
                margin-top: 4px;
                padding: 1px 1px;
            }
            .el-date-picker__header-label {
                font-size: 15px;
                padding: 0 2px;
            }
        }
        .el-picker-panel__content {
            padding: 7px 5px 5px 5px;
            margin: 0;
            width: 202px;

            th {
                width: 25px;
                height: 25px;
                padding:2px;
            }

            td {
                padding: 0;
                width: 25px;
                height: 25px;
                max-width: 25px;

                div {
                    width: 25px;
                    height: 25px;
                    padding: 0;
                    margin: 0;
                }
            }
        }
    }
}
</style>
