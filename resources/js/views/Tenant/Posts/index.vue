<template>
    <div :class="['posts-box']">
        <div :class="['posts']">
            <ui-heading icon="icon-megaphone-1" :title="$t('tenant.news')" :description="$t('tenant.heading_info.news')" />
            
                <ui-divider />
            <div class="container" >
                
                <div class="content">
                    <post-add-card />
                    <el-divider content-position="left">
                        <el-button @click="refreshPage" size="small" icon="icon-arrows-ccw" plain round>{{$t('tenant.refresh')}}</el-button>
                        <!-- <el-popover popper-class="posts-filter" placement="bottom-end" trigger="click" :width="192">
                            <el-button size="small" slot="reference" icon="el-icon-sort" round>{{$t('tenant.filters')}}</el-button>
                            <filters ref="filters" layout="row" :data="filters.data" :schema="filters.schema" @changed="onFiltersChanged" />
                            <el-button type="primary" size="mini" icon="el-icon-sort-up" @click="resetFilters">{{$t('tenant.reset_filters')}}</el-button>
                        </el-popover> -->
                    </el-divider>
                    <dynamic-scroller ref="dynamic-scroller" :items="filteredPosts" :min-item-size="131" v-if="!loading && filteredPosts.length">
                        <template #before v-if="loading && !filteredPosts.length">
                            <loader v-for="idx in 5" :key="idx" />
                        </template>
                        <template v-slot="{item, index, active}">
                            <dynamic-scroller-item :item="item" :active="active" :data-index="index" :size-dependencies="[item]" page-mode >
                                <post-new-tenant-card :data="item" v-if="$constants.posts.type[item.type] === 'new_neighbour'"/>
                                <post-card :data="item" @edit-post="editPost" @delete-post="deletePost" v-else/>
                            </dynamic-scroller-item>
                        </template>
                        <template #after v-if="loading && !filteredPosts.length">
                            <loader />
                        </template>
                    </dynamic-scroller>
                </div>
                <rss-feed class="rss-feed" title="Blick.ch News" />
            </div>
            
        </div>
        <ui-drawer :size="448" :visible.sync="visibleDrawer" :z-index="1" direction="right" docked>
            <ui-divider content-position="left" v-if="editingPost">{{$t('tenant.edit_post')}}</ui-divider>
            <div class="content">
                <post-edit-form :data="editingPost" v-if="editingPost" :visible.sync="visibleDrawer"/>
            </div>
        </ui-drawer>
        
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
                filterCategory: null,
                editingPost: null,
                visibleDrawer: false,
                deleteModalVisible: false,
                delPostStatus: -1
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
            },
            async deletePost(event, data) {
                const resp = await this.$confirm(this.$t(`general.swal.delete_listing.text`), this.$t(`general.swal.delete_listing.title`), {
                    type: 'warning'
                }).then(() => {
                    this.$store.dispatch('newPosts/delete', data)
                }).catch(() => {
                });
            },
            editPost(event, data) {
                console.log('editPost', data)
               this.editingPost = data;
               this.visibleDrawer = true;
            }
        },
        watch: {
            'visibleDrawer': {
                immediate: false,
                handler (state) {
                    // TODO - auto blur container if visible is true first
                    if (!state) {
                        this.editingPost = null
                    }
                }
            }
        },
        computed: {
            ...mapState('newPosts', {
                posts: state => state
            }),
            filteredPosts() {
                // if(this.$refs['dynamic-scroller'])
                //     this.$refs['dynamic-scroller'].forceUpdate()
                return this.posts.data.filter( post => { return this.filterCategory == null || post.category == this.filterCategory})
            }
        },
        async mounted() {
            await this.getPosts()
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
    .layout .container .content .view {
        padding: 0;
    }

    .posts {
        width: 100%;
        height: 100%;
        padding: 16px;
        overflow-y: auto;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .container {
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

    @media screen and (max-width: 676px) {

        .posts .container {
            grid-template-columns: auto;
        }
        .rss-feed {
            display: none;
        }
    }
</style>

<style lang="sass" scoped>
    .posts-box
        /deep/ .ui-drawer
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