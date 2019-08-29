import axios from '@/axios';
import {buildFetchUrl} from 'helpers/url';

export default {
    getTags({commit}, payload) {
        console.log(payload);
        return new Promise((resolve, reject) =>
            axios.get(buildFetchUrl('tags', payload))
                .then(({data: r}) => (r && commit('SET_TAGS', r.data), resolve(r)))
                .catch(({response: {data: err}}) => reject(err)));
    },
}