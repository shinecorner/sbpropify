<template>
    <div class="heatmapchart">
        <apexchart type=heatmap height="310" :options="chartOptions" :series="series" />
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts';
import {format} from 'date-fns';
import en from 'date-fns/locale/en';
import de from 'date-fns/locale/de';
import fr from 'date-fns/locale/fr';
import it from 'date-fns/locale/it';
import axios from '@/axios';

const dateLocale = {en, de, fr, it};

export default {
    components: {'apexchart': VueApexCharts},
    props: {
      type: {
        type: String,
        required: true
      },
      tab: {
        type: String,
      },
      week: {
        type: String,
      }
    },
    data() {
        return {
            series: [],
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
          xaxis: {
            type: 'category',
            labels: {
              hideOverlappingLabels: false,
              formatter: (value) => {
                const realValue =  value.toString().substring(1);
                return realValue;
              }
            }
          },
          tooltip: {
            y: {
              formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                return value;
              }
            },
            custom: function({series, seriesIndex, dataPointIndex, w}) {
              return '<span class="heatmap-tooltip">' + series[seriesIndex][dataPointIndex] + '</span>'
            }
          }
        }
      }
    },
    methods: {
      fetchData(){
        let that = this;                                               
        let url = '';						
        let params = {};
        if(this.type === 'week-hour') {
          url = 'admin/heatMapByDatePeriod';
          if (this.week != null) {
            params.date = this.week;
          }
        }
        else if(this.type === 'month-date'){
          url = 'admin/heatMapByDatePeriod?period=year';
        }
        return axios.get(url, {
          params: params
        })
        .then(function (response) {
          const data = response.data.data;
          for (let i = 0; i < data.length; i++) {
            for (let j = 0; j < data[i].data.length; j++) {
              data[i].data[j].x = 'd' + data[i].data[j].x;
            }
          }
          data.map(value => {
            let name = value.name;
            if (that.type == 'week-hour' && name.match(/[a-zA-Z]+/gi)) {
              name = that.$t('general.days.' + name.toLowerCase());
            }
            else if (that.type == 'month-date' && name > 0) {
              name = format(new Date(2019, name - 1), 'MMMM', {locale: dateLocale[that.$i18n.locale]});
            }
            value.name = name;
            return value;
          });
          that.series = data;
        }).catch(function (error) {
            console.log(error);
        })
      }
    },
    created(){        
      this.fetchData();        
    },
    watch: {
      '$i18n.locale' : function(val) {
        this.fetchData();
      },
      tab: function(val) {
        this.fetchData();
      },
      
      week: function(val) {
        if (this.type == 'week-hour') {
          this.fetchData();
        }
      }
    }
}
</script>
<style lang="scss">
  .heatmapchart {
    .apexcharts-tooltip {
      text-align: right;
      transform: translateX(30px);
    }
  }
  .heatmap-tooltip {
    padding: 5px 10px;
  }
</style>
