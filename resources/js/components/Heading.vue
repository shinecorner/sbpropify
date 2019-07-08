<template>
    <div class="heading">
        <i :class="['icon', icon]" v-if="icon"></i>
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
            color: #6AC06F;
            font-size: 42px;
            margin-right: 16px;
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
