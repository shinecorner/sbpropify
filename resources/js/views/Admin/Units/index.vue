<template>
    <div class="units">
        <heading :title="$t('models.unit.title')" icon="icon-unit" shadow="heavy">
            <template v-if="$can($permissions.create.unit)">
                <el-button @click="add" icon="ti-plus" round size="mini" type="primary">
                    {{$t('models.unit.add')}}
                </el-button>
            </template>
            <template v-if="$can($permissions.delete.unit)">
                <el-button :disabled="!selectedItems.length" @click="batchDelete" icon="ti-trash" round size="mini"
                           type="danger">
                    {{$t('models.unit.delete')}}
                </el-button>
            </template>
        </heading>
        <list-table
            :fetchMore="fetchMore"
            :fetchMoreParams="fetchParams"
            :filters="filters"
            :filtersHeader="filtersHeader"
            :header="header"
            :items="formattedItems"
            :loading="{state: loading}"
            :isLoadingFilters="{state: isLoadingFilters}"
            :pagination="{total, currPage, currSize}"
            :withSearch="false"
            @selectionChanged="selectionChanged"
            v-if="isReady"
        >
        </list-table>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import {mapActions} from 'vuex';
    import ListTableMixin from 'mixins/ListTableMixin';
    import getFilterDistricts from 'mixins/methods/getFilterDistricts';
    import getFilterStates from "mixins/methods/getFilterStates";
    import getFilterPropertyManager from "mixins/methods/getFilterPropertyManager";


    const mixin = ListTableMixin({
        actions: {
            get: 'getUnits',
            delete: 'deleteUnit'
        },
        getters: {
            items: 'units',
            pagination: 'unitsMeta'
        }
    });

    export default {
        components: {
            Heading
        },
        mixins: [mixin, getFilterDistricts, getFilterStates, getFilterPropertyManager],
        data() {
            return {
                isReady: false,
                fetchParams: {},
                states:{},
                propertyManagers:{},
                districts:{},
                buildings:{},
                header: [{
                    label: this.$t('models.unit.name'),
                    prop: 'name'
                }, {
                    label: this.$t('models.unit.building'),
                    prop: 'building.name'
                }, {
                    label: this.$t('models.unit.type.label'),
                    prop: 'typeLabel'
                }, {
                    label: this.$t('models.unit.floor'),
                    prop: 'floor'
                }, {
                    label: this.$t('models.unit.room_no'),
                    prop: 'room_no'
                }, {
                    label: this.$t('models.unit.monthly_rent'),
                    prop: 'monthly_rent'
                }, {
                    label: this.$t('models.unit.tenant'),
                    withUsers: true,
                    prop: 'tenants'
                }, {
                    width: 120,
                    actions: [{
                        icon: 'ti-pencil',
                        title: this.$t('models.unit.edit'),
                        onClick: this.edit,
                        permissions: [
                            this.$permissions.update.unit
                        ]
                    }]
                }],
                building: {},
                isLoadingFilters: false,
            };
        },
        methods: {
            ...mapActions(['getBuildings']),
            async getFilterBuildings() {
                const buildings = await this.getBuildings({
                    get_all: true
                });

                return buildings.data;
            },
            add() {
                this.$router.push({
                    name: 'adminUnitsAdd',
                    params: {
                        id: this.building.id
                    }
                });
            },
            edit({id}) {
                this.$router.push({
                    name: 'adminUnitsEdit',
                    params: {
                        id,
                        buildingId: this.building.id,
                    }
                });
            }
        },
        computed: {
            title() {
                return `${this.building.name} - ${this.$t('menu.units')}`;
            },
            formattedItems() {
                return this.items.map((unit) => {
                    unit.typeLabel = this.$t(`models.unit.type.${unit.typeLabel}`);
                    return unit
                })
            },
            filters() {
                return [
                    {
                        name: this.$t('filters.search'),
                        type: 'text',
                        icon: 'el-icon-search',
                        key: 'search'
                    },
                    {
                        name: this.$t('filters.states'),
                        type: 'select',
                        key: 'state_id',
                        data: this.states,
                    },
                    {
                        name: this.$t('filters.districts'),
                        type: 'select',
                        key: 'district_id',
                        data: this.districts,
                    },
                    {
                        name: this.$t('filters.buildings'),
                        type: 'select',
                        key: 'building_id',
                        data: this.buildings,
                    },
                    {
                        name: this.$t('filters.propertyManagers'),
                        type: 'select',
                        key: 'manager_id',
                        data: this.propertyManagers,
                    },
                    {
                        name: this.$t('filters.requests'),
                        type: 'select',
                        key: 'request',
                        data: [{
                            id: 1,
                            name: this.$t('filters.open_requests')
                        }]
                    },
                ];
            }
        },
        async created() {
            this.isLoadingFilters = true;
            this.isReady = true;
            const districts = await this.axios.get('districts')
            this.districts = districts.data.data.data;

            const propertyManagers = await this.axios.get('propertyManagers?get_all=true')
            this.propertyManagers = propertyManagers.data.data.map((propertyManager) => {
                return {
                    id: propertyManager.id,
                    name: propertyManager.user.name
                }
            });

            const states = await this.axios.get('states?filters=true')
            this.states = states.data.data;

            const buildings = await this.axios.get('buildings?get_all=true')
            this.buildings = buildings.data.data;
            this.isLoadingFilters = false;
        }
    }
</script>
