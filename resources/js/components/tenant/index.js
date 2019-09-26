import LatestMyNeighboursCardError from './LatestMyNeighboursCard/Error'
import LatestMyNeighboursCardLoader from './LatestMyNeighboursCard/Loader'

import LatestPostsCardError from './LatestPostsCard/Error'
import LatestPostsCardLoader from './LatestPostsCard/Loader'

import LatestProductsCardError from './LatestProductsCard/Error'
import LatestProductsCardLoader from './LatestProductsCard/Loader'

import LatestPropertyManagersCardError from './LatestPropertyManagersCard/Error'
import LatestPropertyManagersCardLoader from './LatestPropertyManagersCard/Loader'

import LatestRequestsCardError from './LatestRequestsCard/Error'
import LatestRequestsCardLoader from './LatestRequestsCard/Loader'

import LikeError from './Like/Error'
import LikeLoader from './Like/Loader'

import LikesError from './Likes/Error'
import LikesLoader from './Likes/Loader'

import MyNeighboursError from './MyNeighbours/Error'
import MyNeighboursLoader from './MyNeighbours/Loader'

import PostAddCardError from './PostAddCard/Error'
import PostAddCardLoader from './PostAddCard/Loader'

import PostCardError from './PostCard/Error'
import PostCardLoader from './PostCard/Loader'

import PostNewTenantCardError from './PostNewTenantCard/Error'
import PostNewTenantCardLoader from './PostNewTenantCard/Loader'

import PostEditFormError from './PostEditForm/Error'
import PostEditFormLoader from './PostEditForm/Loader'

import PostDeleteModalError from './PostDeleteModal/Error'
import PostDeleteModalLoader from './PostDeleteModal/Loader'

import ProductAddFormError from './ProductAddForm/Error'
import ProductAddFormLoader from './ProductAddForm/Loader'

import ProductEditFormError from './ProductEditForm/Error'
import ProductEditFormLoader from './ProductEditForm/Loader'

import ProductCardError from './ProductCard/Error'
import ProductCardLoader from './ProductCard/Loader'

import ProductDetailsError from './ProductDetails/Error'
import ProductDetailsLoader from './ProductDetails/Loader'

import RateCardError from './RateCard/Error'
import RateCardLoader from './RateCard/Loader'

import RequestAddFormError from './RequestAddForm/Error'
import RequestAddFormLoader from './RequestAddForm/Loader'

import RequestCardError from './RequestCard/Error'
import RequestCardLoader from './RequestCard/Loader'

import RequestStatusChangeModalError from './RequestStatusChangeModal/Error'
import RequestStatusChangeModalLoader from './RequestStatusChangeModal/Loader'

import RequestsStatisticsCardError from './RequestsStatisticsCard/Error'
import RequestsStatisticsCardLoader from './RequestsStatisticsCard/Loader'

import RSSFeedError from './RSSFeed/Error'
import RSSFeedLoader from './RSSFeed/Loader'

import UserError from './User/Error'
import UserLoader from './User/Loader'

import UserNotificationsError from './UserNotifications/Error'
import UserNotificationsLoader from './UserNotifications/Loader'

import UserSettingsError from './UserSettings/Error'
import UserSettingsLoader from './UserSettings/Loader'

import WeatherCardError from './WeatherCard/Error'
import WeatherCardLoader from './WeatherCard/Loader'

import EmergencyCardError from './EmergencyCard/Error'
import EmergencyCardLoader from './EmergencyCard/Loader'


