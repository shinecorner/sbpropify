<template>
    <card class="latest-products-widget">
        <template slot="header">
            <div class="title">Marketplace products</div>
            <el-button type="text" @click="viewAll()">View all</el-button>
        </template>
        <template v-if="isLoading">
            <loader visible centered :size="20" />
        </template>
        <template v-else>
            <el-row :gutter="16" v-if="products.data.length">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" v-for="product in products.data" :key="product.id">
                    <product :data="product" />
                </el-col>
            </el-row>
            <placeholder v-else :src="require('img/5ca7dde590fa1.png')">
                Currently, there are not products on sell...
                <small slot="secondary">As soon as a product is on sell, it will appear here!</small>
            </placeholder>
        </template>
    </card>
</template>

<script>
    import Card from 'components/Card'
    import Loader from 'components/SimpleLoader'
    import Placeholder from 'components/Placeholder'
    import Product from 'components/tenant/MarketplaceProduct'
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        components: {
            Card,
            Loader,
            Product,
            Placeholder
        },
        props: {
            limit: {
                type: Number,
                default: 5
            }
        },
        data () {
            return {
                loading: false,
                products: {
                    data: []
                }
            }
        },
        methods: {
            viewAll () {
                this.$router.push({name: 'tenantMarketplace'});
            }
        },
        computed: {
            isLoading () {
                return this.loading && !this.products.data.length;
            }
        },
        async created () {
            try {
                this.loading = true

                const {data} = await this.$store.dispatch('products2/get', {
                    per_page: this.limit,
                })

                this.products = data
            } catch (err) {
                displayError(err)
            } finally {
                this.loading = false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-card.latest-products-widget {
        &:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: .032;
            pointer-events: none;
            background-image: url('~img/5ca7dde590fa1.png');
        }
        :global(.el-card__header) {
            .title {
                flex: auto;
                overflow: hidden;
                min-width: 0;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .el-button {
                padding: 0;
            }
        }
        :global(.el-card__body) .el-row .el-col {
            padding: 8px;
        }
    }
</style>