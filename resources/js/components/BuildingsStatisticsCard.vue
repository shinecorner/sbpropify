<template>
    <el-row style="margin-bottom: 4px;" :gutter="20" v-if="data">
        <el-col :sm="24" :md="12" :lg="6">
            <el-card class="box-card-count" style="margin-bottom: 17px;">
                <div class="total-wrapper">
                    <div class="total-box-card-header">
                        <span>{{ $t('dashboard.buildings.total_building') }}</span>
                    </div>
                    <div class="total-box-card-body">
                        <div class="box-card-count">
                            {{ data.total_building }}
                        </div>
                    </div>
                </div>
            </el-card>
        </el-col>
        <el-col :sm="24" :md="12" :lg="6" v-for="n in 3" :key="n">
            <el-card class="box-card" :style="{'border-color': getBuildingsStatusColor(statuses[n - 1].name, 'name')}" style="margin-bottom: 20px;">
                <div slot="header" class="box-card-header clearfix">
                    <span>{{ $t('dashboard.buildings.'+ statuses[n - 1].name) }}</span>
                </div>
                <div class="box-card-body">
                    <div class="box-card-count">
                        {{ data[statuses[n - 1].name] }}
                    </div>
                    <div class="box-card-progress">
                        <el-progress type="circle" :percentage="statuses[n - 1].percentage" :width="70" :color="getBuildingsStatusColor(statuses[n - 1].name, 'name')" :stroke-width="5"></el-progress>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
    import Card from './Card';
    import globalFunction from "helpers/globalFunction";
    export default {
        name: 'BuildingsStatisticsCard',
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
            }
        },
        computed: {
            statuses: function() {
                return [
                    {
                        name: 'total_units',
                        percentage: 100
                    },
                    {
                        name: 'occupied_units',
                        percentage: this.data && this.data.total_units > 0 ? Math.round(this.data.occupied_units * 100 / this.data.total_units) : 0
                    },
                    {
                        name: 'free_units',
                        percentage: this.data && this.data.total_units > 0 ? Math.round(this.data.free_units * 100 / this.data.total_units) : 0
                    }
                ]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .total-wrapper {
        padding: 5px 0 0px 0;
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
