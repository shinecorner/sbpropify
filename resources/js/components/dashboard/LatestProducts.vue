<template>
    <div class="latest-products dashboard-table">
        <div class="link-container">
            <router-link :to="{name: 'adminProducts'}">
                <span class="title">{{ $t('dashboard.marketplace.go_to_marketplace') }} </span>
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
                    type: 'product-details',
                    label: 'general.actions.view',
                    props: ['title', 'created_at', 'image_url'],
                    minWidth: '300px'
                }, {
                    type: 'tag',
                    minWidth: '100px',
                    label: 'models.product.type.label',
                    prop: 'type_label',
                    classSuffix: 'type'
                }, {
                    type: 'plain',
                    label: 'models.product.visibility.label',
                    prop: 'visibility_label'
                }, {
                    type: 'plain',
                    label: 'models.product.price',
                    prop: 'price',
                    style: {
                        color: '#5CC279'
                    }
                }, {
                    type: 'actions',
                    label: 'dashboard.actions',
                    width: 100,
                    actions: [ 
                        {
                            type: 'default',
                            title: 'general.actions.edit',
                            onClick: this.edit,
                            permissions: [
                                this.$permissions.update.product
                            ]
                        }
                    ]
                }],
                product: {},
            };
        },
        computed: {
            productConstants() {
                return this.$store.getters['application/constants'].products;
            },

        },
        methods: {
            edit({id}) {
                this.$router.push({
                    name: 'adminProductsEdit',
                    params: {
                        id
                    }
                });
            },
            fetchData() {
              let that = this;
              let url = '';
              let toolTipSeriesName = '';
              if(this.type === 'latest_products'){
                url = 'products?per_page=5';
                toolTipSeriesName = this.$t('models.building.title');
              }
              return axios.get(url)
              .then(function (response) {
                const items = response.data.data.data.map(item => {
                  item.visibility_label = that.$t(`models.product.visibility.${that.productConstants.visibility[item.visibility]}`);
                  item.type_label = `models.product.type.${that.productConstants.type[item.type]}`;
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
