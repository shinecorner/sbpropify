<template>
    <div :class="['ui-card', {'ui-card--on-hover-shadow': shadow === 'hover', 'ui-card--always-shadow': shadow === 'always'}]" v-on="$listeners">
        <div class="ui-card__header" v-if="title || $slots.header">
            <slot name="header">
                <i :class="icon"></i> {{title}}
            </slot>
        </div>
        <div class="ui-card__body">
            <slot />
        </div>
        <div class="ui-card__footer" v-if="$slots.footer">
            <slot name="footer" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ui-card',
        props: {
            icon: String,
            title: String,
            shadow: {
                type: String,
                default: 'none',
                validator: value => ['none', 'hover', 'always'].includes(value)
            }
        }
    }
</script>

<style lang="sass">
    .ui-card
        overflow: hidden
        position: relative
        border-radius: 12px
        background-color: #fff
        transition: box-shadow .48s
        border: 1px var(--border-color-base) solid

        &--always-shadow,
        &--on-hover-shadow:hover
            box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76)

        &__header
            flex: auto
            min-width: 0
            display: flex
            font-size: 20px
            font-weight: 600
            overflow: hidden
            white-space: nowrap
            align-items: center
            text-overflow: ellipsis
            color: var(--primary-color)
            border-bottom: 1px var(--border-color-base) solid

            > i
                width: 32px
                height: 32px
                display: flex
                margin-right: 8px
                border-radius: 50%
                align-items: center
                justify-content: center
                border: 2px var(--primary-color) solid

        &__footer
            border-top: 1px var(--border-color-base) solid

        &__header, &__body, &__footer
            padding: 16px
</style>