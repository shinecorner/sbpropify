<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Card name</span>
            <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
        </div>
        <div v-for="o in 4" :key="o" class="text item">
            {{'List item ' + o }}
        </div>
    </el-card>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            default: () => {
                return null;
            }
        },
        loading: {
            type: Boolean,
            default: () => {
                return false;
            }
        }
    },
    methods: {
    },
    async created() {
        console.log(item);
    }
}
</script>

<style lang="scss" scoped>

</style>