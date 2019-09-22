<template>
    <div class="p-user__settings">
        <el-form label-position="left">
            <!-- <el-divider content-position="left" @change="save">
                <i class="icon-chart"></i> {{$t('tenant.summary_statistics')}}
            </el-divider>
            <div class="p-user__settings__description">
                {{$t('tenant.select_recieve_statistic_prompt')}}
            </div>
            <el-form-item>
                <el-select v-model="loggedInUser.settings.summary">
                    <el-option v-for="summary in summaries" :key="summary" :label="summary" :value="summary" />
                </el-select>
            </el-form-item> -->
            <el-divider content-position="left">
                <i class="icon-bell"></i> {{$t('tenant.notification_label')}}
            </el-divider>
            <div class="p-user__settings__description">
                {{$t('tenant.select_type_notification_prompt')}}
            </div>
            <el-form-item label="Service">
                <el-switch v-model="loggedInUser.settings.service_notification" @change="save" />
            </el-form-item>
            <div class="p-user__settings__description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
            <el-form-item :label="$t('tenant.news')">
                <el-switch v-model="loggedInUser.settings.news_notification" @change="save" />
            </el-form-item>
            <div class="p-user__settings__description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
            <el-form-item :label="$t('tenant.marketplace')">
                <el-switch v-model="loggedInUser.settings.marketplace_notification" @change="save" />
            </el-form-item>
            <div class="p-user__settings__description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
            <el-form-item :label="$t('tenant.admin')">
                <el-switch v-model="loggedInUser.settings.admin_notification" @change="save" />
            </el-form-item>
            <div class="p-user__settings__description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
            <el-divider content-position="left">
                <i class="icon-language"></i> {{$t('tenant.language')}}
            </el-divider>
            <div class="p-user__settings__description">
                {{$t('tenant.language_selection_prompt')}}
            </div>
            <el-form-item>
                <el-radio-group v-model="loggedInUser.settings.language" @change="save">
                    <el-radio-button v-for="(name, iso) in $constants.app.languages" :key="iso" :label="iso">
                        <img :src="require(`svg/${iso}.svg`)" /> {{name}}
                    </el-radio-button>
                </el-radio-group>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'p-user-settings',
        computed: {
            ...mapGetters(['loggedInUser']),

            summaries () {
                return ['daily', 'monthly', 'yearly']
            }
        },
        methods: {
            ...mapActions(['updateSettings']),

            async save () {
                await this.updateSettings(this.loggedInUser)
            }
        }
    }
</script>

<style lang="sass" scoped>
    .p-user__settings
        &__description
            margin-bottom: 8px
            color: var(--color-text-placeholder)

        .el-form
            .el-divider
                margin: 16px 0

                /deep/ .el-divider__text.is-left
                    font-weight: 600
                    color: var(--color-primary)

            .el-form-item
                display: flex
                margin-bottom: 0
                min-height: 40px
                align-items: center

                /deep/ .el-form-item__label
                    flex: auto
                    padding: 0
                    float: initial
                    line-height: initial
                    color: var(--color-primary)

                    & + .el-form-item__content
                        width: auto

                /deep/ .el-form-item__content
                    width: 100%
                    line-height: initial

                    .el-select
                        display: block

                    .el-radio-group
                        display: flex

                        .el-radio-button
                            flex: auto

                            &:not(.is-active) /deep/ .el-radio-button__inner
                                background-color: transparentize(#fff, .28)

                            /deep/ .el-radio-button__inner
                                padding: 8px
                                display: flex
                                align-items: center
                                flex-direction: column

                                img
                                    width: 32px
                                    height: 32px
                                    margin-bottom: 4px
</style>