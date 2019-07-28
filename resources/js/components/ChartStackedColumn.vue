<template>
    <div class="stackchart">
        <div class="chart-filter">
          <el-radio-group v-model="period" class="stack-radios">                
              <el-radio-button label="day">{{$t('timestamps.days')}}</el-radio-button>
              <el-radio-button label="month">{{$t('timestamps.months')}}</el-radio-button>
              <el-radio-button label="week">{{$t('timestamps.weeks')}}</el-radio-button>
              <el-radio-button label="year">{{$t('timestamps.years')}}</el-radio-button>
          </el-radio-group>
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
                <apexchart ref="stackColumnChart" width="100%" height="310" type="bar" :options="chartOptions" :series="series"></apexchart>
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
            period: 'day',
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
              horizontalAlign: 'center',

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
      fetchData(){
            let that = this;                                               
            let url = '';						
            if(this.type === 'request_by_creation_date'){
                    url = 'admin/chartRequestByCreationDate';
            }
            let params = {
              period: that.period
            };
            if (this.dateRange != null) {
              params.start_date = this.dateRange[0],
              params.end_date = this.dateRange[1]
            }
            return axios.get(url,{
            	params: params
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
        dateRange: function(val) {
            this.fetchData();
        },
        period: function (val) {
            this.fetchData();
        }
    }
}
</script>

<style scoped>
  .stack-radios {
    margin-right: 5px;
  }
</style>
