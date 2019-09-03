import hasPermission from 'helpers/hasPermission'

export default permission => (to, from, next) => hasPermission(permission) ? next() : next('/')