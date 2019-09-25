<template>
    <div class="post">
        <heading icon="ti-announcement" :title="$t('tenant.news')" :description="$t('tenant.heading_info.news')"/>
        <el-row :gutter="24">
            <el-col :span="16">
                <post-card :data="data" v-if="data" :show-actions="false"/>
            </el-col>
            <el-col :span="8">
                <rss-feed title="Blick.ch News"/>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import PostCard from 'components/tenant/PostCard'
    import Heading from 'components/Heading'
    import RssFeed from 'components/tenant/RSSFeed'
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        components: {
            PostCard,
            Heading,
            RssFeed
        },
        data () {
            return {
                data: null
            }
        },
        async created () {
            try {
                const id = Number(this.$route.params.id)
                
                await this.$store.dispatch('newPosts/getById', {id})
                this.data = this.$store.getters['newPosts/getById'](id)

            } catch (err) {
                this.$router.replace({name: 'tenantPosts'})
            }
        }
    }
</script>

<style lang="scss" scoped>
    .post {
        :global(.heading) {
            margin-bottom: 1em;
        }
        .el-row {
            .el-col {
                &:nth-child(1) {
                    max-width: 640px;
                }
                &:nth-child(2) {
                    max-width: 448px;
                }
            }
        }
    }
</style>