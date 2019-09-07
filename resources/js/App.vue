<template>
    <keep-alive>
    <router-view />
    </keep-alive>
</template>

<script>
    export default {
        async mounted () {
            // TODO -> primary-color to color-primary and text-color to color-text
            document.documentElement.setAttribute('style', `
                --primary-color: #6AC06F;
                --text-color: #3f3f3f;

                --color-main-background-base: #F2F4F9;
                --color-main-background-lighter: #bac5df;
                --color-main-background-darker: #8296c5;

                
                --color-primary: #6AC06F;
                --color-primary-lighter: #f0f9f1;
                --test-color: color-mod(var(--color-primary) alpha(1%));
                --color-success: #67C23A;
                --color-success-lighter: #85ce61;
                --color-warning: #E6A23C;
                --color-danger: #F56C6C;
                --color-info: #909399;

                --color-text-primary: #666666;
                --color-text-regular: #606266;
                --color-text-secondary: #909399;
                --color-text-placeholder: #C0C4CC;

                --border-color-base: #DCDFE6;
                --border-color-light: #E4E7ED;
                --border-color-lighter: #EBEEF5;
                --border-color-extra-light: #F2F6FC;

                --color-white: #FFFFFF;
                --color-black: #000000;
                --background-color-base: #F5F7FA;
            `)
        }
    }
</script>


<style lang="scss">
    .custom-remote-select {
        .el-select__tags {
            padding-left: 20px;
        }

        .el-input__prefix {
            display: flex;
            align-items: center;
            margin-left: 5px;
        }

        .el-input--prefix .el-input__inner {
            padding-left: 35px;
            padding-right: 35px;
        }
    }

    .full-button {
        width: 100%;
    }
</style>

