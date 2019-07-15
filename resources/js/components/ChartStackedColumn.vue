<template>
    <div>
      <apexchart width="100%" height="350" type="bar" :options="chartOptions" :series="series"></apexchart>
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
              horizontalAlign: 'center',
              width: 750
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