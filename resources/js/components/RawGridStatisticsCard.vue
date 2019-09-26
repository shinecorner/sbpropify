<template>
    <card>
        <el-row>
            <el-col :span="cols" v-for="(item, index) in data" :key="index" :class="{'item-border': ((index/3)+3)<data.length}">
                <!-- <i :class="item.icon" :style="{'color': item.color}" /> -->
                <div class="item">
                    <h3 >
                        {{ $t(item.description) }}
                        <small :style="{'color': item.color}">{{ item.value }}</small>
                    </h3>
                </div>
                    
            </el-col>
        </el-row>
    </card>
</template>

<script>
    import Card from 'components/Card';

    export default {
        name: 'RawGridStatisticsCard',
        components: {
            Card
        },
        props: {
            data: {
                type: Array,
                required: true
            },
            cols: {
                type: Number,
                default: 12
            }
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
                .item-border {
                    border-bottom: 1px darken(#fff, 15%) solid;
                }
                .el-col {
                    position: relative;
                    padding-top: 1em;
                    padding-bottom: 1em;
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
                    .item {
                        width: 100%;
                        border-right: 1px darken(#fff, 15%) solid;
                        h3 {
                            margin: 0;
                            font-size: 1em;
                            font-weight: medium;
                            color: darken(#fff, 24%);
                            small {
                                font-size: 2em;
                                font-weight: bold;
                                display: block;
                                text-transform: uppercase;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
