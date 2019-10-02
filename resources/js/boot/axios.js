import qs from 'qs'
import axios from 'axios'
import axiosCancel from 'axios-cancel'
import router from 'routes'
import {MAX_REQUESTS_COUNT, REQUESTS_INTERNAL_MS} from 'config'
import {displaySuccess, displayError} from 'helpers/messages'
import store from 'store'

let PENDING_REQUESTS = 0

const Axios = axios.create({
    baseURL: '/api/v1/',
    paramsSerializer: function (params) {
        return qs.stringify(params, {arrayFormat: 'brackets'})
    }
})

axiosCancel(Axios, {
    debug: true
})

Axios.interceptors.request.use(config => {
    const token = localStorage.getItem('token')    
    const selectedLocale = store.state.application.locale || 'de';
    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }
    config.headers.Localization = selectedLocale;
    return new Promise((resolve, reject) => {
        let interval = setInterval(() => {
            if (PENDING_REQUESTS < MAX_REQUESTS_COUNT) {
                PENDING_REQUESTS++

                clearInterval(interval)

                resolve(config)
            }
        }, REQUESTS_INTERNAL_MS)
      })
}, error => Promise.reject)

Axios.interceptors.response.use(response => {
    if (response.config.showMessage) {
        displaySuccess(response.data)
    }

    // TODO - temporary - will be removed
    if (response.config.method === 'get') {
        const data = response.data.data

        if (data) {
            const {current_page, last_page} = data

            if (current_page && last_page && current_page > last_page) {
                router.replace({
                    name: router.name,
                    query: {
                        ...router.currentRoute.query,
                        page: last_page
                    },
                    params: {
                        ...router.currentRoute.params
                    }
                })
            }
        }
    }

    PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1)

    return Promise.resolve(response)
}, error => {
    if (error.config.showMessage) {
        displayError(error.data)
    }

    if (error.response.status === 401) {
        localStorage.removeItem('token')

        router.replace({name: 'login'})
    }

    PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1)

    return Promise.reject(error)
})

export default Axios