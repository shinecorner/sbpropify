<template>
    <div class="pinboard-details" v-if="!_.isEmpty(pinboard)">
        <el-row :gutter="10">
            <template v-if="pinboard.tenant">
                <el-col :md="6" :sm="12">
                    <p class="pinboard-label">{{$t('general.name')}}</p>
                    <p v-if="pinboard.tenant">
                        <router-link :to="{name: 'adminTenantsEdit', params: {id: pinboard.tenant.id}}">
                            {{pinboard.tenant.first_name}} {{pinboard.tenant.last_name}}
                        </router-link>
                    </p>
                </el-col>
                <el-col :md="6" :sm="12" v-if="pinboard.tenant.building">
                    <p class="pinboard-label">{{$t('models.tenant.building.name')}}</p>
                    <p>
                        {{pinboard.tenant.building.name}}
                    </p>
                </el-col>
            </template>
            <template v-else>
                <el-col :md="6" :sm="12">
                    <p class="pinboard-label">{{$t('general.name')}}</p>
                    <router-link :to="{name: 'adminUsersEdit', params: {id: pinboard.user.id}}">
                        {{pinboard.user.name}}
                    </router-link>
                </el-col>
            </template>
            <el-col :md="4" :sm="12">
                <p class="pinboard-label">{{$t('models.pinboard.type.label')}}</p>
                <p>
                    {{this.$t(`models.pinboard.type.${pinboardConstants.type[pinboard.type]}`)}}
                </p>
            </el-col>
            <el-col :md="4" :sm="12">
                <p class="pinboard-label">{{$t('models.pinboard.visibility.label')}}</p>
                <p>
                    {{this.$t(`models.pinboard.visibility.${pinboardConstants.visibility[pinboard.visibility]}`)}}
                </p>
            </el-col>
            <el-col :md="4" :sm="12">
                <p class="pinboard-label">{{$t('models.pinboard.status.label')}}</p>
                <p>
                    {{this.$t(`models.pinboard.status.${pinboardConstants.status[pinboard.status]}`)}}
                </p>
            </el-col>
            <el-col :md="2" :sm="12">
                <p class="pinboard-label">{{$t('models.pinboard.likes')}}</p>
                <p>
                    {{pinboard.likes_counter}}
                </p>
            </el-col>
            <el-col :md="4" :sm="12">
                <p class="pinboard-label">{{$t('models.pinboard.published_at')}}</p>
                <p>
                    {{pinboard.published_at}}
                </p>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="24">
                <p class="pinboard-label">{{$t('general.content')}}</p>
                <p>
                    {{pinboard.content}}
                </p>
            </el-col>
        </el-row>
        <gallery :data="pinboard.media" :withDelete="false" v-if="pinboard.media && pinboard.media.length"></gallery>
    </div>
</template>

<script>
    import Gallery from 'components/RequestMedia';


    export default {
        name: "PinboardDetails",
        components: {
            Gallery
        },
        props: {
            pinboard: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                pinboardConstants: this.$constants.pinboard,
            }
        }
    }
</script>

<style scoped>
    .pinboard-label {
        color: #409EFF;
    }
</style>
