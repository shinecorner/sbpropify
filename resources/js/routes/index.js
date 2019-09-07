import Vue from 'vue'
import store from 'store'
import {DEFAULT_FALLBACK_LOCALE} from 'config'

import Auth1Routes from 'routes/auth/1'
import Auth2Routes from 'routes/auth/2'
import AdminRoutes from 'routes/admin'
import TenantRoutes from 'routes/tenant'
import NotFound from 'routes/404'
import Landing from 'views/Landing'
import VueRouter from 'vue-router'
import {TYPES} from 'store/modules/application'

Vue.use(VueRouter)

let originalTitle

const Router = new VueRouter({
    routes: [{
        path: '/',
        component: Landing,
    }, ...Auth1Routes, ...Auth2Routes, ...TenantRoutes, ...AdminRoutes, ...NotFound],
    mode: 'history'
})

function LightenDarkenColor(col, amt) {
  
    var usePound = false;
  
    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }
 
    var num = parseInt(col,16);
 
    var r = (num >> 16) + amt;
 
    if (r > 255) r = 255;
    else if  (r < 0) r = 0;
 
    var b = ((num >> 8) & 0x00FF) + amt;
 
    if (b > 255) b = 255;
    else if  (b < 0) b = 0;
 
    var g = (num & 0x0000FF) + amt;
 
    if (g > 255) g = 255;
    else if (g < 0) g = 0;
 
    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
  
}

Router.beforeEach(async (to, from, next) => {
    if (!Object.keys(store.state.application.constants).length) {
        await store.dispatch(`application/${TYPES.actions.getConstants}`)

        document.documentElement.style.setProperty('--primary-color', store.state.application.constants.colors.primary_color) // this will be removed
        document.documentElement.style.setProperty('--color-primary', store.state.application.constants.colors.primary_color)
        document.documentElement.style.setProperty('--color-success', store.state.application.constants.colors.primary_color)
        document.documentElement.style.setProperty('--color-primary-lighter', LightenDarkenColor(store.state.application.constants.colors.primary_color, 99))
        document.documentElement.style.setProperty('--color-success-lighter', LightenDarkenColor(store.state.application.constants.colors.primary_color, 99))
        document.documentElement.style.setProperty('--color-main-background-lighter', LightenDarkenColor(store.state.application.constants.colors.primary_color, 99) )

        if (!store.state.application.locale) {
            const [lang, locale] = (((navigator.userLanguage || navigator.language).replace('-', '_')).toLowerCase()).split('_')

            store.dispatch('application/setLocale', Object.keys(store.state.application.constants.app.languages).includes(lang) ? lang : DEFAULT_FALLBACK_LOCALE)
        }

        Vue.prototype.$constants = store.state.application.constants
    }

    if (localStorage.token) {
        if (!store.getters.loggedIn) {
            await store.dispatch('me')
        }
    }

    if (!originalTitle) {
        originalTitle = document.title
    }

    if (to.meta.title) {
        const {meta} = to.matched.slice().reverse().find(({meta}) => meta && meta.title)

        if (meta) {
            document.title = `${originalTitle} - ${meta.title}`
        }
    }

    next()
})

export default Router