import {guest} from 'middlewares';
import Layout from 'layouts/Auth2Layout';
import Login from 'views/Auth2/Login2';
import AutoLogin from 'views/Auth2/AutoLogin2';
import ForgotPassword from 'views/Auth2/ForgotPassword2';
import ResetPassword from 'views/Auth2/ResetPassword2';
import ActivateAccount from 'views/Auth2/ActivateAccount2';

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
        }
    }, {
        path: 'autologin2',
        component: AutoLogin,
        name: 'autoLogin2',
        meta: {
            title: 'Auto Login'
        }
    }, {
        path: 'forgot2',
        component: ForgotPassword,
        name: 'forgot2',
        meta: {
            title: 'Forgot Password',
            middleware: guest
        }
    }, {
        path: 'reset-password2',
        component: ResetPassword,
        name: 'resetPassword2',
        meta: {
            title: 'Reset Password',
            middleware: guest
        }
    }, {
        path: 'activate2',
        component: ActivateAccount,
        name: 'activateAccount2',
        meta: {
            title: 'Activate Account',
            middleware: guest
        }
    }]
}];
