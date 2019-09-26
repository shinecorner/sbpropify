import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantMarketplace',
    path: 'marketplace',
    component: () => import ( /* webpackChunkName: "tenant/marketplace/index" */ 'views/Tenant/Marketplace'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: 'Marketplace'
    }
}