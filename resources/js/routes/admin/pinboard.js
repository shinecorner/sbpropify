import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'pinboard',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminPinboard',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/pinboard/index" */ 'views/Admin/Pinboard'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.pinboard)]),
        meta: {
            title: 'Pinboard'
        }
    }, {
        name: 'adminPinboardAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/pinboard/add" */ 'views/Admin/Pinboard/Add'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.pinboard)]),
        meta: {
            title: 'Add Pinboard'
        }
    }, {
        name: 'adminPinboardEdit',
        path: ':type/:id',
        component: () => import ( /* webpackChunkName: "admin/pinboard/edit" */ 'views/Admin/Pinboard/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.pinboard)]),
        meta: {
            title: 'Edit Pinboard'
        }
    }]
}]