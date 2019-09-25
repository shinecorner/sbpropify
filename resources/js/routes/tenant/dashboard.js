import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantDashboard',
    path: 'dashboard',
    component: () => import ( /* webpackChunkName: "tenant/dashboard/index" */ 'views/Tenant/Dashboard'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: 'Dashboard'
    }
}