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
            const {data} = await this._vm.axios.get(id ? `listings/${id}` : 'listings', {params})

            commit('set', data.data)
        },
        async create ({state, commit}, params) {
            const {data} = await this._vm.axios.post('listings', params, {showMessage: true})
            const newData = state

            newData.data.unshift(data.data)                        
            commit('set', newData)
            return data;
        },
        async update ({commit}, {id, ...params}) {
            const {data} = await this._vm.axios.put(`listings/${id}`, params, {showMessage: true})

            commit('update', data.data)
            return data;
        },
        async delete ({commit}, {id}) {
            await this._vm.axios.delete(`listings/${id}`, {showMessage: true})

            commit('delete', id)
        },
        async like ({commit, getters}, {id}) {
            const {data} = await this._vm.axios.post(`listings/${id}/like`)
            const newData = getters.getById(id)

            Object.assign(newData, {
                liked: true,
                likes: newData.likes.concat([data.data]),
                likes_count: newData.likes_count + 1
            })

            commit('update', newData)
        },
        async unlike ({commit, getters}, {id}) {
            const {data} = await this._vm.axios.post(`listings/${id}/unlike`)
            const newData = getters.getById(id)

            Object.assign(newData, {
                liked: false,
                likes: newData.likes.filter(user => user.id !== data.data.id),
                likes_count: newData.likes_count - 1
            })

            commit('update', newData)
        },
        async publish ({commit}) {
            const {data} = await this._vm.axios.post(`listings/${id}/publish`, params, {showMessage: true})

            commit('update', data.data)
        },
        async uploadMedia ({commit}, {id, ...params}) {
            await this._vm.axios.post(`listings/${id}/media`, params)
        },
        async deleteMedia ({commit}, {id, media_id}) {
            await this._vm.axios.delete(`listings/${id}/media/${media_id}`)
        },
        async addMedia({ commit}, {id, media}) {
            commit('addmedia', {data_id : id, media})
        },
    },
    getters: {
        getById: ({data}) => id => data.find(listing => listing.id === id)
    },
    mutations: {
        reset: state => Object.assign(state, {
            data: []
        }),
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