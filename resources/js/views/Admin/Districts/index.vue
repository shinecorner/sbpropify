<template>
    <div class="districts">
        <heading :title="$t('models.district.title')" icon="icon-share" shadow="heavy">
            <template v-if="$can($permissions.create.district)">
                <el-button @click="add" icon="ti-plus" round size="small" type="primary">
                    {{$t('models.district.add')}}
                </el-button>
            </template>
            <template v-if="$can($permissions.delete.district)">
                <el-button :disabled="!selectedItems.length" @click="batchDelete" icon="ti-trash" round size="small"
                           type="danger">
                    {{$t('models.district.delete')}}
                </el-button>
            </template>
        </heading>
        <list-table
            :fetchMore="fetchMore"
            :filters="filters"
            :filtersHeader="filtersHeader"
            :header="header"
            :items="items"
            :loading="{state: loading}"
            :pagination="{total, currPage, currSize}"
            :withSearch="false"
            @selectionChanged="selectionChanged"
        >
        </list-table>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import ListTableMixin from 'mixins/ListTableMixin';
    import {mapActions} from 'vuex';


    const mixin = ListTableMixin({
        actions: {
            get: 'getDistricts',
            delete: 'deleteDistrict'
        },
        getters: {
            items: 'districts',
            pagination: 'districtsMeta'
        }
    });

    export default {
        components: {
            Heading
        },
        mixins: [mixin],
        data() {
            return {
                i18nName: 'district',
                header: [{
                    label: this.$t('models.district.name'),
                    prop: 'name'
                }, {
                    width: 120,
                    actions: [{
                        icon: 'ti-pencil',
                        type: 'success',
                        title: this.$t('models.district.edit_action'),
                        onClick: this.edit,
                        permissions: [
                            this.$permissions.update.district
                        ]
                    }]
                }],
                model: {
                    id: '',
                    name: '',
                    description: '',
                    buildings: []
                },
                validationRules: {
                    name: [{
                        required: true,
                        message: this.$t('models.district.required')
                    }],
                }
            };
        },
        computed: {
            filters() {
                return [
                    {
                        name: this.$t('filters.search'),
                        type: 'text',
                        icon: 'el-icon-search',
                        key: 'search'
                    }
                ]
            }
        },
        methods: {
            ...mapActions(['getBuildings']),
            async openEditWithRelation(district) {
                this.loading = true;
                const buildingsResp = await this.getBuildings({get_all: true, district_id: district.id});
                await this.openEdit(district);
                this.$set(this.model, 'buildings', buildingsResp.data);
                this.loading = false;
            },
            add() {
                this.$router.push({
                    name: 'adminDistrictsAdd'
                });
            },
            edit({id}) {
                this.$router.push({
                    name: 'adminDistrictsEdit',
                    params: {
                        id
                    }
                });
            },
        }
    }
</script>
