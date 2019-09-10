<template>
    <div :class="['requests']">
        <div class="container" v-infinite-scroll="get" style="overflow: auto;">
            <ui-heading icon="icon-chat-empty" title="Requests" description="Need some info? Encountered an issue? Contact us!">
                <el-popover popper-class="requests__filter-popover" placement="bottom-end" trigger="click" :width="192">
                    <el-button slot="reference" icon="el-icon-sort" round>Filters</el-button>
                    <filters ref="filters" layout="column" :data.sync="filters.data" :schema="filters.schema" @changed="onFiltersChanged" />
                    <el-button type="primary" size="small" icon="el-icon-sort-up" @click="resetFilters">Reset filters</el-button>
                </el-popover>
                <el-button @click="addRequestDialogVisible = true" type="primary" icon="ti-plus" round>
                    Add request
                </el-button>
            </ui-heading>
            <ui-divider />
            <dynamic-scroller ref="dynamic-scroller" :items="requests.data" :min-item-size="249" page-mode v-if="!loading">
                <template #before v-if="loading && !requests.data.length">
                    <loader v-for="idx in 5" :key="idx" />
                </template>
                <template v-slot="{item, index, active}">
                    <dynamic-scroller-item :item="item" :active="active" :data-index="index">
                        <request-card :data="item" :visible-media-limit="3" :media-options="{container: '#gallery'}" @more-media="toggleDrawer(item, 'media')" @tab-click="$refs['dynamic-scroller'].forceUpdate" @hook:mounted="$refs['dynamic-scroller'].forceUpdate">
                            <template #tab-overview-after>
                                <el-button icon="el-icon-right" size="mini" @click="toggleDrawer(item)" plain round>View</el-button>
                            </template>
                            <template #tab-media-after>
                                <ui-divider v-if="!item.media.length">
                                    <el-button icon="el-icon-upload" round @click="toggleDrawer(item, 'media')">Upload files...</el-button>
                                </ui-divider>
                            </template>
                        </request-card>
                    </dynamic-scroller-item>
                </template>
                <template #after v-if="loading && requests.data.length">
                    <loader />
                </template>
            </dynamic-scroller>
        </div>
        <ui-drawer :size="448" :visible.sync="visibleDrawer" :z-index="1" direction="right" docked @update:visibleDrawer="resetDataFromDrawer">
            <el-tabs type="card" v-model="activeDrawerTab" stretch v-if="openedRequest">
                <el-tab-pane name="chat" lazy>
                    <div slot="label">
                        <i class="ti-comments"></i>
                        Chat
                    </div>
                    <chat ref="chat" :id="openedRequest.id" type="request" height="100%" max-height="100%" />
                </el-tab-pane>
                <el-tab-pane name="media" lazy>
                    <div slot="label">
                        <i class="ti-gallery"></i>
                        Media
                    </div>
                    <ui-media-gallery :files="openedRequest.media.map(({url}) => url)" />
                    <!-- <ui-media-uploader v-model="media" :headers="{'Authorization': `Bearer ${authorizationToken}`, 'Accept': 'application/json, text/plain, */*', 'Content-Type': 'application/json;charset=UTF-8'}" :action="`api/v1/requests/${openedRequest.id}/media`" :options="{drop: true, draggable: true, multiple: true}" /> -->

                    <!-- <div ref="media-content" id="media-content" class="content">
                        <ui-media-gallery :images="openedRequest.media.map(({url}) => url)" />
                        <el-divider>
                            <div v-if="uploadedMedia.length">
                                <el-button type="success" size="small" round :loading="uploadingMedia" @click="uploadMedia">
                                    <template v-if="uploadingMedia">Uploading...</template>
                                    <template v-else>Click here to upload {{uploadedMedia.length}} files</template>
                                </el-button>
                                <el-tooltip effect="dark" content="Reset upload" placement="bottom" v-if="!uploadingMedia">
                                    <el-button type="danger" icon="el-icon-delete" size="small" :disabled="uploadingMedia" circle @click="$refs.upload.clear" />
                                </el-tooltip>
                            </div>
                            <template v-else>
                                <i class="el-icon-upload"></i> Upload files...
                            </template>
                        </el-divider>
                        <el-alert type="warning" title="Once confirmed the uploaded files, you can no longer delete them. Please proceed with caution!" :closable="false" center />
                        <el-divider />
                        <media-upload ref="upload" v-model="uploadedMedia" :loading="uploadingMedia" :size="mediaUploadMaxSize" :allowed-types="['image/jpg', 'image/jpeg', 'image/png', 'application/pdf']" :cols="2" >
                            <template slot="trigger" slot-scope="scope">
                                <el-tooltip key="trigger" content="Drop files or click here to select" effect="dark" placement="bottom" >
                                    <el-button class="trigger" icon="el-icon-plus" :style="scope.mediaItemStyle" @click="scope.triggerSelect" :disabled="uploadingMedia" />
                                </el-tooltip>
                            </template>
                        </media-upload>
                        <media ref="media" :id="4" type="requests" layout="list" v-model="uploadedMedia" :upload-options="{drop: true, draggable: true, multiple: true, extensions: 'jpg'}" />
                    </div> -->
                </el-tab-pane>
                <el-tab-pane name="audit" lazy>
                    <div slot="label">
                        <i class="ti-gallery"></i>
                        Audit
                    </div>
                    <audit :id="openedRequest.id" type="request" show-filter />
                </el-tab-pane>
            </el-tabs>
        </ui-drawer>
        <el-dialog ref="add-request-dialog" title="Add request" :visible.sync="addRequestDialogVisible" custom-class="add-request-dialog" append-to-body>
            <request-add-form ref="request-add-form" />
            <span slot="footer" class="dialog-footer">
                <el-button icon="el-icon-close" @click="addRequestDialogVisible = false" round>Cancel</el-button>
                <el-button type="primary" icon="el-icon-check" round @click="addRequest">Confirm</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import Loader from 'components/tenant/RequestCard/Loader'
    import RequestAddForm from 'components/tenant/RequestAddForm'

    export default {
        components: {
            Loader,
            RequestAddForm
        },
        data () {
            return {
                loading: false,
                media: [],
                openedRequest: null,
                visibleDrawer: false,
                activeDrawerTab: 'chat',
                activeDrawerMediaTab: 0,
                addRequestDialogVisible: false,
                filters: {
                    schema: [{
                        type: 'el-select',
                        title: 'Status',
                        name: 'status',
                        props: {
                            placeholder: 'Select the status',
                            clearable: true,
                            size: 'small'
                        },
                        children: Object.entries(this.$store.getters['application/constants'].service_requests.status).map(([value, label]) => ({
                            type: 'el-option',
                            props: {
                                label,
                                value
                            }
                        }))
                    }, {
                        type: 'el-select',
                        title: 'Priority',
                        name: 'priority',
                        props: {
                            placeholder: 'Select the priority',
                            clearable: true,
                            size: 'small'
                        },
                        children: Object.entries(this.$store.getters['application/constants'].service_requests.priority).map(([value, label]) => ({
                            type: 'el-option',
                            props: {
                                label,
                                value
                            }
                        }))
                    }, {
                        type: 'el-date-picker',
                        title: 'Created',
                        name: 'created',
                        props: {
                            placeholder: 'Choose the created date',
                            valueFormat: 'yyyy-MM-dd',
                            format: 'dd.MM.yyyy',
                            style: 'width: 100%',
                            size: 'small'
                        }
                    }, {
                        type: 'el-date-picker',
                        title: 'Due date',
                        name: 'due_date',
                        props: {
                            placeholder: 'Choose the due date',
                            format: 'dd.MM.yyyy',
                            valueFormat: 'yyyy-MM-dd',
                            style: 'width: 100%',
                            size: 'small'
                        }
                    }],
                    data: {
                        status: null,
                        priority: null,
                        created: null,
                        due_date: null
                    },
                },
            }
        },
        computed: {
             ...mapState('newRequests', {
                requests: state => state
            }),

            openedRequestMedia () {
                return this.openedRequest.media.map(({url}) => url)
            }
        },
        methods: {
            async get (params = {}) {
                if (this.loading && this.requests.data.length) {
                    return
                }

                const {current_page, last_page} = this.requests

                if (current_page && last_page && current_page === last_page) {
                    return
                }

                let page = current_page || 0

                page++

                this.loading = true

                await this.$store.dispatch('newRequests/get', {
                    page,
                    per_page: 25,
                    sortedBy: 'desc',
                    orderBy: 'created_at',
                    ...params
                })

                this.loading = false
            },
            async onFiltersChanged (filters) {
                await this.get(filters)
            },
            resetFilters () {
                this.$refs.filters.reset()
            },
            toggleDrawer (request, tab = 'chat') {
                this.activeDrawerTab = tab
                this.openedRequest = request

                this.visibleDrawer = !this.visibleDrawer
            },
            resetDataFromDrawer () {
                this.activeDrawerTab = 'chat'
                this.openedRequest = null
            },
            addRequest () {
                this.$watch(() => this.$refs['request-add-form'].loading, state => {
                    this.$nextTick(async () => {
                        this.$refs['request-add-form'].$el.classList.remove('el-loading-parent--relative')

                        if (!state) {
                            this.addRequestDialogVisible = false

                            this.requests = {
                                data: []
                            }

                            await this.fetch()
                        }
                    })
                })

                this.$refs['request-add-form'].submit()
            },
        },
        mounted () {
            console.log('request', this.openedRequest);
            // console.log('requets media', this.openedRequest.media);
            // console.log('requets media', this.openedRequest.media.map(({url}) => url));
            // this.$refs['dynamic-scroller'].forceUpdate()
        }
    }
