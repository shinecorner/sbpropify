<template>
    <div :class="['add-comment', {'is-reversed': reversed}]">
        <el-tooltip :content="user.name" effect="dark" placement="top-start">
            <avatar :name="user.name" :size="32" :src="user.avatar" />
        </el-tooltip>
        <el-input autosize ref="content" :class="{'is-focused': focused}" type="textarea" resize="none" v-model="content" :placeholder="$t('components.common.addComment.placeholder')" :disabled="loading" :validate-event="false" @blur="focused = false" @focus="focused = true" @keydown.native.alt.enter.exact="save" />
         <el-button circle icon="el-icon-s-promotion" size="small" :loading="loading" @click="save" />
    </div>
</template>

<script>
    import Avatar from './Avatar'
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
            parentId: {
                type: Number,
            },
            type: {
                type: String,
                required: true,
                validator: type => ['post', 'product', 'request', 'conversation'].includes(type)
            },
            autofocus: {
                type: Boolean,
                default: false
            },
            reversed: {
                type: Boolean,
                default: false
            }
        },
        components: {
            Avatar
        },
        data() {
            return {
                content: '',
                focused: false,
                loading: false
            }
        },
        methods: {
            async save () {
                if (!/\S/.test(this.content)) {
                    return
                }

                this.$content.blur()

                this.loading = true

                try {
                    await this.$store.dispatch('comments/create', {
                        id: this.id,
                        comment: this.content,
                        commentable: this.type,
                        parent_id: this.parentId
                    });

                } catch (error) {
                    displayError(error)
                } finally {
                    this.$content.focus()

                    this.content = ''
                    this.loading = false
                }
            }
        },
        computed: {
            user () {
                return this.$store.getters.loggedInUser
            }
        },
        mounted () {
            this.$content = this.$refs.content.$el.querySelector('textarea')

            if (this.autofocus) {
                this.$content.focus()
            } 
        }
    }
</script>

<style lang="scss" scoped>
    .add-comment {
        width: 100%;
        display: flex;
        align-items: flex-end;
        font-size: 14px;
        position: relative;

        .avatar {
            &.el-loading-parent--relative {
                :global(.el-loading-spinner .circular) {
                    margin-left: -5px;
                }
            }
        }

        .el-textarea {
            position: relative;

            :global(.el-textarea__inner) {
                padding: 5px 8px;
                max-height: 256px;
                -webkit-appearance: none;
            }

            &:before,
            &:after {
                content: '';
                position: absolute;
                width: 0;
                height: 0;
                border-width: 0;
                border-style: solid;
                border-color: transparent;
                transition: border-bottom-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
            }
        }

        &.is-reversed {
            flex-direction: row-reverse;

            .el-textarea {
                margin-right: 8px;

                :global(.el-textarea__inner) {
                    border-bottom-right-radius: 0;
                }

                &:before,
                &:after {
                    border-width: 8px 0 0 6px;
                }

                &:before {
                    right: -6px;
                    bottom: 0;
                    border-left-color: #DCDFE6;
                }

                &:after {
                    right: -4px;
                    bottom: 1px;
                }

                &.is-disabled:after {
                    border-left-color: #F5F7FB;
                }

                &:not(.is-disabled):after {
                    border-left-color: #fff;
                }

                &:not(.is-disabled):before {
                    border-left-color: #C0C4CC;
                }

                &.is-focused:before {
                    border-left-color: #6AC06F;
                }

                & + .el-button {
                    margin-right: 8px;
                }
            }
        }

        &:not(.is-reversed) {
            .el-textarea {
                margin-left: 8px;

                :global(.el-textarea__inner) {
                    border-bottom-left-radius: 0;
                }

                &:before,
                &:after {
                    border-width: 0 0 8px 6px;
                }

                &:before {
                    left: -6px;
                    bottom: 0;
                    border-bottom-color: #DCDFE6;
                }

                &:after {
                    left: -4px;
                    bottom: 1px;
                }

                &.is-disabled:after {
                    border-bottom-color: #F5F7FB;
                }

                &:not(.is-disabled):after {
                    border-bottom-color: #fff;
                }

                &:not(.is-disabled):hover:before {
                    border-bottom-color: #C0C4CC;
                }

                &.is-focused:before {
                    border-bottom-color: #6AC06F;
                }

                & + .el-button {
                    margin-left: 8px;
                }
            }
        }
    }
</style>
