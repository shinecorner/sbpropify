<template>
    <div class="managers-list dashboard-table">
        <div class="link-container">
            <router-link :to="{name: 'adminPropertyManagers'}">
                <div @click="searchroute">
                    <span class="title">{{ $t('dashboard.requests.go_to_property_managers') }} </span>
                    <i class="icon-right icon"/>
                </div>
            </router-link>
        </div>
        <list-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            @selectionChanged="selectionChanged"
            :height="250"
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
                    type: 'plain',
                    label: 'general.name',
                    prop: 'name',
                    minWidth: '150px'
                }, {
                    type: 'counts',
                    minWidth: '150px',
                    label: 'general.requests',
                }, {
                    type: 'actions',
                    label: 'dashboard.actions',
                    width: '130px',
                    actions: [ 
                        {
                            type: 'default',
                            title: 'general.actions.edit',
                            editUrl: 'adminPropertyManagersEdit',
                            permissions: [
                                this.$permissions.update.propertyManager
                            ]
                        }
                    ]
                }],
            };
        },
        methods: {
            fetchData() {
              let that = this;
              let url = 'propertyManagers?get_all=true&has_req=1';
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
            },
            searchroute() {
                while( document.querySelector('.content .is-active') != null) 
                {
                    document.querySelector('.content .is-active').classList.remove('is-active'); 
                }
            }
        },
        created() {
          this.fetchData();
        }
    }
</script>