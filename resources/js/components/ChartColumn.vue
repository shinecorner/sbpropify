<template>
    <div class="columnchart">
        <div class="chart-filter">
          <el-radio-group v-model="period" class="stack-radios">                
              <el-radio-button label="day">{{$t('timestamps.days')}}</el-radio-button>
              <el-radio-button label="month">{{$t('timestamps.months')}}</el-radio-button>
              <el-radio-button label="week">{{$t('timestamps.weeks')}}</el-radio-button>
              <el-radio-button label="year">{{$t('timestamps.years')}}</el-radio-button>
          </el-radio-group>
          <custom-date-range-picker
            :pickHandler="pickHandler">
          </custom-date-range-picker>
        </div>    
        <el-row type="flex">
            <el-col :span="24">
                <apexchart width="100%" height="310" type="bar" :options="chartOptions" :series="series"></apexchart>
            </el-col>
        </el-row>        
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import {format, subDays, isBefore, isAfter, parse} from 'date-fns'
import axios from '@/axios';

import CustomDateRangePicker from 'components/CustomDateRangePicker';

export default {  
  components: {
    'apexchart': VueApexCharts,
    CustomDateRangePicker
  },
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
    }
  },    
  computed: {    
    series: function(){  
      return this.yData;
    },
    chartOptions: function(){
      return {  
        chart: {
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
      if(this.type === 'buildings_by_creation_date'){
        url = 'admin/chartBuildingsByCreationDate';
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
        that.yData = [{name: 'count', data: response.data.data.requests_per_day_ydata}];
        that.xData = response.data.data.requests_per_day_xdata;
      }).catch(function (error) {
          console.log(error);
      })
    },

    pickHandler(val) {
      this.dateRange = val;
      this.fetchData();
    }
  },
  created(){
    this.fetchData();
  },
  watch:{
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
