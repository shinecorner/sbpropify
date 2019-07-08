<template>
    <div :class="{reversed}" class="add-comment">
        <el-tooltip :content="user.name" effect="dark" placement="top-start">
            <avatar ref="avatar" :name="user.name" :size="32" :src="user.avatar" />
        </el-tooltip>
        <el-input ref="content" type="textarea" resize="none" :class="{'is-focused': focused}" placeholder="Type a comment..." v-model="content" @blur="handleBlur" @focus="handleFocus" @keydown.native.alt.enter.exact="nextLine" @keydown.native.prevent.enter.exact="add" autosize clearable :disabled="loading.visible" :validate-event="false" />
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
                loading: {
                    visible: false
                }
            }
        },
        methods: {
            focus() {
                this.$content.focus()
            },
            blur() {
                this.$content.blur()
            },
            handleFocus() {
                this.focused = true
            },
            handleBlur() {
                this.focused = false
            },
            nextLine(ev) {
                this.content += '\r\n'
            },
            async add() {
                if (!this.content) {
                    return
                }

                this.blur()

                this.loading = this.$loading({
                    target: this.$refs.avatar.$el
                })

                try {
                    await this.$store.dispatch('comments/create', {
                        id: this.id,
                        comment: this.content,
                        commentable: this.type,
                        parent_id: this.parentId
                    });

                } catch (err) {
                    if (err.response) {
                        displayError(err)
                    }
                } finally {
                    this.content = ''

                    this.focus()

                    this.loading.close()
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
                this.focus()
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

        &.reversed {
            flex-direction: row-reverse;

            .el-textarea {
                margin-right: .5em;

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
            }
        }

        &:not(.reversed) {
            .el-textarea {
                margin-left: .5em;

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
            }
        }
    }
</style>
