import AuditError from './Audit/Error'
import AuditLoader from './Audit/Loader'

import AddCommentError from './AddComment/Error'
import AddCommentLoader from './AddComment/Loader'

import ChatError from './Chat/Error'
import ChatLoader from './Chat/Loader'

import CommentError from './Comment/Error'
import CommentLoader from './Comment/Loader'

import CommentsError from './Comments/Error'
import CommentsLoader from './Comments/Loader'

import FiltersError from './Filters/Error'
import FiltersLoader from './Filters/Loader'

import LocaleSwitcherError from './LocaleSwitcher/Error'
import LocaleSwitcherLoader from './LocaleSwitcher/Loader'

import MediaUploaderError from './MediaUploader/Error'
import MediaUploaderLoader from './MediaUploader/Loader'

import QuickLinksError from './QuickLinks/Error'
import QuickLinksLoader from './QuickLinks/Loader'

export default {
    install (Vue) {
        Object.entries({
            audit: () => ({
                component: import(/* webpackChunkName: "audit" */ './Audit'),
                loading: AuditLoader,
                error: AuditError,
                delay: 0,
                timeout: 8000
            }),
            addComment: () => ({
                component: import(/* webpackChunkName: "addComment" */ './AddComment'),
                loading: AddCommentLoader,
                error: AddCommentError,
                delay: 0,
                timeout: 8000
            }),
            chat: () => ({
                component: import(/* webpackChunkName: "chat" */ './Chat'),
                loading: ChatLoader,
                error: ChatError,
                delay: 0,
                timeout: 8000
            }),
            comment: () => ({
                component: import(/* webpackChunkName: "comment" */ './Comment'),
                loading: CommentLoader,
                error: CommentError,
                delay: 0,
                timeout: 8000
            }),
            comments: () => ({
                component: import(/* webpackChunkName: "comments" */ './Comments'),
                loading: CommentsLoader,
                error: CommentsError,
                delay: 0,
                timeout: 8000
            }),
            filters: () => ({
                component: import(/* webpackChunkName: "filters" */ './Filters'),
                loading: FiltersLoader,
                error: FiltersError,
                delay: 0,
                timeout: 8000
            }),
            localeSwitcher: () => ({
                component: import(/* webpackChunkName: "localeSwitcher" */ './LocaleSwitcher'),
                loading: LocaleSwitcherLoader,
                error: LocaleSwitcherError,
                delay: 0,
                timeout: 8000
            }),
            mediaUploader: () => ({
                component: import(/* webpackChunkName: "mediaUploader" */ './MediaUploader'),
                loading: MediaUploaderLoader,
                error: MediaUploaderError,
                delay: 0,
                timeout: 8000
            }),
            quickLinks: () => ({
                component: import(/* webpackChunkName: "quickLinks" */ './QuickLinks'),
                loading: QuickLinksLoader,
                error: QuickLinksError,
                delay: 0,
                timeout: 8000
            }),
        }).forEach(([name, component]) => Vue.component(name, component))
    }
}