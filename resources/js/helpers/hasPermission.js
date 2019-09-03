import store from '@/store'

export default permissions => {
    const flattenPermissions = array => array.reduce((flat, toFlatten) => {
        return flat.concat(toFlatten.perms ? flattenPermissions(toFlatten.perms) : toFlatten)
    }, [])

    const userPermissions = flattenPermissions(store.getters.loggedInUser.roles).map(({name}) => name)

    if (Array.isArray(permissions)) {
        return permissions.some(name => userPermissions.includes(name)) // ?? every/some
    } else if (typeof permissions === 'string') {
        return userPermissions.includes(permissions)
    }

    return false
}