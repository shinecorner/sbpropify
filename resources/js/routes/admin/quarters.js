import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'quarters',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminQuarters',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/quarters/index" */ 'views/Admin/Quarters'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.quarter)]),
        meta: {
            title: 'Quarters'
        }
    }, {
        name: 'adminQuartersAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/quarters/add" */ 'views/Admin/Quarters/Add'),
        //beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.quarter)]),
        meta: {
            title: 'Add quarter'
        }
    }, {
        name: 'adminQuartersEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/quarters/edit" */ 'views/Admin/Quarters/Edit'),
        //beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.quarter)]),
        meta: {
            title: 'Edit quarter'
        }
    }]
}];