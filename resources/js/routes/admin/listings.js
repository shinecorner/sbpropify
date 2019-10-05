import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'listings',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminListings',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/listings/index" */ 'views/Admin/Listings'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.listing)]),
        meta: {
            title: 'Listings'
        }
    }, {
        name: 'adminListingsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/listings/edit" */ 'views/Admin/Listings/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.listing)]),
        meta: {
            title: 'Edit Listing'
        }
    }]
}]