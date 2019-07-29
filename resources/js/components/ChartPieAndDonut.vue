<template>
    <div class="piechart">
        <div class="chart-filter">              
            <custom-date-range-picker
                :pickHandler="pickHandler">
            </custom-date-range-picker>
        </div>
        <el-row type="flex">
            <el-col :span="24">
                <apexchart :type="chartType" :options="chartOptions" :series="series" />
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
        chartType: 'pie',
        dateRange: [subDays(new Date(), 28), new Date()],
        xData: [],
        yData: [],
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
                breakpoint: 1300,
                options: {
                    chart: {
                        width: 490,
                    },
                    legend: {
                        width: 170,
                    }
                }
            }, {
                breakpoint: 1200,
                options: {
                    chart: {
                        width: '100%',
                        height: 'auto'
                    },
                    legend: {
                        position: 'bottom',
                        width: undefined
                    }
                }
            }, {
                breakpoint: 480,
                options: {
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                show: true,
                width: 220
            },
            chart:{
                toolbar: {
                    show: true,
                },
                autoSelected: '',
                width: 540,
                height: 320
            }
        }
    }
  },
    methods: {
        fetchData(){
            let that = this;                                               
            let url = '';						
            if(this.type === 'request_by_status'){
                this.chartType = 'pie';
                url = 'admin/donutChart';
            }
            else if(this.type === 'request_by_category'){
                this.chartType = 'donut';
                url = 'admin/donutChartRequestByCategory';
            }
            else if (this.type === 'news_by_status') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=posts&column=status';
            }
            else if (this.type === 'news_by_type') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=posts&column=type';
            }
            else if (this.type === 'products_by_type') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=products&column=type';
            }
            let params = {};
            if (this.dateRange != null) {
              params.start_date = this.dateRange[0],
              params.end_date = this.dateRange[1]
            }

            return axios.get(url,{
            	params: params
            })
            .then(function (response) {
                that.yData = response.data.data.data;
                if(that.type === 'request_by_status'){
                    that.xData = response.data.data.labels.map(function(e){return that.$t('models.request.status.'+e)});
                }
                else if(that.type === 'request_by_category'){
                    that.xData = response.data.data.labels;
                }
                else if (that.type === 'news_by_status') {
                    that.xData = response.data.data.labels.map(label => that.$t('models.post.status.' + label));
                }
                else if (that.type === 'news_by_type') {
                    that.xData = response.data.data.labels.map(label => that.$t('models.post.type.' + label));
                }
                else if (that.type === 'products_by_type') {
                    that.xData = response.data.data.labels.map(label => that.$t('models.product.type.' + label));
                }
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
}
</script>
<style lang="scss">
    .piechart {
        max-height: 420px;

        .apexcharts-canvas {
            position: unset;
        }
    }
</style>
