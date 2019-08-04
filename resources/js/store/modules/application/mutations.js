export default {
    SET_CONSTANTS(state, payload) {
        state.constants = payload
    },
    SET_AUDITS(state, {id, type, data}) {
        if (id) {
            state.audits[type][id] = data
        } else {
            state.audits[type] = data
        }
    }
}