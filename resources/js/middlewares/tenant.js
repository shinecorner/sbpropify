import {checkTenancy} from "helpers/checkTenancy";

export default function tenant(ctx) {
    const {next, router, loggedInUser} = ctx;
    const isTenant = checkTenancy(loggedInUser.roles);

    if (isTenant) {
        return next();
    }

    if(loggedInUser.roles[0].name == 'service') {
        return router.push({name: 'adminRequests'});
    }

    return router.push({name: 'adminDashboard'});
}
