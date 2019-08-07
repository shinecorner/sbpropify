<template>
    <div v-if="startDate" class="linechart">
        <div class="chart-filter in-toolbar">
          <el-radio-group v-model="period" class="stack-radios">                
              <el-radio-button label="day">{{$t('general.timestamps.days')}}</el-radio-button>
              <el-radio-button label="week">{{$t('general.timestamps.weeks')}}</el-radio-button>
              <el-radio-button label="month">{{$t('general.timestamps.months')}}</el-radio-button>
              <el-radio-button label="year">{{$t('general.timestamps.years')}}</el-radio-button>
          </el-radio-group>
          <custom-date-range-picker :rangeType="period" :initialRange="dateRange"
            :pickHandler="pickHandler" :startDate="startDate">
          </custom-date-range-picker>
        </div>    
        <el-row type="flex">
            <el-col :span="24">
                <apexchart width="100%" height="310" type="line" :options="chartOptions" :series="series"></apexchart>
            </el-col>
        </el-row>        
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import axios from '@/axios';

import CustomDateRangePicker from 'components/CustomDateRangePicker';
import columnChartMixin from '../mixins/adminDashboardColumnChartMixin';

export default {  
  components: {
    'apexchart': VueApexCharts,
    CustomDateRangePicker
  },
  mixins: [columnChartMixin()],
  computed: {
    chartOptions: function() {
      const options = this.columnChartOptions;
      options.stroke = {
        curve: 'straight'
      }
      return options;
    }
  },
  methods: {
    fetchData(){
      let that = this;
      let url = '';
      let toolTipSeriesName = '';
      if(this.type === 'buildings_by_creation_date'){
        url = 'admin/chartBuildingsByCreationDate';
        toolTipSeriesName = this.$t('models.building.title');
      }
      let params = {
        period: that.period
      };
      if (this.dateRange != null) {
        params.start_date = this.dateRange[0],
        params.end_date = this.dateRange[1]
      }
      return axios.get(url,{
        params: params
      })
      .then(function (response) {
        
        that.yData = [{name: toolTipSeriesName, data: response.data.data.requests_per_day_ydata}];
        that.xData = response.data.data.requests_per_day_xdata;
      }).catch(function (error) {
          console.log(error);
      })
    }
  }
}
</script>

<style scoped>
  .linechart {
    position: relative;
  }
  .stack-radios {
    margin-right: 5px;
  }
</style>