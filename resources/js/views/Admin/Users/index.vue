<template>
    <div class="services">
        <heading icon="icon-user" :title="'Administrators' " shadow="heavy">
            <template v-if="$can($permissions.create.user)">
                <el-button @click="add" icon="ti-plus" round size="mini" type="primary">{{$t('general.actions.add')}}</el-button>
            </template>
            <template v-if="$can($permissions.delete.user)">
                <el-button :disabled="!selectedItems.length" @click="batchDeleteWithIds" icon="ti-trash" round size="mini"
                           type="danger">
                    {{$t('models.user.delete')}}
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

    const mixin = ListTableMixin({
        actions: {
            get: 'getUsers',
            delete: 'deleteUserWithIds'
        },
        getters: {
            items: 'users',
            pagination: 'usersMeta'
        }
    });

    export default {
        name: 'AdminUsers',
        components: {
            Heading
        },
        mixins: [mixin],
        data() {
            return {
                header: [{
                    label: 'models.user.name',
                    prop: 'name'
                }, {
                    label: 'models.user.email',
                    prop: 'email'
                }, {
                    label: 'models.user.phone',
                    prop: 'phone'
                }, {
                    width: 120,
                    actions: [{
                        icon: 'ti-pencil',
                        title: 'models.user.edit_action',
                        onClick: this.edit,
                        permissions: [
                            this.$permissions.update.user
                        ]
                    }]
                }],
            }
        },
        computed: {
            filters() {
                return [
                    {
                        name: this.$t('filters.search'),
                        type: 'text',
                        icon: 'el-icon-search',
                        key: 'search'
                    }, {
                        name: this.$t('filters.roles'),
                        type: 'select',
                        key: 'role',
                        data: [{
                            id: 'administrator',
                            name: this.$t('models.user.administrator'),
                        }, {
                            id: 'super_admin',
                            name: this.$t('models.user.super_admin'),
                        }],
                    },
                ]
            },
        },
        methods: {
            add() {
                this.$router.push({
                    name: 'adminUsersAdd',
                    params: {
                        role: this.$route.query.role
                    }
                });
            },
            edit({id}) {
                this.$router.push({
                    name: 'adminUsersEdit',
                    params: {
                        role: this.$route.query.role,
                        id
                    }
                });
            }
        }
    }
</script>
