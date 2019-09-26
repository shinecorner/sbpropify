import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantSettings',
    path: 'settings',
    component: () => import ( /* webpackChunkName: "tenant/settings/index" */ 'views/Tenant/Settings'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: 'Settings'
    }
}