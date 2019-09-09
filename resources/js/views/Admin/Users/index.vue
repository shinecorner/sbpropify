<template>
    <div class="services">
        <heading icon="icon-user" :title="$t('menu.admins')" shadow="heavy">
            <template v-if="$can($permissions.create.user)">
                <el-button @click="add('administrator')" icon="ti-plus" round size="mini" type="primary">{{$t('general.actions.add')}} {{ $t('general.roles.administrator') }}</el-button>
                <el-button @click="add('super_admin')" icon="ti-plus" round size="mini" type="primary">{{$t('general.actions.add')}} {{ $t('general.roles.super_admin') }}</el-button>
            </template>
            <template v-if="$can($permissions.delete.user)">
                <el-button :disabled="!selectedItems.length" @click="batchDeleteWithIds" icon="ti-trash" round size="mini"
                           type="danger">
                    {{$t('general.actions.delete')}}
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
                    label: 'general.name',
                    prop: 'name'
                }, {
                    label: 'general.email',
                    prop: 'email'
                }, {
                    label: 'general.phone',
                    prop: 'phone'
                }, {
                    label: 'general.roles.label',
                    prop: 'roles[0].name'
                }, {
                    width: 120,
                    actions: [{
                        type: '',
                        icon: 'ti-pencil',
                        title: 'general.actions.edit',
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
            add(role) {
                this.$router.push({
                    name: 'adminUsersAdd',
                    params: {
                        role: role,
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
