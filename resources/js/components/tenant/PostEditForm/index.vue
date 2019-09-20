<template>
    <el-form ref="form" :model="model" :rules="validationRules" label-position="top" v-loading="loading">

        <el-form-item prop="content" :label="$t('tenant.content')" style="grid-column: span 6">
            <el-input type="textarea" resize="none" v-model="model.content" :autosize="{minRows: 4, maxRows: 16}" />
        </el-form-item>

        <el-form-item style="grid-column: span 6">
            <ui-media-gallery :files="data.media.map(({url}) => url)" />
            <media-uploader ref="media" :id="post_id" type="posts" layout="grid" v-model="model.media" :upload-options="uploadOptions" />
        </el-form-item>
        <el-form-item v-if="!hideSubmit" style="grid-column: span 6; display: flex; flex-direction: column; justify-content: flex-end;">
            <el-button class="submit" type="primary" :disabled="loading" @click="submit">{{$t('tenant.actions.save')}}</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        name: 'p-post-edit-form',
        props: {
            hideSubmit: {
                type: Boolean,
                default: false
            },
            data: {
                type: Object
            },
            visible: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                types: [],
                loading: false,
                uploadOptions: {
                    drop: true,
                    multiple: true,
                    draggable: true,
                    hideUploadButton: true,
                    extensions: 'png,jpg,jpeg',
                    hideSelectFilesButton: false
                },
                post_id: null,
                model: {
                    media: [],
                    content: null,   
                },
                validationRules: {
                    content: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.content')})
                    }
                }
            }
        },
        methods: {
            submit () {
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        this.loading = true;

                        const {media, ...params} = this.model

                        params.id = this.data.id

                        this.data.content = this.model.content
                        const resp = await this.$store.dispatch('newPosts/update', this.data);
                        
                        if (resp && resp.data) {                            
                            if (this.model.media.length) {
                            // TODO - make await for this   
                                this.post_id = this.data.id;
                                this.$refs.media.startUploading();
                                this.$root.$on('media-upload-finished', () => this.$emit('update:visible', false));
                            }
                        }

                        this.loading = false
                        
                        if(!this.model.media.length)
                            this.$emit('update:visible', false);
//                        this.$refs.form.resetFields()
                    }
                })
            },
            
        },
        created () {
            this.model.content = this.data.content;
        }
    };
</script>

<style lang="sass" scoped>
    .el-form
        display: grid
        grid-gap: 8px
        grid-auto-columns: 6fr

        .el-form-item
            margin-bottom: 16px

            &:last-child
                margin-bottom: 0

            /deep/ .el-form-item__label
                padding: 0
                line-height: 32px

            /deep/ .el-form-item__content
                .el-input.el-input-group
                    /deep/ .el-input-group__prepend
                        padding: 8px

                .el-button, .el-select
                    width: 100%
</style>