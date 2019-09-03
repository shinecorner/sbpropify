<template>
    <loader v-if="loading && !comments.data.length" />
    <div class="placeholder" v-else-if="!loading && !comments.data.length">
        <img class="image" :src="require('img/5c98b47a97050.png')" />
        <div class="title">{{$t('components.common.commentsList.emptyPlaceholder.title')}}</div>
        <div class="description">{{$t('components.common.commentsList.emptyPlaceholder.description')}}</div>
    </div>
    <div class="comments-list" v-else>
        <template v-if="withScroller">
            <dynamic-scroller ref="dynamic-scroller" :items="comments.data" :min-item-size="40" @resize="scrollToBottom">
                <template #before>
                    <el-divider v-if="comments.current_page !== comments.last_page">
                        <el-button icon="el-icon-top" size="mini" :loading="loading" round @click="fetch">
                            <template v-if="loading">{{$t('components.common.commentsList.loading')}}</template>
                            <template v-else>{{$t('components.common.commentsList.loadMore.simple', {count: comments.total - comments.data.length})}}</template>
                        </el-button>
                    </el-divider>
                </template>
                <template v-slot="{item, index, active}">
                    <dynamic-scroller-item :item="item" :active="active" :data-index="index">
                        <comment v-bind="commentComponentProps" v-on="commentComponentListeners" :show-children="showChildren" :data="item" :reversed="isCommentReversed(item)" />
                    </dynamic-scroller-item>
                </template>
            </dynamic-scroller>
        </template>
        <template v-else>
            <el-button type="text" @click="fetch" :loading="loading" v-if="!data && comments.current_page !== comments.last_page">
                {{$t('components.common.commentsList.loadMore.detailed', {count: comments.total - comments.data.length})}}
            </el-button>
            <comment v-bind="commentComponentProps" :show-children="showChildren" v-for="comment in comments.data" :key="comment.id" :data="comment" :reversed="isCommentReversed(comment)" />
        </template>
    </div>
</template>

<script>
    import Loader from 'components/common/Comments/Loader'
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        props: {
            id: {
                type: Number,
            },
            parentId: {
                type: Number
            },
            type: {
                type: String,
                validator: type => ['post', 'product', 'request', 'conversation'].includes(type)
            },
            data: {
                type: Object
            },
            limit: {
                type: Number,
                default: 5
            },
            reversed: {
                type: Boolean,
                default: false
            },
            withScroller: {
                type: Boolean,
                default: false
            },
            showChildren: {
                type: Boolean,
                default: true
            },
            usePlaceholder: {
                type: Boolean,
                default: true
            }
        },
        components: {
            Loader
        },
        data () {
            return {
                loader: null,
                loading: true,
                comments: {
                    data: []
                }
            }
        },
        methods: {
            async fetch (params) {
                const {
                    current_page,
                    last_page
                } = this.comments;

                if (current_page && last_page &&
                    current_page == last_page) {
                    return
                }

                let prevScrollHeight = 0

                if (this.$refs['dynamic-scroller']) {
                    prevScrollHeight = this.$refs['dynamic-scroller'].$el.scrollHeight
                }

                let page = current_page || 0;

                page++;

                this.loading = true

                try {
                    await this.$store.dispatch('comments/get', {
                        id: this.id,
                        page,
                        per_page: this.limit,
                        sortedBy: 'desc',
                        orderBy: 'created_at',
                        commentable: this.type,
                        ...params
                    })

                    this.comments = this.$store.getters['comments/get'](this.id, this.type)

                    if (this.$refs['dynamic-scroller'] && current_page >= 1) {
                        this.$refs['dynamic-scroller'].$el.scrollTop = this.$refs['dynamic-scroller'].$el.scrollHeight - prevScrollHeight
                    }
                } catch (err) {
                    displayError(err)
                } finally {
                    this.loading = false
                }
            },
            forceUpdate () {
                this.$refs['dynamic-scroller'].forceUpdate()
            },
            scrollToBottom () {
                if (this.$refs['dynamic-scroller']) {
                    this.$refs['dynamic-scroller'].scrollToBottom()
                }
            },
            refreshComments () {
                this.comments = {
                    data: []
                }

                this.fetch()
            },
            isCommentReversed (comment) {
                return this.reversed && comment.user_id !== this.$store.getters.loggedInUser.id
            }
        },
        computed: {
            hasEmptyComments () {
                return !this.loading && !this.comments.data.length
            },
            commentComponentProps() {
                let props = {};

                if (this.id) {
                    props.id = this.id
                }

                if (this.parentId) {
                    props.parentId = this.parentId
                }

                if (this.type) {
                    props.type = this.type
                }

                return props
            },
            commentComponentListeners () {
                return {
                    'enter-edit': this.forceUpdate,
                    'cancel-edit': this.forceUpdate,
                    'size-changed': this.forceUpdate
                }
            }
        },
        watch: {
            'comments.total' () {
                this.scrollToBottom()
            },
            'data' (comments) {
                this.comments = comments
            }
        },
        async mounted() {
            if (this.data) {
                this.comments = this.data;
            } else {
                this.$store.dispatch('comments/clear', {commentable: this.type})

                await this.fetch()
            }
        }
    }
</script>

<style lang="sass" scoped>
    .placeholder
        display: flex
        padding: 16px
        text-align: center
        align-items: center
        flex-direction: column
        justify-content: center

        .image
            width: 128px

        .title
            font-size: 20px
            font-weight: 800
            color: var(--color-primary)

        .description
            font-size: 14px
            font-weight: 600
            word-break: break-word
            color: var(--color-text-placeholder)

    .comments-list
        width: 100%
        display: flex
        position: relative
        flex-direction: column
        box-sizing: border-box

        svg
            &:not(:last-of-type)
                margin-bottom: 4px

        .vue-recycle-scroller
            height: 100%
            overflow: auto
            will-change: transform

            /deep/ .vue-recycle-scroller__item-wrapper
                overflow: visible

        .el-button
            align-self: flex-start
</style>