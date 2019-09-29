<template>
    <div class="">
    <div class="file-uploader-container">
    <el-upload
        :action="''"
        :before-upload="beforeDocumentUpload"
        :drag="drag"
        :http-request="fileUpload"
        :multiple="multiple"
        :show-file-list="false"
        :accept="acceptType"
        class="file-uploader"
    >
        <div class="uploader-icon-div">
            <i class="el-icon-plus"></i>
        </div>
    </el-upload>
    </div>
    </div>
</template>

<script>
    import {displayError} from "../helpers/messages";
    import UploadMixin from 'mixins/uploadMixin';

    export default {
        name: "UploadRentContract",
        mixins: [UploadMixin],
        props: {
            multiple: {
                type: Boolean,
                default: false
            },
            drag: {
                type: Boolean,
                default: false
            },
            acceptType: {
                type: String,
                default: ""
            },
            rentContractIndex: {
                type: Number,
                default: 0
            }
        },
        methods: {
            beforeDocumentUpload(file) {
                const isLt2M = file.size / 1024 / 1024 < 16;

                if (!isLt2M) {
                    displayError({
                        success: false,
                        message: 'Document size can not exceed 16MB!'
                    });
                }

                return isLt2M;
            },
            fileUpload(e) {
                let file = {
                    raw: e.file,
                    name: e.file.name,
                    src: ''
                };
                this.base64(e.file, (dataUrl) => {
                    file.src = dataUrl;
                    this.$emit("fileUploaded", file, this.rentContractIndex);
                });
            }
        }
    }
</script>

<style lang="scss">
    .drag-custom {
        width: 100%;

        .el-upload-dragger {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .el-upload {
            width: 100%;
        }
    }

    /deep/ .rent-contract-upload {
        .file-upload-container { 
            .file-uploader {
                display: grid;
                grid-gap: 8px;
                grid-template-columns: repeat(auto-fill, minmax(112px, 1fr));
                grid-auto-rows: -webkit-min-content;
                grid-auto-rows: min-content;
                

                &:hover {
                    color: var(--color-primary);
                    background-color: var(--primary-color-lighter);
                    border-color: var(--color-primary);
                }
                
                /deep/ .el-upload {
                    
                    .el-upload-dragger {
                        height: 0;
                        padding-top: 100%;
                        border-style: dashed;
                        border-width: 2px;

                        .uploader-icon-div {
                            position: absolute;
                            top: 0;
                            right: 0;
                            bottom: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            display: -webkit-box;
                            display: -ms-flexbox;
                            display: flex;
                            -webkit-box-orient: vertical;
                            -webkit-box-direction: normal;
                            -ms-flex-direction: column;
                            flex-direction: column;
                            -webkit-box-align: center;
                            -ms-flex-align: center;
                            align-items: center;
                            -webkit-box-pack: center;
                            -ms-flex-pack: center;
                            justify-content: center;

                            i {

                            }
                        }
                    }
                }
            }
        }
    }
</style>
