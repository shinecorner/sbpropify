<template>
    <div class="action-group">
        <el-button @click="saveAction" size="small" type="primary"> {{this.$t('actions.save')}}</el-button>
        <el-button @click="saveAndClose" size="small" type="primary"> {{this.$t('actions.saveAndClose')}}
        </el-button>
        <el-button @click="goToListing" size="small" type="warning"> {{this.$t('actions.close')}}
        </el-button>
    </div>
</template>

<script>
    export default {
        props: {
            saveAction: {
                type: Function,
                required: true
            },
            route: {
                type: String,
                required: true
            },
            queryParams: {
                type: Object,
                default() {
                    return {}
                }
            }
        },
        methods: {
            goToListing() {
                return this.$router.push({
                    name: this.route,
                    query: this.queryParams
                })
            },
            async saveAndClose() {
                try {
                    const resp = await this.saveAction();
                    if (resp) {
                        this.goToListing();
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        }
    }
</script>

<style scoped>
    .action-group > .el-button:not(:first-child) {
        margin-left: 0px;
    }
</style>
