import { auth, admin } from 'middlewares';
import permissions from 'middlewares/permissions';


export default [{
    path: 'tenants',
    component: {
        template: '<router-view />'
    },
    children: [{
        path: '/',
        name: 'adminTenants',
        component: () =>
            import ( /* webpackChunkName: "admin/tenants/index" */ 'views/Admin/Tenants'),
        meta: {
            title: 'Tenants',
            middleware: [auth, admin],
            permission: permissions.list.tenant,
            breadcrumb: 'Tenants'
        }
    }, {
        path: 'add',
        name: 'adminTenantsAdd',
        component: () =>
            import ( /* webpackChunkName: "admin/tenants/add" */ 'views/Admin/Tenants/Add'),
        props: {
            title: 'Add tenant'
        },
        meta: {
            title: 'Add Tenant',
            middleware: [auth, admin],
            permission: permissions.create.tenant,
            breadcrumb: 'Add tenant'
        }
    }, {
        path: ':id',
        name: 'adminTenantsEdit2',
        component: () =>
            import ( /* webpackChunkName: "admin/tenants/edit" */ 'views/Admin/Tenants/Edit'),
        props: {
            title: 'Edit tenant'
        },
        meta: {
            title: 'Edit Tenant',
            middleware: [auth, admin],
            permission: permissions.update.tenant,
            breadcrumb: 'Edit tenant'
        }
    }, {
        path: ':id',
        name: 'adminTenantsEdit',
        component: () =>
            import ( /* webpackChunkName: "admin/tenants/editNew" */ 'views/Admin/Tenants/editNew'),
        props: {
            title: 'Edit tenant'
        },
        meta: {
            title: 'Edit Tenant',
            middleware: [auth, admin],
            permission: permissions.update.tenant,
            breadcrumb: 'Edit tenant'
        }
    }, {
        path: ':id/view',
        name: 'adminTenantsView',
        component: () =>
            import ( /* webpackChunkName: "admin/tenants/view" */ 'views/Admin/Tenants/view'),
        props: {
            title: 'View tenant'
        },
        meta: {
            title: 'View Tenant',
            middleware: [auth, admin],
            permission: permissions.view.tenant,
            breadcrumb: 'View tenant'
        }
    }]
}];