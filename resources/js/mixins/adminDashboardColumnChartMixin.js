
import {format, subDays} from 'date-fns'
import adminDashboardChartMixin from './adminDashboardChartMixin';

export default () => {
  let mixin = {
    mixins: [adminDashboardChartMixin()],
    data() {
      return {
        period: 'day',
        dateRange: [format(subDays(new Date(), 28), 'DD.MM.YYYY'), format(new Date(), 'DD.MM.YYYY')],
      };
    },
    computed: {
      columnChartOptions: function() {
        return {
          chart: {
            toolbar: this.toolbar,
          },
          colors: this.colors,
          plotOptions: {
            bar: {
              horizontal: false,
            },
          },
          xaxis: {
            categories: this.xData,
          },
          fill: {
            opacity: 1
          },
          dataLabels:{
              enabled: false,
          },
          plotOptions: {
            bar: {
              horizontal: false,
            },
          },
        };
      }
    },
    watch:{
      period: function (val) {
        this.fetchData();
      }
    }
  };

  return mixin;
};
