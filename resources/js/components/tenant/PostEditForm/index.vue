<template>
    <el-form ref="form" :model="model" :rules="validationRules" label-position="top" v-loading="loading">

        <el-form-item prop="content" :label="$t('tenant.content')" style="grid-column: span 6">
            <el-input type="textarea" resize="none" v-model="model.content" :autosize="{minRows: 4, maxRows: 16}" />
        </el-form-item>

        <el-form-item style="grid-column: span 6">
            <ui-media-gallery :files="data.media.map(({url}) => url)" />
            <media-uploader ref="media" :id="product_id" type="products" layout="grid" v-model="model.media" :upload-options="uploadOptions" />
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
                product_id: null,
                model: {
                    media: [],
                    content: null,
                    tenant_name: null,
                    tenant_phone: null,       
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

                        const {media, tenant_name, tenant_phone, ...params} = this.model

                        params.id = this.data.id

                        const resp = await this.$store.dispatch('newPosts/update', params);
                        
                        if (resp && resp.data) {                            
                            if (this.model.media.length) {
                            // TODO - make await for this   
                                this.product_id = this.data.id;            
                                this.$refs.media.startUploading();
                            }
                        }
                        

                        this.loading = false
                        this.$refs.form.resetFields()
                    }
                })
            },
            
        },
        
        created () {

            console.log('edit', this.data)
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