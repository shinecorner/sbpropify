import axios from '@/axios';
export default (config = {}) => {
    const {model = 'model'} = config;
    return {
        methods: {
            async checkavailabilityEmail(rule, value, callback) {
                let validateObject = this[model];
                if(this.original_email !== validateObject.email) {
                    try {
                        const resp =await axios.get('/users/check-email?email=' + validateObject.email)
                        if(resp)
                        {
                            callback(new Error(resp.data.message));
                        }                  
                    } catch {
                        callback();
                    }
                }
            }
        }
    }  
};