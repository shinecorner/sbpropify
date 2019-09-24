<template>
    <div class="request-card">
        <div class="request-card-header clearfix">
            <el-row  :gutter="20" type="flex">
                <el-col :span="3" class="request-aside">
                   <h4>{{ item.service_request_format }}</h4>
                </el-col>
                <el-col :span="18" class="request-content">
                    <h3>{{ item.title }}</h3>
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
                            {{item.name}}
                        </el-option>
                    </el-select>
                </el-col>
            </el-row>
            <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
                <el-col :span="3" class="request-aside">
                    <router-link :to="{name: 'adminRequestsEdit',  params: { id:item.id}}" class="el-menu-item-link">
                         <i class="ti-pencil"></i>
                          <span>{{ $t('general.actions.edit') }}</span>
                    </router-link>   
                </el-col>
                <el-col :span="18" class="request-content">
                    <p v-html="item.description"></p>
                </el-col>
                <el-col :span="3" class="request-tail">
                   
                </el-col>
            </el-row>
        </div>
        <div class="request-card-body">
            <el-row style="margin-bottom: 24px;" :gutter="20" type="flex" class="request-footer">
                <el-col :span="1" class="request-actions">
                    <el-checkbox @change="handleSelectionChanged"></el-checkbox>
                </el-col> 
                <el-col :span="1" class="request-actions">
                    <el-tooltip :content="$t('dashboard.buildings.go_to_building')" placement="top" effect="light">
                        <router-link :to="{name: 'adminBuildingsEdit', params: {id:item.tenant.building.id}}" class="listing-link">
                             <i class="icon icon-commerical-building"></i>
                        </router-link>
                    </el-tooltip>
                </el-col>
                <el-col :span="1" class="request-actions">
                </el-col>
                <el-col :span="3">
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
                        <avatar class="avatar-count" :size="28" :username="`+ ${item.assignedUsersCount}`"
                                color="#fff"
                                v-if="item.assignedUsers.length>2"></avatar>
                    </div>
                </el-col>
                <el-col :span="5">
                    <span>{{ $t('models.request.created_by') }}</span>
                    <p>
                        <el-tooltip
                            :content="item.tenant_name"
                            class="item"
                            effect="light" placement="top">

                            <table-avatar :src="item.tenant.user.avatar" :name="item.tenant_name" :size="33" />
                        </el-tooltip>
                        {{ item.tenant_name }}, 
                        {{formatDate(item.created_at)}}
                    </p>
                </el-col> 
                <el-col :span="4" class="request-category">
                    <span>{{ $t('models.request.category') }}</span>
                    <p>{{ item.category.parent_id==null?'':item.category.parentCategory.name + ' > ' }}
                        {{ item.category.name }}
                    </p>
                </el-col>
                <el-col :span="3">
                    <span>{{ $t('models.request.internal_priority.label') }}</span>
                    <p>
                        {{ $t('models.request.priority.'+`${item.priority_label}`) }}
                    </p>
                </el-col>
                <el-col :span="3">
                   <span>{{ $t('models.request.last_updated') }}</span>
                    <p v-if="updated_at.h>12">{{ updated_at.date }}</p>
                    <div v-else style="display: flex">
                        <p v-if="updated_at.h">{{ updated_at.h }}h&nbsp;</p>
                        <p v-else-if="updated_at.m">{{  updated_at.m }}m&nbsp;</p>
                        <p>ago</p>
                    </div>
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
    import {
        format, differenceInMinutes, parse, 
        differenceInCalendarDays, subHours
    } from 'date-fns';

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
    data() {
        return {
        }
    },
    components: {
        RequestCount,
        Avatar,
        format,
        'table-avatar': tableAvatar
    },
    computed: {
        due() {
            var currentDate = new Date();
            if(this.item.due_date !==undefined) {
                var updated_date = parse(this.item.due_date, 'yyyy-MM-dd', new Date());
                var days = differenceInCalendarDays(updated_date, new Date()) ;
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
            } else {
                return {
                    label:'models.request.due_on',
                    date: ''
                }
            }
            
        },
        updated_at() {
            var updated_date = parse(this.item.updated_at, 'yyyy-MM-dd hh:mm:ss', new Date());
            var currentDate = new Date();
            var minutes = differenceInMinutes(currentDate, updated_date) + currentDate.getTimezoneOffset() ;
            return {
                date: format(updated_date, 'YYYY-MM-DD'),
                h: Math.floor(minutes / 60),
                m: Math.ceil(minutes % 60)
            }
        },
        selectData() {                        
            const storeConstants = this.$constants.serviceRequests;
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
        },
        formatDate (date) {
            var res = date.split(" ");
            return res[0];
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
                    margin: 14px 0;
                }
                a {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    color: white;
                    height: 50px;
                    background-color: var(--primary-color);
                    font-size: 16px;
                    &:hover {
                        background-color: var(--primary-color-lighter);
                        color: var(--primary-color);
                    }
                }
            }
            .request-content {
                padding-left: 10px !important;
                padding-right: 5px !important;
                display: flex;
                flex-direction: column;
                justify-content: center;
                text-align: start;
               
                p {
                    display: block;
                    display: -webkit-box;
                    max-width: 100%;
                    max-height: 28px;
                    line-height: 1;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    text-align: start;
                    margin: 0;
                }
                h3 {
                    margin: 0;
                }
            }
            .request-tail {
                display: flex;
                align-items: center;
                padding-right: 10px !important;
              
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

                i {
                    font-size: 20px;
                }
            }
            .request-category {
                p {
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                }
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
                    font-weight: 700;
                    margin: 0px;
                    padding-top: 4px;
                }
                &:nth-of-type(5) {
                    p {
                        padding-top: 0px;
                    }
                }
            }
        }
    }
    .listing-link {
        text-decoration: none;
        color: darken(#fff, 50%);
        font-weight: bold;
    }
</style>