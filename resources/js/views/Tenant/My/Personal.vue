<template>
    <placeholder :size="256" :src="require('img/5d0672abb48ed.png')" v-if="!model && !loading.visible">
        No personal data available.
        <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</small>
    </placeholder>
    <div class="personal" v-else-if="model && !loading.visible">
        <heading icon="ti-book" :title="$t('tenant.personal_data')">
            <div slot="description" class="description">{{$t('tenant.my_personal_details')}}</div>
        </heading>
        <el-card ref="card" v-loading="loading.visible">
            <el-form :label-position="labelPosition" :model="model" label-width="144px" ref="form">
                <el-form-item :label="$t('tenant.title')" prop="title">
                    <el-select placeholder="Select title" v-model="model.title">
                        <el-option v-for="title in $constants.tenants.title" :key="title" :label="$t(`general.salutation_option.${title}`)" :value="title" />
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('tenant.company_name')" prop="company" v-if="model.title === 'company'">
                    <el-input type="text" v-model="model.company" />
                </el-form-item>
                <el-form-item :rules="validationRules.first_name" :label="$t('tenant.first_name')" prop="first_name">
                    <el-input type="text" v-model="model.first_name"/>
                </el-form-item>
                <el-form-item :rules="validationRules.last_name" :label="$t('tenant.last_name')" prop="last_name">
                    <el-input type="text" v-model="model.last_name"/>
                </el-form-item>
                <el-form-item :rules="validationRules.birth_date" :label="$t('tenant.birth_date')" prop="birth_date">
                    <el-date-picker format="dd.MM.yyyy" type="date" v-model="model.birth_date" value-format="yyyy-MM-dd" />
                </el-form-item>
                <el-form-item :label="$t('tenant.mobile_phone')" prop="mobile_phone">
                    <el-input type="text" v-model="model.mobile_phone"/>
                </el-form-item>
                <el-form-item :label="$t('tenant.work_phone')" prop="work_phone">
                    <el-input type="text" v-model="model.work_phone"/>
                </el-form-item>
                <el-form-item :label="$t('tenant.personal_phone')" prop="private_phone">
                    <el-input type="text" v-model="model.private_phone"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" icon="ti-save" :disabled="loading.visible" @click="submit">
                        {{$t('tenant.actions.save')}}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import Heading from 'components/Heading'
    import Placeholder from 'components/Placeholder'
    import unitTypes from 'mixins/methods/unitTypes'
    import {displayError, displaySuccess} from 'helpers/messages'
    import {ResponsiveMixin} from 'vue-responsive-components'

    export default {
        mixins: [
            unitTypes,
            ResponsiveMixin
        ],
        components: {
            Heading,
            Placeholder
        },
        data () {
            return {
                model: null,
                loading: {
                    visible: true
                },
                labelPosition: 'left',
                validationRules: {
                    first_name: [{
                        required: true,
                        message: this.$t('models.tenant.validation.first_name.required')
                    }],
                    last_name: [{
                        required: true,
                        message: this.$t('models.tenant.validation.last_name.required')
                    }],
                    birth_date: [{
                        required: true,
                        message: this.$t('models.tenant.validation.birth_date.required')
                    }]
                }
            }
        },
        methods: {
            getUnitType (type) {
                const {label} = this.unitTypes.find(unit => unit.type === type);

                return label
            },
            submit () {
                this.$refs.form.validate(async valid => {
                    if (!valid) {
                        return false
                    }

                    this.loading.visible = true

                    try {
                        // displaySuccess(await this.$store.dispatch('updateMyTenancy', this.model))
                    } catch (error) {
                        displayError(error)
                    } finally {
                        this.loading.visible = false
                    }
                })
            }
        },
        computed: {
            breakpoints () {
                return {
                    sm: el => {
                        if (el.width <= 640) {
                            console.log('y')
                            this.labelPosition = 'top'

                            return true
                        } else {
                            console.log('n')
                            this.labelPosition = 'left'

                            return false
                        }
                    }
                }
            }
        },
        async mounted () {
            this.loading = this.$loading({
                target: this.$el.parentElement,
                text: 'Fetching your personal data...'
            });

            try {
                const {data: {
                    title,
                    company,
                    first_name,
                    last_name,
                    birth_date,
                    mobile_phone,
                    work_phone,
                    private_phone
                }} = await this.$store.dispatch('myTenancy');

                this.model = {
                    title,
                    company,
                    first_name,
                    last_name,
                    birth_date,
                    mobile_phone,
                    work_phone,
                    private_phone
                }
            } catch (error) {
                displayError(error)
            } finally {
                this.loading.close()
            }
        }
    }
</script>

<style lang="scss" scoped>
    .personal {
        &:not(.empty):before {
            content: '';
            position: fixed;
            bottom: 0;
            right: 0;
            background-image: url('~img/5d0672abb48ed.png');
            background-repeat: no-repeat;
             background-attachment: fixed;
            background-position: 4em -8em;
            width: 100%;
            height: 100%;
            opacity: .16;
            pointer-events: none;
        }

        .heading {
            margin-bottom: 24px;
            
            .description {
                color: darken(#fff, 40%);
            }
        }

        .placeholder {
            font-size: 20px;
            color: var(--color-main-background-darker);

            small {
                font-size: 72%;
                color: var(--primary-color-lighter);
            }
        }

        .el-card {
            background-color: transparentize(#fff, .2);
            position: relative;
            max-width: 640px;

            .el-form {
                .el-form-item {
                    .el-button,
                    .el-select,
                    .el-date-editor {
                        width: 100%;
                    }
                    
                    :global(.el-input__inner),
                    :global(.el-textarea__inner) {
                        background-color: transparentize(#fff, .44);
                    }
                }
            }
        }
    }
</style>
