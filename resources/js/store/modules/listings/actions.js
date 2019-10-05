import axios from '@/axios';
import {buildFetchUrl} from 'helpers/url';

export default {
    getListings({commit}, payload) {
        return new Promise((resolve, reject) =>
            axios.get(buildFetchUrl('listings', payload))
                .then(({data: r}) => (r && commit('SET_LISTINGS', r.data), resolve(r)))
                .catch(({response: {data: err}}) => reject(err)));
    },
    getListing(_, {id}) {
        return new Promise((resolve, reject) =>
            axios.get(`listings/${id}`)
                .then(({data: r}) => resolve(r.data))
                .catch(({response: {data: err}}) => reject(err)));
    },
    createListing(_, payload) {
        return new Promise((resolve, reject) =>
            axios.post('listings', payload)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    updateListing(_, {id, ...restPayload}) {
        return new Promise((resolve, reject) =>
            axios.put(`listings/${id}`, restPayload)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    deleteListing(_, {id}) {
        return new Promise((resolve, reject) =>
            axios.delete(`listings/${id}`)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    deleteListingWithIds({}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(`listings/deletewithids`, {ids: _.map(payload, 'id')}).then((resp) => {
                resolve(resp.data);
            }).catch(({response: {data: err}}) => reject(err))
        });
    },
    likeListing(_, id) {
        return new Promise((resolve, reject) =>
            axios.post(`listings/${id}/like`)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    unlikeListing(_, id) {
        return new Promise((resolve, reject) =>
            axios.post(`listings/${id}/unlike`)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    changeListingPublish(_, {id, ...body}) {
        return new Promise((resolve, reject) =>
            axios.post(`listings/${id}/publish`, body)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    uploadListingMedia(_, {id, ...restPayload}) {
        return new Promise((resolve, reject) =>
            axios.post(`listings/${id}/media`, restPayload)
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    deleteListingMedia({}, {id, media_id}) {
        return new Promise((resolve, reject) => {
            axios.delete(`listings/${id}/media/${media_id}`).then((resp) => {
                resolve(resp.data);
            }).catch((error) => {
                reject(error.response.data);
            });
        });
    }
}
