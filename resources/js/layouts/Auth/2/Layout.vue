<template>
    <div class="login2-layout" :style="{backgroundImage: `url(${backImage})`}">
        <el-row class="container-row" type="flex" justify="center">
            <el-col :xs="24" :sm="12" :md="18" :lg="15" :xl="15">
                <div class="auth-card">
                    <el-row type="flex">
                        <el-col :md="12" class="image-container">
                            <img :src="loginImage" alt="login"/>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="12" class="form-container">
                            <router-view></router-view>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
        </el-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loginImage: require('img/login2-left.png'),
            backImage: require('img/login2-bg.jpg')
        }
    }
}
</script>
<style lang="scss" scoped>
    .login2-layout {
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        display: flex;
        align-items: center;

        .container-row {
            width: 100%;

            @media only screen and (max-width: 768px) {
                width: 430px;
                padding: 20px;
                margin-left: auto;
                margin-right: auto;
                max-width: 100%;
            }

            .auth-card {
                width: 100%;
                max-width: 1100px;
                background: #fff;
                display: block;
                box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
                position: relative;
                transition: all .3s ease-in-out;
                margin-right: auto;
                margin-left: auto;

                .image-container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: #eff2f7;

                    @media only screen and (max-width: 992px) {
                        display: none;
                    }

                    img {
                        max-width: 100%;
                    }
                }

                .form-container {
                    padding: 2rem;
                }
            }
        }
    }
</style>
<style lang="scss">
     .login2-layout {
        .container-row {
            .auth-card {
                .form-container {
                    .el-form-item {
                        margin-bottom: 15px !important;
                    }
                }
            }
        }
    }
</style>
