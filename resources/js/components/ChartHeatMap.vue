<template>
    <div>
        <apexchart type=heatmap height="310" :options="chartOptions" :series="series" />
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts';
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
            series: []
        }
    },
    computed: {
      chartOptions: function() {
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
          dataLabels: {
            enabled: false
          },
          colors: ["#008FFB"],
          yaxis: {
            labels: {
              formatter: (value) => {
                return value;
              }
            }
          },
          xaxis: {
            type: 'category',
            //tickAmount: 'dataPoints',
            //tickPlacement: 'between',
            labels: {
              hideOverlappingLabels: false,
              formatter: (value) => {
                return value.substring(1);
              }
            }
          }
        }
      }
    },
    methods: {
      fetchData(){
        let that = this;                                               
        let url = '';						
        if(this.type === 'week-hour') {
            url = 'admin/heatMapByDatePeriod';
        }
        else if(this.type === 'month-date'){
            url = 'admin/heatMapByDatePeriod?period=year';
        }
        return axios.get(url)
        .then(function (response) {
            //that.series = response.data.data;
            const data = response.data.data;
            for (let i = 0; i < data.length; i++) {
              for (let j = 0; j < data[i].data.length; j++) {
                data[i].data[j].x = 'd' + data[i].data[j].x;
              }
            }
            //console.log(data);
            that.series = data;
        }).catch(function (error) {
            console.log(error);
        })
      }
    },
    created(){        
      this.fetchData();        
    }
}
</script>