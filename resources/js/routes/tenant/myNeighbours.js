import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    name: 'tenantMyNeighbours',
    path: 'my-neighbours',
    component: () => import ( /* webpackChunkName: "tenant/myNeighbours/index" */ 'views/Tenant/MyNeighbours'),
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
    meta: {
        title: this.$t('tenant.my_neighbours')
    },
}
