<template>
    <div class="latest-products">
        <div class="link-container">
            <router-link :to="{name: 'adminProducts'}">
                <span class="title">{{ $t('dashboard.marketplace.go_to_marketplace') }} </span>
                <i class="icon-right icon"/>
            </router-link>
        </div>
        <dashboard-list-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            :withSearch="false"
            :withCheckSelection="false"
            @selectionChanged="selectionChanged"
        >
        </dashboard-list-table>
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
          }
        },
        data() {
            return {
                header: [{
                    type: 'product-details',
                    label: this.$t('models.product.details'),
                    props: ['title', 'created_at', 'image_url'],
                    minWidth: '300px'
                }, {
                    type: 'tag',
                    label: this.$t('models.product.type.label'),
                    prop: 'type_label',
                    classSuffix: 'type'
                }, {
                    type: 'plain',
                    label: this.$t('models.product.visibility.label'),
                    prop: 'visibility_label'
                }, {
                    type: 'plain',
                    label: this.$t('models.product.price'),
                    prop: 'price',
                    style: {
                        color: '#5CC279'
                    }
                }, {
                    type: 'actions',
                    label: this.$t('dashboard.actions'),
                    width: 85,
                    actions: [ 
                        {
                            type: 'success',
                            title: this.$t('models.product.edit'),
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
                  item.type_label = that.$t(`models.product.type.${that.productConstants.type[item.type]}`);
                  item.price = '$' + item.price;
                  item.image_url = item.media.length == 0 ? '' : item.media[0].url;
                  return item;
                });
                that.items = items;
                console.log(items);
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

<style lang="scss">
    .latest-products {
        position: relative;

        .link-container {
            position: absolute;
            top: -58px;
            right: 0px;
            text-align: right;
            padding: 20px 15px;
            font-size: 16px;

            a {
                text-decoration: none;
                color: #525252;

                &:hover {
                    color: #303133;
                }
            }
        }
    }
</style>
