<template>
    <div class="requests" v-infinite-scroll="fetch">
        <heading icon="icon-chat-empty" title="Requests">
            <div slot="description" class="description">Need some info? Encountered an issue? Contact us!</div>
            <el-button @click="addRequestDialogVisible = true" icon="ti-plus" round size="small" type="primary">
                Add request
            </el-button>
        </heading>
        <el-divider />
        <dynamic-scroller ref="dynamic-scroller" :items="requests.data" :min-item-size="256" page-mode>
            <template #before v-if="loading && !requests.data.length">
                <loader v-for="idx in 5" :key="idx" />
            </template>
            <template v-slot="{item, index, active}">
                <dynamic-scroller-item :item="item" :active="active" :data-index="index">
                    <request-card :data="item" :visible-media-limit="3" :media-options="{container: '#gallery'}" @show-more-media="toggleDrawer(item, 'media')" @tab-click="$refs['dynamic-scroller'].forceUpdate" >
                        <template #tab-overview-after>
                            <el-button icon="el-icon-right" size="mini" @click="toggleDrawer(item)" plain round>{{$t('tenant.actions.view')}}</el-button>
                        </template>
                        <template #tab-media-after>
                            <el-divider v-if="!item.media.length">
                                <el-button icon="el-icon-upload" round @click="toggleDrawer(item, 'media')">{{$t('tenant.placeholder.upload')}}...</el-button>
                            </el-divider>
                        </template>
                    </request-card>
                </dynamic-scroller-item>
            </template>
            <template #after v-if="loading && requests.data.length">
                <loader />
            </template>
        </dynamic-scroller>
        <el-drawer
            title="I am the title"
            :visible.sync="visibleDrawer"
            direction="rtl"
            >
            <span>Hi, there!</span>
        </el-drawer>

    </div>
</template>

