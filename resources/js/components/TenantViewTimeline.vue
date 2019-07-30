<template>
    <div>
        <div v-if="list.length > 0">
            <el-timeline>
                <el-timeline-item
                        v-for="(element, index) in list"
                        :key="index">
                        <el-row :gutter="20" class="main-section">
                            <el-col :md="2">
                               <el-avatar v-if="element.media.length > 0" shape="square" :size="40" :src="element.media[0].url"></el-avatar>
                            </el-col>
                            <el-col :md="22">
                                <h4>
                                    {{element.title}}
                                    <TimelineStatus :status="element.status" />
                                    <!-- <template >
                                        <span class="btn-wrap">
                                            <template >
                                                <el-button
                                                    type="succcess"
                                                    size="mini"
                                                >
                                                    view
                                                </el-button>
                                            </template>
                                        </span>
                                    </template> -->
                                </h4>
                            <p class="subtitle text-secondary" v-if="element.category.name">
                                <el-tooltip
                                    :content="(element.category.parentCategory && element.category.parentCategory.name ? $t('models.requestCategory.parent')  + ' > ' : '') + $t('models.post.category.label')"
                                    class="item"
                                    effect="light" placement="top">
                                    <span>
                                        {{element.category.parentCategory && element.category.parentCategory.name ? element.category.parentCategory.name + ' >'  : ''}} {{ element.category.name}}
                                    </span>
                                </el-tooltip>
                            </p>
                            <p class="activity-date text-secondary">
                                <el-tooltip
                                    :content="$t('models.tenant.created_at')"
                                    class="item"
                                    effect="light" placement="top">
                                        <span>{{ new Date(element.created_at) | formatDate}}</span>
                                </el-tooltip> 
                            </p>
                             <div class="reactions" v-if="fetchAction == 'getProducts'">
                                <div><i class="ti-thumb-up"  />{{element.likes_count}}</div>
                                <div><i class="ti-comments" /> {{element.comments_count}} </div>
                                <div><i class="ti-gallery"  /> {{element.media.length}}</div>
                            </div>
                            </el-col>
                        </el-row>
                </el-timeline-item>
            </el-timeline>
            <div v-if="meta.current_page < meta.last_page">
                <el-button @click="loadMore" size="mini" style="margin-top: 15px" type="text">{{$t('loadMore')}}</el-button>
            </div>
        </div>
        <div v-else>
            <el-alert
                :title="$t('views.tenant.my.personal.placeholder.title')"
                type="info"
                show-icon
                :closable="false"
            >
            </el-alert>
        </div>
    </div>
</template>

<script>
    import TimelineStatus from 'components/TimelineStatus';
    import {format} from 'date-fns'
    export default {
        async created() {
            await this.fetch();
        },
        data() {
            return {
                list: [],
                meta: {},
            }
        },
        props: {
            filter: {
                type: String,
                required: true
            },
            filterValue: {
                type: Number,
                required: true
            },
            fetchAction: {
                type: String,
                required: true
            },
        },
         components: {
            TimelineStatus
        },
        filters: {
            formatDate(date) {
                return format(date, 'DD.MM.YYYY')
            }
        },
        methods: {
            async fetch(page = 1) {
                try {
                    const resp = await this.$store.dispatch(this.fetchAction, {
                        [this.filter]: this.filterValue,
                        per_page: 5,
                        page
                    });
                    this.meta = _.omit(resp.data, 'data');
                    let currentFetchedDate = resp.data.data.map(data => {
                        switch (this.fetchAction) {
                            case 'getRequests':
                                break;
                            case 'getPostsTruncated':
                                data.title = data.preview
                                data.category = {
                                    ...data.category,
                                    name: null
                                }
                                break;
                            case 'getProducts':
                                data.category = {
                                    ...data.category,
                                    name: null
                                }
                                break;
                        }
                        return data
                    })
                    if (page === 1) {
                        this.list = currentFetchedDate;
                    } else {
                        this.list.push(...currentFetchedDate);
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            loadMore() {
                if (this.meta.current_page < this.meta.last_page) {
                    this.fetch(this.meta.current_page + 1);
                }
            }
        },
    }
</script>

<style lang="scss" scoped>

    .el-timeline {
        .btn-hover{
            text-decoration: none;
        }
        h4 {
            margin-bottom: 0;
            color: #616161;
            font-weight: 700;
            margin-top: 0;
        }

        p {
            margin-top: 5px;
            margin-bottom: 0;
        }

        .subtitle {
            font-size: 13px;
        }

        .activity-date {
            font-size: 12px;
        }

        ul.el-timeline {
            padding-left: 0;
        }
    }

    .el-timeline-item:last-of-type {
        padding-bottom: 0;
    }
     .reactions {
        display: flex;
        align-items: center;
        > div {
            i {
                vertical-align: middle;
            }
            &:not(:last-child) {
                margin-right: 4px;
                &:after {
                    content: '\2022';
                    margin-left: 4px;
                    margin-right: 2px;
                }
            }
        }
        .el-button {
            padding: 0;
            :global(span) {
                margin-left: 5px;
            }
            &:before {
                background-color: transparent;
            }            
        }
        .btn-wrap:not(:first-child) {
            margin-left: 5px;
        }
        .icon-success {
            color: #5fad64;
        }

    }
</style>
