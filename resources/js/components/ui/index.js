import anime from 'animejs'

import Card from './Card'
import Image from './Image'
import Avatar from './Avatar'
import Drawer from './Drawer'
import Divider from './Divider'
import Heading from './Heading'
import ReadMore from './ReadMore'
import MediaGallery from './MediaGallery'
import MediaUploader from './MediaUploader'
import ImagesCarousel from './ImagesCarousel'

export default {
    version: '0.1',
    install (Vue, options) {
        [
            Card,
            Image,
            Avatar,
            Drawer,
            Divider,
            Heading,
            ReadMore,
            MediaGallery,
            MediaUploader,
            ImagesCarousel
        ].forEach(component => Vue.component(component.name, component))

        Vue.prototype.$anime = anime

        // Vue.directive('anime', {
        //     bind: function bind(targets, binding) {
        //         anime(Object.assign({}, binding.value, {targets: targets}))
        //     },
        //     update: function bind(targets, binding) {
        //         anime(Object.assign({}, binding.value, {targets: targets}))
        //     }
        // })

    }
}