<script>
    import {MEDIA_UPLOAD_MAX_SIZE} from '@/config'
    import Audit from 'components/Audit'
    import Drawer from 'components/Drawer'
    import Heading from 'components/Heading'
    import Placeholder from 'components/Placeholder'
    import MediaUpload from 'components/MediaUpload'
    import MediaGallery from 'components/MediaGalleryList'
    import RequestAddForm from 'components/tenant/RequestAddForm'
    import PQueue from 'p-queue'
    import {format} from 'date-fns'
    import VueSticky from 'vue-sticky'
    import Media from 'components/common/Media'

    import Loader from 'components/tenant/RequestCard/Loader'
    import ErrorFallback from 'components/tenant/RequestCard/Error'

    const RequestCard = () => ({
        component: import(/* webpackChunkName: "requestCard" */ 'components/tenant/RequestCard'),
        loading: Loader,
        error: ErrorFallback,
        delay: 0,
        timeout: 8000
    })

    export default {
        components: {
            Audit,
            Drawer,
            Heading,
            Placeholder,
            MediaUpload,
            MediaGallery,
            Loader,
            RequestCard,
            RequestAddForm,
            Media
        },
        directives: {
            sticky: VueSticky
        },
        data () {
            return {
                activeTab: 'chat',
                mediaUploadMaxSize: MEDIA_UPLOAD_MAX_SIZE,
                uploadedMedia: [],
                requests: {
                    data: []
                },
                filters: {
                    schema: [{
                        type: 'el-select',
                        title: 'Status',
                        name: 'status',
                        props: {
                            placeholder: 'Select the status',
                            clearable: true
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
                            style: 'width: 100%'
                        }
                    }, {
                        type: 'el-date-picker',
                        title: 'Due date',
                        name: 'due_date',
                        props: {
                            placeholder: 'Choose the due date',
                            format: 'dd.MM.yyyy',
                            valueFormat: 'yyyy-MM-dd',
                            style: 'width: 100%'
                        }
                    }],
                    data: {
                        status: null,
                        priority: null,
                        created: null,
                        due_date: null
                    },
                },
                loading: false,
                openedRequest: null,
                visibleDrawer: false,
                uploadingMedia: false,
                addRequestDialogVisible: false
            }
        },
        filters: {
            formatDate (date) {
                return format(date, 'DD.MM.YYYY hh:mma')
            }
        },
        methods: {
            async fetch(params = {}) {
                if (this.loading && this.requests.data.length) {
                    return
                }

                const {
                    current_page,
                    last_page
                } = this.requests;

                if (current_page && last_page && current_page == last_page) {
                    return
                }

                let page = current_page || 0

                page++;

                this.loading = true

                try {
                    const {data: {data, ...rest}} = await this.$store.dispatch('getRequests', {
                        page,
                        per_page: 25,
                        sortedBy: 'desc',
                        orderBy: 'created_at',
                        ...params
                    })

                    this.requests = {data: [...this.requests.data, ...data], ...rest}
                } catch (err) {
                    this.$notify.error({
                        title: 'Oops!',
                        message: err
                    })
                } finally {
                    this.loading = false
                }
            },
            async resetFilters () {
                if (this.$refs.filters) {
                    this.$refs.filters.reset()
                } else {
                    this.requests = {
                        data: []
                    }

                    Object.keys(this.filters.data).forEach(property => this.filters.data[property] = null)

                    await this.fetch()
                }
            },
            uploadMedia () {
                this.$confirm('Are you sure you want to upload these files?', 'Confirm', {
                    roundButton: true
                }).then(async () => {
                    this.uploadingMedia = true

                    const queue = new PQueue({concurrency: 1})

                    this.uploadedMedia.forEach(({file}) => queue.add(async () => {
                        try {
                            const {data} = await this.$store.dispatch('uploadRequestMedia', {
                                id: this.openedRequest.id,
                                media: file.src
                            })

                            this.openedRequest.media.push(data)

                            if (this.openedRequest.media.length === 1) {
                                this.$refs['dynamic-scroller'].forceUpdate()
                            }

                            this.$refs.upload.removeFile(file)
                        } catch (error) {
                            this.$notify.error({title: 'Oops!', message: error, position: 'bottom-left'})
                        }
                    }))

                    await queue.onIdle()

                    this.uploadingMedia = false
                    this.$refs.upload.clear()
                }).catch(() => null)
            },
            async filtersChanged (filters) {
                this.requests = {
                    data: []
                }

                await this.fetch(filters)
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
            toggleDrawer (request, tab = 'chat') {
                this.openedRequest = request;

                this.activeTab = tab

                if (this.activeTab === 'media') {
                    this.$nextTick(() => this.$refs['media-content'].scrollTop = this.$refs['media-content'].scrollHeight)
                }

                this.visibleDrawer = !this.visibleDrawer
            },
            resetDataFromDrawer () {
                this.activeTab = 'chat'
                this.uploadedMedia = []
                this.openedRequest = null
            }
        },
        computed: {
            hasFilters () {
                return Object.values(this.filters.data).some(value => value)
            }
        },
        async mounted () {
            // await this.fetch()
        }
    }
</script>

<style lang="scss" scoped>
    .requests {
        &:before {
            content: '';
            position: fixed;
            bottom: 0;
            right: 0;
            background-image: url('~img/5c7d3b0b0f0f4.png');
            background-repeat: no-repeat;
            background-position: 100% 100%;
            width: 100%;
            height: 100%;
            opacity: .16;
            pointer-events: none;
        }

        .el-card {
            max-width: 640px;

            &:not(:last-child) {
                margin-bottom: 16px;
            }
        }

        .vue-recycle-scroller {
            max-width: 640px;

            // margin: -.5em -1em;
            :global(.vue-recycle-scroller__item-wrapper) {
                overflow: visible;

                :global(.vue-recycle-scroller__item-view) {
                    margin-bottom: 20px;
                    padding-bottom: 20px;
                }

                :global(.vue-recycle-scroller__item-view) > div {
                    padding-bottom: 16px;

                    .request-card {
                        .el-button {
                            float: right;
                        }
                    }
                }
            }
            :global(.vue-recycle-scroller__slot) .el-loading-parent--relative {
                min-height: 42px;
            }
        }
    }
</style>