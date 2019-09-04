import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'districts',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminDistricts',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/districts/index" */ 'views/Admin/Districts'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.district)]),
        meta: {
            title: 'Districts'
        }
    }, {
        name: 'adminDistrictsAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/districts/add" */ 'views/Admin/Districts/Add'),
        // beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.edit.district)]),
        meta: {
            title: 'Add district'
        }
    }, {
        name: 'adminDistrictsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/districts/edit" */ 'views/Admin/Districts/Edit'),
        // beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.add.district)]),
        meta: {
            title: 'Edit district'
        }
    }]
}];