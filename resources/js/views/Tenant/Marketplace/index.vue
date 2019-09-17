<template>
    <div :class="['marketplace', {md: el.is.md}]">
        <div class="container">
            <ui-heading icon="icon-basket" title="Marketplace" description="Start selling things you don't need anymore." />
            <ui-divider />
            <ui-card class="content" shadow="always" v-loading="loading">
                <template #header>
                    <el-popover popper-class="marketplace__filter-popover" placement="bottom-start" trigger="click" :width="192">
                        <el-button slot="reference" icon="el-icon-sort">{{$t('tenant.filters')}}</el-button>
                        <filters ref="filters" layout="row" :data.sync="filters.data" :schema="filters.schema" @changed="onFiltersChanged" />
                        <el-button type="primary" size="small" icon="el-icon-sort-up" @click="resetFilters">{{$t('tenant.reset_filters')}}</el-button>
                    </el-popover>
                    <el-input prefix-icon="el-icon-search" v-model="search" :placeholder="$t('tenant.placeholder.search_product')" clearable @clear="handleSearch" @keyup.enter.native="handleSearch" />
                    <el-button type="primary" icon="el-icon-search" :disabled="loading" @click="handleSearch">{{$t('tenant.actions.search')}}</el-button>
                    <el-button type="primary" icon="icon-plus" @click="visibleDrawer = !visibleDrawer">{{$t('tenant.add_product')}}</el-button>
                </template>
                <template v-if="loading">
                    <loader v-for="idx in 5" :key="idx" />
                </template>
                <div class="placeholder" v-else-if="!loading && !products.data.length">
                    <img class="image" :src="require('img/5ca7dde590fa1.png')" />
                    <div class="title">{{$t('tenant.no_data.product')}}</div>
                    <div class="description">Et aut cum ut earum. Et aperiam ut possimus explicabo. Modi dolores in odit id fuga maxime aperiam dolor.</div>
                </div>
                <template v-else>
                    <product-card v-for="product in products.data" :key="product.id" :data="product" @click="openProductDetailsDialog(product)" />
                </template>
                <el-pagination slot="footer" :layout="pagination.layout" :current-page="pagination.current" :page-size="pagination.size" :page-sizes="pagination.sizes" :total="products.total" @size-change="onSizeChange" @current-change="onCurrentPageChange" background />
            </ui-card>
            <el-dialog :custom-class="`marketplace__opened-product-dialog ${el.is.md ? 'marketplace__opened-product-md-dialog' : ''}`" :visible.sync="visibleDialog" :before-close="onProductDetailsDialogClose" :show-close="false" append-to-body>
                <product-details :data="openedProduct" v-if="openedProduct" />
            </el-dialog>
        </div>
        <ui-drawer :size="448" :visible.sync="visibleDrawer" :z-index="1" direction="right" docked>
            <ui-divider content-position="left">{{$t('tenant.add_product')}}</ui-divider>
            <div class="content">
                <product-add-form />
            </div>
        </ui-drawer>
    </div>
</template>

<script>
    import Loader from 'components/tenant/ProductCard/Loader'
    import {ResponsiveMixin} from 'vue-responsive-components'
    import {mapState} from 'vuex'

    const DEFAULT_PAGINATION_LAYOUT = 'total, sizes, prev, pager, next, jumper'
    const MINIMAL_PAGINATION_LAYOUT = 'prev, pager, next'

    export default {
        mixins: [
            ResponsiveMixin
        ],
        components: {
            Loader
        },
        data () {
            return {
                loading: false,
                search: undefined,
                openedProduct: null,
                visibleDrawer: false,
                visibleDialog: false,
                pagination: {
                    current: 1,
                    size: 15,
                    sizes: [15, 25, 50, 100],
                    layout: DEFAULT_PAGINATION_LAYOUT
                },
                filters: {
                    schema: [{
                        type: 'el-switch',
                        title: 'My offerings',
                        name: 'user_id',
                        props: {
                            activeValue: this.$store.getters.loggedInUser.id.toString(),
                            inactiveValue: null
                        }
                    }, {
                        type: 'el-select',
                        title: this.$t('tenant.type'),
                        name: 'type',
                        props: {
                            size: 'small'
                        },
                        children: [{
                            type: 'el-option',
                            props: {
                                label: this.$t('tenant.all'),
                                value: null
                            }
                        }].concat(Object.entries(this.$constants.products.type).map(([value, label]) => ({
                            type: 'el-option',
                            props: {label, value}
                        })))
                    }],
                    data: {
                        type: null,
                        user_id: null
                    }
                }
            }
        },
        computed: {
            ...mapState('newProducts', {
                products: state => state
            }),

            breakpoints () {
                return {
                    md: el => {
                        if (el.width <= 1024) {
                            this.pagination.layout = MINIMAL_PAGINATION_LAYOUT

                            return true
                        } else {
                            this.pagination.layout = DEFAULT_PAGINATION_LAYOUT
                        }
                    },
                    sm: el => el.width <= 768
                }
            }
        },
        methods: {
            async get(params = {
                search: this.search,
                page: this.pagination.current,
                per_page: this.pagination.size
            }) {
                if (this.loading && this.products.data.length) {
                    return
                }

                this.loading = true

                this.pagination.current = +params.page
                this.pagination.size = +params.per_page

                if ('search' in params && !params.search) {
                    delete params.search
                }

                this.$router.replace({query: params, name: this.$route.name})

                await this.$store.dispatch('newProducts/get', {
                    per_page: 5,
                    sortedBy: 'desc',
                    orderBy: 'created_at',
                    ...params
                })

                this.loading = false
                this.$el.scrollTop = 0
            },
            async handleSearch (value) {
                const {page, per_page, search, ...rest} = this.$route.query

                await this.get({page, per_page, search: this.search, ...rest})
            },
            async onFiltersChanged (filters) {
                await this.get({
                    page: 1,
                    per_page: this.pagination.size,
                    search: this.$route.query.search,
                    ...filters
                })
            },
            async onSizeChange (per_page) {
                await this.get({page: 1, per_page})
            },
            async onCurrentPageChange (page) {
                await this.get({page, per_page: this.pagination.size})
            },
            resetFilters () {
                this.$refs.filters.reset()
            },
            openProductDetailsDialog (product) {
                this.openedProduct = product
                this.visibleDialog = true
            },
            onProductDetailsDialogClose (done) {
                this.openedProduct = null

                done()
            }
        },
        created () {
            const {search, ...rest} = this.$route.query

            if (search) {
                this.search = search
            }

            Object.entries(rest).forEach(([param, value]) => {
                if (this.filters.data.hasOwnProperty(param)) {
                    this.filters.data[param] = value
                }
            })
        },
        async mounted () {
            const {page = this.pagination.current, per_page = this.pagination.size, search, ...rest} = this.$route.query

            await this.get({page, per_page, search, ...rest})
        }
    }
