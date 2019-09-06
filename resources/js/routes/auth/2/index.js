import Layout from 'layouts/Auth/2/Layout'
import isGuestGuard from 'guards/isGuestGuard'
import VueRouterMultiguard from 'vue-router-multiguard'

export default [{
    path: '/',
    component: Layout,
    children: [{
        name: 'login2',
        path: 'login2',
        component: () => import( /* webpackChunkName: "auth/2/login" */ 'views/Auth/2/Login'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Login'
        }
    }, {
        path: 'autologin2',
        component: () => import( /* webpackChunkName: "auth/2/autoLogin" */ 'views/Auth/2/AutoLogin'),
        name: 'autoLogin2',
        meta: {
            title: 'Auto Login'
        }
    }, {
        name: 'forgot2',
        path: 'forgot2',
        component: () => import( /* webpackChunkName: "auth/2/forgotPassword" */ 'views/Auth/2/ForgotPassword'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Forgot Password'
        }
    }, {
        name: 'resetPassword2',
        path: 'reset-password2',
        component: () => import( /* webpackChunkName: "auth/2/resetPassword" */ 'views/Auth/2/ResetPassword'),
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Reset Password'
        }
    }, {
        path: 'activate2',
        component: () => import( /* webpackChunkName: "auth/2/activateAccount" */ 'views/Auth/2/ActivateAccount'),
        name: 'activateAccount2',
        beforeEnter: VueRouterMultiguard([isGuestGuard]),
        meta: {
            title: 'Activate Account',
        }
    }]
}]
