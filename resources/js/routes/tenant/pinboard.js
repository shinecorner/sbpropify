import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    path: 'pinboard',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'tenantPinboards',
        path: '/',
        component: () => import ( /* webpackChunkName: "tenant/pinboard/index" */ 'views/Tenant/Pinboard'),
        meta: {
            title: 'Pinboards'
        }
    }, {
        name: 'tenantPinboard',
        path: ':id',
        component: () => import ( /* webpackChunkName: "tenant/pinboard/detail" */ 'views/Tenant/Pinboard/Detail'),
        meta: {
            title: 'Pinboard'
        }
    }],
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
}