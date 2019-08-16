import {guest} from 'middlewares';
import Layout from 'layouts/Auth/2/Layout';
import Login from 'views/Auth/2/Login';
import AutoLogin from 'views/Auth/2/AutoLogin';
import ForgotPassword from 'views/Auth/2/ForgotPassword';
import ResetPassword from 'views/Auth/2/ResetPassword';
import ActivateAccount from 'views/Auth/2/ActivateAccount';

export default [{
    path: '/',
    component: Layout,
    children: [{
        path: 'login2',
        component: Login,
        name: 'login2',
        meta: {
            title: 'Login',
            middleware: guest
        },
    }, {
        path: 'autologin2',
        component: AutoLogin,
        name: 'autoLogin2',
        meta: {
            title: 'Auto Login'
        },
    }, {
        path: 'forgot2',
        component: ForgotPassword,
        name: 'forgot2',
        meta: {
            title: 'Forgot Password',
            middleware: guest
        },
    }, {
        path: 'reset-password2',
        component: ResetPassword,
        name: 'resetPassword2',
        meta: {
            title: 'Reset Password',
            middleware: guest
        },
    }, {
        path: 'activate2',
        component: ActivateAccount,
        name: 'activateAccount2',
        meta: {
            title: 'Activate Account',
            middleware: guest
        },
    }]
}];
