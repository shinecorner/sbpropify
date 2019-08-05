import axios from '@/axios';
export default (config = {}) => {
    const {model = 'model'} = config;
    return {
        methods: {
            checkavailabilityEmail(rule, value, callback) {
                let validateObject = this[model];
                if(this.origin_email !== validateObject.email) {
                    axios.get('http://localhost:8000/api/v1/users/check-email?email=' + validateObject.email)
                        .then(({data: r}) => {callback(new Error(r.message))})
                        .catch(err => {callback();});
                }
            }
        }
    }  
};