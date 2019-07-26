<template>
    <div>
        <el-timeline>
            <el-timeline-item
                    v-for="(element, index) in list"
                    :key="index">
                <h4>{{element.title}}</h4>
                <p class="subtitle text-secondary" v-if="element.category.name">{{element.category.name}}</p>
                <p class="activity-date text-secondary">{{ new Date(element.created_at) | formatDate}}</p>
            </el-timeline-item>
        </el-timeline>
        <div v-if="meta.current_page < meta.last_page">
            <el-button @click="loadMore" size="mini" style="margin-top: 15px" type="text">{{$t('loadMore')}}</el-button>
        </div>
    </div>
</template>

<script>
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

</style>
