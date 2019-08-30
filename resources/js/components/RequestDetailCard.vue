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
                        <span>{{ $t('general.actions.edit') }}</span>    
                    </el-button>
                </el-col>
                <el-col :span="18" class="request-content">
                    <h3>{{ item.title }}</h3>
                    <p>{{ item.category.name }}</p>
                    <p>{{ item.description }}</p>
                </el-col>
                <el-col :span="3" class="request-tail">
                    <el-select 
                        class="select-icon rounded-select"  
                        v-model="item.status" 
                        @change="$emit('onChange', $event)"
                    >
                        <template slot="prefix">
                        </template>
                        <el-option
                            :key="item.id"
                            :label="item.name"
                            :value="item.id"
                            v-for="item in selectData">
                            <i class="icon-dot-circled" :class="item.id == 1 ? 'icon-success':'icon-danger'" ></i> {{item.name}}
                        </el-option>
                    </el-select>
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
                    <p>
                        <el-tooltip
                            :content="item.tenant_name"
                            class="item"
                            effect="light" placement="top">

                            <table-avatar :src="item.tenant.user.avatar" :name="item.tenant_name" :size="33" />
                        </el-tooltip>
                        {{ item.tenant_name }}, 
                        {{ item.created_at }}
                    </p>
                </el-col> 
                <el-col :span="3">
                    <span>{{ $t('models.request.priority.label') }}</span>
                    <p>
                        <el-button v-if="item.priority_label == 'low'" class="btn-priority-badge btn-badge"  round>{{ $t('models.request.priority.low') }}</el-button>
                        <el-button v-else-if="item.priority_label == 'normal'" plain type="warning" class="btn-priority-badge btn-badge"  round>{{ $t('models.request.priority.normal') }}</el-button>
                        <el-button v-else-if="item.priority_label == 'urgent'" plain type="danger" class="btn-priority-badge btn-badge"  round>{{ $t('models.request.priority.urgent') }}</el-button>
                    </p>
                </el-col>
                <el-col :span="3">
                    {{ $t('models.request.last_updated') }}
                    <br>
                    <span v-if="updated_at.h>12">{{ updated_at.date }}</span>
                    <span v-else-if="updated_at.h">{{ updated_at.h }}h</span>
                    <span v-else-if="updated_at.m">{{  updated_at.m }}m</span>
                    <span v-else>ago</span>
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
    import tableAvatar from 'components/Avatar';
    import globalFunction from "helpers/globalFunction";

export default {
    mixins: [globalFunction],
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
        Avatar,
        'table-avatar': tableAvatar
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
                    date: Math.floor(days) + (Math.floor(days) > 1?` ${this.$t('general.timestamps.days')}`:` ${this.$t('validation.attributes.day')}`),
                };
            else
                return {
                    label:'models.request.due_on',
                    date: this.item.due_date
                };
        },
        updated_at() {
            var currentDate = new Date();
            var updated_date = new Date(
                parseInt(this.item.created_by.substr(6,4)), 
                parseInt(this.item.created_by.substr(3,2)) - 1, 
                parseInt(this.item.created_by.substr(0,2)), 
                parseInt(this.item.created_by.substr(11,2)), 
                parseInt(this.item.created_by.substr(14,2)), 
                parseInt(this.item.created_by.substr(17,2)), 
            );
            var minutes = Math.ceil((currentDate.getTime() - updated_date.getTime()) / 1000 / 60) ;
            return {
                date: this.item.created_by.substr(0,10),
                h: Math.floor(minutes / 60),
                m: Math.ceil(minutes % 60)
            }
        },
        selectData() {
            const storeConstants = this.$store.getters['application/requests'];
            if (storeConstants) {
                const constants = storeConstants['status'];
                var data = Object.keys(constants).map((id) => {
                    return {
                        name: this.$t(`models.request.status.${constants[id]}`),
                        id: parseInt(id)
                    };
                });
                return data;
            }
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
        .el-col {
            padding: 0px !important;
        }
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
                h4 {
                    margin-bottom: auto;
                }
                .el-button {
                    width: 100%;
                    border-radius: 0px;
                    height: 50px;
                    padding-left: 0;
                    padding-right: 0;
                    text-align: center;
                }
            }
            .request-content {
                padding-left: 10px !important;
                padding-right: 5px !important;
                h3 {
                    margin-bottom: 10px;
                }
                p:nth-of-type(1) {
                    margin: 0px;
                    padding: 0px;
                }
                p {
                    margin-bottom: 2px;
                    line-height: 15px;
                }
            }
            .request-tail {
                display: flex;
                align-items: flex-end;
                padding-right: 10px !important;
                div {
                    margin-bottom: 20px
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