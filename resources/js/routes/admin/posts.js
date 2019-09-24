import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'posts',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminPosts',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/posts/index" */ 'views/Admin/Posts'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.post)]),
        meta: {
            title: 'Posts'
        }
    }, {
        name: 'adminPostsAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/posts/add" */ 'views/Admin/Posts/Add'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.post)]),
        meta: {
            title: 'Add Post'
        }
    }, {
        name: 'adminPostsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/posts/edit" */ 'views/Admin/Posts/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.post)]),
        meta: {
            title: 'Edit Post'
        }
    }]
}]