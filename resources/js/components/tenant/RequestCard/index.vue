<template>
    <ui-card class="request-card" shadow="always">
        <el-tabs type="card" v-model="idState.activeTab" stretch v-on="$listeners">
            <el-tab-pane name="overview">
                <div slot="label">
                    <i class="el-icon-tickets"></i>
                    Overview
                </div>
                <slot name="tab-overview-before" />
                <div class="statuses">
                    <div class="item">
                        Status:
                        <div class="label">
                            {{$t(`models.request.status.${$constants.service_requests.status[data.status]}`)}}
                        </div>
                    </div>
                    <div class="item">
                        Priority:
                        <div class="label">
                            {{$t(`models.request.priority.${$constants.service_requests.priority[data.priority]}`)}}
                        </div>
                    </div>
                    <div class="item" v-if="this.data.category.parent_id == 1 && this.data.qualification != 1" >
                        Qualification:
                        <div class="label">
                            {{$t(`models.request.qualification.${$constants.service_requests.qualification[data.qualification]}`)}}
                        </div>
                    </div>
                </div>
                <div class="statuses">
                    <div class="item" v-if="this.data.category.parent_id == 1 && this.data.qualification ==5" >
                        Cost Impact:
                        <div class="label">
                            {{$t(`models.request.category_options.costs.${this.data.payer}`)}}
                        </div>
                    </div>
                </div>
                <div class="category">{{getCompleteCategory(data.category)}}</div>
                <div class="title">{{data.title}}</div>
                <ui-readmore class="description" :text="data.description" :max="512" />
                <div class="assignees" v-if="assignees.length">
                    Assignees
                    <div :key="assignee.id" class="assignee" v-for="assignee in visibleAssignees">
                        <ui-avatar :name="assignee.user.name" :size="32" :src="assignee.user.avatar" />
                        <div class="content">
                            {{assignee.user.name}}
                            <small>{{assignee.user.email}}</small>
                        </div>
                    </div>
                    <div class="more" v-if="!idState.showAllAssginees && assignees.length > 4">
                        <ui-avatar :key="assignee.user.id" :name="assignee.user.name" :size="32" :src="assignee.user.avatar" v-for="assignee in assignees.slice(3)" />
                        <el-link @click="showRestAssignees" type="success">and {{assignees.slice(3).length}} more</el-link>
                    </div>
                </div>
                <ui-divider />
                <div class="user">
                    <ui-avatar :name="data.tenant.user.name" :size="32" :src="data.tenant.user.avatar" />
                    <div class="content">
                        {{data.tenant.user.name}}
                        <!-- <small>
                            created on {{formatDatetime(data.created_at)}}
                            <template v-if="$constants.service_requests.status[data.status] === 'done'"> -->
                                <!-- and solved on {{formatDatetime(data.solved_date)}} -->
                            <!-- </template> -->
                        <!-- </small> -->
                    </div>
                </div>
                <slot name="tab-overview-after" />
            </el-tab-pane>
            <el-tab-pane name="media">
                <div slot="label">
                    <i class="el-icon-picture-outline"></i>
                    Media
                </div>
                <slot name="tab-media-before" />
                <ui-media-gallery :files="data.media.slice(0, 3).map(({url}) => url)">
                    <!-- <div slot="after" key="view-all" class="ui-media-gallery__item" @click="$emit('more-media')" v-if="data.media.length">
                        <div class="ui-media-gallery__item__content">
                            <i class="icon-picture"></i>
                            View all
                        </div>
                    </div> -->
                </ui-media-gallery>
                <slot name="tab-media-after" />
            </el-tab-pane>
        </el-tabs>
    </ui-card>
</template>

