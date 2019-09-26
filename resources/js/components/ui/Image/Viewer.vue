<template>
    <div class="ui-image-viewer" :style="{'z-index': this.zIndex}">
        <div class="ui-image-viewer__mask"></div>
        <div class="ui-image-viewer__btn ui-image-viewer__btn--close icon-cancel" @click="close"></div>
        <template v-if="images.length > 1">
            <div class="ui-image-viewer__btn ui-image-viewer__btn--prev icon-left" v-if="isPrevVisible" @click="prev"></div>
            <div class="ui-image-viewer__btn ui-image-viewer__btn--next icon-right" v-if="isNextVisible" @click="next"></div>
        </template>
        <ui-image :src="src" v-for="(src, srcIndex) in images" :key="srcIndex" :style="{'filter': index === srcIndex ? 'opacity(1)' : 'opacity(0)'}" />
    </div>
</template>

<script>
    export default {
        name: 'ui-viewer',
        props: {
            currentImage: {
                type: String,
            },
            images: {
                type: Array,
                default: () => []
            },
            zIndex: {
                type: Number,
                default: 999999
            }
        },
        data () {
            return {
                index: 0
            }
        },
        computed: {
            isPrevVisible () {
                return this.index > 0
            },
            isNextVisible () {
                return this.index < this.images.length - 1
            }
        },
        methods: {
            onKeyDownHandler (event) {
                event.stopPropagation()

                switch (event.keyCode) {
                    case 27:
                        this.close()

                        break
                    case 37:
                        this.prev()

                        break
                    case 39:
                        this.next()

                        break
                }
            },
            close () {
                this.$emit('close')
            },
            prev () {
                if (this.isPrevVisible) {
                    this.index--
                }
            },
            next () {
                if (this.isNextVisible) {
                    this.index++
                }
            }
        },
        mounted () {
            this.index = this.images.indexOf(this.currentImage)

            document.addEventListener('keydown', this.onKeyDownHandler)
            document.body.appendChild(this.$el)
        },
        beforeDestroy () {
            document.removeEventListener('keydown', this.onKeyDownHandler)
        }
    }
</script>

<style lang="sass">
    .ui-image-viewer
        position: fixed
        top: 0
        left: 0
        right: 0
        bottom: 0
        display: flex
        align-items: center

        &__mask
            width: 100%
            height: 100%
            background: #000
            position: absolute
            top: 0
            left: 0
            filter: opacity(.8)

        .ui-image
            width: 100%
            height: 100%
            display: flex
            align-items: center
            justify-content: center
            position: absolute
            top: 0
            left: 0
            transition: filter .32s

            &__inner
                width: auto
                height: auto
                max-width: 100%
                max-height: 100%
                box-shadow: 0 2px 6px transparentize(#000, .88), 0 2px 4px transparentize(#000, .76)

        &__btn
            z-index: 9
            color: #fff
            width: 48px
            height: 48px
            display: flex
            margin: 0 16px
            cursor: pointer
            font-size: 24px
            border-radius: 50%
            position: absolute
            align-items: center
            filter: opacity(.64)
            justify-content: center
            transition: filter .48s
            background-color: transparentize(#000, .44)

            &:hover
                filter: opacity(1)

            &--close
                top: 0
                right: 0
                margin: 16px

            &--prev
                left: 0

            &--next
                right: 0
</style>