<template>
    <el-form ref="form" :model="model" :rules="validationRules" label-position="top" v-loading="loading">
        <el-form-item prop="title" :label="$t('tenant.title')" style="grid-column: span 6">
            <el-input v-model="model.title" />
        </el-form-item>
        <el-form-item prop="type" :label="$t('tenant.type')" style="grid-column: span 3">
            <el-select v-model="model.type">
                <el-option v-for="category in types" :key="category.value" :label="$t(`models.product.type.${category.label}`)" :value="category.value" />
            </el-select>
        </el-form-item>
        <el-form-item prop="visibility" :label="$t('tenant.visibility')" style="grid-column: span 3">
            <el-select v-model="model.visibility">
                <el-option v-for="visibility in visibilities" :key="visibility.value" :label="$t(`models.product.visibility.${visibility.label}`)" :value="visibility.value" />
            </el-select>
        </el-form-item>
        <el-form-item prop="price" :label="$t('tenant.price')" v-if="isPriceVisible" style="grid-column: span 3">
            <div style="display: flex">
                <el-input v-model="model.price.integer">
                    <template slot="prepend">CHF</template>
                </el-input>
                <div style="padding: 4px">.</div>
                <el-input v-model="model.price.decimals" style="width: 50%" />
            </div>
        </el-form-item>
        <el-form-item prop="content" :label="$t('tenant.content')" style="grid-column: span 6">
            <el-input type="textarea" resize="none" v-model="model.content" :autosize="{minRows: 4, maxRows: 16}" />
        </el-form-item>
        <el-form-item prop="tenant_name" :label="$t('tenant.contact_name')" style="grid-column: span 3">
            <el-input v-model="model.tenant_name" />
        </el-form-item>
        <el-form-item prop="tenant_phone" :label="$t('tenant.contact_phone')" style="grid-column: span 3">
            <el-input v-model="model.tenant_phone" />
        </el-form-item>
        <el-form-item style="grid-column: span 6">
            <ui-media-gallery :files="data.media.map(({url}) => url)" />
            <media-uploader ref="media" :id="product_id" type="products" layout="grid" v-model="model.media" :upload-options="uploadOptions" />
        </el-form-item>
        <el-form-item v-if="!hideSubmit" style="grid-column: span 3">
            <el-button class="submit is-round" type="primary" :disabled="loading" @click="submit">{{$t('tenant.actions.save')}}</el-button>
        </el-form-item>
        <el-form-item v-if="!hideSubmit" style="grid-column: span 3">
            <el-button class="is-round" type="danger" :disabled="loading" @click.stop="$emit('delete-product', $event, data)">{{$t('general.actions.delete')}}</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        name: 'p-product-edit-form',
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
                product_id: null,
                model: {
                    media: [],
                    type: null,
                    title: null,
                    price: {
                        integer: '0',
                        decimals: '00'
                    },
                    content: null,
                    visibility: null,
                    tenant_name: null,
                    tenant_phone: null,       
                },
                validationRules: {
                    type: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.type')})
                    },
                    title: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.title')})
                    },
                    price: {
                        required: true,
                        validator: this.priceValidator
                    },
                    content: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.content')})
                    },
                    visibility: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.visibility')})
                    },
                    tenant_name: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.contact_name')})
                    },
                    tenant_phone: {
                        required: true,
                        message: this.$t('validation.required',{attribute: this.$t('tenant.contact_phone')})
                    }
                }
            }
        },
        methods: {
            submit () {
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        this.loading = true;

                        const {price, media, tenant_name, tenant_phone, ...params} = this.model

                        params.price = `${price.integer}.${price.decimals}`
                        params.contact = `${tenant_name} - ${tenant_phone}`
                        params.id = this.data.id

                        const resp = await this.$store.dispatch('newProducts/update', params);
                        
                        if (resp && resp.data) {                            
                            if (this.model.media.length) {
                            // TODO - make await for this   
                                this.product_id = this.data.id;            
                                this.$refs.media.startUploading();
                                this.$root.$on('media-upload-finished', () => this.$emit('update:visible', false));
                            }
                        }
                        

                        this.loading = false
                        this.$refs.form.resetFields()
                        if(!this.model.media.length)
                            this.$emit('update:visible', false);
                        // this.$refs.media.clearUploader()
                    }
                })
            },
            priceValidator (rule, value, callback) {
                const integer = +(value.integer || undefined)
                const decimals = +(value.decimals || undefined)

                if (!isNaN(integer) &&
                    !isNaN(decimals) &&
                    integer % 1 === 0 &&
                    decimals % 1 === 0 &&
                    decimals >= 0 && decimals <= 99 &&
                    integer >= 0 && integer <= Number.MAX_SAFE_INTEGER
                ) {
                    callback()
                } else {
                    callback(new Error('The price is invalid'))
                }
            }
        },
        computed: {
            isPriceVisible () {
                return this.model.type != (Object.values(this.$constants.products.type).find(name => name === 'giveaway') || [])[0]
            }
        },
        created () {
            this.model.title = this.data.title;
            this.model.type = this.data.type;
            this.model.visibility = this.data.visibility;
            this.model.content = this.data.content;

            const {first_name, last_name, mobile_phone} = this.$store.getters.loggedInUser.tenant

            this.model.tenant_phone = mobile_phone
            this.model.tenant_name = `${first_name} ${last_name}`

            this.model.price.integer = this.data.price.split(".")[0]
            this.model.price.decimals = this.data.price.split(".")[1]
            this.types = Object.entries(this.$constants.products.type).map(([value, label]) => ({value: +value, label}))
            this.visibilities = Object.entries(this.$constants.products.visibility).map(([value, label]) => ({value: +value, label}))

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