import {guest} from 'middlewares';
import Layout from 'layouts/Auth2Layout';
import Login from 'views/Auth/Login';
import AutoLogin from 'views/Auth/AutoLogin';
import ForgotPassword from 'views/Auth/ForgotPassword';
import ResetPassword from 'views/Auth/ResetPassword';
import ActivateAccount from 'views/Auth/ActivateAccount';

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
        props: { loginMode: 2 }
    }, {
        path: 'autologin2',
        component: AutoLogin,
        name: 'autoLogin2',
        meta: {
            title: 'Auto Login'
        },
        props: { loginMode: 2 }
    }, {
        path: 'forgot2',
        component: ForgotPassword,
        name: 'forgot2',
        meta: {
            title: 'Forgot Password',
            middleware: guest
        },
        props: { loginMode: 2 }
    }, {
        path: 'reset-password2',
        component: ResetPassword,
        name: 'resetPassword2',
        meta: {
            title: 'Reset Password',
            middleware: guest
        },
        props: { loginMode: 2 }
    }, {
        path: 'activate2',
        component: ActivateAccount,
        name: 'activateAccount2',
        meta: {
            title: 'Activate Account',
            middleware: guest
        },
        props: { loginMode: 2 }
    }]
}];
