import axios from '@/axios';
import {buildFetchUrl} from 'helpers/url';

export default {
    getServices({commit}, payload) {
        return new Promise((resolve, reject) =>
            axios.get(buildFetchUrl('services', payload))
                .then(({data: r}) => (r && commit('SET_SERVICES', r.data), resolve(r)))
                .catch(({response: {data: err}}) => reject(err)));
    },
    getServicesGroupedByCategory({commit}, payload) {
        return new Promise((resolve, reject) =>
            axios.get('services/category')
                .then(({data: r}) => resolve(r))
                .catch(({response: {data: err}}) => reject(err)));
    },
    createService({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios.post('services', payload).then((response) => {
                resolve(response.data);
            }).catch(({response: {data: err}}) => reject(err));
        });
    },
    updateService({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios.put(`services/${payload.id}`, payload).then((response) => {
                resolve(response.data);
            }).catch(({response: {data: err}}) => reject(err));
        });
    },
    getService({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(`services/${payload.id}`).then((response) => {
                resolve(response.data);
            }).catch(({response: {data: err}}) => reject(err));
        });
    },
    deleteService({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios.delete(`services/${payload.id}`).then((response) => {
                resolve(response.data)
            }).catch(({response: {data: err}}) => reject(err))
        })
    },
    deleteServiceWithIds({}, payload) {        
        return new Promise((resolve, reject) => {
            axios.post(`services/deletewithids`, {ids: _.map(payload, 'id')}).then((resp) => {                
                resolve(resp.data);
            }).catch(({response: {data: err}}) => reject(err))
        });
    },
    assignServiceQuarter({}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(`services/${payload.id}/quarters/${payload.toAssignId}`, {}).then((resp) => {
                resolve(resp.data);
            }).catch(({response: {data: err}}) => reject(err))
        });
    },
    assignServiceBuilding({}, payload) {
        return new Promise((resolve, reject) => {
            axios.post(`services/${payload.id}/buildings/${payload.toAssignId}`, {}).then((resp) => {
                resolve(resp.data);
            }).catch(({response: {data: err}}) => reject(err))
        });
    },
    unassignServiceBuilding({}, payload) {
        return new Promise((resolve, reject) => {
            axios.delete(`services/${payload.id}/buildings/${payload.toAssignId}`).then((response) => {
                resolve(response.data)
            }).catch(({response: {data: err}}) => reject(err))
        })
    },
    unassignServiceQuarter({}, payload) {
        return new Promise((resolve, reject) => {
            axios.delete(`services/${payload.id}/quarters/${payload.toAssignId}`).then((response) => {
                resolve(response.data)
            }).catch(({response: {data: err}}) => reject(err))
        })
    },
    getServiceAssignments({}, payload) {
        return new Promise((resolve, reject) => {
            axios.get(buildFetchUrl(`services/${payload.provider_id}/locations`, payload)).then((response) => {
                response.data.data.data = response.data.data.data.map((building) => {
                    if (building.type === 'building') {
                        building.aType = 1;
                        building.assignmentType = 'building';
                    } else {
                        building.aType = 2;
                        building.assignmentType = 'quarter';
                    }
                    return building;
                });
                resolve(response.data);
            }).catch(({response: {data: err}}) => reject(err));
        });
    }
}
