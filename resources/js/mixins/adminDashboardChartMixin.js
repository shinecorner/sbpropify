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
        total: 0,
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
        colorsAdded: [],
        colorsPredefined: [
          '#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#3F51B5',
          '#03A9F4', '#4CAF50', '#F9CE1D', '#FF9800', '#33B2DF', '#546E7A'
        ]
      };
    },
    computed: {
      series: function() {
        return this.yData;
      },
      colors: function() {
        const that = this;
        return this.yData.map((val, index) => {
          if(index < 12) {
            return that.colorsPredefined[index];
          }
          else {
            let isSelected = false;
            while (!isSelected) {
              var randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
              if (!that.colorsAdded.includes(randomColor) && !that.colorsPredefined.includes(randomColor)) {
                isSelected = true;
                that.colorsAdded.push(randomColor);
              }
            }
            return randomColor;
          }
        });
      }
    },
    methods: {
      fetchData(){
        
      },
      pickHandler(val) {
        this.dateRange = val;
        this.fetchData();
      },
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
