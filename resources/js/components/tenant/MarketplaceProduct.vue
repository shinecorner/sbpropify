<template>
    <div class="product" v-on="$listeners">
        <div class="media">
            <img :src="data.media[0].url" v-if="data.media[0]" />
            <empty v-else :image="require('img/5c98a90bb5c05.png')" :size="112" />
            <div class="price" v-if="hasPrice">{{ data.price | emptyPrice }}</div>
        </div>
        <div class="content">
            <div class="title">
                <el-tag type="success" size="mini" v-if="isFree">Free</el-tag> {{ data.title }}
            </div>
            <small>
                added {{ ago(data.published_at) }}
            </small>
            <reactions :id="data.id" type="products" counter>
                <div><i class="ti-comments" /> {{ data.comments_count }}</div>
            </reactions>
        </div>
    </div>
</template>

<script>
    import Empty from 'components/Empty'
    import {distanceInWordsToNow} from 'date-fns'
    import Reactions from 'components/Reactions'

    export default {
        props: {
            data: {
                type: Object,
                required: true
            }
        },
        components: {
            Empty,
            Reactions
        },
        filters: {
            emptyPrice (price) {
                if (!price) {
                    return 'No price available'
                }

                return `${price} CHF`
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
            }
        },
        computed: {
            isFree () {
                return !this.data.price && this.data.type === 4
            },
            hasPrice () {
                return this.data.type !== 4
            }
        }
    }
</script>

<style lang="scss" scoped>
    .product {
        background-color: #fff;
        border: 1px darken(#fff, 12%) solid;
        border-radius: 6px;
        overflow: hidden;
        .media {
            width: 100%;
            overflow: hidden;
            padding-top: 100%;
            position: relative;
            background-color: darken(#fff, 2%);
            border-bottom: 1px darken(#fff, 12%) solid;
            img, :global(.empty) {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
            }
            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            .price {
                position: absolute;
                left: 0;
                bottom: 0;
                margin: 8px;
                font-size: 12px;
                font-weight: bold;
                padding: 4px 8px;
                border-radius: 4px;      
                color: #fff;
                background-color: transparentize(#000, .2);
            }
        }
        .content {
            padding: 8px;
            .title {
                flex: 1;
                font-weight: bold;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            small {
                color: darken(#fff, 48%);
            }
        }
    } 
</style>