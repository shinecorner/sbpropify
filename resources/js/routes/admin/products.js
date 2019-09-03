import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'products',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminProducts',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/products/index" */ 'views/Admin/Products'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.product)]),
        meta: {
            title: 'Products'
        }
    }, {
        name: 'adminProductsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/products/edit" */ 'views/Admin/Products/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.product)]),
        meta: {
            title: 'Edit Product'
        }
    }]
}]