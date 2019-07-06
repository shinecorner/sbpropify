<template>
    <div class="marketplace">
        <!-- if a product is given away do not show the price, otherwise show the price for each product, and show the product type lend/sell in product details aswell  -->
        <heading icon="ti-shopping-cart" title="Marketplace" description="Start selling things you don't need anymore." class="custom-heading" />
        <card class="search">
            <el-input placeholder="Search for a product..." v-model="search" clearable>
                <i slot="prefix" class="el-input__icon" :class="searchIcon"></i>
            </el-input>
            <el-button type="primary" icon="el-icon-circle-plus-outline" @click="addProduct">Add product</el-button>
            <el-dialog custom-class="add-product" title="Add product" :visible.sync="addProductDialogVisible">
                <add-product ref="addProduct" />
                <template class="dialog-footer" slot="footer">
                    <el-button @click="closeAddProduct" icon="el-icon-close" round>
                        Cancel
                    </el-button>
                    <el-button @click="saveProduct" icon="el-icon-check" round type="primary">
                        Save
                    </el-button>
                </template>
            </el-dialog>
        </card>
        <card class="products" :loading="loading">
            <div class="heading">
                Latest products added
                <el-popover placement="bottom-end" trigger="click" :width="192">
                    <filters :data="filters.data" :schema="filters.schema" @changed="filtersChanged" layout="row" />
                    <el-button size="mini" slot="reference" icon="el-icon-sort" round>Filters</el-button>
                </el-popover>
            </div>
            <empty v-if="emptyData" :image="require('img/5ca7dde590fa1.png')" :size="512" text="Unfortunately, no one is selling what you are looking for...">
                Do not worry, definitely there will be someone selling soon the product you want, so you may come and check again a bit later!
            </empty>
            <product v-for="product in products.data" :key="product.id" :data="product" @click="open(product)" />
            <el-dialog custom-class="product-details" :visible.sync="dialogVisible" :before-close="handleDialogClose" width="80%">
                <product-details :data="openedProduct" v-if="openedProduct" />
            </el-dialog>
        </card> 
    </div>
</template>

<script>
    import {distanceInWordsToNow} from 'date-fns'
    import {displaySuccess, displayError} from 'helpers/messages'

    import Product from 'components/tenant/MarketplaceProduct'
    import AddProduct from 'components/tenant/MarketplaceAddProduct'
    import ProductDetails from 'components/tenant/MarketplaceProductDetails'

    import Heading from 'components/Heading'
    import Card from 'components/Card'
    import Empty from 'components/Empty'
    import Filters from 'components/Filters'

    export default {
        components: {
            Product,
            AddProduct,
            ProductDetails,
            Heading,
            Card,
            Empty,
            Filters
        },
        data () {
            const filterSchema = [{
                type: 'el-switch',
                title: 'My offerings',
                name: 'user_id',
                props: {
                    activeValue: this.$store.getters.loggedInUser.id.toString(),
                    inactiveValue: null
                }
            }, {
                type: 'el-select',
                title: 'Type',
                name: 'type',
                props: {
                    clearable: true,
                    size: 'mini'
                },
                children: [{
                    type: 'el-option',
                    props: {
                        label: 'All',
                        value: null
                    }
                }].concat(Object.entries(this.$constants.products.type).map(([value, label]) => ({
                    type: 'el-option',
                    props: {label, value}
                })))
            }]

            const filterData = {
                user_id: null,
                type: null
            }

            return {
                search: null,
                loading: {
                    state: false,
                    background: 'rgba(255, 255, 255, 0.8)'
                },
                products: [],
                openedProduct: null,
                dialogVisible: false,
                addProductDialogVisible: false,
                searchIcon: 'el-icon-search',
                filters: {
                    schema: filterSchema,
                    data: filterData
                }
            }
        },
        methods: {
            open (product) {
                this.openedProduct = product
                this.dialogVisible = true
            },
            handleDialogClose (done) {
                this.openedProduct = null

                done()
            },
            addProduct () {
                this.addProductDialogVisible = true
            },
            closeAddProduct (done) {
                if (done instanceof Event) {
                    this.addProductDialogVisible = false;
                } else {
                    done();
                }
            },
            saveProduct () {
                this.$refs.addProduct.submit();
            },
            async get (params) {
                try {
                    this.loading.state = true

                    const {data} = await this.$store.dispatch('products2/get', {
                        per_page: 9999, // temporary to load all till infinite scrolling is fully implemented
                        ...params
                    })

                    this.products = this.$store.getters['products2/get']

                    await this
                } catch (err) {
                    displayError(err)
                } finally {
                    this.loading.state = false
                }
            },
            async getMore () {
                const {
                    current_page,
                    last_page
                } = this.products

                if (current_page === last_page) {
                    return
                }

                if (!this.loading.state) {
                    let page = current_page

                    page++

                    await this.get({page, inserting: true})
                }
            },
            async filtersChanged (filters) {
                let query = {
                    ...this.$route.query,
                    ...filters
                };

                this.$router.replace({
                    name: this.$route.name,
                    query: {
                        search: this.$route.query.search,
                        ...filters
                    },
                    params: this.$route.params
                });

                await this.get(filters);
            },
            async handleSearch () {
                let query = {...this.$route.query};

                if (this.search) {
                    query = {...query, search: this.search}
                } else {
                    delete query.search
                }

                this.$router.replace({
                    name: this.$route.name, query, params: this.$route.params});

                await this.get({search: this.search, ...this.$route.query})

                this.searchIcon = 'el-icon-search'
            }
        },
        computed: {
            emptyData () {
                return !this.loading.state && !this.products.data.length
            }
        },
        watch: {
            search (newValue, oldValue) {
                this.loading.state = true
                this.searchIcon = 'el-icon-loading'
                
                this.debouncedHandleSearch()
            }
        },
        async created () {
            // TODO - needs more work to handle the query params properly
            await this.get()
            
            this.debouncedHandleSearch = _.debounce(this.handleSearch, 512)

            const {search, ...restQuery} = this.$route.query

            if (search) {
                this.search = search
            }

            if (restQuery) {
                this.filters.data.user_id = restQuery.user_id
            }
        }
    }
