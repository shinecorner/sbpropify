<template>
    <div class="avatars-wrapper square-avatars">
        <span v-if="countsData.counts.rent_contracts.active > 0">
            <el-tooltip
                :content="$t('models.tenant.status.active')"
                class="item"
                effect="light" placement="top"

            >
                <avatar 
                    background-color="#5fad64"
                    color="#fff"
                    :initials="` ${countsData.counts.rent_contracts.active}`"
                    :size="30"
                    :style="{'z-index': 800}"
                    :username="`${countsData.counts.rent_contracts.active}`"
                />
            </el-tooltip>
        </span>
        <span v-if="countsData.counts.rent_contracts.not_active > 0">
            <el-tooltip
                :content="$t('models.tenant.status.not_active')"
                class="item"
                effect="light" placement="top"

            >
                <avatar 
                    background-color="#dd6161"
                    color="#fff"
                    :initials="` ${countsData.counts.rent_contracts.not_active}`"
                    :size="30"
                    :style="{'z-index': 799}"
                    :username="`${countsData.counts.rent_contracts.not_active}`"
                />
            </el-tooltip>
        </span>
    </div>
</template>
<script>
    import {Avatar} from 'vue-avatar';

    export default {
        name: 'RentContractCount',
        data() {
            return {
                counts: [
                {
                    prop: 'counts.rent_contracts.active',
                    background: '#5fad64',
                    color: '#fff',
                    label: this.$t('models.tenant.status.active')
                }, {
                    prop: 'counts.rent_contracts.inactive',
                    background: '#dd6161',
                    color: '#fff',
                    label: this.$t('models.tenant.status.not_active')
                }
                ]
            }
        },
        props: {
            countsData: {
                type: Object,
                default: () => {
                    return null;
                }
            },
        },
        components: {
            Avatar
        }
        
    }
</script>
<style lang="scss" scoped>
    .avatars-wrapper {
        display: flex;

        & > span {
        }

        .vue-avatar--wrapper {
            font-size: 12px !important;
        }
    }

    .square-avatars {
        flex-wrap: wrap;

        & > span {
            margin-bottom: 2px;

            & > div {
                position: relative;
                margin-right: -10px;
                border: 1px solid #fff;
                cursor: pointer;

                &:hover {
                    z-index: 999 !important;
                }
            }
        }
    }

</style>