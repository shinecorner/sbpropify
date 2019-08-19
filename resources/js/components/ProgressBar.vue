<template>
    <div class="progress-bar">
        <div class="progress-status">
            <span class="progress-value">{{ value }}</span>
            <span class="progress-percent">{{ value*100/maxValue }}</span>
        </div>
        <el-progress :percentage="value*100/maxValue" :color="color" :show-text="false"></el-progress>
    </div>
</template>
<script>
export default {
    props: {
        value: {
            type: Number,
        },
        maxValue: {
            type: Number
        },
        color: {
            type: String
        }
    },
    data() {
        return {

        }
    }

}
</script>
<style lang="scss" scoped>
    .progress-bar {
        .progress-status {
            display: flex;
            justify-content: space-between;

            .progress-percent {
            }
        }
    }
</style>