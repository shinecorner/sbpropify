export default {
    namespaced: true,
    state: {
        data: []
    },
    actions: {
        async get ({state, commit}, params) {
            const {data} = await this._vm.axios.get('notifications', {params})

            if (state.data.length) {
                const {data: items, ...rest} = data.data

                commit('set', {
                    data: [
                        ...state.data,
                        ...items
                    ],
                    ...rest
                })
            } else {
                commit('set', data.data)
            }
        },
        async mark ({commit}, {id, ...params}) {
            const {data} = await this._vm.axios.post(id ? `notifications/${id}` : 'notifications', {params})

            commit('mark', data.data)
        }
    },
    getters: {
        read: state => state.data.filter(({read_at}) => read_at),
        unread: state => state.data.filter(({read_at}) => !read_at)
    },
    mutations: {
        set: (state, payload) => Object.assign(state, payload),
        mark: (state, payload) => Object.assign(state.data.find(notification => payload.id === notification.id), payload)
    }
}