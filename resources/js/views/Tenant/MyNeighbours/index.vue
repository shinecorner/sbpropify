<template>
    <div class="my-neighbours">
        <heading icon="icon-group" :title="$t('tenant.my_neighbours')">
            <div slot="description">Et aut cum ut earum. Et aperiam ut possimus explicabo. Modi dolores in odit id fuga maxime aperiam dolor.</div>
        </heading>
        <el-divider />
        <el-card>
            <my-neighbours />
        </el-card>
    </div>
</template>

<script>
    import Heading from 'components/Heading'
    export default {
        components: {
            Heading
        },
    }
</script>

<style lang="scss" scoped>
    .my-neighbours {
        position: relative;

        &:before {
            content: '';
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-image: url('~img/5d4c33211edfc.png');
            background-position: top left;
            background-repeat: no-repeat;
            background-attachment: fixed;
            pointer-events: none;
            z-index: -1;
            filter: opacity(.048);
        }

        .el-divider {
            background: linear-gradient(to right, var(--border-base-color), transparent 56%);
        }

        .el-card {
            max-width: 640px;
            background-color: transparentize(#fff, .28);
        }
    }
</style>