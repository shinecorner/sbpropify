<template>
    <div>
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
          yaxis: {
            labels: {
              formatter: (value) => {
                const realValue = value.toString();
                if (realValue == '') {
                  return;
                }
                else if (this.type == 'week-hour' && realValue.match(/[a-zA-Z]+/gi)) {
                  return this.$t('days.' + realValue.toLowerCase());
                }
                else if (this.type == 'month-date' && value > 0) {
                  return format(new Date(2019, value - 1), 'MMMM', {locale: dateLocale[this.$i18n.locale]});
                }
                else {
                  return realValue;
                }
              }
            }
          },
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
                title: {
                    formatter: (seriesName) => {
                      const realValue = seriesName.toString();
                      if (this.type == 'week-hour' && realValue.match(/[a-zA-Z]+/gi)) {
                        return this.$t('days.' + realValue.toLowerCase());
                      }
                      else if (this.type == 'month-date' && (parseInt(realValue) || 0) > 0) {
                        return format(new Date(2019, parseInt(realValue) - 1), 'MMMM', {locale: dateLocale[this.$i18n.locale]});
                      }
                      return realValue;
                    },
                },
            },
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