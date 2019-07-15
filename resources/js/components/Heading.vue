<template>
    <div class="heading">
        <i :class="['icon', icon, {'admin-icon':  !this.$store.getters.isTenant}]" v-if="icon"></i>
        <div class="content">
            <div class="title">{{title}}</div>
            <slot name="description" />
        </div>
        <slot />
    </div>
</template>

<script>
    export default {
        props: {
            icon: String,
            title: {
                type: String,
                required: true
            },
            description: String
        }
    }
</script>

<style lang="scss" scoped>
    .heading {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        position: relative;
        z-index: 1;

        .icon {
            width: 56px;
            height: 56px;
            background-color: transparentize(#fff, .2);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6AC06F;
            font-size: 22px;
            margin-right: 16px;
        }

        .admin-icon{
                box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,.03), 
                            0 0.9375rem 1.40625rem rgba(4,9,20,.03), 
                            0 0.25rem 0.53125rem rgba(4,9,20,.05), 
                            0 0.125rem 0.1875rem rgba(4,9,20,.03);
        }

        .content {
            flex: auto;
            min-width: 0;
            flex-shrink: 0;

            .title {
                color: #6AC06F;
                font-size: 24px;
                font-weight: bold;
                overflow: hidden;
                min-width: 0;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }
    }
</style>
