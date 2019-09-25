<template>
  <el-date-picker
    v-model="dateRange"
    :type="pickerType"
    align="right"
    unlink-panels
    :range-separator="$t('general.date_range.range_separator')"
    :start-placeholder="$t('general.date_range.start_date')"
    :end-placeholder="$t('general.date_range.end_date')"
    :format="viewFormat"
    value-format="dd.MM.yyyy"
    :picker-options="pickerOptions"
    popper-class="custom-picker-panel"
  >
  </el-date-picker>
</template>

<script>
import {subDays, format, startOfWeek, lastDayOfWeek, subMonths, startOfMonth, endOfMonth, lastDayOfMonth} from 'date-fns';

export default {
  name: 'CustomDateRangePicker',
  props: {
    pickHandler: {
      type: Function,
    },
    rangeType: {
      type: String
    },
    initialRange: {
      type: Array
    },
    startDate: {
      type: String
    }
  },
  data() {
    return {
      dateRange: this.initialRange,
    }
  },
  computed: {
    pickerType: function() {
      if (this.rangeType == 'month') {
        return 'monthrange';
      }
      return 'daterange';
    },
    viewFormat: function() {
      if (this.rangeType == 'month') {
        return 'MM.yyyy';
      }
      return 'dd.MM.yyyy';
    },
    pickerOptions: function() {
      const lastWeek = {
        text: this.$t('general.date_range.last_week'),
        onClick(picker) {
          let end = subDays(new Date(), 7);
          const start = startOfWeek(end);
          end = lastDayOfWeek(end);

          picker.$emit('pick', [start, end]);
        }
      };
      const last7Days = {
        text: this.$t('general.date_range.last_7_days'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
          picker.$emit('pick', [start, end]);
        }
      };
      const last14Days = {
        text: this.$t('general.date_range.last_14_days'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 14);
          picker.$emit('pick', [start, end]);
        }
      };
      const last30Days = {
        text: this.$t('general.date_range.last_30_days'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
          picker.$emit('pick', [start, end]);
        }
      };
      const lastMonth = {
        text: this.$t('general.date_range.last_month'),
        onClick(picker) {
          let end = subMonths(new Date(), 1);
          const start = startOfMonth(end);
          end = lastDayOfMonth(end);

          picker.$emit('pick', [start, end]);
        }
      };
      const last3Months = {
        text: this.$t('general.date_range.last_3_months'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
          picker.$emit('pick', [start, end]);
        }
      };
      const last6Months = {
        text: this.$t('general.date_range.last_6_months'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 183);
          picker.$emit('pick', [start, end]);
        }
      };
      const lastYear = {
        text: this.$t('general.date_range.last_year'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 365);
          picker.$emit('pick', [start, end]);
        }
      };
      const last2Years = {
        text: this.$t('general.date_range.last_2_years'),
        onClick(picker) {
          const end = new Date();
          const start = new Date();
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 730);
          picker.$emit('pick', [start, end]);
        }
      }

      const that = this;

      const allTime = {
        text: this.$t('general.date_range.all_time'),
        onClick(picker) {
          const end = new Date();
          const start = new Date(that.startDate);
          picker.$emit('pick', [start, end]);
        }
      }
      if (this.rangeType == 'day') {
        return {
          shortcuts: [last7Days, last14Days, last30Days, lastWeek, lastMonth, last3Months]
        };
      }
      else if (this.rangeType == 'week') {
        return {
          shortcuts: [lastWeek, lastMonth, last3Months, last6Months, lastYear]
        };
      }
      else if (this.rangeType == 'month') {
        return {
          shortcuts: [lastMonth, last3Months, last6Months, lastYear, last2Years, allTime]
        };
      }
      else if (this.rangeType == 'all') {
        return {
          shortcuts: [last7Days, last14Days, last30Days, lastWeek, lastMonth, last3Months, last6Months, lastYear, last2Years, allTime]
        };
      }
      else {
        return {
          shortcuts: [lastYear, last2Years, allTime]
        };
      }
    },
  },
  watch:{
    dateRange: function(val) {
      this.pickHandler(val);
    }
  }
}
</script>

<style lang="scss">
  .el-picker-panel.custom-picker-panel.has-sidebar {
    line-height: normal;
    width: min-content;

    .el-picker-panel__body-wrapper {
      .el-picker-panel__body {
        min-width: 428px;
      }
      .el-picker-panel__content {
        padding: 7px 5px 5px 5px;

        .el-date-range-picker__header {
          margin: 10px 5px 0px;

          .el-picker-panel__icon-btn {
            margin-top: 2px;
            padding: 1px 1px;
          }
          div {
            font-size: 15px;
            margin: 0 auto;
          }
        }

        th {
          width: 25px;
          height: 25px;
          padding:2px;
        }

        td {
          padding: 0;
          width: 25px;
          height: 25px;
          max-width: 25px;

          div {
            width: 25px;
            height: 25px;
            padding: 0;
            margin: 0;
          }
        }
      }
    }
  }
</style>
