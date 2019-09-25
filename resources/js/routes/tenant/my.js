import {isAuthenticatedGuard, isTenantGuard} from 'guards'
import VueRouterMultiguard from 'vue-router-multiguard'

export default {
    path: 'my',
    component: {
        template: '<router-view />'
    },
    children: [{
        name: 'tenantMyPersonal',
        path: 'personal',
        component: () => import ( /* webpackChunkName: "tenant/my/personal" */ 'views/Tenant/My/Personal'),
        meta: {
            title: 'My personal data'
        }
    }, {
        name: 'tenantMyContracts',
        path: 'contracts',
        component: () => import ( /* webpackChunkName: "tenant/my/contracts" */ 'views/Tenant/My/Contracts'),
        meta: {
            title: 'My recent contracts'
        }
    }, {
        name: 'tenantMyDocuments',
        path: 'documents',
        component: () => import ( /* webpackChunkName: "tenant/my/documents" */ 'views/Tenant/My/Documents'),
        meta: {
            title: 'My documents'
        }
    }, {
        name: 'tenantMyContacts',
        path: 'contacts',
        component: () => import ( /* webpackChunkName: "tenant/my/contacts" */ 'views/Tenant/My/Contacts'),
        meta: {
            title: 'My contact persons'
        }
    }],
    beforeEnter: VueRouterMultiguard([isAuthenticatedGuard, isTenantGuard])
}