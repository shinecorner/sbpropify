<template>
    <div class="tenants-by-device-chart">
        <el-row type="flex">
            <el-col :span="24">
                <apexchart type="donut" :options="chartOptions" :series="series" />
            </el-col>
        </el-row>
        <el-row type="flex">
            <el-col :span="8">
                
            </el-col>
        </el-row>
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import axios from '@/axios';

import chartMixin from '../mixins/adminDashboardChartMixin';

export default {
  components: {
    'apexchart': VueApexCharts
  },
  mixins: [chartMixin()],
  props: {
    colNum: {
        type: Number
    }
  },
  computed:{
    chartOptions: function(){
      let responsive = [];
      if (this.colNum == 2) {
        responsive = [{
          breakpoint: 1000,
          options: {
            chart: {
              width: '100%',
              height: 'auto'
            }
          }
        }];
      }
      else {
        responsive = [{
          breakpoint: 1500,
          options: {
            chart: {
              width: '100%',
              height: 'auto'
            }
          }
        }];
      }
      return {
        labels: this.xData,
        responsive: responsive,
        legend: {
          show: false
        },
        chart:{
          toolbar: this.toolbar,
          width: '100%',
          height: 270
        },
        colors: ['#218BFB', '#84BFFD', '#B5D8FD'],
        plotOptions: {
          pie: {
            donut: {
              size: '80%'
            }
          }
        }
      }
    }
  },
  methods: {
      fetchData() {
          let that = this;                                               
          let url = 'admin/chartLoginDevice';

          return axios.get(url)
          .then(function (response) {
              that.yData = response.data.data.data.map(val => parseFloat(val) || 0);
              that.xData = response.data.data.labels;
          }).catch(function (error) {
              console.log(error);
          })
      }
  }
}
</script>
<style lang="scss">
    .chart-card {
        .tenants-by-device-chart .apexcharts-canvas {
            margin-top: 25px;
            @media screen and (max-width: 1650px) {
              margin-top: 30px;
            }
        }
        .tenants-by-device-chart {
            position: relative;

            .apexcharts-canvas {
                position: unset;
            }
        }
    }
</style>
