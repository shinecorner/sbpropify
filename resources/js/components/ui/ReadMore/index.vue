<template>
    <div class="ui-readmore">
        {{formattedText}}
        <span class="ui-readmore__button" v-if="text.length > max" @click="isReadMore = !isReadMore">
            <template v-if="isReadMore">
                read less
            </template>
            <template v-else>
                read more
            </template>
        </span>
    </div>
</template>

<script>
    export default {
        name: 'ui-readmore',
        props: {
            text: {
                type: String,
                required: true
            },
            max: {
                type: Number,
                default: 128
            }
        },
        data () {
            return {
                isReadMore: false
            }
        },
        computed: {
            formattedText () {
                let text = this.text

                if (!this.isReadMore) {
                    if (this.text.length > this.max) {
                        text = text.substring(0, this.max) + '...'
                    }
                }

                return text
            }
        }
    }
</script>

<style lang="sass">
    .ui-readmore
        &__button
            color: var(--color-primary)
            cursor: pointer
            text-transform: lowercase
</style>