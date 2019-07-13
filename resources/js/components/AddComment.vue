<template>
    <div :class="['add-comment', {'with-templates': useTemplates}]">
        <el-tooltip :content="user.name" effect="dark" placement="top-start">
            <avatar :name="user.name" :size="32" :src="user.avatar" />
        </el-tooltip>
        <div class="content">
            <el-input autosize ref="content" :class="{'is-focused': focused}" type="textarea" resize="none" v-model="content" :placeholder="$t('components.common.addComment.placeholder')" :disabled="loading" :validate-event="false" @blur="focused = false" @focus="focused = true" @keydown.native.alt.enter.exact="save" />
            <el-dropdown size="small" placement="top" trigger="click" v-if="useTemplates">
                <el-button class="el-dropdown-link" type="text" :disabled="loading">
                    <i class="el-icon-more"></i>
                </el-button>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item>Template 1</el-dropdown-item>
                    <el-dropdown-item>Template 2</el-dropdown-item>
                    <el-dropdown-item>Template 3</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <el-button circle icon="el-icon-s-promotion" size="small" :disabled="!content" :loading="loading" @click="save" />
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
            },
            useTemplates: {
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

                this.$refs.content.blur()

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
                    this.$refs.content.focus()

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
            if (this.autofocus) {
                this.$refs.content.focus()
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

        .content {
            position: relative;
            flex: auto;

            .el-textarea {
                position: relative;
                margin-left: 8px;

                :global(.el-textarea__inner) {
                    padding: 6px 8px;
                    max-height: 256px;
                    overflow-y: overlay;
                    overflow-x: hidden;
                    scrollbar-width: thin;
                    overscroll-behavior: contain;
                    border-bottom-left-radius: 0;
                    -webkit-appearance: none;
                    -webkit-overflow-scrolling: touch;

                    &::-webkit-scrollbar {
                        width: 4px;
                    }
        
                    &::-webkit-scrollbar-thumb {
                        border-radius: 8px;
                        width: 4px;
                        background-color: lighten(#6AC06F, 8%);
                    }

                    &:hover::-webkit-scrollbar-thumb {
                        background-color: #6AC06F;
                    }
        
                    &::-webkit-scrollbar-track {
                        border-radius: 8px;
                        background-color: #fff;
                    }

                    &::-webkit-scrollbar-thumb:window-inactive {
                        background-color: lighten(#6AC06F, 16%);
                    }
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
                    border-width: 0 0 8px 6px;
                    transition: border-bottom-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
                }

                &:before {
                    left: -6px;
                    bottom: 0;
                }

                &:after {
                    left: -4px;
                    bottom: 1px;
                }

                &.is-disabled:before {
                    border-bottom-color: #E4E7ED;
                }

                &.is-disabled:after {
                    border-bottom-color: #F5F7FB;
                }

                &:not(.is-disabled):after {
                    border-bottom-color: #fff;
                }

                &:not(.is-disabled).is-focused:before {
                    border-bottom-color: #6AC06F;
                }

                &:not(.is-disabled):not(.is-focused):before {
                    border-bottom-color: #DCDFE6;
                }

                &:not(.is-disabled):not(.is-focused):hover:before {
                    border-bottom-color: #C0C4CC;
                }
                
                & + .el-dropdown {
                    position: absolute;
                    bottom: 0;
                    right: -8px;

                    .el-dropdown-link {
                        padding: 8px;
                        transform: rotate(90deg);
                    }
                }
            }

            & + .el-button {
                margin-left: 16px;
            }
        }

        &.with-templates {
            .content {
                .el-textarea {
                    :global(.el-textarea__inner) {
                        padding-right: 32px;
                    }
                }
            }
        }
    }
</style>
