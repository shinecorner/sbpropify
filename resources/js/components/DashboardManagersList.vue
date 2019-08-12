<template>
    <div class="managers-list">
        <div class="link-container">
            <router-link :to="{name: 'adminPropertyManagers'}">
                <span class="title">{{ $t('dashboard.requests.go_to_property_managers') }} </span>
                <i class="icon-right icon"/>
            </router-link>
        </div>
        <dashboard-list-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            @selectionChanged="selectionChanged"
            :height="250"
        >
        </dashboard-list-table>
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
                    type: 'plain',
                    label: this.$t('models.propertyManager.name'),
                    prop: 'name',
                    minWidth: '150px'
                }, {
                    type: 'counts',
                    minWidth: '150px',
                    label: this.$t('models.propertyManager.requests'),
                    counts: [{
                            prop: 'requests_count',
                            background: '#aaa',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.total')
                        }, {
                            prop: 'requests_received_count',
                            background: '#bbb',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.received')
                        }, {
                            prop: 'requests_assigned_count',
                            background: '#ebb563',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.assigned')
                        }, {
                            prop: 'requests_in_processing_count',
                            background: '#ebb563',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.in_processing')
                        }, {
                            prop: 'requests_reactivated_count',
                            background: '#ebb563',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.reactivated')
                        }, {
                            prop: 'requests_done_count',
                            background: '#67C23A',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.done')
                        }, {
                            prop: 'requests_archived_count',
                            background: '#67C23A',
                            color: '#fff',
                            label: this.$t('models.building.requestStatuses.archived')
                        }
                    ]
                }, {
                    type: 'actions',
                    label: this.$t('dashboard.actions'),
                    width: 100,
                    actions: [ 
                        {
                            type: 'success',
                            title: this.$t('models.propertyManager.edit'),
                            onClick: this.edit,
                            permissions: [
                                this.$permissions.update.propertyManager
                            ]
                        }
                    ]
                }],
            };
        },
        methods: {
            edit({id}) {
                this.$router.push({
                    name: 'adminPropertyManagersEdit',
                    params: {
                        id
                    }
                });
            },
            fetchData() {
              let that = this;
              let url = 'propertyManagers?req_count=true&get_all=true';
              return axios.get(url)
              .then(function (response) {
                const items = response.data.data.map(item => {
                  item.name = item.first_name + ' ' + item.last_name;
                  item.requests_count = item.requests_received_count
                                        + item.requests_assigned_count
                                        + item.requests_in_processing_count
                                        + item.requests_reactivated_count
                                        + item.requests_done_count
                                        + item.requests_archived_count;
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

<style lang="scss">
    .managers-list {
        position: relative;

        .link-container {
            position: absolute;
            top: -55px;
            right: 0px;
            text-align: right;
            padding: 20px 15px;
            font-size: 14px;

            a {
                text-decoration: none;
                color: #525252;

                &:hover {
                    color: #303133;
                }
            }
        }
    }
</style>
