import Layout from 'layouts/Auth/1/Layout'
import isGuestGuard from 'guards/isGuestGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: '/',
    component: Layout,
    children: [{
        name: 'login',
        path: 'login',
        component: () => import( /* webpackChunkName: "auth/1/login" */ 'views/Auth/1/Login'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Login'
        }
    }, {
        path: 'autologin',
        component: () => import( /* webpackChunkName: "auth/1/autoLogin" */ 'views/Auth/1/AutoLogin'),
        name: 'autoLogin',
        meta: {
            title: 'Auto Login'
        }
    }, {
        name: 'forgot',
        path: 'forgot',
        component: () => import( /* webpackChunkName: "auth/1/forgotPassword" */ 'views/Auth/1/ForgotPassword'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Forgot Password'
        }
    }, {
        name: 'resetPassword',
        path: 'reset-password',
        component: () => import( /* webpackChunkName: "auth/1/resetPassword" */ 'views/Auth/1/ResetPassword'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Reset Password'
        }
    }, {
        path: 'activate',
        component: () => import( /* webpackChunkName: "auth/1/activateAccount" */ 'views/Auth/1/ActivateAccount'),
        name: 'activateAccount',
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Activate Account',
        }
    }]
}]
