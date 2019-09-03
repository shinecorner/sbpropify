import AdminPermissions from 'boot/roles/admin'
import hasPermissionGuard from 'guards/hasPermissionGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: 'buildings',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'adminBuildings',
        path: '/',
        component: () => import ( /* webpackChunkName: "admin/buildings/index" */ 'views/Admin/Buildings'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.building)]),
        meta: {
            title: 'Buildings'
        }
    }, {
        name: 'adminBuildingsAdd',
        path: 'add',
        component: () => import ( /* webpackChunkName: "admin/buildings/add" */ 'views/Admin/Buildings/Add'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.building)]),
        props: {
            title: 'Add building'
        },
        meta: {
            title: 'Add Building'
        }
    }, {
        name: 'adminBuildingsEdit',
        path: ':id',
        component: () => import ( /* webpackChunkName: "admin/buildings/edit" */ 'views/Admin/Buildings/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.building)]),
        props: {
            title: 'Edit building'
        },
        meta: {
            title: 'Edit Building'
        }
    }, {
        name: 'adminBuildingUnits',
        path: ':id/units',
        component: () => import ( /* webpackChunkName: "admin/units/index" */ 'views/Admin/Buildings/Units'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.list.unit)]),
        meta: {
            title: 'Building Units'
        }
    }, {
        name: 'adminBuildingUnitsAdd',
        path: ':id/units/add',
        component: () => import ( /* webpackChunkName: "admin/units/add" */ 'views/Admin/Buildings/Units/Add'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.create.unit)]),
        props: {
            title: 'Add unit'
        },
        meta: {
            title: 'Add Unit'
        }
    }, {
        name: 'adminBuildingUnitsEdit',
        path: ':buildingId/units/:id/edit',
        component: () => import ( /* webpackChunkName: "admin/units/edit" */ 'views/Admin/Buildings/Units/Edit'),
        beforeEnter: VueRouterMultiguard([hasPermissionGuard(AdminPermissions.update.unit)]),
        props: {
            title: 'Edit unit'
        },
        meta: {
            title: 'Edit Unit'
        }
    }]
}]