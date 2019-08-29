import { auth, admin } from 'middlewares';
import permissions from 'middlewares/permissions';


export default [{
    path: 'requests',
    component: {
        template: '<router-view />'
    },
    children: [{
        path: '/',
        name: 'adminRequests',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/index" */ 'views/Admin/Requests'),
        props: {
            // title: 'Requests'
        },
        meta: {
            title: 'Requests',
            middleware: [auth, admin],
            permission: permissions.list.request,
            breadcrumb: 'Requests',
        }
    },  {
        path: 'my',
        name: 'adminMyRequests',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/index" */ 'views/Admin/Requests'),
        props: {
            // title: 'My Requests'
        },
        meta: {
            title: 'My Requests',
            middleware: [auth, admin],
            permission: permissions.list.request,
            breadcrumb: 'My Requests',
        }
    }, {
        path: 'mypending',
        name: 'adminMypendingRequests',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/index" */ 'views/Admin/Requests'),
        props: {
            // title: 'My pending requests'
        },
        meta: {
            title: 'My Requests',
            middleware: [auth, admin],
            permission: permissions.list.request,
            breadcrumb: 'My Requests',
        }
    }, {
        path: 'notassigned',
        name: 'adminUnassignedRequests',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/index" */ 'views/Admin/Requests'),
        props: {
            // title: 'Not Assigned'
        },
        meta: {
            title: 'Not Assigned',
            middleware: [auth, admin],
            permission: permissions.list.request,
            breadcrumb: 'Not Assigned',
        }
    }, {
        path: 'pending',
        name: 'adminAllpendingRequests',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/index" */ 'views/Admin/Requests'),
        props: {
            // title: 'All pending requests'
        },
        meta: {
            title: 'All pending requests',
            middleware: [auth, admin],
            permission: permissions.list.request,
            breadcrumb: 'All pending requests',
        }
    }, {
        path: 'add',
        name: 'adminRequestsAdd',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/add" */ 'views/Admin/Requests/Add'),
        props: {
            // title: 'Add request'
        },
        meta: {
            title: 'Add Request',
            middleware: [auth, admin],
            permission: permissions.create.request,
            breadcrumb: 'Add request'
        }
    }, {
        path: 'activity',
        name: 'adminRequestsActivity',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/activity" */ 'views/Admin/Requests/Activity'),
        props: {
            // title: 'Activity requests'
        },
        meta: {
            title: 'Activity requests',
            middleware: [auth, admin],
            breadcrumb: 'Activity requests'
        }
    }, {
        path: ':id',
        name: 'adminRequestsEdit',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/edit" */ 'views/Admin/Requests/Edit'),
        props: {
            // title: 'Edit request'
        },
        meta: {
            title: 'Edit Request',
            middleware: [auth, admin],
            permission: [permissions.update.request, permissions.update.serviceRequest],
            breadcrumb: 'Edit request'
        }
    }]
}];