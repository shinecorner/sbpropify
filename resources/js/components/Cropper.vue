<template>
    <el-popover
            class="avatar-wrapper"
            placement="right"
            :width="boundary.width"
            :disabled="!uploaded"
            trigger="click"
            :value="showPopover"
            @hide="showPopover = false"
            :open-delay="300">
        <div class="croppie-wrapper">
            <vue-croppie
                    :boundary="boundary"
                    :enableOrientation="orientation"
                    :enableResize="resize"
                    :enableZoom="zoom"
                    :showZoomer="showZoomer"
                    :viewport="computedViewport"
                    @result="result"
                    @update="update"
                    ref="croppieRef">
            </vue-croppie>
        </div>
        <div class="avatar-wrapper__bot">
            <el-button @click="crop()" type="primary">{{$t('general.actions.crop')}}</el-button>
            <upload-avatar type="link" @file="upload"></upload-avatar>
        </div>
        <div slot="reference" class="avatar-box">
            <el-avatar v-if="previewImg" shape="square" :size="250" :src="previewImg">
            </el-avatar>
            <i v-else class="el-icon-s-custom def-icon"></i>
            <upload-avatar @file="upload"/>
        </div>
    </el-popover>
</template>

<script>
    import UploadAvatar from 'components/UploadAvatar';
    import 'croppie/croppie.css'

    export default {
        components: {
            UploadAvatar
        },
        props: {
            boundary: {
                type: Object,
                default: () => {
                    return {
                        height: 400,
                    }
                }
            },
            viewport: {
                type: Object,
                default: () => {
                    return {
                        width: 300,
                        height: 300
                    }
                }
            },
            zoom: {
                type: Boolean,
                default: true
            },
            orientation: {
                type: Boolean,
                default: true
            },
            showZoomer: {
                type: Boolean,
                default: false
            },
            resize: {
                type: Boolean,
                default: true
            },
            viewportType: {
                type: String,
                default: 'square'
            }
        },
        data() {
            return {
                previewImg: null,
                imgOriginal: null,
                uploaded: false,
                showPopover: false,
            }
        },
        methods: {
            crop() {
                this.previewImg = this.imgOriginal;
                this.$emit("cropped", this.imgOriginal.split("base64,")[1]);
            },
            upload(binaryfile) {
                this.uploaded = true;
                this.showPopover = true;
                this.bind(binaryfile);
            },
            result(output) {
                this.imgOriginal = output;
                if(!this.previewImg) {
                    this.previewImg = output;
                    this.$emit("cropped", output.split("base64,")[1]);
                }
            },
            update(options) {
                this.$refs.croppieRef.result({
                    ...options,
                    quality: 1,
                    imageSmoothingQuality: 'high',
                    size: 'original',
                    type: 'canvas',
                    imageSmoothingEnabled: true
                });
            },
            bind(src) {
                const url = window.URL.createObjectURL(src);
                this.$refs.croppieRef.bind({
                    url
                });
            },
        },
        computed: {
            computedViewport() {
                return {...this.viewport, type: this.viewportType};
            }
        }
    }
</script>

<style lang="scss">
    .avatar-wrapper {
        display: inline-flex;
        &__bot {
            padding-top: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            .el-link {
                margin-top: 10px;
            }
        }
    }
    .avatar-box {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 250px;
        height: 250px;
        border-radius: 4px;
        background: #eee;
        .def-icon {
            font-size: 175px;
        }
        .el-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar-uploader {
            z-index: 1;
            position: absolute;
            left: 0;
            bottom: 0;
            display: flex;
            width: 40px;
            height: 40px;
            border-radius: 0 4px 0 4px;
            background: rgba(0,0,0,0.5);
            color: #fff;
            font-size: 20px;
            .el-upload {
                width: 100%;
                height: 100%;
                line-height: 40px !important;
                i {
                    vertical-align: middle;
                }
            }
        }
    }
    .cr-boundary {
        width: 100% !important;
        height: 100% !important;
    }
    .croppie-container {
        max-height: 360px;
        .cr-resizer {
            max-width: 100%;
            max-height: 100%;
        }
    }
    .croppie-wrapper {
        width: 250px;
        height: 360px;
    }
</style>