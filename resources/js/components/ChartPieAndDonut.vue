<template>
    <div>
      <apexchart :type="type" width='400' height='400' :options="chartOptions" :series="series" />
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
            },
            type: {
                type: String,
                required: true
            }
    },  
  data() {
    return {        
        
    }
  },
  computed:{
    series: function(){        
        return this.yData;
    },
    chartOptions: function(){
        return {
          labels: this.xData,
          responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 350
                },
                legend: {
                    show: false
                }
            }
          }],
          legend: {
                show: true,                                
           },
           chart:{
                 toolbar: {
                    show: true,
                 },
                 autoSelected: ''
            }
        }
    }
  }  
}
</script>