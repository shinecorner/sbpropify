<template>
    <div v-if="startDate" class="progress-bar-container">
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
        <el-row class="progress-card-body">
            <el-col :span="24" v-for="(data, index) in yData" :key="index">
                <div class="progress-bar">
                    <progress-bar :label="`${xData[index]}`" :value="yData[index]" :maxValue="total" :color="`${colorsPredefined[index%12]}`" ></progress-bar>
                </div>
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
import ProgressBar from 'components/ProgressBar';

export default {
  components: {
    'apexchart': VueApexCharts,
    CustomDateRangePicker,
    ProgressBar
  },
  mixins: [chartMixin()],
  props: {
      height: {
          type: Number,
          default: ()=> {
              return 400;
          }
      }
  },  
  data() {
    return {      
          showPicker: false,  
    }
  },
  computed:{
  
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
            else if(this.type === 'buildings_by_state'){
                this.chartType = 'pie';
                url = 'admin/pieChartBuildingByState';
                langPrefix = '';
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
                that.yData = response.data.data.data.map((val) => {
                    that.total += parseInt(val);
                    return parseFloat(val) || 0;
                });
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
<style lang="scss" scoped>
    .progress-bar-container {
        .progress-card-body {
            height: 400px;
            overflow: auto;
            padding: 20px;
            .progress-bar {
                padding-top: 5px;
                padding-bottom: 5px;
                padding-right: 30px;
            }
        }
    }
</style>
