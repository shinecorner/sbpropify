import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'units',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminUnits',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/units/index */ 'views/Admin/Units'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.unit)]),
        meta: {
            title: 'Units'
        }
    }, {
        name: 'adminUnitsAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/units/add" */ 'views/Admin/Units/Add'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.unit)]),
        props: {
            title: 'Add units'
        },
        meta: {
            title: 'Add Unit'
        }
    }, {
        name: 'adminUnitsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/units/edit" */ 'views/Admin/Units/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.unit)]),
        props: {
            title: 'Edit units'
        },
        meta: {
            title: 'Edit Unit'
        }
    }]
}]