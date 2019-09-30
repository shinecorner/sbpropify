// TODO - will eventually replace the old "products"
import * as types from './types'
import queryString from 'query-string'

export default {
    async fetch ({commit}, params = {}) {
        const {id, ...restParams} = params

        if (Object.keys(restParams).length) {
            restParams = '?' + Object.entries(restParams).map(pair => pair.map(encodeURIComponent).join('=')).join('&')
        }

        const {data} = await this._vm.axios.get(id ? `pinboard/${id}` : 'pinboard' + restParams)

        commit(types.FETCH, data)
    },
    async get ({commit}, payload = {}) {
        try {
            const {id, ...restPayload} = payload

            let request = id ? `pinboard/${id}`: 'pinboard'

            if (Object.keys(restPayload).length) {
                request += '?' + queryString.stringify(restPayload)
            }

            const {data} = await this._vm.axios.get(request)

            commit('set', data.data)

            return Promise.resolve(data)
        } catch (err) {
            return Promise.reject(err)
        }
    },
    // async create ({commit}, payload) {
    //     try {
    //         const data = await axios.post('products', payload)

    //         commit('SAVE', data.data)

    //         return Promise.resolve(data)
    //     } catch (err) {
    //         return Promise.reject(err)
    //     }
    // },
    // async update ({commit}, {id, ...payload}) {
    //     try {
    //         const data = await axios.put(`products/${id}`, payload)

    //         commit('UPDATE', data)

    //         return Promise.resolve(data)
    //     } catch (err) {
    //         return Promise.reject(err)
    //     }
    // },
    // async delete ({commit}, {id}) {
    //     try {
    //         const data = await axios.delete(`products/${id}`)

    //         commit('DELETE', data.data)

    //         return Promise.resolve(data)
    //     } catch (err) {
    //         return Promise.reject(err)
    //     }
    // }
}