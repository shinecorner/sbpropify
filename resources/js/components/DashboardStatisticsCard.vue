<template>
    <el-row style="margin-bottom: 24px;" :gutter="20" type="flex">
        <el-col :span="6">
            <!--<el-card class="box-card">
                <div slot="header" class="clearfix">
                  <span>Card name</span>
                  <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
                </div>
                <div v-for="o in 20" :key="o" class="text item">
                  {{'List item ' + o }}
                </div>
            </el-card>-->
        </el-col>
        <el-col :span="18">
            <el-row :gutter="20">
                <el-col v-for="(count, index) in data.data" :key="index" :span="8" style="padding: 0 10px 20px 10px">
                    <el-card class="box-card" :style="{'border-color': getRequestStatusColor(data.labels[index], 'name')}">
                        <div slot="header" class="box-card-header clearfix">
                          <span>{{ $t('models.request.status.'+data.labels[index]) }}</span>
                        </div>
                        <div class="box-card-body">
                            <div class="box-card-count">
                                {{ count }}
                            </div>
                            <div class="box-card-progress">
                                <el-progress type="circle" :percentage="25" :width="60" :color="getRequestStatusColor(data.labels[index], 'name')" :stroke-width="4"></el-progress>
                            </div>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
        </el-col>    
     </el-row>
</template>

<script>
    import Card from './Card';
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
                type: Number,
                default: 0
            },
            avgReqDuration: [String, Number]
        },
        data(){
            return {}
        }
    }
</script>

<style lang="scss" scoped>
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
