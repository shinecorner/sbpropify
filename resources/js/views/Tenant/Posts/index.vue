<template>
    <div>
        <ui-heading icon="icon-megaphone-1" title="News" description="Sed placerat volutpat mollis." />
        
        <ui-divider />
        <div class="posts" v-infinite-scroll="getPosts" infinite-scroll-disabled="loading" >
            
            <div class="content">
                <post-add-card />
                <el-divider content-position="left">
                    <el-button @click="refreshPage" size="small" icon="icon-refresh" plain round>{{$t('tenant.refresh')}}</el-button>
                    <el-popover popper-class="posts-filter" placement="bottom-end" trigger="click" :width="192">
                        <el-button size="small" slot="reference" icon="el-icon-sort" round>{{$t('tenant.filters')}}</el-button>
                        <filters ref="filters" layout="row" :data="filters.data" :schema="filters.schema" @changed="onFiltersChanged" />
                        <el-button type="primary" size="mini" icon="el-icon-sort-up" @click="resetFilters">{{$t('tenant.reset_filters')}}</el-button>
                    </el-popover>
                </el-divider>
                <dynamic-scroller ref="dynamic-scroller" :items="filteredPosts" :min-item-size="131" page-mode>
                    <template #before v-if="loading && !filteredPosts.length">
                        <loader v-for="idx in 5" :key="idx" />
                    </template>
                    <template v-slot="{item, index, active}">
                        <dynamic-scroller-item :item="item" :active="active" :data-index="index">
                            <post-new-tenant-card :data="item" v-if="$constants.posts.type[item.type] === 'new_neighbour'" @hook:updated="$refs['dynamic-scroller'].forceUpdate" />
                            <post-card :data="item" @hook:updated="$refs['dynamic-scroller'].forceUpdate" v-else />
                        </dynamic-scroller-item>
                    </template>
                    <template #after v-if="loading && filteredPosts.length">
                        <loader />
                    </template>
                </dynamic-scroller>
            </div>
            <rss-feed title="Blick.ch News" />
        </div>
    </div>
</template>

<script>
    import Loader from 'components/tenant/PostCard/Loader'
    import {mapState} from 'vuex'

    import PostCardLoader from 'components/tenant/PostCard/Loader'
    import PostCardErrorFallback from 'components/tenant/PostCard/Error'

    import PostNewTenantCardLoader from 'components/tenant/PostNewTenantCard/Loader'
    import PostNewTenantCardFallbackError from 'components/tenant/PostNewTenantCard/Error'

    export default {
        components: {
            Loader,
            postAddCard: () => ({
                component: import(/* webpackChunkName: "postAddCard" */ 'components/tenant/PostAddCard'),
                delay: 0,
                timeout: 8000
            }),
            postCard: () => ({
                component: import(/* webpackChunkName: "postCard" */ 'components/tenant/PostCard'),
                loading: PostCardLoader,
                error: PostCardErrorFallback,
                delay: 0,
                timeout: 8000
            }),
            postNewTenantCard: () => ({
                component: import(/* webpackChunkName: "postCard" */ 'components/tenant/PostNewTenantCard'),
                loading: PostNewTenantCardLoader,
                error: PostNewTenantCardFallbackError,
                delay: 0,
                timeout: 8000
            }),
            rssFeed: () => ({
                component: import(/* webpackChunkName: "rssFeed" */ 'components/tenant/RSSFeed'),
                delay: 0,
                timeout: 8000
            })
        },
        data () {
            return {
                loading: false,
                filters: {
                    schema: [{
                        type: 'el-select',
                        title: 'Category',
                        name: 'category',
                        props: {
                            size: 'mini',
                            clearable: false,
                            defaultFirstOption: true
                        },
                        children: [{
                            type: 'el-option',
                            props: {
                                label: this.$t('tenant.all'),
                                value: null
                            }
                        }, {
                            type: 'el-option',
                            props: {
                                label: this.$t('tenant.my_posts'),
                                value: 1
                            }
                        }, {
                            type: 'el-option',
                            props: {
                                label: this.$t('tenant.from_neighbourhood'),
                                value: 2
                            }
                        }, {
                            type: 'el-option',
                            props: {
                                label: this.$t('tenant.from_quarter'),
                                value: 3
                            }
                        }]
                    }],
                    data: {
                        category: null
                    }
                },
                filterCategory: null
            }
        },
        methods: {
            async getPosts (params = {}) {
                if (this.loading && this.posts.data.length) {
                    return
                }

                const {current_page, last_page} = this.posts

                if (this.posts.data.length && current_page === last_page) {
                    return
                }

                let page = current_page || 0

                page++

//                this.$refs['dynamic-scroller'].forceUpdate()
                this.loading = true

                await this.$store.dispatch('newPosts/get', {
                    page,
                    per_page: 25,
                    sortedBy: 'desc',
                    orderBy: 'created_at',
                    ...params
                })

                this.loading = false
            },
            async onFiltersChanged (filters) {
                this.filterCategory = filters.category;
            },
            resetFilters () {
                this.$refs.filters.reset()
                this.filterCategory = null;
            },
            refreshPage () {
                this.getPosts();
                this.resetFilters ()
            }
        },
        computed: {
            ...mapState('newPosts', {
                posts: state => state
            }),
            filteredPosts() {
                return this.posts.data.filter( post => { return this.filterCategory == null || post.category == this.filterCategory})
            }
        }
    }
</script>

<style lang="scss" scoped>
    .posts-filter {
        // .el-divider {
        //     .el-divider__text {
        //         width: 100%;
        //         padding: 16px;
        //         background-color: transparent;
        //         padding: 0;
        //         left: 0;
        //         display: flex;
        //         align-items: center;
        //         box-sizing: border-box;
        //     }

        //     .el-button {
        //         width: 100%;
        //         margin-top: 16px;
        //     }
        // }
    }
</style>


<style lang="scss" scoped>
    .posts {
        display: grid;
        grid-gap: 12px;
        grid-template-columns: minmax(min-content, 640px) minmax(auto, 480px);

        &:before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            background-image: url('~img/51177185_23843277688790167_2069589399565238272_n.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: top left;
            width: 100%;
            height: 100%;
            opacity: .16;
            pointer-events: none;
        }

        .heading {
            & + .el-divider {
                grid-column: 1 / -1;
            }
        }

        .el-card {
            background-color: transparentize(#fff, .28);
            align-self: baseline;
            z-index: 1;
        }

        .content {
            > .el-card {
                & + .el-divider {
                    :global(.el-divider__text) {
                        width: 100%;
                        padding: 16px;
                        background-color: transparent;
                        left: 0;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        box-sizing: border-box;
                    }
                }
            }

            .vue-recycle-scroller {
                :global(.vue-recycle-scroller__item-wrapper) {
                    overflow: visible;

                    :global(.vue-recycle-scroller__item-view) > div {
                        padding-top: 6px;
                        padding-bottom: 6px;
                    }
                }
            }
        }
    }
</style>
