<template>
    <div class="media-carousel-gallery">
        <gallery :images="images" :index="index" @close="close" />
        <el-carousel :autoplay="false" :height="height" indicator-position="none">
            <el-carousel-item v-for="(file, idx) in media" :key="file.id">
                <img :src="file.url" :alt="file.name" @click="open(file, idx)" />
            </el-carousel-item>
        </el-carousel>
    </div>
    <!-- <empty v-else :image="require('img/5c98a90bb5c05.png')" text="There are no media files available..." :inverted="inverted">
        Any image file can be seen in fullsize by hovering over and clicking the zoom icon
    </empty> -->
</template>

<script>
    import Gallery from './MediaGallery'
    import Empty from './Empty'

    export default {
        props: {
            media: {
                type: Array,
                default: []
            },
            height: {
                type: String,
                default: '320px'
            }
        },
        components: {
            Gallery,
            Empty
        },
        data () {
            return {
                index: null
            }
        },
        methods: {
            open (file, idx) {
                if (this.isImage(file)) {
                    this.index = idx;
                }
            },
            close () {
                this.index = null
            },
            isImage (file) {
                return ['jpg', 'jpeg', 'gif', 'bmp', 'png'].includes(file.name.split('.').pop());
            }
        },
        computed: {
            images () {
                return this.media.map(file => {
                    if (this.isImage(file)) {
                        return file.url
                    }
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .media-carousel-gallery {
        height: 100%;
        .el-carousel {
            height: 100%;
            :global(.el-carousel__container) {
                height: 100%;
                :global(.el-carousel__item) {
                    display: flex;
                    align-items: center;
                    img {
                        will-change: transform;
                        transition: transform .16s linear;
                        &:hover {
                            cursor: zoom-in;
                            transform: scale(1.16)
                        }
                    }
                }
            }
        }
    }
    
</style>