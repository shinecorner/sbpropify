import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantListing',
    path: 'listing',
    component: () => import ( /* webpackChunkName: "tenant/listing/index" */ 'views/Tenant/Listing'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: 'Listing'
    }
}