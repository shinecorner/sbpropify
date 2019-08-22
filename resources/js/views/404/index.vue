<template>
    <div class="not-found">
        <div class="not-found__title">404</div>
        <div class="not-found__subtitle">{{$t('general.page_not_found.title')}}</div>
        <div class="not-found__desc">{{$t('general.page_not_found.message')}}</div>
        <div class="not-found__home">
            <router-link to="/">
                <el-button type="primary">{{$t('general.to_homepage')}}</el-button>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NotFound",
        methods: {
            init(){
                this.$i18n.locale = localStorage.getItem('locale');
            },
        },
        mounted() {
            this.init();
        }
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
            font-weight: 500;
        }
        &__subtitle {
            margin-top: 0.5em;
            line-height: 1em;
            font-size: 30px;
            font-weight: 500;
        }
        &__desc {
            margin-top: 0.5em;
            max-width: 600px;
            text-align: center;
            line-height: 1.2em;
            font-size: 24px;
        }
        &__home {
            margin-top: 30px;
        }
    }
</style>