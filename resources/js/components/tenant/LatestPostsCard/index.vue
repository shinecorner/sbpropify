<template>
    <ui-card shadow="always">
        <template #header>
            <i class="icon-megaphone-1"></i> {{$t('tenant.latest_news')}}
            <el-button type="text" @click="$router.push({name: 'tenantPosts'})">{{$t('tenant.actions.view_all')}}</el-button>
        </template>
        <loader v-if="loading" />
        <div class="placeholder" v-else-if="!loading && !posts.length">
            <img class="image" :src="require('img/5c9d6e6c73f70.png')" />
            <div class="content">
                <div class="title">No post available yet.</div>
                <div class="description">Et aut cum ut earum. Et aperiam ut possimus explicabo. Modi dolores in odit id fuga maxime aperiam dolor.</div>
            </div>
        </div>
        <el-collapse :value="0" accordion v-else>
            <el-collapse-item v-for="(post, index) in posts" :key="post.id" :name="index">
                <template #title>
                    <ui-avatar :src="post.user.avatar" :size="36" :name="post.user.name" />
                    <div class="content">
                        <div class="user">
                            {{post.user.name}}
                        </div>
                        <like :id="post.id" type="post" readonly>
                            <div>
                                <i class="icon-chat"></i> {{post.comments_count}}
                            </div>
                            <div>
                                <i class="icon-picture"></i> {{post.media.length}}
                            </div>
                            <div class="time">
                                {{ago(post.published_at)}}
                            </div>
                        </like>
                    </div>
                </template>
                <div class="content">{{post.content}}</div>
                <el-button size="mini" icon="icon-right-1" plain round>{{$t('tenant.actions.view')}}</el-button>
            </el-collapse-item>
        </el-collapse>
    </ui-card>
</template>

<script>
    import Loader from './Loader'
    import AgoMixin from 'mixins/agoMixin'
    import {mapState} from 'vuex'
    import {EXTRA_LOADING_SECONDS} from 'config'

    export default {
        name: 'p-latest-posts-card',
        mixins: [AgoMixin],
        props: {
            limit: {
                type: Number,
                default: 5
            }
        },
        components: {
            Loader
        },
        data () {
            return {
                loading: false,
                timeout: null
            }
        },
        computed: {
            ...mapState('newPosts', {
                posts: ({data}) => data.slice(this.limit)
            })
        },
        async mounted () {
            if (!this.posts.length) {
                this.loading = true

                await this.$store.dispatch('newPosts/get', {
                    feed: 1,
                    sortedBy: 'desc',
                    per_page: this.limit,
                    orderBy: 'created_at',
                    status: +Object.entries(this.$constants.posts.status).find(([key, name]) => name === 'published')[0]
                })

                this.timeout = setTimeout(() => this.loading = false, EXTRA_LOADING_SECONDS)
            }
        },
        beforeDestroy () {
            clearTimeout(this.timeout)
        }
    }
</script>

<style lang="sass" scoped>
    .ui-card
        /deep/ .ui-card__header
            .el-button
                padding: 0
                margin-left: auto

                /deep/ [class*=icon] + span
                    margin-left: 5px

        /deep/ .ui-card__body
            .el-collapse
                margin: -16px
                border-style: none

                .el-collapse-item
                    &:hover
                        background-color: var(--primary-color-lighter)

                    &:last-child /deep/ .el-collapse-item__header
                        border-bottom-style: none

                    /deep/ .el-collapse-item__header
                        height: 56px
                        cursor: pointer
                        padding: 0 16px
                        line-height: 56px
                        background: transparent

                        .content
                            flex: auto
                            display: flex
                            overflow: hidden
                            margin-left: 16px
                            line-height: 1.48
                            flex-direction: column
                            justify-content: center

                            .user
                                min-width: 0
                                font-size: 15px
                                overflow: hidden
                                font-weight: 600
                                white-space: nowrap
                                text-overflow: ellipsis
                                color: var(--color-primary)


                            .like
                                font-size: 13px
                                font-weight: 300
                                color: var(--color-text-placeholder)

                    /deep/ .el-collapse-item__wrap
                        background: transparent

                        /deep/ .el-collapse-item__content
                            color: var(--color-text-secondary)
                            padding: 0 16px 16px 68px
                            font-size: 14px

                            &:after
                                content: ''
                                clear: both
                                display: table

                            .content
                                white-space: pre-wrap

                            .el-button
                                float: right
</style>