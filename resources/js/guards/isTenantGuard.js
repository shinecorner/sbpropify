import store from 'store'

export default (to, from, next) => store.getters.loggedInUser.roles.findIndex(({name}) => name === 'registered') > -1 ? next() : next({name: 'adminDashboard'})