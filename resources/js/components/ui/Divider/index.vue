<template>
    <div :class="['ui-divider', {[`ui-divider--${direction}`]: true, 'ui-divider--transparent': transparent}]">
        <div :class="['ui-divider__content', {[`ui-divider__content--aligned-${contentPosition}`]: true}]" v-if="direction === 'horizontal'">
            <slot />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ui-divider',
        props: {
            direction: {
                type: String,
                default: 'horizontal',
                validator: value => ['horizontal', 'vertical'].includes(value)
            },
            transparent: {
                type: Boolean,
                default: false
            },
            contentPosition: {
                type: String,
                default: 'center',
                validator: value => ['left', 'center', 'right'].includes(value)
            }
        }
    }
</script>

<style lang="sass">
    .ui-divider
        flex-shrink: 0
        position: relative
        background-color: var(--border-color-base)

        &:not(.ui-divider--transparent) .ui-divider__content
            background-color: #fff

        &--horizontal
            display: block
            height: 1px
            width: 100%
            margin: 16px 0

            .ui-divider__content
                padding: 0 16px
                font-size: 14px
                font-weight: 500
                position: absolute

                &--aligned-left
                    left: 16px
                    transform: translateY(-50%)

                &--aligned-center
                    left: 50%
                    transform: translateX(-50%) translateY(-50%)

                &--aligned-right
                    right: 16px
                    transform: translateY(-50%)

        &--vertical
            width: 1px
            height: 1em
            margin: 0 8px
            position: relative
            display: inline-block
            vertical-align: middle
</style>