<script>
    
    import FormatDateTimeMixin from 'mixins/formatDateTimeMixin'
    import {IdState} from 'vue-virtual-scroller'

    export default {
        mixins: [
            FormatDateTimeMixin,
            IdState({
                idProp: vm => vm.data.id
            })
        ],
        components: {
            
        },
        props: {
            data: {
                type: Object,
                default: {
                    media: []
                },
            },
            visibleMediaLimit: {
                type: Number,
                default: 0
            },
            mediaOptions: {
                type: Object,
                default: () => ({})
            }
        },
        idState () {
            return {
                test: [],
                activeTab: 'overview',
                showAllAssginees: false
            }
        },
        computed: {
            assignees () {
                return [...this.data.property_managers, ...this.data.service_providers]
            },
            visibleAssignees () {
                if (this.idState.showAllAssginees) {
                    return this.assignees
                }

                if (this.assignees.length === 4) {
                    return this.assignees.slice(0, 4)
                }

                return this.assignees.slice(0, 3)
            }
        },
        methods: {
            getCompleteCategory (category) {
                const flattenCategories = (category, result = '') => {
                    result = result.replace(/^/, category.name + (result.length ? '/' : ''))

                    if (category.parentCategory) {
                        return flattenCategories(category.parentCategory, result)
                    }

                    return result
                }

                return flattenCategories(category)
            },
            showRestAssignees () {
                this.idState.showAllAssginees = true

                this.$emit('tab-click')
            }
        },
        mounted () {
            console.log('Request Card', this.data);
            console.log('tenant media1', this.data.media);
            console.log('tenant media2', this.data.media.slice(0, 3).map(({url}) => url));
            
        }
    }
</script>

<style lang="sass" scoped>
    .ui-card
        /deep/ &__body
            padding: 0

            .el-tabs
                /deep/ .el-tabs__header
                    margin-bottom: 0

                    /deep/ .el-tabs__nav-wrap
                        /deep/ .el-tabs__nav-scroll
                            /deep/ .el-tabs__nav
                                border: 0

                /deep/ .el-tabs__content
                    padding: 16px
                    height: 100%
                    display: flex
                    flex-direction: column
                    overflow-y: auto

                    #pane-overview
                        .statuses
                            display: flex
                            align-items: center
                            margin-bottom: 16px

                            .item
                                font-weight: 600
                                color: var(--color-text-secondary)
                                display: flex
                                align-items: center

                                &:not(:first-child)
                                    margin-left: 8px

                                .label
                                    font-size: 12px
                                    font-weight: 700
                                    padding: 4px 12px
                                    margin-left: 4px
                                    border-radius: 12px
                                    text-transform: uppercase
                                    background-color: darken(#fff, 4%)
                                    color: var(--color-text-placeholder)
                                    border: 1px var(--border-color-lighter) solid

                        .title, .category
                            text-overflow: ellipsis
                            overflow: hidden
                            white-space: nowrap

                        .category
                            font-size: 15px
                            font-weight: 500
                            color: var(--color-text-placeholder)

                        .title
                            font-size: 20px
                            font-weight: 600
                            color: var(--color-primary)

                        .description
                            margin-top: 16px
                            color: var(--color-text-secondary)

                        .assignees
                            font-size: 15px
                            font-weight: 500
                            margin-top: 16px
                            color: var(--color-text-placeholder)

                            .assignee
                                font-size: 14px
                                color: var(--color-text-secondary)
                                display: flex
                                align-items: center
                                margin: 8px 0

                                .content
                                    font-weight: 600
                                    line-height: 1.28
                                    margin-left: 8px

                                    small
                                        font-size: 96%
                                        font-weight: 400
                                        display: block
                                        color: var(--color-text-placeholder)

                            .more
                                .ui-avatar
                                    &:not(:first-child)
                                        margin-left: -10px
                                        border: 2px #fff solid

                        .user
                            display: inline-flex
                            align-items: center
                            color: var(--color-text-secondary)

                            .content
                                font-weight: 600
                                line-height: 1.28
                                margin-left: 8px

                                small
                                    font-size: 96%
                                    font-weight: 400
                                    display: block
                                    color: var(--color-text-placeholder)

                    #pane-media
                        .ui-media-gallery
                            display: flex
                            margin: -4px

                            .ui-media-gallery__item
                                width: 25%
                                padding-top: 25%
                                margin: 4px

                                &:last-child
                                    font-size: 16px
                                    font-weight: 600
                                    border-width: 2px
                                    border-style: dashed
                                    box-shadow: none
                                    color: var(--color-text-placeholder)
                                    cursor: pointer

                                    &:hover
                                        color: var(--color-primary)
                                        border-color: var(--color-primary)

                                    i
                                        font-size: 28px
</style>