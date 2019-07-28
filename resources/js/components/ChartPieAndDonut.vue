<template>
    <div class="piechart">
        <div class="chart-filter">              
            <el-date-picker
                v-model="dateRange"
                type="daterange"
                align="right"
                unlink-panels
                range-separator="To"
                start-placeholder="Start date"
                end-placeholder="End date"
                format="dd.MM.yyyy"
                value-format="dd.MM.yyyy"
                :picker-options="pickerOptions">
            </el-date-picker>
        </div>
        <el-row type="flex">
            <el-col :span="24">
                <apexchart :type="chartType" :options="chartOptions" :series="series" />
            </el-col>
        </el-row>       
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import {format, subDays, isBefore, isAfter, parse} from 'date-fns'
import axios from '@/axios';

export default {
  components: {'apexchart': VueApexCharts},
  props: {            
            type: {
                type: String,
                required: true
            }
    },  
  data() {
    return {        
        chartType: 'pie',
        dateRange: [subDays(new Date(), 28), new Date()],
        xData: [],
        yData: [],
        pickerOptions: {
            shortcuts: [{
                text: 'Last week',
                onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', [start, end]);
                }
            }, {
                text: 'Last month',
                onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                    picker.$emit('pick', [start, end]);
                }
            }, {
                text: 'Last 3 months',
                onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                    picker.$emit('pick', [start, end]);
                }
            }, {
                text: 'Last 6 months',
                onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 183);
                    picker.$emit('pick', [start, end]);
                }
            }, {
                text: 'Last year',
                onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 365);
                    picker.$emit('pick', [start, end]);
                }
            }, {
                text: 'Last 2 years',
                onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 730);
                    picker.$emit('pick', [start, end]);
                }
            }]
        },
    }
  },
  computed:{
    chartWidth: function() {
        if (this.type === 'request_by_status') {
            return 490;
        }
        else {
            return 490;
        }
    },
    series: function(){        
        return this.yData;
    },
    chartOptions: function(){
        return {
            labels: this.xData,
            responsive: [{
                breakpoint: 1210,
                options: {
                    chart: {
                        width: '100%',
                        height: 'auto'
                    },
                    legend: {
                        position: 'bottom',
                        width: undefined
                    }
                }
            }, {
                breakpoint: 480,
                options: {
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                show: true,
                width: 170
            },
            chart:{
                toolbar: {
                    show: true,
                },
                autoSelected: '',
                width: this.chartWidth,
                height: 320
            }
        }
    }
  },
    methods: {
        fetchData(){
            let that = this;                                               
            let url = '';						
            if(this.type === 'request_by_status'){
                this.chartType = 'pie';
                url = 'admin/donutChart';
            }
            else if(this.type === 'request_by_category'){
                this.chartType = 'donut';
                url = 'admin/donutChartRequestByCategory';
            }
            let params = {};
            if (this.dateRange != null) {
              params.start_date = this.dateRange[0],
              params.end_date = this.dateRange[1]
            }

            return axios.get(url,{
            	params: params
            })
            .then(function (response) {
                if(that.type === 'request_by_status'){                    
                    that.yData = response.data.data.data;
                    that.xData = response.data.data.labels.map(function(e){return that.$t('models.request.status.'+e)});
                }
                else if(that.type === 'request_by_category'){
                    that.yData = response.data.data.data;
                    that.xData = response.data.data.labels;
                }                
            }).catch(function (error) {
                console.log(error);
            })
        }
    },
    watch:{
        dateRange: function(val) {
            this.fetchData();
        }     
    },
    created(){        
        this.fetchData();        
    },
}
</script>
<style lang="scss">
    .piechart {
        max-height: 420px;

        .apexcharts-canvas {
            position: unset;
        }
    }
</style>
