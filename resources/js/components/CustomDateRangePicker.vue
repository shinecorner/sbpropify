<template>
  <el-date-picker
    v-model="dateRange"
    :type="pickerType"
    align="right"
    unlink-panels
    :range-separator="$t('date_range.range_separator')"
    :start-placeholder="$t('date_range.start_date')"
    :end-placeholder="$t('date_range.end_date')"
    :format="viewFormat"
    value-format="dd.MM.yyyy"
    :picker-options="pickerOptions">
  </el-date-picker>
</template>

<script>
import {subDays, format} from 'date-fns';

export default {
  name: 'CustomDateRangePicker',
  props: {
    pickHandler: {
      type: Function,
    },
    rangeType: {
      type: String
    }
  },
  data() {
    return {
      dateRange: [format(subDays(new Date(), 28), 'DD.MM.YYYY'), format(new Date(), 'DD.MM.YYYY')],
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
  computed: {
    pickerType: () => {
      if (this.rangeType == 'month') {
        return 'monthrange';
      }
      return 'daterange';
    },
    viewFormat: () => {
      if (this.rangeType == 'month') {
        return 'MM.yyyy';
      }
      return 'dd.MM.yyyy';
    }
  },
  watch:{
    dateRange: function(val) {
      this.pickHandler(val);
    }
  }
}
</script>

