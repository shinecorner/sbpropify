import axios from '@/axios';
export default (config = {}) => {
    const {model = 'model'} = config;
    return {
        methods: {
            async checkavailabilityEmail(rule, value, callback) {
                let validateObject = this[model];
                
                if(this.original_email !== validateObject.email) {
                    try {
                        const resp = await axios.get('users/check-email?email=' + validateObject.email);                 
                    } catch(error) {
                        if(error.response.data.success == false) {
                            callback(new Error(error.response.data.message));
                        }
                    }
                }
            }
        }
    }  
};