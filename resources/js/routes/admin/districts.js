import { auth, admin } from 'middlewares';
import permissions from 'middlewares/permissions';

export default [{
    path: 'districts',
    component: {
        template: '<router-view />'
    },
    children: [{
        path: '/',
        name: 'adminDistricts',
        component: () =>
            import ( /* webpackChunkName: "admin/districts/index" */ 'views/Admin/Districts'),
        meta: {
            title: 'Districts',
            middleware: [auth, admin],
            permission: permissions.list.district
        }
    }, {
        path: 'add',
        name: 'adminDistrictsAdd',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/add" */ 'views/Admin/Districts/Add'),
        props: {
            title: 'Add district'
        },
        meta: {
            title: 'Add District',
            middleware: [auth, admin],
            permission: permissions.create.district,
            breadcrumb: 'Add districts'
        }
    }, {
        path: ':id',
        name: 'adminDistrictsEdit',
        component: () =>
            import ( /* webpackChunkName: "admin/serviceRequests/edit" */ 'views/Admin/Districts/Edit'),
        props: {},
        meta: {
            title: 'Edit District',
            middleware: [auth, admin],
            permission: [permissions.update.district, permissions.update.serviceDistrict],
            breadcrumb: 'Edit district'
        }
    }]
}];