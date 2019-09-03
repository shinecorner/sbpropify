import axios from '@/axios'
import VApi from 'vuex-rest-api'

export const TYPES = {
    actions: {
        getConstants: 'getConstants',
    },
    mutations: {
        setConstants: 'setConstants'
    },
    getters: {
        getConstants: 'constants', //temporary name
    }
}

export default {
    state: {
        constants: {},
        locale: ''
    },
    actions: {
        setLocale ({commit}, locale) {
            commit('setLocale', locale)
        },
        async [TYPES.actions.getConstants] ({commit}) {
            const {data} = await this._vm.axios.get('constants')

            commit(TYPES.mutations.setConstants, data.data)
        }
    },
    mutations: {
        setLocale: (state, locale) => state.locale = locale,
        [TYPES.mutations.setConstants]: ({constants}, payload) => Object.assign(constants, payload)
    },
    getters: {
        [TYPES.getters.getConstants]: ({constants}) => constants
    }
}

// const Store = new VApi({
//         axios
//     })
//     .get({
//         path: 'constants',
//         property: 'constants',
//         action: 'getConstants',
//         onSuccess (state, {data}) {
//             state.constants = data.data
//         }
//     })
//     .getStore()

// Store.getters = {
//     constants: ({constants}) => constants
// }

// export default Store
