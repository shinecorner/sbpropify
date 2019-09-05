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
                quarter_format: '',
                validationRules: {
                    name: [{
                        required: true,
                        message: this.$t('models.quarter.required')
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
                    ...mapActions(['createQuarter']),
                    async saveQuarter() {
                        const resp = await this.createQuarter(this.model);
                        return resp;
                    },
                    async submit(afterValid = false) {
                        const valid = await this.form.validate();
                        if (valid) {
                            this.loading.state = true;
                            try {
                                const resp = await this.saveQuarter();
                                displaySuccess(resp);
                                
                                this.form.resetFields();
                                if (!!afterValid) {
                                    afterValid(resp);
                                } else {
                                    this.$router.push({
                                        name: 'adminQuartersEdit',
                                        params: {id: response.data.id}
                                    })
                                }
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
                    ...mapActions(['getQuarter', 'updateQuarter']),
                    async fetchCurrentQuarter() {
                        const resp = await this.getQuarter({id: this.$route.params.id});
                        
                        this.model.id = resp.id;
                        this.model.name = resp.name;
                        this.model.description = resp.description;
                        this.quarter_format = resp.quarter_format;
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
                                    const resp = await this.updateQuarter(this.model);                                    
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
                    await this.fetchCurrentQuarter();
                    this.loading.state = false;
                };

                break;
        }
    }

    return mixin;
}