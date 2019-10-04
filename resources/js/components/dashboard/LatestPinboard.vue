<template>
    <div class="latest-pinboard dashboard-table">
        <div class="link-container">
            <router-link :to="{name: 'adminPinboard'}">
                <span class="title">{{ $t('dashboard.pinboard.go_to_pinboard') }} </span>
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
                    type: 'pinboard-title',
                    label: 'models.pinboard.title',
                    props: ['content', 'user'],
                    minWidth: '300px'
                }, {
                    type: 'tag',
                    label: 'models.pinboard.status.label',
                    prop: 'status_label',
                    classSuffix: 'status'
                }, {
                    type: 'counts',
                    label: 'dashboard.pinboard.counts',
                    counts: [{
                            prop: 'comments_count',
                            background: '#bbb',
                            color: '#fff',
                            label: 'models.pinboard.comments'
                        }, {
                            prop: 'likes_count',
                            background: '#ebb563',
                            color: '#fff',
                            label: 'models.pinboard.likes'
                        }
                    ]
                }, {
                    type: 'actions',
                    label: 'dashboard.actions',
                    width: '130px',
                    actions: [ 
                        {
                            type: 'default',
                            title: 'general.actions.edit',
                            onClick: this.edit,
                            editUrl: 'adminPinboardEdit',
                            permissions: [
                                this.$permissions.update.listing
                            ]
                        }
                    ]
                }],
                listing: {},
            };
        },
        computed: {
            pinboardConstants() {
                return this.$constants.pinboard;
            },

        },
        methods: {
            edit({id}) {
                this.$router.push({
                    name: 'adminPinboardEdit',
                    params: {
                        id
                    }
                });
            },
            fetchData() {
              let that = this;
              const url = 'pinboard?per_page=5';

              return axios.get(url)
              .then(function (response) {
                const items = response.data.data.data.map(item => {
                  item.status_label = `models.pinboard.status.${that.pinboardConstants.status[item.type]}`;
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
