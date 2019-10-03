import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'tenants',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminTenants',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/tenants/index" */ 'views/Admin/Tenants'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.tenant)]),
        meta: {
            title: 'Tenants'
        }
    }, {
        name: 'adminTenantsAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/tenants/add" */ 'views/Admin/Tenants/Add'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.tenant)]),
        props: {
            title: 'Add tenant'
        },
        meta: {
            title: 'Add Tenant'
        }
    }, {
        name: 'adminTenantsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/tenants/editNew" */ 'views/Admin/Tenants/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.tenant)]),
        props: {
            title: 'Edit tenant'
        },
        meta: {
            title: 'Edit Tenant'
        }
    }, {
        path: ':id',
        name: 'adminTenantsEdit2',
        component: () => import ( /* webpackChunkName: "admin/tenants/edit" */ 'views/Admin/Tenants/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.tenant)]),
        props: {
            title: 'Edit tenant'
        },
        meta: {
            title: 'Edit Tenant'
        }
    }, {
        path: ':id/view',
        name: 'adminTenantsView',
        component: () => import ( /* webpackChunkName: "admin/tenants/view" */ 'views/Admin/Tenants/view'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.view.tenant)]),
        props: {
            title: 'View tenant'
        },
        meta: {
            title: 'View Tenant'
        }
    }]
}]