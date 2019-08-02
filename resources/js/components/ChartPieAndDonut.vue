<template>
    <div class="piechart">
        <div class="chart-filter in-toolbar">              
            <custom-date-range-picker rangeType="day" :initialRange="dateRange"
                :pickHandler="pickHandler" :style="{display: showPicker ? 'inline-flex' : 'none'}">
            </custom-date-range-picker>
            <div class="show-button" v-if="!showPicker" @click="handleShowClick(true)"><i class="el-icon-date"></i></div>
            <div class="hide-button" v-if="showPicker" @click="handleShowClick(false)"><i class="el-icon-circle-close"></i></div>
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
    },
    colNum: {
        type: Number
    }
  },  
  data() {
    return {        
        chartType: 'pie',
        dateRange: null,
        xData: [],
        yData: [],
        showPicker: false
    }
  },
  computed:{
    series: function(){        
        return this.yData;
    },
    chartOptions: function(){
        let responsive = [];
        if (this.colNum == 2) {
            responsive = [{
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
            }];
        }
        else {
            responsive = [{
                breakpoint: 1800,
                options: {
                    chart: {
                        width: 490,
                    },
                    legend: {
                        width: 170,
                    }
                }
            }, {
                breakpoint: 1650,
                options: {
                    chart: {
                        width: '100%',
                        height: 'auto'
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        width: undefined
                    }
                }
            }];
        }
        return {
            labels: this.xData,
            responsive: responsive,
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
            },
            tooltip: {
                followCursor: false
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
            else if (this.type === 'tenants_by_request_status') {
                this.chartType = 'donut';
                url = 'admin/donutChartTenantsByDateAndStatus';
            }
            else if (this.type === 'tenants_by_status') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=tenants&column=status';
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
                that.yData = response.data.data.data.map(val => parseFloat(val) || 0);
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
                else if (that.type === 'tenants_by_request_status') {
                    that.xData = response.data.data.labels.map(function(e){return that.$t('models.request.status.'+e)});
                }
                else if (that.type === 'tenants_by_status') {
                    that.xData = response.data.data.labels.map(label => that.$t('models.tenant.status.' + label));
                }
            }).catch(function (error) {
                console.log(error);
            })
        },
        pickHandler(val) {
            this.dateRange = val;
            this.fetchData();
        },
        handleShowClick(val) {
            this.showPicker = val;
        }
    },
    created(){        
        this.fetchData();        
    },
    watch: {
      '$i18n.locale' : function(val) {
        this.fetchData();
      }
    }
}
</script>
<style lang="scss">
    .chart-card {
        @media screen and (max-width: 1200px) {
            .piechart .apexcharts-canvas {
                margin-top: 30px;
            }
        }

        @media screen and (max-width: 1650px) {
            &.col-3 .piechart .apexcharts-canvas {
                margin-top: 30px;
            }
        }
        .piechart {
            //max-height: 420px;
            position: relative;

            .apexcharts-canvas {
                position: unset;
            }

            .apexcharts-legend {
                display: flex;
                //flex-direction: column;
                justify-content: center !important;
            }

            .chart-filter {
                .show-button {
                    cursor: pointer;
                    padding: 5px 0;
                    color: #6E8192;
                    font-size: 17px;

                    &:hover {
                        color: #333;
                    }
                }

                .hide-button {
                    cursor: pointer;
                    position: absolute;
                    padding: 7px;
                    top: 0;
                    right: 0;
                    color: #C0C4CC;

                    &:hover {
                        color: #333;
                    }
                }
                .el-input__icon.el-range__close-icon {
                    display: none;
                }

                .el-range-editor {
                    padding-right: 15px;
                }
            }
        }
    }
</style>
