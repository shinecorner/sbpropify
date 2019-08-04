import axios from '@/axios'
import queryString from 'query-string'

export default {
    async constants({commit}) {
        const {data} = await axios.get('constants')

        commit('SET_CONSTANTS', data.data)
    },
    async fetchAudits({commit}, {
        auditable_id,
        auditable_type,
        ...restPayload
    }) {
        const {data} = await axios.get(`audits?${queryString.stringify({
            auditable_id,
            auditable_type,
            ...restPayload
        })}`)

         commit('SET_AUDITS', {
            id: auditable_id,
            type: auditable_type,
            data: data.data
        })
    }
}