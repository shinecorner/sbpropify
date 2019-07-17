<template>
    <div>
        <heading class="custom-heading" icon="ti-home" title="Dashboard" shadow="heavy" />
        <el-row :gutter="20" class="dashboard" style="margin-bottom: 24px;" type="flex">
            <el-col class="dashboard-tabpanel">
                <el-tabs type="border-card">
                    <el-tab-pane :label="$t('menu.requests')">
                        <el-row style="margin-bottom: 24px;" type="flex">
                            <el-col :span="24">
                                <dashboard-statistics-card :totalRequest="totalRequest" :data="reqStatusCount" :avgReqDuration="avgReqDuration"></dashboard-statistics-card>
                            </el-col>                            
                        </el-row>
                        <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                            <el-col :span="24">
                                <el-card class="chart-card" :header="$t('dashboard.requests_by_creation_date')">
                                    <chart-stacked-column 
                                                :yData="chartDataTotalReqByCreationDate.yData" 
                                                :xData="chartDataTotalReqByCreationDate.xData">
                                    </chart-stacked-column>                                    
                                </el-card>
                            </el-col>                                                        
                         </el-row>   
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="12">
                                <el-card class="chart-card" :header="$t('dashboard.requests_by_status')">
                                    <chart-pie-and-donut 
                                        type="pie"
                                        :xData="chartDataReqByStatus.xData" 
                                        :yData="chartDataReqByStatus.yData">
                                    </chart-pie-and-donut>
                                </el-card>
                            </el-col>                            
                            <el-col :span="12">
                                <el-card class="chart-card" :header="$t('dashboard.requests_by_category')">
                                    <chart-pie-and-donut
                                        type="donut"
                                        :xData="chartDataReqByCategory.xData" 
                                        :yData="chartDataReqByCategory.yData">
                                    </chart-pie-and-donut>
                                </el-card>                                
                            </el-col>                           
                        </el-row>
                        <el-row :gutter="20" style="margin-bottom: 24px;" type="flex">
                            <el-col :span="12">
                                <el-card class="chart-card" :header="$t('dashboard.each_hour_request')">
                                    <chart-heat-map
                                        :xData="chartDataReqByHour.xData" 
                                        :yData="chartDataReqByHour.yData">
                                    </chart-heat-map>
                                </el-card>                                
                            </el-col>
                        </el-row>    
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.buildings')">
                        {{'Second Tab'}}
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.news')">
                        {{'Content Third tab'}}
                    </el-tab-pane>
                    <el-tab-pane :label="$t('menu.marketplace')">
                        {{'Fourth Tab'}}
                    </el-tab-pane>                                      
                    <el-tab-pane :label="$t('menu.tenants')">
                        {{'Fourth Tab'}}
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
            ChartHeatMap
        },
        data() {
            return {
                totalRequest: 0,
                avgReqDuration: '',
                chartDataTotalReqByCreationDate: {                                        
                    yData: [],
                    xData: []
                },
                chartDataReqByStatus: {
                    xData: [],
                    yData: []
                },
                chartDataReqByCategory:{
                    xData: [],
                    yData: []
                },
                chartDataReqByHour:{
                    xData: [],
                    yData: []
                },
                chartOptionsTotalReqByCreationDate: {},
                reqStatusCount: {
                    data: [],
                    labels: []
                },
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
                }]
            }
        },
        methods: {            
            getReqStatastics() {
                let that = this;                                               
                
                return axios.get('admin/statistics')
                .then(function (response) { 
                    
                    that.reqStatusCount.data = response.data.data.requests_per_status.data;
                    that.reqStatusCount.labels = response.data.data.requests_per_status.labels;

                    that.totalRequest = response.data.data.total_requests;
                    that.avgReqDuration = response.data.data.avg_request_duration;
                    that.chartDataReqByStatus.xData = response.data.data.requests_per_status.labels.map(function(e){return that.$t('models.request.status.'+e)});
                    that.chartDataReqByStatus.yData = response.data.data.requests_per_status.data;
                    
                    
                    
                    that.chartDataReqByCategory.xData = response.data.data.requests_per_category.labels;
                    that.chartDataReqByCategory.yData = response.data.data.requests_per_category.data;
                    
                    that.chartDataTotalReqByCreationDate.yData = response.data.data.requests_per_day_ydata;
                    that.chartDataTotalReqByCreationDate.xData = response.data.data.requests_per_day_xdata;
                    
                }).catch(function (error) {
                    console.log(error);
                })
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
</style>
