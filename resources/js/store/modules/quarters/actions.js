import axios from '@/axios';
import {buildFetchUrl} from 'helpers/url';

export default {
    getQuarters({commit}, payload) {
        return new Promise((resolve, reject) =>
            axios.get(buildFetchUrl('quarters', payload))
                .then(({data: r}) => (r && commit('SET_QUARTERS', r.data), resolve(r)))
                .catch(({response: {data: err}}) => reject(err)));
    },
    getQuarter(_, {id}) {
        return new Promise((resolve, reject) =>
            axios.get(`quarters/${id}`)
                .then(({data: r}) => resolve(r.data))
                .catch(({response: {data: err}}) => reject(err)));
    },
    createQuarter(_, payload) {
        return new Promise((resolve, reject) =>
            axios.post('quarters', payload)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    updateQuarter(_, {id, ...restPayload}) {
        return new Promise((resolve, reject) =>
            axios.put(`quarters/${id}`, restPayload)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    deleteQuarter(_, {id}) {
        return new Promise((resolve, reject) =>
            axios.delete(`quarters/${id}`)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    deleteQuarterWithIds({}, payload) {        
        return new Promise((resolve, reject) => {
            axios.post(`quarters/deletewithids`, {ids: _.map(payload, 'id')}).then((resp) => {                
                resolve(resp.data);
            }).catch(({response: {data: err}}) => reject(err))
        });
    }
}
