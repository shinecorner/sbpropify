<template>
    <el-card  :class="{announcement: data.announcement}" >
        <div ref="container" >
        <div class="announcement" v-if="data.announcement"><span>announcement</span></div>
        <div class="user">
            <ui-avatar :name="data.user.name" :size="42" :src="data.user.avatar" />
            <div class="name">
                {{data.user.name}}
                <small>
                    {{formatDatetime(data.created_at)}}
                </small>
            </div>
            <div class="actions" v-if="showActions && loggedInUser.id == data.user_id">
                <el-tooltip :content="$t('tenant.tooltips.edit_pinboard')">
                    <el-button size="mini" icon="icon-pencil" @click="$emit('edit-pinboard', $event, data)" plain round>{{$t('general.actions.edit')}}</el-button>
                </el-tooltip>
                <el-tooltip :content="$t('tenant.tooltips.delete_pinboard')">
                    <el-button size="mini" icon="icon-trash-empty" @click="$emit('delete-pinboard', $event, data)" plain round>{{$t('general.actions.delete')}}</el-button>
                </el-tooltip>
                
            </div>
        </div>
        <div class="title" v-if="data.announcement">
            <small>{{$t('tenant.category')}}:
                {{$t(`models.pinboard.category.${$store.getters['application/constants'].pinboard.category[data.category]}`)}}
            </small>
            <strong>{{data.title}}</strong>
        </div>
        
        <hr v-if="data.announcement" />
        <read-more class="content" :text="data.content" :max-chars="512" :more-str="$t('tenant.read_more')" :less-str="$t('tenant.read_less')" />

        <hr v-if="data.announcement"/>
        <div class="execution" v-if="data.announcement">
            {{$t('tenant.execution')}} {{execution}}
        </div>
        <div class="providers" v-if="data.announcement && data.providers && data.providers.length">
            {{$t('tenant.providers')}}: {{data.providers.map(provider => provider.name).join(', ')}}
        </div>
        <div class="gallery" v-if="data.media.length">
            <ui-images-carousel :images="data.media.map(({url}) => url)" :use-placeholder="false" :show-indicator="false" v-if="data.media.length > 0"/>
        </div>
        <!-- <media-gallery-carousel :media="data.media" :use-placeholder="false" height="320px" :autoplay="false" :gallery-options="{container: '#gallery'}" /> -->
        <likes type="pinboard" :data="data.likes" layout="row" />
        <like :id="data.id" type="pinboard">
            <el-button @click="$refs.addComment.focus()" icon="ti-comment-alt" type="text"> &nbsp;{{$t('tenant.comment')}}</el-button>
            <el-button icon="icon-picture" type="text" v-if="data.announcement === false && data.media.length">
                <template v-if="data.media.length">
                    {{data.media.length}} {{data.media.length > 1 ? $t('tenant.images') : $t('tenant.image')}}
                </template>
            </el-button>
        </like>
            
        
        <comments ref="comments" :id="data.id" type="pinboard" :use-placeholder="false" :with-scroller="true" @update-dynamic-scroller="$emit('update-dynamic-scroller')"/>
        <add-comment ref="addComment" :id="data.id" type="pinboard"/>
        </div>
    </el-card>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    import AgoMixin from 'mixins/agoMixin'
    import Card from 'components/Card'
    import Likes from 'components/tenant/Likes'
    // import AddComment from 'components/AddComment'
    import MediaGalleryCarousel from 'components/MediaGalleryCarousel'
    import FormatDateTimeMixin from 'mixins/formatDateTimeMixin'
    import {format, isSameDay} from 'date-fns'
    import {IdState} from 'vue-virtual-scroller'
    import GalleryList from 'components/MediaGalleryList'
    import RequestMedia from 'components/RequestMedia';

    export default {
        name: 'p-pinboard-card',
        mixins: [
            AgoMixin,
            FormatDateTimeMixin,
            IdState({
                idProp: vm => vm.data.id
            })
        ],
        data () {
            return {
                height: null,
            }
        },
        props: {
            data: {
                type: Object,
                required: true
            },
            showActions : {
                type: Boolean,
                default: true
            },
        },
        idState () {
            return {
            }
        },
        components: {
            Card,
            Likes,
            // AddComment,
            MediaGalleryCarousel,
            GalleryList,
            RequestMedia
        },
        methods: {
            showChildrenAddComment() {
                this.$refs.comments.showChildrenAddComment()
            },
        },
        computed: {
            ...mapGetters(['loggedInUser']),

            isNewNeighbourType() {
                return this.$store.getters['application/constants'].pinboard.type[this.data.type] === 'new_neighbour'
            },
            execution() {
                const {execution_start, execution_end} = this.data

                const start = this.formatDatetime(execution_start)
                const end = isSameDay(execution_start, execution_end) ? format(execution_end, 'HH:mm') : this.formatDatetime(execution_end);
                
                return `${start} - ${end}`
            },
            tenant() {
                const {title, first_name, last_name} = this.data.tenant;

                return `${title}. ${first_name} ${last_name}`
            }
            
        },
        mounted () {
            this.data.height =  this.$refs.container.clientHeight

        }
    }
