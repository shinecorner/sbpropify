<template>
    <el-card>
        <ui-avatar :src="data.user.avatar" :name="data.user.name" :size="48" shadow="always" />
        <div class="user">{{data.user.name}}</div>
        <div class="content">{{$t('tenant.welcome_neighbour_msg',{num_days: ago(data.created_at)})}}</div>
        <likes type="post" layout="column" :data="data.likes" suffix="welcomed the neighbour" />
        <like :id="data.id" type="post" :icons="{like: 'icon-heart', unlike: 'icon-heart-empty'}" :show-text="false" />
    </el-card>
</template>

<script>
    import AgoMixin from 'mixins/agoMixin'

    export default {
        name: 'p-post-new-tenant-card',
        mixins: [
            AgoMixin
        ],
        props: {
            data: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-card {
        overflow: visible;
        margin-top: 20px;
        margin-bottom: 20px;

        :global(.el-card__body) {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            .ui-avatar {
                margin-top: -40px;
                border: 4px transparentize(#fff, .28) solid;
            }

            .user {
                font-size: 18px;
                font-weight: 600;
                color: var(--primary-color);
            }

            .content {
                font-size: 14px;
                font-weight: 500;

                b {
                    font-size: 18px;
                    color: var(--color-primary);
                }
            }

            :global(.like) {
                margin-bottom: -36px;

                :global(.el-button) {
                    font-size: 24px;
                    width: 40px;
                    height: 40px;
                    padding: 0;
                    background-color: #fff;
                    color: var(--color-danger);
                    border-radius: 50%;
                    border: 1px var(--border-color-base) solid;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76);
                }
            }
        }
    }
</style>