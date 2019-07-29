<template>
  <el-date-picker
    v-model="dateRange"
    type="daterange"
    align="right"
    unlink-panels
    :range-separator="$t('date_range.range_separator')"
    :start-placeholder="$t('date_range.start_date')"
    :end-placeholder="$t('date_range.end_date')"
    format="dd.MM.yyyy"
    value-format="dd.MM.yyyy"
    :picker-options="pickerOptions">
  </el-date-picker>
</template>

<script>
import {subDays} from 'date-fns';

export default {
  name: 'CustomDateRangePicker',
  props: {
    pickHandler: {
      type: Function,
    }
  },
  data() {
    return {
      dateRange: [subDays(new Date(), 28), new Date()],
      pickerOptions: {
        shortcuts: [{
          text: this.$t('date_range.last_week'),
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: this.$t('date_range.last_month'),
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: this.$t('date_range.last_3_months'),
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: this.$t('date_range.last_6_months'),
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 183);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: this.$t('date_range.last_year'),
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 365);
            picker.$emit('pick', [start, end]);
          }
        }, {
          text: this.$t('date_range.last_2_years'),
          onClick(picker) {
            const end = new Date();
            const start = new Date();
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 730);
            picker.$emit('pick', [start, end]);
          }
        }]
      },
    }
  },
  watch:{
    dateRange: function(val) {
      this.pickHandler(val);
    }
  }
}
</script>

