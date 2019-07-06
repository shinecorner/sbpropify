<template>
    <el-form ref="form" class="add-product" :model="model" label-position="top" v-loading="loading">
        <el-form-item prop="title" label="Title" required>
            <el-input v-model="model.title" />
        </el-form-item>
        <el-row type="flex">
            <el-col>
                <el-form-item prop="type" label="Type" required>
                    <el-select v-model="model.type">
                        <el-option v-for="category in types" :key="category.value" :label="category.label" :value="category.value" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col v-if="canShowPrice">
                <el-form-item prop="price" label="Price" required>
                    <el-input v-model="model.price" />
                </el-form-item>
            </el-col>
             <el-col>
                <el-form-item prop="visibility" label="Visibility" required>
                    <el-select v-model="model.visibility">
                        <el-option v-for="visibility in visibilities" :key="visibility.value" :label="visibility.label" :value="visibility.value" />
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>
        <el-form-item prop="content" label="Content" required>
            <el-input type="textarea" resize="none" v-model="model.content" :autosize="{minRows: 2, maxRows: 6}" />
        </el-form-item>
        <el-row type="flex">
            <el-col>
                <el-form-item prop="tenant_name" label="Contact name" required>
                    <el-input v-model="model.tenant_name" />
                </el-form-item>
            </el-col>
            <el-col>
                <el-form-item prop="tenant_phone" label="Contact phone" required>
                    <el-input v-model="model.tenant_phone" />
                </el-form-item>
            </el-col>
        </el-row>
        <media-upload ref="upload" extensions="image/jpeg,image/png" v-model="model.media" :cols="5" />
        <el-form-item v-if="showSubmit">
            <el-button class="submit" type="primary" @click="submit">Save</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import {displaySuccess, displayError} from 'helpers/messages';
    import MediaUpload from 'components/MediaUpload'

    export default {
        props: {
            showSubmit: {
                type: Boolean,
                default: false
            }
        },
        components: {
            MediaUpload
        },
        data () {
            const {first_name, last_name, mobile_phone} = this.$store.getters.loggedInUser.tenant

            return {
                model: {
                    title: '',
                    price: '',
                    type: '',
                    visibility: '',
                    content: '',
                    tenant_name: `${first_name} ${last_name}`,
                    tenant_phone: mobile_phone,
                    media: [],
                },
                types: [],
                loading: false
            }
        },
        methods: {
            submit () {
                this.form.validate(async valid => {
                    if (valid) {
                        try {
                            this.loading = true;

                            const {media, tenant_name, tenant_phone, ...params} = this.model;

                            params.contact = `${tenant_name} - ${tenant_phone}`

                            const {data} = await this.$store.dispatch('products2/create', params);

                            displaySuccess(data);

                            if (this.model.media.length) {
                                let promises = media.map(({file}) => this.$store.dispatch('media/upload', {
                                    id: data.data.id,
                                    media: file.src,
                                    type: 'products'
                                }));

                                await Promise.all(promises);
                            }

                            this.form.resetFields();
                            this.$refs.upload.clear();
                        } catch (err) {
                            displayError(err);
                        } finally {
                            this.loading = false;
                        }
                    }
                });
            }
        },
        computed: {
            form () {
                return this.$refs.form;
            },
            canShowPrice () {
                return this.model.type !== 4
            }
        },
        created () {
            this.types = Object.entries(this.$constants.products.type).map(([value, label]) => ({value: +value, label}))
            this.visibilities = Object.entries(this.$constants.products.visibility).map(([value, label]) => ({value: +value, label}))
            
            if (this.types.length) {
                this.model.type = this.types[0].value
            }

            if (this.visibilities) {
                this.model.visibility = this.visibilities[0].value
            }
        }
    };
</script>

<style lang="scss" scoped>
    .add-product {
        .el-row {
            .el-col:not(:last-of-type) {
                margin-right: 8px;
            }
        }
        .el-form-item {
            .el-select {
                width: 100%;
            }
        }
        .el-button.submit {
            margin-top: 1em;
        }
    }
</style>