<template>
  <div id="dashboard-google-map">

  </div>
</template>

<script>
  import axios from '@/axios';
  import MarkerClusterer from '@google/markerclusterer';

  export default {
    props: {
      'latitude': {
        type: Number,
        default: function(){
          return 46.8189236
        }
      },
      'longitude': {
        type: Number,
        default: function(){
          return 8.3639852
        }
        // 46.8189236 8.3639852
      },
      'zoom': {
        type: Number,
        default: function(){
          return 8
        }
      },
      type: {
        type: String
      }
    },

    data(){
      return {
        data: [],
        markers: [],
        markerClusterer: null,
        map: null,
      }
    },
    mounted() {
      this.map = new google.maps.Map(document.getElementById('dashboard-google-map'), {
        center: {lat: this.latitude, lng: this.longitude},
        zoom: this.zoom
      });
      this.fetchData();
    },
    methods: {
      clearMarkers(){
        for( var i = 0; i < this.markers.length; i++ ){
          this.markerClusterer.clearMarkers();
          this.markers[i].setMap( null );
        }
      },
      buildMarkers(){
        const that = this;
        this.markers = [];

        for( var i = 0; i < this.data.length; i++ ){
          var marker = new google.maps.Marker({
            position: { lat: parseFloat( this.data[i].latitude ), lng: parseFloat( this.data[i].longitude ) },
            map: this.map
          });

          this.attachToolTip(marker, this.data[i]);
          
          this.markers.push( marker );
        }

        var options = {
            imagePath: 'https://googlemaps.github.io/js-marker-clusterer/images/m'
        };

        this.markerCluster = new MarkerClusterer(this.map, this.markers, options);
      },
      attachToolTip(marker, markerData) {
        const content = `
          <h3>${markerData.name}</h3>
          <p>Count of managers: <b>${markerData.property_managers_count}</b></p>
          <p>Count of Tenants : <b>${markerData.tenants_count}</b></p>
          <p>Count of requests: <b>${markerData.requests_count}</b></p>
        `;
        var infowindow = new google.maps.InfoWindow({
          content
        });

        marker.addListener('click', function() {
          infowindow.open(marker.get('map'), marker);
        });
      },
      fetchData() {
        let that = this;                                               
        let url = '';
        let langPrefix = '';
        if(this.type === 'buildings') {
          url = 'buildings/map';
          langPrefix = 'models.request.status.';
        }

        return axios.get(url)
        .then(function (response) {
          that.data = response.data.data;
          that.clearMarkers();
          that.buildMarkers();
        }).catch(function (error) {
          console.log(error);
        })
      }
    }
  }
</script>
<style lang="scss">
  #dashboard-google-map {
    width: 100%;
    height: 500px;
  }
</style>
