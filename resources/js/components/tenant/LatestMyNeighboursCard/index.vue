<template functional>
    <ui-card shadow="always">
        <template #header>
            <i class="icon-group"></i> My neighbours
            <el-button type="text" @click="$router.push({name: 'tenantMyNeighbours'})">View all</el-button>
        </template>
        <my-neighbours ref="my-neighbours" :limit="limit" />
    </ui-card>
</template>

<script>
    export default {
        name: 'p-latest-my-neighbours-card',
        props: {
            limit: {
                type: Number,
                default: -1,
                validator: value => value >= -1
            }
        }
    }
</script>

<style lang="sass" scoped>
    .ui-card
        /deep/ .ui-card__header
            .el-button
                padding: 0
                margin-left: auto

                /deep/ [class*=icon] + span
                    margin-left: 5px
</style>