</script>

<style lang="sass">
    .marketplace__opened-product-dialog
        width: 80%
        max-width: 1024px
        overflow: hidden
        border-radius: 12px

        &.marketplace__opened-product-md-dialog .el-dialog__body .product-details
            grid-template-columns: 1fr

            .ui-images-carousel
                height: 384px !important

        .el-dialog__header
            display: none

        .el-dialog__body
            padding: 0

    .marketplace__filter-popover
        padding: 16px
        border-radius: 12px
        box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76)

        .el-button
            width: 100%
            margin-top: 8px
</style>

<style lang="sass" scoped>
    .marketplace
        display: flex
        padding: 0 !important
        flex-direction: column
        overflow: hidden !important

        &:before
            content: ''
            top: 0
            left: 0
            z-index: -1
            width: 100%
            height: 100%
            position: fixed
            filter: opacity(.08)
            pointer-events: none
            background-repeat: no-repeat
            background-attachment: fixed
            background-position: top left
            background-image: url('~img/5c3a1aefbaf4e.png')

        &.md .container .content /deep/ .ui-card__footer .el-pagination
            justify-content: center

        .container
            height: 100%
            padding: 16px
            overflow-y: auto

            .content
                background-color: transparentize(#fff, .28) !important

                /deep/ .ui-card__header
                    display: flex
                    align-items: center

                    .el-button
                        margin: 0

                    > *:not(:last-child)
                        margin-right: 8px

                /deep/ > .ui-card__body
                    display: grid
                    grid-gap: 24px
                    grid-template-rows: auto auto auto
                    grid-template-columns: repeat(auto-fill, minmax(256px, 1fr))

                    .placeholder
                        grid-column: 1 / -1
                        grid-row-end: 3
                        display: flex
                        flex-direction: column
                        align-items: center

                        .image
                            width: 320px
                            margin-bottom: 16px

                        .title
                            font-size: 28px
                            font-weight: 800
                            color: var(--color-primary)

                        .description
                            font-size: 16px
                            color: var(--color-text-placeholder)

                    .ui-card
                        background-color: transparent

                /deep/ .ui-card__footer
                    .el-pagination
                        display: flex
                        align-items: center

                        /deep/ .el-pagination__sizes
                            flex: 1

        .ui-drawer
            display: flex
            flex-direction: column

            &:before
                content: ''
                position: fixed
                top: 0
                left: 0
                width: 100%
                height: 100%
                background-image: url('~img/5d619aede1e3c.png')
                background-repeat: no-repeat
                background-position: top center
                width: 100%
                height: 100%
                filter: opacity(0.08)
                pointer-events: none

            .ui-divider
                margin: 32px 16px 0 16px

                /deep/ .ui-divider__content
                    left: 0
                    z-index: 1
                    padding-left: 0
                    font-size: 20px
                    font-weight: 700
                    color: var(--color-primary)

            .content
                height: 100%
                display: flex
                padding: 16px
                overflow-y: auto
                flex-direction: column

                .el-form
                    flex: 1

                    /deep/ .el-input .el-input__inner,
                    /deep/ .el-textarea .el-textarea__inner
                        background-color: transparentize(#fff, .44)

                    /deep/ .el-loading-mask
                        position: fixed
</style>