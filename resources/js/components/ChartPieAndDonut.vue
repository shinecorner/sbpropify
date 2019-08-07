<template>
    <div v-if="startDate" class="piechart">
        <div class="chart-filter in-toolbar">              
            <custom-date-range-picker 
                rangeType="all"
                :initialRange="dateRange"
                :pickHandler="pickHandler"
                :style="{display: showPicker ? 'inline-flex' : 'none'}"
                :startDate="startDate"
            />
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
import chartMixin from '../mixins/adminDashboardChartMixin';

export default {
  components: {
    'apexchart': VueApexCharts,
    CustomDateRangePicker
  },
  mixins: [chartMixin()],
  props: {
    colNum: {
        type: Number
    }
  },  
  data() {
    return {        
        chartType: 'pie',
        showPicker: false,
    }
  },
  computed:{
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
                toolbar: this.toolbar,
                width: 540,
                height: 320
            },
            colors: this.colors
        }
    }
  },
    methods: {
        fetchData(){
            if (this.dateRange == null) {
                return;
            }
            let that = this;                                               
            let url = '';
            let langPrefix = '';
            if(this.type === 'request_by_status'){
                this.chartType = 'pie';
                url = 'admin/donutChart';
                langPrefix = 'models.request.status.';
            }
            else if(this.type === 'request_by_category'){
                this.chartType = 'donut';
                url = 'admin/donutChartRequestByCategory';
                langPrefix = '';
            }
            else if(this.type === 'request_by_assigned_status'){
                this.chartType = 'donut';
                url = 'admin/chartRequestByAssignedProvider';
                langPrefix = 'dashboard.requests.';
            }
            else if (this.type === 'news_by_status') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=posts&column=status';
                langPrefix = 'models.post.status.';
            }
            else if (this.type === 'news_by_type') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=posts&column=type';
                langPrefix = 'models.post.type.';
            }
            else if (this.type === 'products_by_type') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=products&column=type';
                langPrefix = 'models.product.type.';
            }
            else if (this.type === 'tenants_by_request_status') {
                this.chartType = 'donut';
                url = 'admin/donutChartTenantsByDateAndStatus';
                langPrefix = 'models.request.status.';
            }
            else if (this.type === 'tenants_by_status') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=tenants&column=status';
                langPrefix = 'models.tenant.status.';
            }
            else if (this.type === 'tenants_by_language') {
                this.chartType = 'donut';
                url = 'admin/chartTenantLanguage';
                langPrefix = '';
            }
            else if (this.type === 'tenants_by_title') {
                this.chartType = 'donut';
                url = 'admin/donutChart?table=tenants&column=title';
                langPrefix = 'models.tenant.titles.';
            }

            return axios.get(url,{
            	params: {
                    start_date: this.dateRange[0],
                    end_date: this.dateRange[1]
                }
            })
            .then(function (response) {
                that.yData = response.data.data.data.map(val => parseFloat(val) || 0);
                that.xData = response.data.data.labels.map(function(e) {
                    if (langPrefix !== '') {
                        return that.$t(langPrefix + e);
                    }
                    else {
                        return e;
                    }
                });
            }).catch(function (error) {
                console.log(error);
            })
        },
        handleShowClick(val) {
            this.showPicker = val;
        }
    },
    watch: {
      'startDate': function(val) {
          if (val) {
            this.dateRange = [val, format(new Date(), 'DD.MM.YYYY')];
            this.fetchData();
          }
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
                &.in-toolbar {
                    right: 40px;
                }

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