</script>

<style lang="sass">
    .requests__filter-popover
        padding: 16px
        border-radius: 12px
        box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76)

        .el-button
            width: 100%
            margin-top: 8px
</style>

<style lang="sass" scoped>
    .requests
        display: flex
        padding: 0 !important
        flex-direction: column
        overflow: hidden !important

        &:before
            content: ''
            top: 0
            left: 0
            z-index: -1
            width: 100%
            height: 100%
            position: fixed
            filter: opacity(.08)
            pointer-events: none
            background-repeat: no-repeat
            background-attachment: fixed
            background-position: top left
            background-image: url('~img/5c7d3b0b0f0f4.png')

        .container
            height: 100%
            padding: 16px
            overflow-y: auto

            .vue-recycle-scroller
                max-width: 640px

                /deep/ .vue-recycle-scroller__item-wrapper
                    overflow: visible

                    /deep/ .vue-recycle-scroller__item-view > div
                        padding: 8px 0

                        .request-card
                            .el-tabs .el-tabs__content .el-tab-pane
                                &:nth-child(1)
                                    .el-button
                                        float: right

                                &:nth-child(2)
                                    .ui-divider
                                        margin-top: 32px

                /deep/ .vue-recycle-scroller__slot .el-loading-parent--relative
                    min-height: 42px

        .ui-drawer
            .el-tabs
                height: 100%
                display: flex
                flex-direction: column

                /deep/ .el-tabs__header
                    margin-bottom: 0

                    /deep/ .el-tabs__nav-wrap
                        /deep/ .el-tabs__nav-scroll
                            /deep/ .el-tabs__nav
                                border: 0

                /deep/ .el-tabs__content
                    height: 100%
                    overflow-y: auto
                    display: flex
                    flex-direction: column

                    /deep/ .el-tab-pane
                        height: 100%
                        display: flex
                        flex-direction: column

                        > *
                            padding: 16px

                        .el-tabs
                            padding: 0

                        .chat
                            .comments-list
                                .vue-recycle-scroller
                                    margin-top: -16px
                                    margin-right: -16px
                                    padding-top: 16px
                                    padding-right: 16px

                        // .ui-media-gallery
                        //     height: 100%
                        //     padding: 16px

                        // .audit
                        //     padding: 16px
</style>