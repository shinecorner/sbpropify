import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'cleanifyRequest',
    path: 'cleanify',
    component: () => import ( /* webpackChunkName: "tenant/cleanify/index" */ 'views/Tenant/Cleanify'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: 'Cleanify'
    },
}
