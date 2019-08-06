<template>
    <div class="latest-products">
        <list-latest-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            :withSearch="false"
            :withCheckSelection="false"
            @selectionChanged="selectionChanged"
        >
        </list-latest-table>
        <div class="link-container">
            <router-link :to="{name: 'adminProducts'}">
                <span class="title">{{ $t('dashboard.marketplace.go_to_marketplace') }} </span>
                <i class="el-icon-right icon"/>
            </router-link>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import axios from '@/axios';
    import {format} from 'date-fns'

    import {displayError, displaySuccess} from "helpers/messages";
    import LatestListMixin from 'mixins/LatestListMixin';
    
    const mixin = LatestListMixin();

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
                    type: 'multi-props',
                    label: this.$t('models.product.details'),
                    props: ['title', 'user_email', 'created_at'],
                    minWidth: '250px'
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
                  item.status_label = that.$t(`models.product.status.${that.productConstants.status[item.status]}`);
                  item.visibility_label = that.$t(`models.product.visibility.${that.productConstants.visibility[item.visibility]}`);
                  item.type_label = that.$t(`models.product.type.${that.productConstants.type[item.type]}`);
                  item.price = '$' + item.price;
                  item.user_email = item.user.email;
                  item.title = that.getReducedTitle(item.title);
                  item.created_at = that.getReadableTime(item.created_at);
                  return item;
                });
                that.items = items;
              }).catch(function (error) {
                  console.log(error);
              })
            },
            getReducedTitle(val) {
                if (val.length > 30) {
                    val = val.substring(0, 30) + '...';
                }
                return val;
            },
            getReadableTime(timeString) {
                return format(new Date(timeString), 'D MMMM YYYY HH:mm');
            }
        },
        created() {
          this.fetchData();
        }
    }
</script>

<style lang="scss">
    .latest-products {
        .link-container {
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