export default {
    install (Vue) {
        Object.entries({
            latestMyNeighboursCard: () => ({
                component: import(/* webpackChunkName: "latestMyNeighboursCard" */ './LatestMyNeighboursCard'),
                loading: LatestMyNeighboursCardLoader,
                error: LatestMyNeighboursCardError,
                delay: 0,
                timeout: 8000
            }),
            latestPostsCard: () => ({
                component: import(/* webpackChunkName: "latestPostsCard" */ './LatestPostsCard'),
                loading: LatestPostsCardLoader,
                error: LatestPostsCardError,
                delay: 0,
                timeout: 8000
            }),
            latestProductsCard: () => ({
                component: import(/* webpackChunkName: "latestProductsCard" */ './LatestProductsCard'),
                loading: LatestProductsCardLoader,
                error: LatestProductsCardError,
                delay: 0,
                timeout: 8000
            }),
            latestPropertyManagersCard: () => ({
                component: import(/* webpackChunkName: "latestPropertyManagersCard" */ './LatestPropertyManagersCard'),
                loading: LatestPropertyManagersCardLoader,
                error: LatestPropertyManagersCardError,
                delay: 0,
                timeout: 8000
            }),
            latestRequestsCard: () => ({
                component: import(/* webpackChunkName: "latestRequestsCard" */ './LatestRequestsCard'),
                loading: LatestRequestsCardLoader,
                error: LatestRequestsCardError,
                delay: 0,
                timeout: 8000
            }),
            like: () => ({
                component: import(/* webpackChunkName: "like" */ './Like'),
                loading: LikeLoader,
                error: LikeError,
                delay: 0,
                timeout: 8000
            }),
            likes: () => ({
                component: import(/* webpackChunkName: "likes" */ './Likes'),
                loading: LikesLoader,
                error: LikesError,
                delay: 0,
                timeout: 8000
            }),
            myNeighbours: () => ({
                component: import(/* webpackChunkName: "myNeighbours" */ './MyNeighbours'),
                loading: MyNeighboursLoader,
                error: MyNeighboursError,
                delay: 0,
                timeout: 8000
            }),
            postAddCard: () => ({
                component: import(/* webpackChunkName: "postAddCard" */ './PostAddCard'),
                loading: PostAddCardLoader,
                error: PostAddCardError,
                delay: 0,
                timeout: 8000
            }),
            postCard: () => ({
                component: import(/* webpackChunkName: "postCard" */ './PostCard'),
                loading: PostCardLoader,
                error: PostCardError,
                delay: 0,
                timeout: 8000
            }),
            postNewTenantCard: () => ({
                component: import(/* webpackChunkName: "postNewTenantCard" */ './PostNewTenantCard'),
                loading: PostNewTenantCardLoader,
                error: PostNewTenantCardError,
                delay: 0,
                timeout: 8000
            }),
            postEditForm: () => ({
                component: import(/* webpackChunkName: "postEditForm" */ './PostEditForm'),
                loading: PostEditFormLoader,
                error: PostEditFormError,
                delay: 0,
                timeout: 8000
            }),
            postDeleteModal: () => ({
                component: import(/* webpackChunkName: "postDeleteModal" */ './PostDeleteModal'),
                loading: PostDeleteModalLoader,
                error: PostDeleteModalError,
                delay: 0,
                timeout: 8000
            }),
            productAddForm: () => ({
                component: import(/* webpackChunkName: "productAddForm" */ './ProductAddForm'),
                loading: ProductAddFormLoader,
                error: ProductAddFormError,
                delay: 0,
                timeout: 8000
            }),
            productEditForm: () => ({
                component: import(/* webpackChunkName: "productEditForm" */ './ProductEditForm'),
                loading: ProductEditFormLoader,
                error: ProductEditFormError,
                delay: 0,
                timeout: 8000
            }),
            productCard: () => ({
                component: import(/* webpackChunkName: "productCard" */ './ProductCard'),
                loading: ProductCardLoader,
                error: ProductCardError,
                delay: 0,
                timeout: 8000
            }),
            productDetails: () => ({
                component: import(/* webpackChunkName: "productDetails" */ './ProductDetails'),
                loading: ProductDetailsLoader,
                error: ProductDetailsError,
                delay: 0,
                timeout: 8000
            }),
            rateCard: () => ({
                component: import(/* webpackChunkName: "rateCard" */ './RateCard'),
                loading: RateCardLoader,
                error: RateCardError,
                delay: 0,
                timeout: 8000
            }),
            requestCard: () => ({
                component: import(/* webpackChunkName: "requestCard" */ './RequestCard'),
                loading: RequestCardLoader,
                error: RequestCardError,
                delay: 0,
                timeout: 8000
            }),
            requestAddForm: () => ({
                component: import(/* webpackChunkName: "requestAddForm" */ './RequestAddForm'),
                loading: RequestAddFormLoader,
                error: RequestAddFormError,
                delay: 0,
                timeout: 8000
            }),
            requestStatusChangeModal: () => ({
                component: import(/* webpackChunkName: "requestAddForm" */ './RequestStatusChangeModal'),
                loading: RequestStatusChangeModalLoader,
                error: RequestStatusChangeModalError,
                delay: 0,
                timeout: 8000
            }),
            requestsStatisticsCard: () => ({
                component: import(/* webpackChunkName: "requestsStatisticsCard" */ './RequestsStatisticsCard'),
                loading: RequestsStatisticsCardLoader,
                error: RequestsStatisticsCardError,
                delay: 0,
                timeout: 8000
            }),
            rssFeed: () => ({
                component: import(/* webpackChunkName: "rssFeed" */ './RSSFeed'),
                loading: RSSFeedLoader,
                error: RSSFeedError,
                delay: 0,
                timeout: 8000
            }),
            user: () => ({
                component: import(/* webpackChunkName: "user" */ './User'),
                loading: UserLoader,
                error: UserError,
                delay: 0,
                timeout: 8000
            }),
            userNotifications: () => ({
                component: import(/* webpackChunkName: "userNotifications" */ './UserNotifications'),
                loading: UserNotificationsLoader,
                error: UserNotificationsError,
                delay: 0,
                timeout: 8000
            }),
            userSettings: () => ({
                component: import(/* webpackChunkName: "userSettings" */ './UserSettings'),
                loading: UserSettingsLoader,
                error: UserSettingsError,
                delay: 0,
                timeout: 8000
            }),
            weatherCard: () => ({
                component: import(/* webpackChunkName: "weatherCard" */ './WeatherCard'),
                loading: WeatherCardLoader,
                error: WeatherCardError,
                delay: 0,
                timeout: 8000
            }),
            emergencyCard: () => ({
                component: import(/* webpackChunkName: "weatherCard" */ './EmergencyCard'),
                loading: EmergencyCardLoader,
                error: EmergencyCardError,
                delay: 0,
                timeout: 8000
            })
        }).forEach(([name, component]) => Vue.component(name, component))
    }
}