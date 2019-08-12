<template>
    <div class="latest-buildings">
        <div class="link-container">
            <router-link :to="{name: 'adminBuildings'}">
                <span class="title">{{ $t('dashboard.buildings.go_to_buildings') }} </span>
                <i class="icon-right icon"/>
            </router-link>
        </div>
        <dashboard-list-table
            :header="header"
            :items="items"
            :loading="{state: loading}"
            @selectionChanged="selectionChanged"
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
                    label: this.$t('models.building.name'),
                    prop: 'name',
                    minWidth: '280px'
                }, {
                    type: 'plain',
                    label: this.$t('models.building.units'),
                    prop: 'units_count'
                }, {
                    type: 'plain',
                    label: this.$t('models.building.tenants'),
                    prop: 'tenants_count'
                }, {
                    type: 'actions',
                    label: this.$t('dashboard.actions'),
                    width: 85,
                    actions: [ 
                        {
                            type: 'success',
                            title: this.$t('models.building.edit'),
                            onClick: this.edit,
                            permissions: [
                                this.$permissions.update.building
                            ]
                        }
                    ]
                }],
            };
        },
        methods: {
            edit({id}) {
                this.$router.push({
                    name: 'adminBuildingsEdit',
                    params: {
                        id
                    }
                });
            },
            fetchData() {
                let that = this;
                const url = 'buildings/latest';
                return axios.get(url)
                .then(function (response) {
                    that.items = response.data.data;
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
    .latest-buildings {
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
