import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'request-categories',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminRequestCategories',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/requestCategories/index" */ 'views/Admin/RequestCategories'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.requestCategory)]),
        meta: {
            title: 'Request Categories'
        }
    }]
}]