export default {
    namespaced: true,
    state: {
        data: []
    },
    actions: {
        async get ({state, commit}, {id, ...params} = {}) {
            const {data} = await this._vm.axios.get(id ? `products/${id}` : 'products', {params})

            commit('set', data.data)
        },
        async create ({state, commit}, params) {
            const {data} = await this._vm.axios.post('products', params, {showMessage: true})
            const newData = state

            newData.data.unshift(data.data)

            commit('set', newData)
        },
        async update ({commit}, {id, ...params}) {
            const {data} = await this._vm.axios.put(`products/${id}`, params, {showMessage: true})

            commit('update', data.data)
        },
        async delete ({commit}, {id}) {
            await this._vm.axios.delete(`products/${id}`, {showMessage: true})

            commit('delete', id)
        },
        async like ({commit, getters}, {id}) {
            const {data} = await this._vm.axios.post(`products/${id}/like`)
            const newData = getters.getById(id)

            Object.assign(newData, {
                liked: true,
                likes: newData.likes.concat([data.data]),
                likes_count: newData.likes_count + 1
            })

            commit('update', newData)
        },
        async unlike ({commit, getters}, {id}) {
            const {data} = await this._vm.axios.post(`products/${id}/unlike`)
            const newData = getters.getById(id)

            Object.assign(newData, {
                liked: false,
                likes: newData.likes.filter(user => user.id !== data.data.id),
                likes_count: newData.likes_count - 1
            })

            commit('update', newData)
        },
        async publish ({commit}) {
            const {data} = await this._vm.axios.post(`products/${id}/publish`, params, {showMessage: true})

            commit('update', data.data)
        },
        async uploadMedia ({commit}, {id, ...params}) {
            await this._vm.axios.post(`products/${id}/media`, params)
        },
        async deleteMedia ({commit}, {id, media_id}) {
            await this._vm.axios.delete(`products/${id}/media/${media_id}`)
        }
    },
    getters: {
        getById: ({data}) => id => data.find(product => product.id === id)
    },
    mutations: {
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
        }
    }
}