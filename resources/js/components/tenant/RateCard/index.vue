<template>
    <ui-card class="rate" icon="icon-thumbs-up" title="Rate us" shadow="always" v-loading="loading">
        <el-rate v-model="model.rating" :max="10"></el-rate>
        <el-input type="textarea" v-model="model.review" placeholder="How would you rate us?" resize="none" :validate-event="false" :autosize="{minRows: 2, maxRows: 6}" />
        <el-button type="primary" icon="icon-paper-plane" :disabled="!model.rating || !model.review || loading" @click="send">Send</el-button>
    </ui-card>
</template>

<script>
    import {mapGetters} from 'vuex'
    import {displaySuccess} from 'helpers/messages'

    export default {
        name: 'p-rate-card',
        data () {
            return {
                model: {
                    rating: 1,
                    review: null
                },
                loading: false
            }
        },
        computed: {
            ...mapGetters(['loggedInUser'])
        },
        methods: {
            async send () {
                if (!this.model.rating || !this.model.review) {
                    return
                }

                this.loading = true

                const {data} = await this.axios.post('addReview', {
                    tenant_id: this.loggedInUser.tenant.id,
                    ...this.model
                })

                displaySuccess(data)

                this.loading = false
                this.model = {
                    rating: 1,
                    review: null
                }
            }
        }
    }
</script>

<style lang="sass" scoped>
    .ui-card
        /deep/ .ui-card__body
            .el-rate
                outline: 0
                height: 40px

                /deep/ .el-rate__item .el-rate__icon
                    font-size: 28px

            .el-button
                width: 100%
                margin-top: 16px
</style>