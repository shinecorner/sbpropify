import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantRequests',
    path: 'requests',
    component: () => import ( /* webpackChunkName: "tenant/requests/index" */ 'views/Tenant/Requests/index'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: this.$t('tenant.requests')
    }
}