</script>

<style lang="scss">
    .el-dialog.add-product {
        position: relative;
        border-radius: 6px;
        z-index: 1;
        border-radius: 6px;
        .el-dialog__body {
            :global(.el-input__inner),
            :global(.el-textarea__inner) {
                background-color: transparentize(#fff, .44);
            }
            &:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                z-index: -1;
                width: 100%;
                height: 100%;
                border-radius: 6px;
                background-image: url('~img/5ca7ec589fc67.png');
                background-repeat: no-repeat;
                background-size: 64em;
                background-position: -4em -12em;
                opacity: .16;
            }
        }
    }
    .el-dialog.product-details {
        max-width: 896px;
        overflow: hidden;
        border-radius: 6px;
        .el-dialog__header .el-dialog__headerbtn {
            top: 12px;
            right: 12px;
            z-index: 1;
        }
        .el-dialog__body {
            padding: 0;
            margin-top: -30px;
        }
    }
</style>

<style lang="scss" scoped>
    .marketplace {
        .custom-heading {
            width: 100%;
            margin-bottom: 2em;
        }
        .el-card {
            &.search {
                margin-bottom: 1em;
                :global(.el-card__body) {
                    padding: 8px;
                    display: flex;
                    align-items: center;
                    .el-input + .el-button {
                        margin-left: 8px;
                    }
                    .el-popover__reference {
                        margin: 0 8px;
                    }
                }
            }
            &.products :global(.el-card__body) {
                display: flex;
                flex-wrap: wrap;
                align-content: flex-start;
                padding: 4px;
                min-height: 256px;
                .heading {
                    width: 100%;
                    padding: 8px;
                    font-size: 16px;
                    font-weight: bold;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }
                :global(.product) {
                    width: 20%;
                    margin: 4px;
                    flex-basis: calc(20% - 10px);
                    transition: box-shadow .32s ease;
                    cursor: pointer;
                    &:hover {
                        box-shadow: 0 1px 3px transparentize(#000, .88),
                                    0 1px 2px transparentize(#000, .76);
                    }
                } 
            }
        }
    }
</style>