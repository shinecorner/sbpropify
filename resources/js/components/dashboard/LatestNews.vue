<template>
    <div class="latest-news dashboard-table">
        <div class="link-container">
            <router-link :to="{name: 'adminPosts'}">
                <span class="title">{{ $t('dashboard.news.go_to_news') }} </span>
                <i class="icon-right icon"/>
            </router-link>
        </div>
        <list-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            @selectionChanged="selectionChanged"
        >
        </list-table>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import axios from '@/axios';

    import {displayError, displaySuccess} from "helpers/messages";
    import DashboardListMixin from 'mixins/DashboardListMixin';
    
    const mixin = DashboardListMixin();

    export default {
        mixins: [mixin],
        props: {
          type: {
            type: String
          }
        },
        data() {
            return {
                header: [{
                    type: 'news-title',
                    label: 'models.post.title',
                    props: ['content', 'user'],
                    minWidth: '300px'
                }, {
                    type: 'tag',
                    label: 'models.post.status.label',
                    prop: 'status_label',
                    classSuffix: 'status'
                }, {
                    type: 'counts',
                    label: 'dashboard.news.counts',
                    counts: [{
                            prop: 'comments_count',
                            background: '#bbb',
                            color: '#fff',
                            label: 'models.post.comments'
                        }, {
                            prop: 'likes_count',
                            background: '#ebb563',
                            color: '#fff',
                            label: 'models.post.likes'
                        }
                    ]
                }, {
                    type: 'actions',
                    label: 'dashboard.actions',
                    width: 100,
                    actions: [ 
                        {
                            type: 'default',
                            title: 'general.actions.edit',
                            onClick: this.edit,
                            editUrl: 'adminPostsEdit',
                            permissions: [
                                this.$permissions.update.product
                            ]
                        }
                    ]
                }],
                product: {},
            };
        },
        computed: {
            newsConstants() {
                return this.$constants.posts;
            },

        },
        methods: {
            edit({id}) {
                this.$router.push({
                    name: 'adminPostsEdit',
                    params: {
                        id
                    }
                });
            },
            fetchData() {
              let that = this;
              const url = 'posts?per_page=5';

              return axios.get(url)
              .then(function (response) {
                const items = response.data.data.data.map(item => {
                  item.status_label = `models.post.status.${that.newsConstants.status[item.type]}`;
                  item.image_url = item.media.length == 0 ? '' : item.media[0].url;
                  return item;
                });
                that.items = items;
              }).catch(function (error) {
                  console.log(error);
              })
            }
        },
        created() {
          this.fetchData();
        }
    }
</script>
