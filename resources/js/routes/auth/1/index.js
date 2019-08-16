import {guest} from 'middlewares';
import Layout from 'layouts/Auth/1/Layout';
import Login from 'views/Auth/1/Login';
import AutoLogin from 'views/Auth/1/AutoLogin';
import ForgotPassword from 'views/Auth/1/ForgotPassword';
import ResetPassword from 'views/Auth/1/ResetPassword';
import ActivateAccount from 'views/Auth/1/ActivateAccount';

export default [{
    path: '/',
    component: Layout,
    children: [{
        path: 'login',
        component: Login,
        name: 'login',
        meta: {
            title: 'Login',
            middleware: guest
        }
    }, {
        path: 'autologin',
        component: AutoLogin,
        name: 'autoLogin',
        meta: {
            title: 'Auto Login'
        }
    }, {
        path: 'forgot',
        component: ForgotPassword,
        name: 'forgot',
        meta: {
            title: 'Forgot Password',
            middleware: guest
        }
    }, {
        path: 'reset-password',
        component: ResetPassword,
        name: 'resetPassword',
        meta: {
            title: 'Reset Password',
            middleware: guest
        }
    }, {
        path: 'activate',
        component: ActivateAccount,
        name: 'activateAccount',
        meta: {
            title: 'Activate Account',
            middleware: guest
        }
    }]
}];
