<template>
    <div class="chat">
        <comments ref="comments" :id="id" :type="type" :limit="limit" reversed with-scroller :show-children="false" :style="{height: height, maxHeight: maxHeight}" />
        <add-comment ref="addComment" :id="id" :type="type" :show-templates="showTemplates" />
    </div>
</template>

<script>
    import ErrorFallback from 'components/common/Chat/Error'

    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
            type: {
                type: String,
                required: true,
                validator: type => ['post', 'product', 'request', 'conversation', 'internalNotices'].includes(type)
            },
            height: {
                type: String,
                default: '100%'
            },
            maxHeight: {
                type: String,
                default: '320px'
            },
            limit: {
                type: Number,
                default: 50
            },
            autofocus: {
                type: Boolean,
                default: false
            },
            showTemplates: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                errorFallback: ErrorFallback
            }
        },
        methods: {
            focusOnAddComment() {
                this.$refs.addComment.focus()
            }
        },
        mounted () {
            if (this.autofocus) {
                this.focusOnAddComment()
            }
        }
    }
</script>

<style lang="sass" sccoped>
    .chat
        height: 100%
        display: flex
        flex-direction: column

        .comments-list 
            /deep/ .vue-recycle-scroller
                padding-bottom: 8px

                // /deep/ .vue-recycle-scroller__slot)
                //     :global(.el-divider) 
                //         margin-top: 8px

        .add-comment
            width: auto
</style>

<style lang="scss" scoped>
    // .chat {
    //     height: 100%;
    //     color: lighten(#000, 32%);
    //     display: flex;
    //     flex-direction: column;

    //     .comments-list {
    //         :global(.vue-recycle-scroller) {
    //             padding-bottom: 8px;

    //             :global(.vue-recycle-scroller__slot) {
    //                 :global(.el-divider) {
    //                     margin-top: 8px;
    //                 }
    //             }
    //         }
    //     }
    //     .add-comment {
    //         width: auto;
    //     }
    // }
</style>
