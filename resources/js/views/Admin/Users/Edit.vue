<template>
    <div class="users-edit">
        <heading :title="this.$route.params.role == 'administrator' ? $t('models.user.edit_admin')  : $t('models.user.edit_super_admin')" icon="icon-user">
            <edit-actions :saveAction="submit" :deleteAction="deleteUser" route="adminUsers" :queryParams="queryParams" shadow="heavy"/>
        </heading>
        <el-row class="crud-view">
            <el-form :model="model" label-position="top" label-width="192px" ref="form">
                <el-col :md="12" id="left_card">
                    <card :loading="loading">
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('models.user.name')" :rules="validationRules.name" prop="name">
                                    <el-input type="text" v-model="model.name"/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('models.user.email')" :rules="validationRules.email"
                                            prop="email">
                                    <el-input type="email" v-model="model.email"/>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('general.password')" :rules="validationRules.password"
                                            autocomplete="off"
                                            prop="password">
                                    <el-input type="password" v-model="model.password"/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('general.confirm_password')"
                                            :rules="validationRules.password_confirmation"
                                            prop="password_confirmation">
                                    <el-input type="password" v-model="model.password_confirmation"/>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <el-form-item :label="$t('models.user.phone')" prop="phone">
                                    <el-input type="text" v-model="model.phone"/>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <el-form-item :label="$t('general.roles.label')" :rules="validationRules.role" prop="role">
                                    <el-select style="width: 100%;" v-model="model.role">
                                        <el-option :key="role" :label="$t('general.roles.' + role )" :value="role"
                                                v-for="role in allRoles"/>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </card>
                </el-col>
                <el-col :md="12" id="right_card">
                    <card :loading="loading">
                        <el-form-item :label="$t('models.tenant.language')" :rules="validationRules.language" 
                            prop="settings.language">
                            <select-language :model.sync="model.settings.language"/>
                        </el-form-item>
                    </card>
                </el-col>
            </el-form>
        </el-row>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import {mapActions} from 'vuex';
    import AdminUsersMixin from 'mixins/adminUsersMixin';
    import EditActions from 'components/EditViewActions';
    import SelectLanguage from 'components/SelectLanguage';

    export default {
        name: 'AdminUsersEdit',
        mixins: [AdminUsersMixin({
            mode: 'edit'
        })],
        components: {
            Heading,
            Card,
            EditActions,
            SelectLanguage
        },
        methods: {
            ...mapActions(['deleteUser']),
        }
    }
</script>

<style lang="scss" scoped>
    .users-edit {
        .heading {
            margin-bottom: 20px;
        }
        .el-form {
            #left_card {
                padding-left: 1%;
                padding-right: 1%;
            }
            #right_card {
                padding-left: 1%;
                padding-right: 1%;
            }
        }
    }
</style>

