<template>
    <div class="latest-listings dashboard-table">
        <div class="link-container">
            <router-link :to="{name: 'adminListings'}">
                <span class="title">{{ $t('dashboard.listing.go_to_listing') }} </span>
                <i class="icon-right icon"/>
            </router-link>
        </div>
        <list-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            :withSearch="false"
            :withCheckSelection="false"
            @selectionChanged="selectionChanged"
        >
        </list-table>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import axios from '@/axios';

    import {displayError, displaySuccess} from "helpers/messages";
    import DashboardListMixin from 'mixins/DashboardListMixin';
    
    const mixin = DashboardListMixin();

    export default {
        mixins: [mixin],
        props: {
          type: {
            type: String
          },
        },
        data() {
            return {
                header: [{
                    type: 'listing-details',
                    label: 'general.actions.view',
                    props: ['title', 'created_at', 'image_url'],
                    minWidth: '300px'
                }, {
                    type: 'tag',
                    minWidth: '100px',
                    label: 'models.listing.type.label',
                    prop: 'type_label',
                    classSuffix: 'type'
                }, {
                    type: 'plain',
                    label: 'models.listing.visibility.label',
                    prop: 'visibility_label'
                }, {
                    type: 'plain',
                    label: 'models.listing.price',
                    prop: 'price',
                    style: {
                        color: '#5CC279'
                    }
                }, {
                    type: 'actions',
                    label: 'dashboard.actions',
                    width: '130px',
                    actions: [ 
                        {
                            type: 'default',
                            title: 'general.actions.edit',
                            editUrl: 'adminListingsEdit',
                            permissions: [
                                this.$permissions.update.listing
                            ]
                        }
                    ]
                }],
                listing: {},
            };
        },
        computed: {
            listingConstants() {
                return this.$constants.listings;
            },

        },
        methods: {
            fetchData() {
              let that = this;
              let url = '';
              let toolTipSeriesName = '';
              if(this.type === 'latest_listings'){
                url = 'listings?per_page=5';
                toolTipSeriesName = this.$t('models.building.title');
              }
              return axios.get(url)
              .then(function (response) {
                const items = response.data.data.data.map(item => {
                  item.visibility_label = that.$t(`models.listing.visibility.${that.listingConstants.visibility[item.visibility]}`);
                  item.type_label = `models.listing.type.${that.listingConstants.type[item.type]}`;
                  item.price = '$' + item.price;
                  item.image_url = item.media.length == 0 ? '' : item.media[0].url;
                  return item;
                });
                that.items = items;
              }).catch(function (error) {
                  console.log(error);
              })
            }
        },
        created() {
          this.fetchData();
        }
    }
</script>
