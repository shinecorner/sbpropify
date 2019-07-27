<template>
    <div :class="['media-uploader', {[`media-${layout}-layout`]: true}]">
        <gallery :index="galleryIndex" :images="galleryImages" :options="galleryOptions" />
        <uploader ref="uploader" :value="value" v-bind="$attrs" :input-id="`upload-${$_uid}`" :headers="headers" :custom-action="customAction" @input="value => $emit('input', value)" @input-filter="onUploadFilter" />
        <draggable class="media-draggable" ghost-class="ghost" :list="value" :animation="240" :disabled="isDraggableDisabled">
            <transition-group class="media-list" type="transition" tag="div" name="flip-list" mode="out-in">
                <div :class="['media-item', {'is-draggable': draggable && value.length && !$refs.uploader.uploaded}, $refs.uploader.active && {'is-active': +file.progress && !file.success, 'is-pending': !+file.progress}, {'is-success': file.success, 'is-failed': file.error}]" v-for="(file, idx) in value" :key="file.id" :style="{'transition-delay': `calc(0.16 * ${idx}s)`}">
                    <div class="media-content">
                        <i class="icon-ellipsis-vert media-dragger" v-if="isListLayout"></i>
                        <el-image class="media-image" :src="file.file.blob" fit="cover" :alt="file.name" v-if="isFileImage(file)" @click="isListLayout ? previewFile(file, idx) : undefined" lazy v-once>
                            <div slot="error" style="color: red;">
                                <i class="icon-file-image" />
                            </div>
                            <div slot="placeholder" class="el-icon-loading"></div>
                        </el-image>
                        <i class="media-icon ti-file" v-else></i>
                        <div class="media-filename" v-if="isListLayout || !isFileImage(file)">
                            {{file.name}}
                            <small class="media-filesize">
                                {{file.size | formatBytes}}
                            </small>
                        </div>
                        <transition-group class="media-progress" tag="div" name="fade" v-if="canShowProgress(file)">
                            <el-progress :width="80" :type="progressType" key="progress" :stroke-width="3" :percentage="+file.progress" :status="getProgressStatus(file)" />
                            <div key="speed" class="media-progress-speed" v-if="canShowProgressSpeed(file)">
                                {{file.speed | formatBytes}}/s
                            </div>
                        </transition-group>
                        <div class="media-actions" v-if="!file.active">
                            <el-button circle plain icon="el-icon-zoom-in" size="mini" @click="previewFile(file, idx)" v-if="isGridLayout && canFileBePreviewed(file)" />
                            <el-button circle plain type="danger" icon="el-icon-delete" size="mini" @click="removeFile(file)" v-if="!file.success" />
                        </div>
                    </div>
                </div>
                <el-button-group key="buttons" v-if="isListLayout">
                    <el-button class="media-upload-trigger" icon="el-icon-plus" @click="selectFiles()">
                        Drop files or click to select...
                    </el-button>
                    <el-button type="primary" icon="icon-upload-cloud" @click="startUploading()" v-if="canShowUploadButton">
                        Upload
                    </el-button>
                </el-button-group>
                <template v-else-if="isGridLayout">
                    <el-button key="trigger" class="media-upload-trigger" @click="selectFiles()">
                        <i class="icon-plus"></i>
                        Drop files or click to select...
                    </el-button>
                    <el-button key="upload" type="primary" icon="icon-upload-cloud" @click="startUploading()" v-if="canShowUploadButton">
                        Upload
                    </el-button>
                </template>
            </transition-group>
        </draggable>
        <div v-show="isDropActive" class="drop-active">
            <slot name="drop-active">
                <i class="el-icon-upload"></i>
                Drop your files here
                <small>Only the files with the following <b></b> extensions are allowed.</small>
            </slot>
        </div>
    </div>
</template>

