<template>
    <div class="stackchart">
        <el-row type="flex" class="chart-filter">
            <el-col :span="24">
                <el-radio-group v-model="radio1">
                    <el-radio-button label="Day"></el-radio-button>
                    <el-radio-button label="Month"></el-radio-button>                                        
                </el-radio-group>
                <el-date-picker
                    v-model="start_date"
                    type="date"
                    placeholder="Pick a day">
                </el-date-picker>
                <el-date-picker
                    v-model="end_date"
                    type="date"
                    placeholder="Pick a day">
                </el-date-picker>
            </el-col>
        </el-row>    
        <el-row style="margin-bottom: 24px;" type="flex">
            <el-col :span="24">
                <apexchart width="100%" height="310" type="bar" :options="chartOptions" :series="series"></apexchart>
            </el-col>
        </el-row>        
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'

export default {
  components: {'apexchart': VueApexCharts},
  props: {
            xData: {
                type: Array,
                required: true
            },
            yData: {
                type: Array,
                required: true
            }
    },  
    data() {
        return {        
            radio1: 'Day',
            start_date: '',
            end_date: '',
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
              type: 'datetime',
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
        
      }
}
</script>