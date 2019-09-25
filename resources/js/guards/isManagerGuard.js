import store from 'store'

export default (to, from, next) => store.getters.loggedInUser.roles.findIndex(({name}) => name === 'manager') == -1 ? next() : next({name: 'adminBuildings'})

