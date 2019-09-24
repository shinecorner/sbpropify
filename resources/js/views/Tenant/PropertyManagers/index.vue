<template>
    <div class="property-managers">
        <ui-heading icon="icon-users" :title="$t('tenant.property_managers')" description="Et aut cum ut earum. Et aperiam ut possimus explicabo. Modi dolores in odit id fuga maxime aperiam dolor.">
        </ui-heading>
        <ui-divider />
        <loader v-if="loading" />
        <div class="placeholder" v-else-if="!loading && !groupedManagers">
            <img class="image" :src="require('img/5d4c33211edfc.png')" />
            <div class="content">
                <div class="title">There are no property managers available yet.</div>
                <div class="description">Et aut cum ut earum. Et aperiam ut possimus explicabo. Modi dolores in odit id fuga maxime aperiam dolor.</div>
            </div>
        </div>
        <el-card v-else>
            <el-timeline>
                <template v-for="(managers, letter) in groupedManagers">
                    <el-timeline-item class="letter" size="large">
                        <el-divider content-position="left">
                            {{letter}}
                        </el-divider>
                    </el-timeline-item>
                    <el-timeline-item v-for="{id, slogan, user} in managers" :key="id">
                        <ui-avatar :size="40" :src="user.avatar":name="user.name" shadow="hover" />
                        <div class="content">
                            <div class="name">
                                {{user.name}}
                            </div>
                            <div class="phone">
                                {{user.phone}}
                            </div>
                            <div class="email">
                                {{user.email}}
                            </div>
                            <div class="slogan">
                                {{slogan}}
                            </div>
                        </div>
                    </el-timeline-item>
                </template>
            </el-timeline>
        </el-card>
    </div>
</template>

<script>
import Heading from 'components/Heading'
    import Loader from './Loader'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            Loader,
            Heading
        },
        props: {
            limit: {
                type: Number,
                default: -1,
                validator: value => value >= -1
            }
        },
        data () {
            return {
                loading: false,
                groupedManagers: null
            }
        },
        computed: {
            ...mapGetters({
                user: 'loggedInUser'
            }),

            isLoading () {
                return this.loading && !this.tenants.length;
            }
        },
        async mounted () {
            const {tenant} = this.user

            if (tenant.building_id) {
                this.loading = true

                let {managers_last} = await this.$store.dispatch('getBuilding', {
                    id: tenant.building_id
                })

                if (this.limit > -1) {
                    managers_last = managers_last.slice(0, this.limit)
                }

                const unorderedList = managers_last.reduce((obj, manager) => {
                    obj[manager.user.name[0]] = obj[manager.user[0]] || []
                    obj[manager.user.name[0]].push(manager)

                    return obj
                }, {})

                this.groupedManagers = Object.keys(unorderedList)
                    .sort((a, b) => a.localeCompare(b))
                    .reduce((obj, key) => {
                        obj[key] = unorderedList[key].sort((a, b) => a.user.name.localeCompare(b.user.name))

                        return obj
                    }, {})

                this.loading = false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .property-managers {
        position: relative;

        &:before {
            content: '';
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-image: url('~img/5d4c5257a99ab.png');
            background-position: top left;
            background-repeat: no-repeat;
            background-attachment: fixed;
            pointer-events: none;
            z-index: -1;
            filter: opacity(.048);
        }

        .placeholder {
            position: relative;

            .image {
                width: 100%;
                filter: opacity(.16);
            }

            .content {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;

                .title {
                    font-size: 24px;
                    font-weight: 800;
                    color: var(--primary-color);
                    filter: opacity(.72);
                }

                .description {
                    font-size: 14px;
                    font-weight: 600;
                    color: transparentize(#000, .72);
                }
            }
        }

        .el-card {
            background-color: transparentize(#fff, .28);
            max-width: 640px;

            .el-timeline {
                padding: 0;

                .el-timeline-item {
                    padding-bottom: 1px;

                    &:not(.letter) {
                        :global(.el-timeline-item__wrapper) {
                            padding-left: 24px;
                        }
                    }

                    &:first-child {
                        :global(.el-timeline-item__node) {
                            &:global(.el-timeline-item__node--large) {
                                top: 0;
                            }
                        }

                        :global(.el-timeline-item__wrapper) {
                            :global(.el-timeline-item__content) {
                                .el-divider {
                                    margin-top: 0;
                                }
                            }
                        }
                    }

                    &:last-child {
                        :global(.el-timeline-item__node) {
                            &:not(:global(.el-timeline-item__node--large)) {
                                top: 0;
                            }
                        }
                    }

                    :global(.el-timeline-item__node) {
                        position: relative;

                        &:not(:global(.el-timeline-item__node--large)) {
                            top: 24px;
                        }

                        &:global(.el-timeline-item__node--large) {
                            top: 28px;
                        }
                    }

                    :global(.el-timeline-item__wrapper) {
                        :global(.el-timeline-item__content) {
                            display: flex;
                            align-items: center;
                            text-transform: capitalize;

                            .el-divider {
                                background: linear-gradient(to right, #DCDFE6, transparent);

                                .el-divider__text {
                                    &.is-left {
                                        color: var(--color-primary);
                                        background-color: #fff;
                                        font-size: 20px;
                                        font-weight: 900;
                                        width: 32px;
                                        height: 32px;
                                        padding: 0;
                                        border-radius: 50%;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        left: 0;
                                        box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76)
                                    }
                                }
                            }

                            .ui-avatar {
                                align-self: flex-start;
                            }

                            .content {
                                margin-left: 8px;

                                .name {
                                    font-size: 18px;
                                    font-weight: 800;
                                }

                                .phone {
                                    color: var(--color-text-placeholder);
                                }

                                .email {
                                    color: var(--color-text-placeholder);
                                }

                                .slogan {
                                    color: var(--color-text-secondary);
                                    margin-top: 8px;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>