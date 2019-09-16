
export default {
    namespaced: true,
    state: {
        data: []
    },
    actions: {
        reset ({commit}) {
            commit('reset')
        },
        async get ({state, commit}, {id, ...params} = {}) {
            const {data} = await this._vm.axios.get(id ? `posts/${id}` : 'posts', {params})
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
                let newData = state;
                newData.data.push(data.data)
                commit('set', data.data)
            }
        },
        async create ({state, commit}, params) {
            const {data} = await this._vm.axios.post('posts', params, {showMessage: true})
            const newData = state

            newData.data.unshift(data.data)

            commit('set', newData)
            return data;
        },
        async update ({commit}, {id, ...params}) {
            const {data} = await this._vm.axios.put(`posts/${id}`, params, {showMessage: true})

            commit('update', data.data)
        },
        async delete ({commit}, {id}) {
            await this._vm.axios.delete(`posts/${id}`, {showMessage: true})

            commit('delete', id)
        },
        async publish ({commit}, {id, ...params}) {
            const {data} = await this._vm.axios.post(`posts/${id}/publish`, params)

            commit('update', data.data)
        },
        async like ({commit, getters}, {id}) {
            const {data} = await this._vm.axios.post(`posts/${id}/like`)
            // const newData = getters[TYPES.getters.getById](id)
            const newData = getters.getById(id)
            
            Object.assign(newData, {
                liked: true,
                likes: newData.likes.concat([data.data]),
                likes_count: newData.likes_count + 1
            })

            commit('update', newData)
        },
        async unlike ({commit, getters}, {id}) {
            const {data} = await this._vm.axios.post(`posts/${id}/unlike`)
            // const newData = getters[TYPES.getters.getById](id)
            const newData = getters.getById(id)

            Object.assign(newData, {
                liked: false,
                likes: newData.likes.filter(user => user.id !== data.data.id),
                likes_count: newData.likes_count - 1
            })

            commit('update', newData)
        },
        async assignBuilding ({commit}, {id, buildingId}) {
            const {data} = await this._vm.axios.post(`posts/${id}/buildings/${buildingId}`)

            commit('update', data.data)
        },
        async unassignBuilding ({commit}, {id, buildingId}) {
            const {data} = await this._vm.axios.delete(`posts/${id}/buildings/${buildingId}`)

            commit('update', data.data)
        },
        async assignQuarter ({commit}, {id, quarterId}) {
            const {data} = await this._vm.axios.post(`posts/${id}/quarters/${quarterId}`)

            commit('update', data.data)
        },
        async unassignQuarter ({commit}, {id, quarterId}) {
            const {data} = await this._vm.axios.delete(`posts/${id}/quarters/${quarterId}`)

            commit('update', data.data)
        },
        async assignProvider ({commit}, {id, providerId}) {
            const {data} = await this._vm.axios.post(`posts/${id}/providers/${providerId}`)

            commit('update', data.data)
        },
        async unassignProvider ({commit}, {id, providerId}) {
            const {data} = await this._vm.axios.delete(`posts/${id}/providers/${providerId}`)

            commit('update', data.data)
        },
        async getComments ({commit}, {parent_id, ...params}) {
            const {data} = await this._vm.axios.get('comments', {params})
        },
        async addMedia({ commit}, {id, media}) {
            commit('addmedia', {data_id : id, media})
        },
    },
    getters: {
        getById: ({data}) => id => data.find(item => item.id === id)
    },
    mutations: {
        reset: state => state = {
            data: []
        },
        set: (state, payload) => Object.assign(state, payload),
        update: ({data}, payload) => Object.assign(data.find(({id}) => id === payload.id), payload),
        delete: ({data}, id) => {
            let i = data.length

            while (i--) {
                if (id === data[i].id) {
                    data.splice(i, 1)

                    break
                }
            }
        },
        addmedia: ({data}, {data_id, media}) => {
            let item = data.find(({id}) => id === data_id)
            if(!item.media)
                item.media = [];
            item.media.push(media);
        }
    }
}