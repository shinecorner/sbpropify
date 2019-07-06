<template>
    <el-menu background-color="#fff" mode="horizontal">
        <el-menu-item index="prefix" v-if="hasSlot('prefix')">
            <slot name="prefix"></slot>
        </el-menu-item>
        <el-menu-item class="logo" index="logo">
            <img src="~img/logo3.png"/>
        </el-menu-item>
        <el-menu-item class="header-menu-links" index="content" v-if="hasSlot()">
            <slot/>
        </el-menu-item>
    </el-menu>
</template>

<script>
    export default {
        name: 'AdminHeader',
        methods: {
            hasSlot(slot) {
                if (slot) {
                    return !!this.$slots[slot];
                }

                return !!this.$slots.default;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-menu {
        &.el-menu--horizontal {
            box-shadow: 0 1px 3px transparentize(#000, .88),
            0 1px 2px transparentize(#000, .76);
            display: flex;
            align-items: center;
            flex-shrink: 0;
            padding: 0 1em;

            > .el-menu-item {
                height: 72px;
                line-height: 72px;
                padding: 0 1em;
                background: none !important;
                border-bottom-style: none !important;

                :global(.el-button i) {
                    color: inherit;
                }

                &.logo {
                    flex: 1;
                    padding: 1em;

                    img {
                        height: 100%;
                        vertical-align: baseline;
                    }
                }
            }
        }
    }
</style>

<style lang="scss">
    .el-menu {
        &.el-menu--horizontal {
            > .el-menu-item.header-menu-links {
                display: flex !important;
                align-items: center;

                font-size: 15px;

                .header-link {
                    margin-right: 15px;
                    display: flex;
                    line-height: 1;
                    flex-direction: column;
                    text-align: center;
                    text-decoration: none;
                    color: #909399;

                    i {
                        margin-bottom: 5px;
                    }

                    &:hover {
                        color: #6AC06F;

                        i {
                            color: #6AC06F;
                        }
                    }
                }

                .logout-button {
                    display: flex;
                    flex-direction: column;
                    color: #909399;

                    i {
                        margin-bottom: 5px;
                    }

                    &:hover {
                        color: #6AC06F;
                    }
                }
            }
        }
    }
</style>
