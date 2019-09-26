<template>
    <div>
        <div :class="['ui-heading', `ui-heading--${shadow}-shadow`]">
            <i :class="['ui-heading__icon', icon]" v-if="icon"></i>
            <div class="ui-heading__content">
                <div class="ui-heading__content__title">{{title}}</div>
                <div class="ui-heading__content__description" v-if="description || $slots.default">
                    {{description || $slots.default}}
                </div>
                <div class="ui-heading__content__description" v-if="$slots.description">
                    <slot name="description"/>
                </div>
            </div>
            <div class="ui-heading__actions" v-if="!el.is.md">
                <slot />
            </div>
        </div>
        <div class="ui-heading__mobile_actions"  v-if="el.is.md">
            <slot />
        </div>
    </div>
</template>

<script>
    import { ResponsiveMixin } from "vue-responsive-components"

    export default {
        name: 'ui-heading',
        mixins: [ResponsiveMixin],
        props: {
            icon: String,
            title: {
                type: String,
                required: true
            },
            description: String,
            shadow: {
                type: String,
                default: 'light',
                validator: type => ['light', 'heavy'].includes(type)
            },
        },
        computed: {

            breakpoints () {
                return {
                    md: el => {
                        if (el.width <= 700) {
                            return true
                        } else {
                            return false
                        }
                    }
                }
            },
        },
    }
</script>

<style lang="sass">
    .ui-heading
        z-index: 1
        display: flex
        flex-shrink: 0
        position: relative
        align-items: center

        &--light-shadow .ui-heading__icon
            box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76)

        &--heavy-shadow .ui-heading__icon
            box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,.03), 0 0.9375rem 1.40625rem rgba(4,9,20,.03), 0 0.25rem 0.53125rem rgba(4,9,20,.05), 0 0.125rem 0.1875rem rgba(4,9,20,.03)

        &__icon
            width: 56px
            height: 56px
            display: flex
            flex-shrink: 0
            font-size: 24px
            margin-right: 16px
            border-radius: 12px
            align-items: center
            justify-content: center
            color: var(--primary-color)
            background-color: transparentize(#fff, .28)

        &__content
            flex: 1
            min-width: 0
            flex-shrink: 0

            &__title
                min-width: 0
                font-size: 28px
                overflow: hidden
                font-weight: 700
                white-space: nowrap
                text-overflow: ellipsis
                color: var(--primary-color)

            &__description
                font-size: 16px
                font-weight: 500
                color: var(--color-text-placeholder)

        &__actions
            display: flex
            align-items: center

            > *:not(:last-child)
                margin-right: 8px
    .ui-heading__mobile_actions
        display: block
        margin-top: 10px
</style>