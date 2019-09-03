import hasPermission from 'guards/hasPermissionGuard'
import isAdmin from 'guards/isAdminGuard'
import isAuthenticated from 'guards/isAuthenticatedGuard'
import isGuest from 'guards/isGuestGuard'
import isTenant from 'guards/isTenantGuard'

export const hasPermissionGuard = hasPermission
export const isAdminGuard = isAdmin
export const isAuthenticatedGuard = isAuthenticated
export const isGuestCard = isGuest
export const isTenantGuard = isTenant