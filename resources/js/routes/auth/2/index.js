import Layout from 'layouts/Auth/2/Layout'
import isGuestGuard from 'guards/isGuestGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: '/',
    component: Layout,
    children: [{
        name: 'login2',
        path: 'login',
        component: () => import( /* webpackChunkName: "auth/2/login" */ 'views/Auth/2/Login'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Login'
        }
    }, {
        path: 'autologin',
        component: () => import( /* webpackChunkName: "auth/2/autoLogin" */ 'views/Auth/2/AutoLogin'),
        name: 'autoLogin2',
        meta: {
            title: 'Auto Login'
        }
    }, {
        name: 'forgot2',
        path: 'forgot',
        component: () => import( /* webpackChunkName: "auth/2/forgotPassword" */ 'views/Auth/2/ForgotPassword'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Forgot Password'
        }
    }, {
        name: 'resetPassword2',
        path: 'reset-password',
        component: () => import( /* webpackChunkName: "auth/2/resetPassword" */ 'views/Auth/2/ResetPassword'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Reset Password'
        }
    }, {
        path: 'activate',
        component: () => import( /* webpackChunkName: "auth/2/activateAccount" */ 'views/Auth/2/ActivateAccount'),
        name: 'activateAccount2',
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Activate Account',
        }
    }]
}]
