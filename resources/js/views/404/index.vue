<template>
    <div class="not-found">
        <div class="not-found__title">404</div>
        <div class="not-found__desc">{{$t('general.page_not_found')}}</div>
        <div class="not-found__home">
            <router-link to="/">
                <el-button type="primary">{{$t('general.home')}}</el-button>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NotFound"
    }
</script>

<style lang="scss" scoped>
    .not-found {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        &__title {
            line-height: 1em;
            font-size: 180px;
        }
        &__desc {
            margin-top: 0.5em;
            line-height: 1em;
            font-size: 24px;
        }
        &__home {
            margin-top: 30px;
        }
    }
</style>