import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantPropertyManagers',
    path: 'property-managers',
    component: () => import ( /* webpackChunkName: "tenant/propertyManagers/index" */ 'views/Tenant/PropertyManagers'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: 'Property managers'
    },
}
