export default () => {
  let mixin = {
    props: {
      type: {
        type: String,
        required: true
      },
      startDate: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        dateRange: null,
        xData: [],
        yData: [],
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
        colors: [
          '#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5',
          '#03A9F4', '#4CAF50', '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A'
        ]
      };
    },
    computed: {
      series: function() {
        return this.yData;
      },
    },
    methods: {
      fetchData(){
        
      },
      pickHandler(val) {
        this.dateRange = val;
        this.fetchData();
      }
    },
    created(){
      this.fetchData();
    },
    watch:{
      '$i18n.locale' : function(val) {
        this.fetchData();
      }
    }
  };

  return mixin;
};