<script>
    import {API_BASE_URL} from '@/config'
    import Gallery from './MediaGallery'
    import fileSize from 'filesize'
    import Draggable from 'vuedraggable'
    import Uploader from 'vue-upload-component'

    export default {
        props: {
            value: Array,
            id: {
                type: Number,
                required: true
            },
            type: {
                type: String,
                validator: type => ['posts', 'requests', 'products'].includes(type),
                required: true
            },
            layout: {
                type: String,
                default: 'grid',
                validator: layout => ['grid', 'list'].includes(layout)
            },
            loading: {
                type: Boolean,
                default: false
            },
            draggable: {
                type: Boolean,
                default: true
            },
            galleryOptions: {
                type: Object,
                default: () => ({})
            },
            autoUpload: {
                type: Boolean,
                default: false
            },
            autoClearUploader: {
                type: Boolean,
                default: false,
            },
            hideUploadButton: {
                type: Boolean,
                default: false
            },
            showClearButton: {
                type: Boolean,
                default: false
            },
            showUploadMessages: {
                type: Boolean,
                default: false
            }
        },
        components: {
            Gallery,
            Uploader,
            Draggable
        },
        filters: {
            formatBytes (bytes) {
                return fileSize(bytes)
            }
        },
        data () {
            return {
                galleryIndex: null
            }
        },
        methods: {
            selectFiles () {
                document.getElementById(`upload-${this.$_uid}`).click()
            },
            isFileImage ({type}) {
                return type.includes('image/')
            },
            previewFile (file, idx) {
                if (this.isFileImage(file)) {
                    this.galleryIndex = idx
                } else if (this.canFileBePreviewed(file)) {
                    window.open(file.file.blob)
                } else {
                    this.$message.warning('This file cannot be previewed.', {
                        duration: 2400
                    })
                }
            },
            canFileBePreviewed (file) {
                return this.isFileImage(file) || ['application/pdf'].includes(file.type)
            },
            onUploadFilter (newFile, oldFile, prevent) {
                if (newFile) {
                    const fileReader = new FileReader()

                    fileReader.readAsDataURL(newFile.file)
                    fileReader.onload = () => newFile.file.src = /,(.+)/.exec(fileReader.result)[1]

                    newFile.file.blob = URL.createObjectURL(newFile.file)
                }
            },
            clearUploader () {
                this.$refs.uploader.clear()
            },
            async customAction (file) {
                const xhr = new XMLHttpRequest()

                xhr.open('POST', `${API_BASE_URL}/${this.type}/${this.id}/media`.replace(/([^:]\/)\/+/g, "$1"))

                return this.$refs.uploader.uploadXhr(xhr, file, JSON.stringify({
                    media: file.file.src
                }))
            },
            getProgressStatus ({success, error}) {
                return success ? 'success' : error ? 'exception' : undefined
            },
            startUploading () {
                this.$refs.uploader.active = true
            },
            canShowProgress ({active, success}) {
                return active || success
            },
            removeFile (file) {
                this.$refs.uploader.remove(file)
            },
            canShowProgressSpeed ({success, progress}) {
                return this.isListLayout && +progress && success
            }
        },
        computed: {
            headers () {
                return {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json;charset=UTF-8',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            },
            galleryImages () {
                return this.value.filter(file => this.isFileImage(file)).map(({file}) => file.blob)
            },
            isListLayout () {
                return this.layout === 'list'
            },
            isGridLayout () {
                return this.layout === 'grid'
            },
            progressType () {
                return this.isListLayout ? 'line' : this.isGridLayout ? 'circle' : undefined
            },
            canShowUploadButton () {
                return !this.autoUpload && !this.hideUploadButton
            },
            isDraggableDisabled () {
                return !this.draggable || this.value.length && this.$refs.uploader.uploaded
            },
            isDropActive () {
                return this.$refs.upload && this.$refs.upload.dropActive
            }
        },
        mounted () {
            if (this.autoUpload || this.autoClearUploader) {
                this.$watch(() => this.value, media => {
                    if (media.length) {
                        if (this.autoUpload) {
                            this.$refs.uploader.active = true

                            this.$message.success('Uploading...', {
                                showClose: true
                            })
                        }

                        if (this.autoClearUploader) {
                            if (this.$refs.uploader.uploaded) {
                                this.$refs.uploader.clear()

                                if (this.showUploadMessages) {
                                    this.$message.success('Media files have been succesfully uploaded.', {
                                        showClose: true
                                    })
                                }
                            }
                        }
                    }
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .media-uploader {
        width: 100%;

        &.media-list-layout {
            .media-draggable {
                .media-list {
                    .media-item {
                        padding: 8px;
                        
                        .media-content {
                            display: flex;
                            flex-wrap: wrap;
                            align-items: center;

                            .media-dragger {
                                font-size: 18px;
                            }

                            .media-icon,
                            .media-image {
                                width: 32px;
                                height: 32px;
                                border: 1px darken(#fff, 6%) solid;
                                border-radius: 6px;
                                margin-right: 8px;
                                box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76);
                            }

                            .media-image {
                                filter: opacity(.8);
                                transition: filter .24s;

                                &:hover {
                                    filter: opacity(1);
                                    cursor: zoom-in;
                                }
                            }

                            .media-icon {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            }

                            .media-filename {
                                flex: 1;
                            }

                            .media-progress {
                                width: 100%;
                                margin-left: 58px;

                                .media-progress-speed {
                                    font-size: 12px;
                                    color: darken(#fff, 48%);
                                }
                            }

                            .media-actions {
                                visibility: hidden;
                            }
                        }

                        &:not(:last-child) {
                            margin-bottom: 4px;
                        }

                        &:hover {
                            .media-actions {
                                visibility: visible;
                            }

                            &:not(.is-success):not(.is-failed) {
                                background-color: darken(#fff, 4%);
                            }
                        }
                    }

                    .el-alert {
                        padding: 8px;

                        :global(.el-alert__description) {
                            margin: 0;
                        }
                    }

                    .el-button-group {
                        width: 100%;
                        display: flex;

                        .el-button {
                            &:nth-child(1) {
                                flex: 1;
                                border-width: 2px;
                                border-style: dashed;
                            }

                            &:nth-child(2) {
                                margin-left: -1px;
                            }

                            &:not(.is-circle) :global([class^="icon-"]) {
                                margin-right: 8px;
                            }
                        }
                    }
                }
            }
        }

        &.media-grid-layout {
            .media-draggable {
                .media-list {
                    display: grid;
                    grid-gap: 8px;
                    grid-template-columns: repeat(auto-fill, minmax(112px, 1fr));

                    .media-item {
                        position: relative;
                        padding-top: 100%;

                        .media-content {
                            position: absolute;
                            top: 0;
                            left: 0;
                            bottom: 0;
                            right: 0;
                            width: 100%;
                            height: 100%;
                            cursor: pointer;
                            box-sizing: border-box;
                            border: 1px darken(#fff, 12%) solid;
                            box-shadow: 0 1px 3px transparentize(#000, .88), 0 1px 2px transparentize(#000, .76);
                            overflow: hidden;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            text-align: center;
                            border-radius: 4px;
                            word-break: break-word;
                            hyphens: auto;

                            .media-icon {
                                font-size: 24px;
                            }

                            .media-filename {
                                width: 90%;
                                padding: 4px;
                            }

                            .media-progress {
                                background-color: transparentize(#fff, .08);
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            }

                            .media-actions {
                                background-color: transparentize(#000, .56);
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                opacity: 0;
                                transition: opacity .32s cubic-bezier(.17,.67,1,1.23);

                                .el-button {
                                    font-size: 20px;
                                    padding: 0;
                                    border-style: none;
                                    background-color: transparent;
                                    filter: opacity(.72);
                                    transition: filter .24s;

                                    &:not(:last-of-type) {
                                        color: #fff;
                                    }

                                    &:hover {
                                        filter: opacity(1);
                                    }
                                }
                            }

                            &:hover .media-actions {
                                opacity: 1;
                            }
                        }
                    }

                    > .el-button {
                        &:nth-of-type(1) {
                            position: relative;
                            padding: 0;
                            padding-top: 100%;
                            border-width: 2px;
                            border-style: dashed;

                            :global(span) {
                                font-size: 12px;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                color: darken(#DCDFE6, 4%);
                                position: absolute;
                                top: 0;
                                left: 0;
                                bottom: 0;
                                right: 0;
                                width: 100%;
                                height: 100%;
                                white-space: normal;
                                line-height: 1.24;

                                :global(i) {
                                    font-size: 18px;
                                }
                            }
                        }

                        &:nth-of-type(2) {
                            margin-left: 0;
                            grid-column: 1 / -1;
                        }
                    }
                }
            }
        }

        .media-draggable {
            .media-list {
                .media-item {
                    border: 1px darken(#fff, 6%) solid;
                    border-radius: 6px; 
                    transition-property: color, background-color, filter;
                    transition-duration: .24s;
                    filter: opacity(1);

                    &.is-pending {
                        filter: opacity(.16);
                        pointer-events: none;
                    }

                    &.is-success {
                        background-color: #f0f9eb;
                        border-color: darken(#f0f9eb, 4%);
                        color: #67c23a;
                    }

                    &.is-failed {
                        background-color: #fef0f0;
                        border-color: darken(#fef0f0, 4%);
                        color: #f56c6c;
                    }

                    &.is-draggable .media-content {
                        cursor: move;
                    }

                    .media-content {
                        .media-filename {
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;

                            .media-filesize {
                                font-size: 10px;
                                color: darken(#fff, 24%);
                                display: block;
                            }
                        }
                    }
                }
            }
        }
    }
</style>