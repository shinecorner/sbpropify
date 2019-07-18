<template>


    <aside class="aside">
        <el-menu :default-active="currActive">
            <li class="slot" index="slot" v-if="hasSlot">
                <slot/>
            </li>

            <ul class="content">
                <el-menu-item
                        :class="{nested: link.nestedItem }"
                        :index="link.title"
                        :key="link.title"
                        @click="handleLink($event, key, link)"
                        v-for="(link, key) in links"
                        v-if="!link.children && ($can(link.permission) || !link.permission)">
                    <a href="#">
                        <i :class="[link.icon, 'icon']"/>
                        <span class="title">{{ link.title }}</span>
                    </a>
                </el-menu-item>
                <el-submenu :index="link.title" v-else-if="($can(link.permission) || !link.permission)">
                    <template slot="title">
                        <a href="#">
                            <i :class="[link.icon, 'icon']"/>
                            <span class="title">{{ link.title }}</span>
                        </a>
                    </template>
                    <el-menu-item
                            :index="child.title"
                            :key="child.title"
                            @click="handleLink($event, childKey, child)"
                            v-for="(child, childKey) in link.children">
                        <a href="#">
                            <i :class="[child.icon, 'icon']"/>
                            <span class="title">{{ child.title }}</span>
                        </a>
                    </el-menu-item>
                </el-submenu>
            </ul>
        </el-menu>
    </aside>
</template>

<script>
    export default {
        name: 'AdminSidebar',
        props: {
            links: {
                type: Array,
                default: []
            },
            defaultActive: {
                default: '0'
            }
        },
        data() {
            return {
                currActive: this.defaultActive
            }
        },
        methods: {
            handleLink(ev, key, {route, action, children}) {
                this.currActive = key.toString();

                !children && route && this.$router.push(route);

                if (action) {
                    if (action.showConfirmation) {
                        action && this.$confirm('Please proceed with caution.', 'Are you sure?', {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Cancel',
                            type: 'warning',
                            roundButton: true
                        }).then(() => {
                            this.$store.dispatch(action.name)
                                .then(r => displaySuccess(r))
                                .catch(err => displayError(err));
                        }).catch(() => {
                        });
                    } else {
                        this.$store.dispatch(action.name)
                            .then(r => displaySuccess(r))
                            .catch(err => displayError(err));
                    }
                }
            }
        },
        computed: {
            hasSlot() {
                return !!this.$slots.default;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .aside{
        background: #fff;
    }

    .el-menu {
        width: 256px;
        display: flex;
        flex-direction: column;
        border-right: none !important;

        .content {
            padding: 0;
            overflow: auto;

            a {
                color: #303133;
                text-decoration: none;
            }

            .el-menu-item,
            :global(.el-submenu__title) {
                .icon {
                    vertical-align: middle;
                    margin-right: 5px;
                    width: 24px;
                    text-align: center;
                    font-size: 18px;
                }

                &.nested {
                    padding: 0 40px !important;
                }
            }
        }
    }

    .el-submenu :global(.el-menu) {
        background-color: darken(#fff, 2.4%);
    }
</style>
