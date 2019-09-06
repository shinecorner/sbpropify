<template>
    <div class="products">
        <heading :title="$t('models.product.title')" icon="icon-basket" shadow="heavy">
            <!--<el-button @click="add" icon="ti-plus" round type="primary">-->
            <!--{{$t('models.product.add')}}-->
            <!--</el-button>-->
            <template v-if="$can($permissions.delete.product)">
                <el-button :disabled="!selectedItems.length" @click="batchDeleteWithIds" icon="ti-trash" round size="mini"
                           type="danger">
                    {{$t('general.actions.delete')}}
                </el-button>
            </template>
        </heading>
        <list-table
            :fetchMore="fetchMore"
            :filters="filters"
            :filtersHeader="filtersHeader"
            :header="header"
            :items="formattedItems"
            :loading="{state: loading}"
            :isLoadingFilters="{state: isLoadingFilters}"
            :pagination="{total, currPage, currSize}"
            :withSearch="false"
            @selectionChanged="selectionChanged"
        >
        </list-table>
        <el-dialog :title="$t('general.actions.view')" :visible.sync="productDetailsVisible">
            <product-details :product="product"></product-details>
            <el-button @click="changeProductStatus(product.id, productConstants.published)"
                       type="success"
                       v-if="product.status != productConstants.published"
            >
                {{$t('models.product.publish')}}
            </el-button>
            <el-button @click="changeProductStatus(product.id, productConstants.unpublished)"
                       type="danger"
                       v-else
            >
                {{$t('models.product.unpublish')}}
            </el-button>
        </el-dialog>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import {mapActions} from 'vuex';
    import {displayError, displaySuccess} from "helpers/messages";
    import ListTableMixin from 'mixins/ListTableMixin';
    import ProductDetails from "components/ProductDetails";
    import getFilterQuarters from 'mixins/methods/getFilterQuarters';
    
    const mixin = ListTableMixin({
        actions: {
            get: 'getProducts',
            delete: 'deleteProductWithIds'
        },
        getters: {
            items: 'products',
            pagination: 'productsMeta'
        }
    });

    export default {
        components: {
            Heading,
            ProductDetails
        },
        mixins: [mixin, getFilterQuarters],
        data() {
            return {
                header: [{
                    label: 'models.product.product_title',
                    prop: 'title'
                }, {
                    label: 'general.email',
                    prop: 'user.email'
                }, {
                    label: 'models.product.type.label',
                    prop: 'formatted_type_label'
                }, {
                    label: 'models.product.visibility.label',
                    prop: 'formatted_visibility_label'
                }, {
                    label: 'models.product.status.label',
                    prop: 'formatted_status_label'
                }, {
                    // width: 170,
                    width: 85,
                    actions: [
                        // {
                        //     type: 'primary',
                        //     title: this.$t('general.actions.view'),
                        //     onClick: this.show,
                        //     permissions: [
                        //         this.$permissions.view.product
                        //     ]
                        // }, 
                        {
                            title: 'general.actions.edit',
                            onClick: this.edit,
                            permissions: [
                                this.$permissions.update.product
                            ]
                        }
                    ]
                }],
                product: {},
                productDetailsVisible: false,
                tenants: {},
                quarters: {},
                isLoadingFilters: false,
            };
        },
        computed: {
            formattedItems() {
                const storeConstants = this.$store.getters['application/constants'].products;
                return this.items.map((product) => {                                        
                    product.formatted_status_label = this.$t(`models.product.status.${storeConstants.status[product.status]}`);
                    product.formatted_visibility_label = this.$t(`models.product.visibility.${storeConstants.visibility[product.visibility]}`);
                    product.formatted_type_label = this.$t(`models.product.type.${storeConstants.type[product.type]}`);
                    return product
                });
            },
            filters() {
                return [
                    {
                        name: this.$t('filters.search'),
                        type: 'text',
                        icon: 'el-icon-search',
                        key: 'search'
                    },
                    {
                        name: this.$t('models.product.status.label'),
                        type: 'select',
                        key: 'status',
                        data: this.prepareFilters("status"),
                    },
                    {
                        name: this.$t('models.product.type.label'),
                        type: 'select',
                        key: 'type',
                        data: this.prepareFilters("type"),
                    },
                    {
                        name: this.$t('filters.quarters'),
                        type: 'select',
                        key: 'quarter_id',
                        data: this.quarters
                    },
                    {
                        name: this.$t('filters.tenant'),
                        type: 'remote-select',
                        key: 'tenant_id',
                        data: this.tenants,
                        remoteLoading: false,
                        fetch: this.fetchRemoteTenants
                    }
                ];
            },
            productConstants() {
                return this.$store.getters['application/constants'].products;
            },

        },
        methods: {
            ...mapActions(['changeProductPublish', 'getBuildings', 'getTenants']),
            async getFilterBuildings() {
                this.loading = true;
                const buildings = await this.getBuildings({
                    get_all: true
                });
                this.loading = false;

                return buildings.data;
            },
            async fetchRemoteTenants(search) {
                const tenants = await this.getTenants({get_all: true, search});

                return tenants.data.map((tenant) => {
                    return {
                        name: `${tenant.first_name} ${tenant.last_name}`,
                        id: tenant.id
                    };
                });
            },
            add() {
                this.$router.push({
                    name: 'adminProductsAdd'
                });
            },
            edit({id}) {
                this.$router.push({
                    name: 'adminProductsEdit',
                    params: {
                        id
                    }
                });
            },
            show(product) {
                this.product = product;
                this.productDetailsVisible = true;
            },
            changeProductStatus(id, status) {
                this.changeProductPublish({id, status}).then((resp) => {
                    this.getProducts();
                    this.productDetailsVisible = false;
                    displaySuccess(resp);
                }).catch((error) => {
                    displayError(error);
                });
            },
            prepareFilters(property) {
                return Object.keys(this.productConstants[property]).map((id) => {
                    return {
                        id: parseInt(id),
                        name: this.$t(`models.product.${property}.${this.productConstants[property][id].toLowerCase()}`)
                    };
                });
            },
        },
        async created(){
            this.isLoadingFilters = true;
            this.tenants = await this.fetchRemoteTenants();
            const quarters = await this.axios.get('quarters')
            this.quarters = quarters.data.data.data;
            this.isLoadingFilters = false;
        }
    }
</script>
