<template>
    <div class="stackchart">
        <el-row type="flex" class="chart-filter">
            <el-col :span="24">
                <el-radio-group v-model="period">
                    <el-radio-button label="day">{{$t('timestamps.days')}}</el-radio-button>
                    <el-radio-button label="month">{{$t('timestamps.months')}}</el-radio-button>
                    <el-radio-button label="week">{{$t('timestamps.weeks')}}</el-radio-button>
                    <el-radio-button label="year">{{$t('timestamps.years')}}</el-radio-button>
                </el-radio-group>
                <el-date-picker
                        v-model="startDate"
                        type="date"
                        format="dd.MM.yyyy"
                        value-format="dd.MM.yyyy"
                >
                </el-date-picker>
                <el-date-picker
                        v-model="endDate"
                        type="date"
                        format="dd.MM.yyyy"
                        value-format="dd.MM.yyyy"
                >
                </el-date-picker>
            </el-col>
        </el-row>
        <el-row style="margin-bottom: 24px;" type="flex">
            <el-col :span="24">
                <apexchart ref="stackColumnChart" width="100%" height="310" type="bar" :options="chartOptions" :series="series"></apexchart>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import VueApexCharts from 'vue-apexcharts'
    import FormatDateTimeMixin from 'mixins/formatDateTimeMixin'
    import {format} from 'date-fns'
    import axios from '@/axios';

    export default {
        mixins: [FormatDateTimeMixin],
        components: {'apexchart': VueApexCharts},
        props: {
            type: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                period: 'day',
                startDate: '',
                endDate: '',
                xData: [],
                yData: []
            }
        },
        computed: {
            series: function(){
                return this.yData;
            },
            chartOptions: function(){
                return {
                    chart: {
                        stacked: true,
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: true,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false
                            },
                        },
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: 0,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                        },
                    },

                    xaxis: {
                        categories: this.xData,
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center'
                    },
                    fill: {
                        opacity: 1
                    },
                    dataLabels:{
                        enabled: false,
                    }
                }
            }
        },
        methods: {
            changeStartDate(type){

            },
            fetchData(){
                let that = this;
                let url = '';
                if(this.type === 'request_by_creation_date'){
                    url = 'admin/chartRequestByCreationDate';
                }
                return axios.get(url,{
                    params: {
                        start_date: that.startDate,
                        end_date: that.endDate,
                        period: that.period
                    }
                })
                    .then(function (response) {
                        that.yData = response.data.data.requests_per_day_ydata;
                        that.xData = response.data.data.requests_per_day_xdata;

                    }).catch(function (error) {
                        console.log(error);
                    })
            }
        },
        created(){
            if(this.type === 'request_by_creation_date'){
                this.fetchData();
            }
        },
        watch:{
            startDate: function (val) {
                this.fetchData();
            },
            endDate: function (val) {
                this.fetchData();
            },
            period: function (val) {
                this.fetchData();
            }
        }
    }
</script>
