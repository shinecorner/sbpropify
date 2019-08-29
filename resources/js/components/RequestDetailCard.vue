<template>
    <div class="request-card">
        <div class="request-card-header clearfix">
            <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                <el-col :span="3" class="request-aside">
                   <h4>{{ item.service_request_format }}</h4>
                    <el-button
                        type="primary"
                        size="medium"
                        @click="edit"
                    >
                        <i class="ti-pencil"></i>
                        <span>{{ $t('models.propertyManager.edit') }}</span>    
                    </el-button>
                </el-col>
                <el-col :span="21" class="request-header">
                     <el-row style="margin-bottom: 24px;" :gutter="21" >
                        <el-col :span="21" class="request-content">
                            <h3>{{ item.title }}</h3>
                            <p>{{ item.description }}</p>
                        </el-col>
                        <el-col :span="3" class="request-tail">
                            {{ $t('models.request.last_updated') }}
                            <br>
                            {{ item.updated_at }}
                        </el-col>
                    </el-row>
                </el-col>
            </el-row>
        </div>
        <div class="request-card-body">
            <el-row style="margin-bottom: 24px;" :gutter="20" type="flex" class="request-footer">
                <el-col :span="1" class="request-actions">
                    <el-checkbox @change="handleSelectionChanged"></el-checkbox>
                </el-col> 
                <el-col :span="1" class="request-actions">
                </el-col>
                <el-col :span="1" class="request-actions">
                </el-col>
                <el-col :span="6">
                    <span>{{ $t('models.request.assigned_to') }}</span>
                        <div class="avatars-wrapper">
                        <span :key="index" v-for="(user, index) in item.assignedUsers">
                                <el-tooltip
                                    :content="user.first_name ? `${user.first_name} ${user.last_name}`: (user.user ? `${user.user.name}`:`${user.name}`)"
                                    class="item"
                                    effect="light" placement="top">
                                    <template v-if="user.user">
                                        <avatar :size="28"
                                                :username="user.first_name ? `${user.first_name} ${user.last_name}`: (user.user ? `${user.user.name}`:`${user.name}`)"
                                                backgroundColor="rgb(205, 220, 57)"
                                                color="#fff"
                                                v-if="!user.user.avatar"></avatar>
                                        <avatar :size="28" :src="`/${user.user.avatar}`" v-else></avatar>
                                    </template>
                                    <template v-else>
                                        <avatar :size="28"
                                                :username="user.first_name ? `${user.first_name} ${user.last_name}`: `${user.name}`"
                                                backgroundColor="rgb(205, 220, 57)"
                                                color="#fff"
                                                v-if="!user.avatar"></avatar>
                                        <avatar :size="28" :src="`/${user.avatar}`" v-else></avatar>
                                    </template>
                                </el-tooltip>

                        </span>
                    </div>
                </el-col>
                <el-col :span="6">
                    <span>{{ $t('models.request.created_by') }}</span>
                    <p>{{ item.tenant_name }}, {{ item.created_at }}</p>
                </el-col> 
                <el-col :span="6">
                    <span>{{ $t('models.request.priority.label') }}</span>
                    <p>
                        <el-button v-if="item.priority_label == 'low'" class="btn-priority-badge btn-badge"  round>{{ $t('models.request.priority.low') }}</el-button>
                        <el-button v-else-if="item.priority_label == 'normal'" plain type="warning" class="btn-priority-badge btn-badge"  round>{{ $t('models.request.priority.normal') }}</el-button>
                        <el-button v-else-if="item.priority_label == 'urgent'" plain type="danger" class="btn-priority-badge btn-badge"  round>{{ $t('models.request.priority.urgent') }}</el-button>
                    </p>
                </el-col>
                <el-col :span="3">
                    <span>{{ $t(due.label) }}</span>
                    <p>{{ due.date }}</p>
                </el-col>
            </el-row>    
        </div>
    </div>
</template>

<script>

    import RequestCount from 'components/RequestCount.vue';
    import {Avatar} from 'vue-avatar'

export default {
    props: {
        item: {
            type: Object,
            default: () => {
                return [];
            }
        },
        loading: {
            type: Object,
            default: () => ({
                state: false,
                text: 'Loading...',
                icon: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.8)'
            })
        }
    },
    components: {
        RequestCount,
        Avatar
    },
    computed: {
        due() {
            var currentDate = new Date();

            var updated = this.item.due_date.split('.');
            var updated_date = new Date(parseInt(updated[2]), parseInt(updated[1])-1, parseInt(updated[0]));
            var days = ( updated_date.getTime() - currentDate.getTime()) / 1000 / 60 / 60 / 24 ;
            if(days < 0)
                return {
                    label:'models.request.was_due_on',
                    date: this.item.due_date
                };
            else if(days <= 30)
                return {
                    label:'models.request.due_in',
                    date: `${Math.floor(days)}`
                };
            else
                return {
                    label:'models.request.due_on',
                    date: this.item.due_date
                };
        }   
    },
    methods: {
        handleSelectionChanged(val) {
            this.$emit('selectionChanged', this.item);
        },
        edit() {
            this.$emit('editAction', this.item);
        }
    },
    created() {
    }
}
</script>
<style lang="scss" scoped>
    .el-row {
        margin: 0px !important;
    }
    .avatars-wrapper {
        display: flex;

        .item {
            margin-right: 5px;
        }
    }
    .request-card {
        text-align: left;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 
                    0 1px 2px rgba(0,0,0,0.24);
        margin: 4px;
        .request-card-header {
            .el-row {
                margin:-18px -20px;
            }
            .request-aside {
                display: flex;
                flex-direction: column;
                justify-content: center;
                text-align: center;
            
                padding: 0px !important;
                .el-button {
                    width: 100%;
                    border-radius: 0px;
                    height: 50px;
                    padding-left: 0;
                    padding-right: 0;
                    text-align: center;
                }
            }
            .request-header {
               
                .request-content {
                    p {
                        margin-bottom: 7px;
                    }
                }
                .request-tail {
                    padding-right: 50px;
                    padding-top: 17.5px;
                }
            }
        }
        .request-footer {
            background-color: #f2f2f2;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            .request-actions {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0px !important;
            }
            .el-col {
                border-right: 1px solid darken(#ebeef5, 10%);
                padding: 5px 15px !important;
                &:last-child {
                    border-right: none;
                }

                span {
                    color: darken(#ffffff, 45%);
                }
                p {
                    font-weight: 600;
                }
            }
            p {
                margin: 0px;
                padding: 0px;
            }
        }
    }
</style>