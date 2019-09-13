<template>
    <el-card :class="['post-add', {'is-focused': focused}]" v-loading="loading">
        <ui-avatar :size="42" :src="loggedInUser.avatar" :name="loggedInUser.name" />
        <el-input ref="content" type="textarea" v-model="model.content" autosize resize="none" placeholder="What do you want to publish?" :validate-event="false" @focus="focused = true" @blur="focused = false" @keydown.native.alt.enter.exact="submit" />
        <media-uploader ref="media" :id="post_id" type="posts" layout="list" v-model="model.media" :upload-options="uploadOptions" />
        <div class="actions" :style="[model.content && {'width': '100%', 'justify-content': 'flex-end'}]">
            <el-tag size="mini">
                <i class="icon-eye"></i>
                {{$t(`components.tenant.postAdd.visibility.${model.visibility.name}`)}}
            </el-tag>
            <el-dropdown size="small" trigger="click" placement="bottom-end" @command="onVisibilityChoosen" @visible-change="onDropdownVisibility">
                <el-tooltip ref="visibility-button-tooltip" content="Choose the visibility">
                    <el-button type="text" class="el-dropdown-link">
                        <i class="icon-ellipsis-vert"></i>
                    </el-button>
                </el-tooltip>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item v-for="(visibility, index) in visibilityTypes" :key="visibility.key" :command="visibility" :icon="visibility.icon" :divided="!! index">
                        {{$t(`components.tenant.postAdd.visibility.${visibility.name}`)}}
                        <small style="display: block;color: #A9A9A9;">{{visibility.description}}</small>
                    </el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
            <el-divider direction="vertical" />
            <el-tag size="mini" v-show="model.media.length">
                +{{model.media.length}}
            </el-tag>
            <el-tooltip content="Upload media or drag and drop files here">
                <el-button type="text" @click="uploadMedia">
                    <i class="icon-picture"></i>
                </el-button>
            </el-tooltip>
            <el-divider direction="vertical" />
            <el-tooltip :content="`send or use ${saveKeysShortcut} shortcut`">
                <el-button circle type="primary" icon="icon-paper-plane" :loading="loading" :disabled="!model.content" @click="submit" />
            </el-tooltip>
        </div>

        <!-- <pre>
            {{model.media}}
        </pre> -->
        <!-- <media-upload ref="upload" :cols="5" :allowed-types="['image/jpeg', 'image/png', 'application/pdf']" v-model="model.media" hide-trigger :style="{marginTop: model.media.length ? '16px' : '0px'}" /> -->
        <!-- <media ref="media" :id="5" type="requests" layout="grid" v-model="model.media" :upload-options="{drop: true, draggable: true, multiple: true, extensions: 'jpg,png'}" /> -->

        <!-- <media :id="4" type="requests" v-model="model.media" multiple auto-clear show-messages layout="list" extensions="jpg" :drop="true" /> -->

        <!-- <media :id="4" type="requests" v-model="model.media" multiple format="grid" /> -->
        <!-- <el-button type="danger" size="small" round>Remove all media files</el-button> -->
        <!-- allow only these: .png .jpg .jpeg -->
    </el-card>
</template>

<script>
    import {mapGetters} from 'vuex'
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        name: 'p-post-add-card',
        data () {
            return {
                model: {
                    media: [],
                    content: '',
                    visibility: null
                },
                post_id: null,
                focused: false,
                loading: false,
                dropdownVisible: false,
                uploadOptions: {
                    drop: true,
                    draggable: true,
                    multiple: true,
                    extensions: 'png,jpg,jpeg',
                    // size: 212168,
                    hideUploadButton: true,
                    hideSelectFilesButton: true
                }
            }
        },
        methods: {
            onVisibilityChoosen (visibility) {
                this.model.visibility = visibility
            },
            onDropdownVisibility (state) {
                this.dropdownVisible = state

                this.$refs['visibility-button-tooltip'].hide()
            },
            uploadMedia () {
                return this.$refs.media.selectFiles()
            },
            async submit () {
                if (!this.model.content || !this.model.visibility) {
                    return
                }

                try {
                    this.loading = true

                    const {media, ...params} = this.model

                    params.visibility = params.visibility.key

                    
                    const resp = await this.$store.dispatch('newPosts/create', params);

                    displaySuccess(resp.message)
                    const data = resp.data
                    //const {data: {data}} = await this.axios.post('posts', params);                                        
                    if (data.hasOwnProperty('id') && this.model.media.length) { 
                        this.post_id = data.id;
                        await this.$refs.media.startUploading();
                        //console.log('data', this.data);
                        // this.$refs.media.
                    }

                    this.model.content = ''
                    //this.$refs.media.clearUploader()

                    //displaySuccess(data)
                   
                } catch (error) {
                    displayError(error)
                } finally {
                    this.loading = false
                }
            }
        },
        computed: {
            ...mapGetters('application', [
                'constants'
            ]),
            ...mapGetters(['loggedInUser']),

            saveKeysShortcut () {
                if (navigator.platform.toUpperCase().includes('MAC')) {
                    return 'option+enter'
                }

                return 'alt+enter'
            },
            visibilityTypes () {
                const icons = {
                    address: 'icon-address',
                    district: 'icon-location',
                    all: 'icon-group'
                }

                const descriptions = {
                    address: 'Your post will be visible for tenants on your address only.',
                    district: 'Your post will be visible for tenants within your district only.',
                    all: 'Your post will be able to be seen by everyone.'
                }

                return Object.entries(this.constants.posts.visibility).map(([key, name]) => ({
                    key, name,
                    icon: icons[name] || '',
                    description: descriptions[name] || ''
                }))
            },
            isMediaVisible () {
                return this.model.content || this.model.media.length
            },
            isDividerVisible () {
                return this.model.content || this.model.media.length
            }
        },
        created () {
            this.model.visibility = this.visibilityTypes[0]
        }
    }
</script>

<style lang="scss" scoped>
    .el-card.post-add {
        position: relative;
        border: 2px transparent solid;

        &.is-focused {
            border-bottom-color: var(--primary-color);
        }

        :global(.el-card__body) {
            padding: 16px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            .ui-avatar {
                align-self: flex-start;
            }

            .el-textarea {
                flex: 1;

                :global(.el-textarea__inner) {
                    background-color: transparent;
                    border-style: none;
                }

                & + .el-divider {
                    margin: 16px 0;
                    margin-left: 44px;
                }
            }

            .actions {
                display: flex;
                align-items: center;
                align-self: flex-end;

                .el-tag {
                    text-transform: uppercase;
                    border-radius: 10px;
                    margin-right: 4px;
                }
            }

            .media-upload {
                :global(.drop-active) {
                    :global(i) {
                        display: none;
                    }
                }
            }
        }
    }
</style>