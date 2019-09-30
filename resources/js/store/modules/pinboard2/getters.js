export default {
    get (state) {
        return state
    },
    getById: state => id => state.data.find(pinboard => pinboard.id == id)
}