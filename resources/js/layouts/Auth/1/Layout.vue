<template>
    <el-container>
        <el-aside width="30%">
            <router-link to="/" class="logo">
                <img src="~img/logo5.png"/>
            </router-link>
            <router-view></router-view>
        </el-aside>
        <el-main>
            <div class="content">
                <h1>{{ $t('auth.title') }}</h1>
                <p>
                    {{ $t('auth.intro') }}
                </p>
                <el-row :gutter="24">
                    <el-col :span="12">
                        <i class="icon-vcard" />
                        <div class="content">
                            <h3>{{ $t('auth.benefit_1.title') }}</h3>
                            <p>
                                {{ $t('auth.benefit_1.description') }}
                            </p>
                        </div>
                    </el-col>
                    <el-col :span="12">
                        <i class="icon-megaphone-1" />
                        <div class="content">
                            <h3>{{ $t('auth.benefit_2.title') }}</h3>
                            <p>
                                {{ $t('auth.benefit_2.description') }}
                            </p>
                        </div>
                    </el-col>
                </el-row>
                <el-row :gutter="24">
                    <el-col :span="12">
                        <i class="icon-chat-empty" />
                        <div class="content">
                            <h3>{{ $t('auth.benefit_3.title') }}</h3>
                            <p>
                                {{ $t('auth.benefit_3.description') }}
                            </p>
                        </div>
                    </el-col>
                    <el-col :span="12">
                        <i class="icon-basket" />
                        <div class="content">
                            <h3>{{ $t('auth.benefit_4.title') }}</h3>
                            <p>
                                {{ $t('auth.benefit_4.description') }}
                            </p>
                        </div>
                    </el-col>
                </el-row>
            </div>
        </el-main>
    </el-container>
</template>
<style lang="scss" scoped>
    .el-container {
        height: 100%;
        position:relative;
        background-color:#515862;
        &:before{
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url(https://www.fortimo.ch/assets/images/a/7059-180618-aussenbilder-1-3e87cb84.jpg);
            position:absolute;
            filter:opacity(0.5);
            width: 100%;
            height: 100%;
            content: '';
        }
        .el-aside {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3em;
            background-color: #ffffff;
            margin: 40px 0 40px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19),
            0 6px 6px rgba(0, 0, 0, 0.23);
            .logo {
                margin: 1em auto;
                img {
                    width: 192px;
                }
            }
            &:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                background-image: url("~img/5c3b59fab215e.png");
                filter: opacity(.024) sepia(100%);
                z-index: -1;
                width: 100%;
                height: 100%;
            }
        }
        .el-main {
            position: relative;
            padding: 8em;
            display: flex;
            align-items: flex-end;
            @media screen and (max-width: 1368px) {
                padding: 4em;
            }
            &:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                background-repeat: no-repeat;
                background-size: cover;
                z-index: -1;
                filter: opacity(.05);
                width: 100%;
                height: 100%;
            }
            &:after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                background-repeat: no-repeat;
                background-size: 88em;
                background-position: left calc(100% + 7em);
                z-index: 1;
                opacity: .32;
                width: 100%;
                height: 100%;
            }
            .content {
                position: relative;
                z-index: 2;
                h1 {
                    font-size: 2.5em;
                    color: #6AC06F;
                    margin-top: 0;
                    margin-bottom: .5em;
                    text-shadow: 0 0 3px #000;
                }
                p {
                    font-size: 16px;
                    color: #fff;
                }
                .el-row {
                    margin-top: 4em;
                    margin-bottom: 4em;
                    @media screen and (max-width: 1368px) {
                        margin-top: 2em;
                        margin-bottom: 2em;
                    }
                    &:last-of-type{
                        margin-bottom: 0;
                    }
                    .el-col {
                        &:not(:last-of-type) {
                            margin-bottom: 2em;
                        }
                        display: flex;
                        align-items: center;
                        i {
                            width: 72px;
                            height: 72px;
                            flex-shrink: 0;
                            display: block;
                            border-radius: 12px;
                            font-size: 2.4em;
                            text-align: center;
                            line-height: 72px;
                            color: #fff;
                            background-color: #6AC06F !important;
                            box-shadow: 0 10px 20px rgba(0,0,0,0.19),
                            0 6px 6px rgba(0,0,0,0.23);
                            margin-right: .5em;
                        }
                        .content {
                            h3 {
                                font-size: 1.4em;
                                margin: 0;
                                margin-bottom: .32em;
                                color: #6AC06F;
                                text-shadow: 0 0 3px #000;
                            }
                            p {
                                margin: 0;
                                font-size: 14px;
                                color: #fff;
                            }
                        }
                    }
                }
            }
        }
    }

</style>
<style lang="less">
    .el-card__header {
        border-bottom: 1px solid #EBEEF5 !important;
        font-size: 16px !important;
    }
</style>
