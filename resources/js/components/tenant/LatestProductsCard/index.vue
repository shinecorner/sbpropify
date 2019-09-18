<template>
    <ui-card class="p-latest-products-card" shadow="always">
        <template #header>
            <i class="icon-basket"></i> {{$t('tenant.latest_products')}}
            <el-button type="text" @click="$router.push({name: 'tenantMarketplace'})">{{$t('tenant.actions.view_all')}}</el-button>
        </template>
        <div v-if="loading">loading...</div>
        <div class="placeholder" v-else-if="!loading && !products">
            <img class="image" :src="require('img/5c9d48f15dd1a.png')" />
            <div class="content">
                <div class="title">No requests available yet.</div>
                <div class="description">Et aut cum ut earum. Et aperiam ut possimus explicabo. Modi dolores in odit id fuga maxime aperiam dolor.</div>
            </div>
        </div>
        <product-card v-for="product in products" :key="product.id" :data="product" v-else :show-action="false"/>
    </ui-card>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: 'p-latest-products-card',
        props: {
            limit: {
                type: Number,
                default: 4
            }
        },
        data () {
            return {
                loading: false
            }
        },
        computed: {
            ...mapState('newProducts', {
                products: ({data}) => data.slice(this.limit)
            })
        },
        async mounted () {
            if (!this.products.length) {
                this.loading = true

                await this.$store.dispatch('newProducts/get', {
                    sortedBy: 'desc',
                    orderBy: 'created_at',
                    per_page: this.limit
                })

                this.loading = false
            }
        }
    }
</script>

<style lang="sass" scoped>
    .p-latest-products-card
        /deep/ .ui-card__header
            .el-button
                padding: 0
                margin-left: auto

                /deep/ [class*=icon] + span
                    margin-left: 5px

        > /deep/ .ui-card__body
            display: grid
            grid-gap: 24px
            grid-template-columns: repeat(auto-fill, minmax(192px, 1fr))
</style>