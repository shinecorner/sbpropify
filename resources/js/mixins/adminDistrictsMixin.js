import {mapActions} from 'vuex';
import {displayError, displaySuccess} from 'helpers/messages';

export default (config = {}) => {
    let mixin = {
        data() {
            return {
                model: {
                    id: '',
                    name: '',
                    description: '',
                    buildings: []
                },
                district_format: '',
                validationRules: {
                    name: [{
                        required: true,
                        message: this.$t('models.district.required')
                    }]
                },
                loading: {
                    state: false,
                    text: this.$t('general.please_wait')
                },
            }
        },
        computed: {
            form() {
                return this.$refs.form;
            },
        },
    };

    if (config.mode) {
        switch (config.mode) {
            case 'add':
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['createDistrict']),
                    async saveDistrict() {
                        const resp = await this.createDistrict(this.model);
                        return resp;
                    },
                    async submit() {
                        const valid = await this.form.validate();
                        if (valid) {
                            this.loading.state = true;
                            try {
                                const resp = await this.saveDistrict();

                                displaySuccess(resp);
                                return resp;
                            } catch (err) {
                                displayError(err);
                            } finally {
                                this.loading.state = false;
                            }
                        }
                    },
                };

                break;

            case 'edit':
                mixin.methods = {
                    ...mixin.methods,
                    ...mapActions(['getDistrict', 'updateDistrict']),
                    async fetchCurrentDistrict() {
                        const resp = await this.getDistrict({id: this.$route.params.id});
                        
                        this.model.id = resp.id;
                        this.model.name = resp.name;
                        this.model.description = resp.description;
                        this.district_format = resp.district_format;
                    },
                    submit() {
                        return new Promise((resolve, reject) => {
                            this.form.validate(async valid => {
                                if (!valid) {
                                    resolve(false);
                                    return false;
                                }

                                this.loading.state = true;
                                
                                try {
                                    const resp = await this.updateDistrict(this.model);                                    
                                    displaySuccess(resp);
                                    resolve(true);
                                } catch (err) {
                                    displayError(err);
                                    resolve(false);
                                } finally {
                                    this.loading.state = false;
                                }
                            });
                        });
                    },
                };

                mixin.created = async function () {
                    this.loading.state = true;
                    await this.fetchCurrentDistrict();
                    this.loading.state = false;
                };

                break;
        }
    }

    return mixin;
}