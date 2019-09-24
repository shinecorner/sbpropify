import Layout from 'layouts/TenantLayout'
import MyRoutes from 'routes/tenant/my'
import PostsRoutes from 'routes/tenant/posts'
import RequestsRoutes from 'routes/tenant/requests'
import SettingsRoutes from 'routes/tenant/settings'
import DashboardRoutes from 'routes/tenant/dashboard'
import MarketplaceRoutes from 'routes/tenant/marketplace'
import CleanifyRoutes from 'routes/tenant/cleanify'
import MyNeighboursRoutes from 'routes/tenant/myNeighbours'
import PropertyManagersRoutes from 'routes/tenant/propertyManagers'

export default [{
    path: '/',
    component: Layout,
    children: [
        MyRoutes,
        PostsRoutes,
        RequestsRoutes,
        SettingsRoutes,
        DashboardRoutes,
        CleanifyRoutes,
        MarketplaceRoutes,
        MyNeighboursRoutes,
        PropertyManagersRoutes
    ]
}]
