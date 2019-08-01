<template>
    <div class="stackchart">
        <div class="chart-filter in-toolbar">
          <el-radio-group v-model="period" class="stack-radios">                
              <el-radio-button label="day">{{$t('timestamps.days')}}</el-radio-button>
              <el-radio-button label="week">{{$t('timestamps.weeks')}}</el-radio-button>
              <el-radio-button label="month">{{$t('timestamps.months')}}</el-radio-button>
              <el-radio-button label="year">{{$t('timestamps.years')}}</el-radio-button>
          </el-radio-group>
          <custom-date-range-picker :rangeType="period" :initialRange="dateRange"
            :pickHandler="pickHandler">
          </custom-date-range-picker>
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
            dateRange: [format(subDays(new Date(), 28), 'DD.MM.YYYY'), format(new Date(), 'DD.MM.YYYY')],
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
              formatter: value => {
                const realValue = value.toString();
                if (realValue.match(/[a-zA-Z]+/gi)) {
                  switch (this.type) {
                    case 'news_by_creation_date':
                      return this.$t('models.post.status.' + realValue);
                    case 'products_by_creation_date':
                      return this.$t('models.product.status.' + realValue);
                    case 'tenants_by_creation_date':
                      return this.$t('models.tenant.status.' + realValue);
                  }
                }
                return realValue;
              }
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
        else if (this.type === 'news_by_creation_date') {
          url = 'admin/chartByCreationDate?table=posts';
        }
        else if (this.type === 'products_by_creation_date') {
          url = 'admin/chartByCreationDate?table=products';
        }
        else if (this.type === 'tenants_by_creation_date') {
          url = 'admin/chartByCreationDate?table=tenants';
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
        },
        '$i18n.locale' : function(val) {
          this.fetchData();
        }
    }
}
</script>

<style scoped>
  .stackchart {
    position: relative;
  }
  .stack-radios {
    margin-right: 5px;
  }
</style>
