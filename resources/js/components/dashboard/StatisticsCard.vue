<template>
    <el-row style="margin-bottom: 4px;" :gutter="20" v-if="data.labels">
        <el-col :sm="24" :md="12" :lg="6">
            <el-card class="box-card-count" style="margin-bottom: 17px;">
                <div class="total-wrapper">
                    <div class="total-box-card-header">
                        <span>{{ $t('general.requeststatuses.total') }}</span>
                    </div>
                    <div class="total-box-card-body">
                        <div class="box-card-count">
                            {{ totalRequest }}
                        </div>
                    </div>
                </div>
                <el-divider style="margin: 0;"></el-divider>
                <div class="avg-wrapper">
                    <div class="total-box-card-header clearfix ">
                        <span>{{ $t('dashboard.average_request_duration') }}</span>
                    </div>
                    <div class="total-box-card-body">
                        <div class="box-card-count">
                            {{ avgReqDuration }}
                        </div>
                    </div>
                </div>
            </el-card>
        </el-col>
        <el-col :sm="24" :md="12" :lg="6" v-for="n in 3" :key="n">
            <el-card v-for="m in 2" :key="m" class="box-card" :style="{'border-color': getRequestStatusColor(data.labels[n -1 + (m - 1) * 3], 'name')}" style="margin-bottom: 20px;">
                <div slot="header" class="box-card-header clearfix">
                    <span>{{ $t('models.request.status.'+data.labels[n -1 + (m - 1) * 3]) }}</span>
                </div>
                <div class="box-card-body">
                    <div class="box-card-count">
                        {{ data.data[n -1 + (m - 1) * 3] }}
                    </div>
                    <div class="box-card-progress">
                        <el-progress type="circle" :percentage="/*data.tag_percentage[n -1 + (m - 1) * 3]*/percentage[n -1 + (m - 1) * 3]" :width="70" :color="getRequestStatusColor(data.labels[n -1 + (m - 1) * 3], 'name')" :stroke-width="5"></el-progress>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
    import Card from 'components/Card';
    import globalFunction from "helpers/globalFunction";
    
    export default {
        name: 'DashboardStatisticsCard',
        mixins: [globalFunction],
        components: {
            Card
        },
        props: {
            data: {
                type: Object,
                required: true
            },
            cols: {
                type: Number,
                default: 3
            },
            totalRequest: {
                type: String,
                default: 0
            },
            avgReqDuration: [String, Number],
            animationTrigger: {
                type: String
            }
        },
        data(){
            return {
                percentage: []
            }
        },
        watch: {
            'data.tag_percentage': function(val) {
                const that = this;
                this.percentage = val.map(val => 0);
                setTimeout(function() {
                    that.percentage = val;
                }, 200);
            },
            animationTrigger: function(val) {
                const that = this;
                if (val == 'requests' && this.data.tag_percentage) {
                    this.percentage = this.data.tag_percentage.map(val => 0);
                    setTimeout(function() {
                        that.percentage = that.data.tag_percentage;
                    }, 100);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .total-wrapper {
        padding: 5px 0 11px 0;
    }
    .avg-wrapper {
        padding: 11px 0 5px 0;
    }
    .el-divider.el-divider--horizontal {
        width: 90%;
        margin: 0 auto;
    }
    .el-card {
        :global(.el-card__body) {
            padding: 0;
            .el-row {
                margin: -1px;
                margin-bottom: -2px;
                margin-right: -2px;
                border: 1px darken(#fff, 4%) solid;
                .el-col {
                    position: relative;
                    border-right: 1px darken(#fff, 4%) solid;
                    border-bottom: 1px darken(#fff, 4%) solid;
                    padding: 1em;
                    text-align: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    i {
                        border-radius: 50%;
                        line-height: 40px;
                        margin-bottom: 1em;
                        text-align: center;
                        background-color: darken(#fff, 4%);
                        width: 40px;
                        height: 40px;
                    }
                    h3 {
                        margin: 0;
                        font-size: 1.8em;
                        small {
                            font-size: 40%;
                            font-weight: normal;
                            display: block;
                            text-transform: uppercase;
                            color: darken(#fff, 24%);
                        }
                    }
                }
            }
        }
    }
</style>
