import {isAuthenticatedGuard, isAdminGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

import permissions from 'middlewares/permissions';
import Layout from 'layouts/AdminLayout';
import Dashboard from 'views/Admin';
import Profile from 'views/Admin/Profile';
import Settings from 'views/Admin/Settings';

import BuildingsRoutes from 'routes/admin/buildings';
import UnitsRoutes from 'routes/admin/units';
import TenantsRoutes from 'routes/admin/tenants';
import UsersRoutes from 'routes/admin/users';
import ServicesRoutes from 'routes/admin/services';
import PostsRoutes from 'routes/admin/posts';
import DistrictsRoutes from 'routes/admin/districts';
import RequestsRoutes from 'routes/admin/requests';
import PropertyManagersRoutes from 'routes/admin/propertyManagers';
import ProductsRoutes from 'routes/admin/products';
import TemplatesRoutes from 'routes/admin/templates';


export default [{
    path: '/admin',
    component: Layout,
    children: [{
        path: '/',
        name: 'admin',
        component: Dashboard,
        meta: {
            breadcrumb: 'Home'
        },
    }, {
        path: 'dashboard',
        name: 'adminDashboard',
        component: Dashboard,
        meta: {
            breadcrumb: 'Home'
        },
    }, {
        path: 'profile',
        name: 'adminProfile',
        component: Profile,
        meta: {
            breadcrumb: 'Profile'
        }
    }, {
        path: 'settings',
        name: 'adminSettings',
        component: Settings,
        meta: {
            permission: permissions.view.realEstate,
            breadcrumb: 'Settings'
        },
    },
        ...UsersRoutes,
        ...ServicesRoutes,
        ...TenantsRoutes,
        ...BuildingsRoutes,
        ...PostsRoutes,
        ...UnitsRoutes,
        ...DistrictsRoutes,
        ...RequestsRoutes,
        ...PropertyManagersRoutes,
        ...ProductsRoutes,
        ...TemplatesRoutes,
    ],
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isAdminGuard]),
}];
