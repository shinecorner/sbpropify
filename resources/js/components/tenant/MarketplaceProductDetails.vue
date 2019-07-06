<template>
    <el-row type="flex">
        <el-col class="media" :span="10" :class="{empty: !data.media.length}" v-if="data.media.length > 1">
            <media-carousel :media="data.media" inverted />
            <reactions :id="data.id" type="products" />
        </el-col>
        <el-col class="details" :span="data.media.length > 1 ? 14 : 24">
            <el-tooltip effect="dark" content="Refresh comments" placement="top-end">
                <el-button size="mini" icon="el-icon-refresh" circle v-show="activeTab === 'comments'" @click="refreshComments" />
            </el-tooltip>
            <el-tabs v-model="activeTab" @tab-click="onTabClick">
                <el-tab-pane label="Overview" name="overview">
                    <div class="title">
                        {{ data.title }}
                        <small>
                            {{ ago(data.published_at) }}
                        </small>
                    </div>
                    <hr />
                    <div class="price">{{ data.price | emptyPrice }}</div>
                    <div class="description">{{ data.content }}</div>
    
                    <hr />
                    <div class="contact" v-if="contactVisible">
                        <small>Contact informations:</small>
                        {{ data.contact }}
                    </div>
                    <template v-else>
                        <el-button type="primary" round @click="showContact">Get in touch</el-button>
                        <small>Use the above button to get to know how you may contact the seller in order to get this product.</small>
                    </template>
                </el-tab-pane>
                <el-tab-pane name="comments">
                    <div slot="label">
                        <i class="ti-comments" />
                        Comments
                    </div>
                    <template v-if="loadComments">
                        <comments-list ref="comments" :id="data.id" type="product" />
                        <add-comment :id="data.id" type="product" />
                    </template>
                </el-tab-pane>
            </el-tabs>
        </el-col>
    </el-row>
</template>

<script>
    import Avatar from 'components/Avatar'
    import {distanceInWordsToNow} from 'date-fns'
    import MediaCarousel from 'components/MediaCarouselGallery'
    import CommentsList from 'components/CommentsList'
    import AddComment from 'components/AddComment'
    import Reactions from 'components/Reactions'

    export default {
        props: {
            data: {
                type: Object,
                required: true,
                
            }
        },
        data () {
            return {
                activeTab: 'overview',
                contactVisible: false,
                loadComments: false
            }
        },
        components: {
            Avatar,
            MediaCarousel,
            CommentsList,
            AddComment,
            Reactions
        },
        filters: {
            emptyPrice (value) {
                if (!value) {
                    return 'No price available'
                }

                return value
            }
        },
        methods: {
            ago (date) {
                if (date) {
                    return distanceInWordsToNow(date, {
                        includeSeconds: true,
                        addSuffix: 'ago'
                    });
                }
            },
            showContact () {
                this.contactVisible = true
            },
            onTabClick ({name}) {
                if (name === 'comments') {
                    this.loadComments = true
                }
            },
            refreshComments () {
                this.$refs.comments.refresh()
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-row {
        .el-col {
            &.media {
                display: flex;
                flex-direction: column;
                position: relative;
                background-color: #000;
                :global(.reactions) {
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    padding: 1em;
                    z-index: 9;
                    will-change: transform;
                    box-sizing: border-box;
                    transition: transform .3s ease;
                    transform: translate3d(0, 100%, 0);
                }
                &.empty {
                    opacity: .8;
                }
                &:after {
                    content: '';
                    z-index: 2;
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                    opacity: 0;
                    transition: opacity .3s ease;
                    box-shadow: inset 0 -56px 40px -16px transparentize(#000, .36);
                }
                &:hover {
                    :global(.reactions) {
                        transform: translate3d(0, 0, 0);
                    }
                    &:after {
                        opacity: 1;
                    }
                }
            }
            &.details {
                padding: 2em;
                > .el-button {
                    position: absolute;
                    right: 0;
                    z-index: 1;
                    margin: 6px 28px 6px;
                }
                .el-tabs {
                    :global(.el-tabs__header) {
                        margin: 0;
                    }
                    :global(.el-tabs__content) {
                        :global(.el-tab-pane) {
                            &:nth-child(1) {
                                margin-top: 1em;
                                .title {
                                    color: #000;
                                    font-size: 18px;
                                    small {
                                        display: block;
                                        font-size: 64%;
                                        color: darken(#fff, 56%);
                                    }
                                }
                                hr {
                                    margin: 1em 0;
                                    border: 1px darken(#fff, 8%) solid;
                                }
                                .price {
                                    font-size: 20px;
                                    font-weight: bold;
                                    color: #6AC06F;
                                }
                                .description {
                                    margin: 1em 0;
                                    white-space: pre-wrap;
                                    word-break: break-word;
                                }
                                .seller {
                                    display: flex;
                                    align-items: center;
                                    .content {
                                        margin-left: .5em;
                                        small {
                                            display: block;
                                        }
                                    }
                                }
                                .contact {
                                    font-size: 16px;
                                    small {
                                        font-weight: bold;
                                        display: block;
                                    }
                                }
                                .el-button {
                                    width: 100%;
                                }
                                > small:last-of-type {
                                    display: block;
                                    text-align: center;
                                    margin-top: 1em;
                                }
                            }
                            &:nth-child(2) {
                                > div {
                                    &:nth-child(1) {
                                        padding: 1em 1em 0 0;
                                        &.empty {
                                            margin-bottom: 1em;
                                        }
                                    }
                                    &:nth-child(2) {
                                        :global(.el-textarea__inner) {
                                            border-top-right-radius: 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>