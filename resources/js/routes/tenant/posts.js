import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    path: 'news',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'tenantPosts',
        path: '/',
        component: () => import ( /* webpackChunkName: "tenant/posts/index" */ 'views/Tenant/Posts'),
        meta: {
            title: 'Posts'
        }
    }, {
        name: 'tenantPost',
        path: ':id',
        component: () => import ( /* webpackChunkName: "tenant/posts/detail" */ 'views/Tenant/Posts/Detail'),
        meta: {
            title: 'Post'
        }
    }],
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard]),
}