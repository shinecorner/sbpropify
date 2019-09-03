import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'templates',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminTemplates',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/templates/index" */ 'views/Admin/Templates'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.template)]),
        meta: {
            title: 'Templates'
        }
    }, {
        name: 'adminTemplatesEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/templates/edit" */ 'views/Admin/Templates/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.template)]),
        props: {
            title: 'Edit template'
        },
        meta: {
            title: 'Edit Building'
        }
    }]
}]