</script>

<style lang="scss" scoped>
    .el-card {
        &.announcement {
            :global(.el-card__body) {
                border-width: 8px;
                border-style: solid;
                border-image: linear-gradient(to bottom, darken(#fff, 4%), transparent) 1;
                position: relative;
            }
        }

        hr {
            border-style: solid none none none;
            border-color: darken(#fff, 6%);
        }

        .user {
            display: flex;
            align-items: center;

            .name {
                font-size: 16px;
                line-height: 1.32;
                margin-left: 1em;

                small {
                    font-size: 80%;
                    display: block;
                    color: darken(#fff, 48%);
                }
            }

            .actions {
                flex-grow: 1;
                display: flex;
                justify-content: flex-end;
            }
        }

        .title {
            font-weight: 500;
            margin: 8px 0;
            line-height: 1.32;

            small {
                font-size: 80%;
                font-weight: normal;
                display: block;
                color: darken(#fff, 48%);
            }
        }

        .execution {
            font-size: 12px;
            color: darken(#fff, 48%);
        }

        .gallery {
            padding-bottom: 20px;
        }

        .media-gallery-carousel {
            margin: 12px -16px -17px -16px;
            box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76);
        }

        .like {
            background: #f2f4fa;
            padding: 10px;
        }
        .likes {
            font-size: 14px;
            margin: 0;
            padding: 0;
            padding-bottom: 16px;
            display: flex;
            align-items: center;

            :global(.avatar) {
                border: 2px #fff solid;

                &:not(:first-of-type) {
                    margin-left: -10px;
                }
            }

            .users {

                line-height: 1.32;

                small {
                    color: darken(#fff, 40%);
                }
            }
        }

        .placeholder {
            padding: 8px;
        }

        :global(.reactions) {
            border-width: 1px;
            border-color: darken(#fff, 6%);
            border-style: solid none;
            margin: 16px -16px;
            padding: 12px 16px;
        }

        :global(.comments-list) {
            margin: 16px 0;
            min-height: 30px;

            :global(.vue-recycle-scroller) {
                min-height: 30px;
            }

            > :global(.el-button) {
                padding-top: 0;
            }
        }

        .announcement {
            position: absolute;
            right: 2px;
            top: 2px;
            z-index: 1;
            overflow: hidden;
            width: 75px;
            height: 75px;
            text-align: right;

            span {
                font-size: 10px;
                font-weight: bold;
                color: #fff;
                text-transform: uppercase;
                text-align: center;
                line-height: 20px;
                transform: rotate(45deg);
                width: 100px;
                display: block;
                background: #6AC06F;
                background: linear-gradient(darken(#6AC06F, 10%) 0%, #6AC06F 100%);
                box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
                position: absolute;
                top: 19px;
                right: -21px;

                &:before {
                    content: "";
                    position: absolute;
                    left: 0px;
                    top: 100%;
                    z-index: -1;
                    border-left: 3px solid #6AC06F;
                    border-right: 3px solid transparent;
                    border-bottom: 3px solid transparent;
                    border-top: 3px solid #6AC06F;
                }

                &:after {
                    content: "";
                    position: absolute;
                    right: 0px;
                    top: 100%;
                    z-index: -1;
                    border-left: 3px solid transparent;
                    border-right: 3px solid #6AC06F;
                    border-bottom: 3px solid transparent;
                    border-top: 3px solid #6AC06F;
                }
            }
        }

        &:not(.new-neighbour) {
            .users {
                margin-left: 4px;

                small {
                    display: block;
                }
            }

            .content {
                margin: 16px 0;
                :global(p) {
                    margin: 0;
                    white-space: pre-wrap;
                }
                :global(a) {
                    color: #6AC06F;
                    text-decoration: none;
                    transition: color .48s;
                    &:focus,
                    &:hover {
                        color: lighten(#6AC06F, 16%);
                    }
                }
            }
        }

        &.new-neighbour {
            .content {
                margin-bottom: 8px;

                b {
                    text-transform: capitalize;
                }

                small {
                    display: block;
                    color: darken(#fff, 40%);
                }
            }

            .reactions {
                margin-bottom: -17px;
            }
        }
    }
</style>
