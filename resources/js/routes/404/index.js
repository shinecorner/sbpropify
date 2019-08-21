import NotFound from './../../views/404';

export default [{
    path: '/404',
    name: '404',
    component: NotFound
}, {
    path: '*',
    redirect: '/404'
}];