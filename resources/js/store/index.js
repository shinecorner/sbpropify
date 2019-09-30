import Vue from 'vue'
import Vuex from 'vuex'

// These wil be depracated soon - awful structure - yet keeping to not cause breaking changes
import UsersStore from 'store/modules/users'
import UnitsStore from 'store/modules/units'
import TenantsStore from 'store/modules/tenants'
import TemplatesStore from 'store/modules/templates'
import ServicesStore from 'store/modules/services'
import RequestsStore from 'store/modules/requests'
import RequestCategoriesStore from 'store/modules/requestCategories'
import PropertyManagersStore from 'store/modules/propertyManagers'
import ProductsStore from 'store/modules/products'
import PinboardStore from 'store/modules/pinboard'
import NotificationsStore from 'store/modules/notifications'
import MediaStore from 'store/modules/media'
import QuartersStore from 'store/modules/quarters'
import DashboardStore from 'store/modules/dashboard'
import CommentsStore from 'store/modules/comments'
import CleanifyStore from 'store/modules/cleanify'
import BuildingsStore from 'store/modules/buildings'
import ApplicationStore from 'store/modules/application'
import AddressesStore from 'store/modules/addresses'
import Products2Store from 'store/modules/products2' // :(
import Pinboard2Store from 'store/modules/pinboard2' // :(
import TagsStore from 'store/modules/tags'

// new ones - this will stay in the future, the above one will be removed at some point
import NewPinboardStore from 'store/modules/newPinboard'
import NewRequestsStore from 'store/modules/newRequests'
import NewProductsStore from 'store/modules/newProducts'
import rentContractsStore from 'store/modules/rentContracts'

import createPersistedState from 'vuex-persistedstate'


Vue.use(Vuex)

export default new Vuex.Store({
    state: {

        allLanguages: ['en', 'fr', 'de', 'it']
    },
    mutations: {},
    actions: {},
    getters: {
        getAllAvailableLanguages (state) {
            return state.allLanguages
        }
    },
    modules: {
        users: UsersStore,
        tenants: TenantsStore,
        buildings: BuildingsStore,
        units: UnitsStore,
        addresses: AddressesStore,
        services: ServicesStore,
        pinboard: PinboardStore,
        quarters: QuartersStore,
        requests: RequestsStore,
        requestCategories: RequestCategoriesStore,
        propertyManagers: PropertyManagersStore,
        products: ProductsStore,
        templates: TemplatesStore,
        cleanify: CleanifyStore,
        application: {
            namespaced: true,
            ...ApplicationStore
        },
        notifications: NotificationsStore,
        media: {
            namespaced: true,
            ...MediaStore
        },
        pinboard2: {
            namespaced: true,
            ...Pinboard2Store
        },
        products2: {
            namespaced: true,
            ...Products2Store
        },
        TagsStore,

        // this will stay in the future only
        comments: CommentsStore,
        newPinboard: NewPinboardStore,
        newProducts: NewProductsStore,
        newRequests: NewRequestsStore,
        rentContracts: rentContractsStore
    },
    plugins: [createPersistedState({
        key: 'state',
        paths: ['application.locale']
    })],
})