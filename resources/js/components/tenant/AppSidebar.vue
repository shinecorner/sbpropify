<template>
    <div :class="['menu-wrapper', {'is-main': !parentKey}]" :style="style">
        <ul ref="menu" :class="['menu-content', {'is-visible': visible, 'is-collapsed': collapsed}]">
            <li class="bar" ref="bar" v-if="!parentKey"/>
            <li class="menu-item" v-if="$slots.default"><slot/></li>
            <li class="menu-item" :class="{'is-active': isActive(key, link)}" :style="link.style" v-for="(link, key) in items" :key="link.name" @click.stop="handleLink($event, key, link)">
                <div class="content">
                    <i :class="link.icon" class="icon"/>
                    <div class="title">{{link.title}}</div>
                </div>
                <sidebar :parent-key="key" :routes="link.children" v-if="canShowChildren(key, link)"/>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'sidebar',
        props: {
            parentKey: Number,
            routes: {
                type: Array,
                default: []
            },
            visible: {
                type: Boolean,
                default: true
            },
            drawable: {
                type: String,
                validator: value => value[0] === '#' && value.length > 1
            },
            drawableZIndex: {
                default: '10000'
            }
        },
        data() {
            return {
                children: false,
                collapsed: true,
                currSubmenu: null,
                $observer: null,
                $drawableContent: null,
                $backdropEl: null,
            }
        },
        methods: {
            async handleLink(ev, key, link) {
                const items = this.$refs.menu.querySelector('.is-active')

                if (items) {
                    items.classList.remove('is-active')
                }

                const item = ev.target.closest('.menu-item')

                if (item) {
                    item.classList.add('is-active')
                }

                if (this.children) {
                    this.$refs.bar.style.top = item.offsetTop + 'px'
                }

                key = this.getRealKey(key)

                if (this.currSubmenu === key || !link.children) {
                    this.currSubmenu = null
                    this.collapsed = true
                } else {
                    this.currSubmenu = key

                    if (this.collapsed) {
                        this.collapsed = false
                    }
                }

                if (link.route) {
                    this.$router.push(link.route)
                } else if (link.action) {
                    if (link.action.handler) {
                        link.action.handler(link.action.name)
                    } else {
                        await this.$store.dispatch(link.action.name)
                    }
                }
            },
            isActive (key, {route, children}) {
                return route ? route.name === this.$route.name || this.$route.matched.some(({path}) => this.$router.resolve(path).route.name === route.name)
                    : (children || []).some(({route: childRoute}) => childRoute.name === this.$route.name)
            },
            getRealKey(key) {
                return this.parentKey ? `${this.parentKey}.${key}` : key
            },
            canShowChildren(key, {children}) {
                if (Array.isArray(children) && children.length) {
                    if (this.currSubmenu == this.getRealKey(key)) {
                        if (children.every(({route}) => route.name !== this.$route.name)) {
                            this.$router.push(children[0].route)
                        }

                        return true
                    }
                }

                return false
            }
        },
        computed: {
            style () {
                const obj = {}

                if (!this.parentKey) {
                    if (this.drawable) {
                        obj.position = 'absolute'

                        if (this.visible) {
                            obj.transform = 'translate3d(0, 0, 0)'
                        } else {
                            obj.transform = 'translate3d(-100%, 0, 0)'
                        }
                    } else {
                        obj.position = 'relative'
                    }
                }

                return obj
            },
            items() {
                let items = [...this.routes]

                const itemsPositionedBottom = items.filter(item => item.positionedBottom)
                const diff = items.filter(item => !itemsPositionedBottom.includes(item))

                if (itemsPositionedBottom.length) {
                    itemsPositionedBottom[0].style = 'margin-top: auto'
                }

                return [...diff, ...itemsPositionedBottom]
            }
        },
        mounted () {
            this.children = this.routes.find(link => link.children)

            this.$nextTick(() => {
                if (this.children) {
                    this.$refs.bar.style.top = this.$refs.menu.querySelector('.is-active').offsetTop + 'px'
                }
            })

            if (!this.parentKey && this.drawable) {
                this.$drawableContent = document.getElementById(this.drawable.slice(1))

                if (!this.$drawableContent) {
                    return
                }

                this.$drawableContent.style.position = 'relative'
                this.$drawableContent.style.transition = 'all .48s'

                this.$backdropEl = document.createElement('div')

                this.$backdropEl.style.top = '0'
                this.$backdropEl.style.left = '0'
                this.$backdropEl.style.right = '0'
                this.$backdropEl.style.bottom = '0'
                this.$backdropEl.style.opacity = '0'
                this.$backdropEl.style.width = '100%'
                this.$backdropEl.style.height = '100%'
                this.$backdropEl.style.position = 'absolute'
                this.$backdropEl.style.visibility = 'hidden'
                this.$backdropEl.style.transition = 'opacity .48s'
                this.$backdropEl.style.background = `rgba(0, 0, 0, 0.5)`
                this.$backdropEl.style.zIndex = this.drawableZIndex

                this.$watch(() => this.visible, state => {
                    if (state) {
                        this.$backdropEl.style.opacity = '1'
                        this.$backdropEl.style.visibility = 'visible'
                    } else {
                        this.$backdropEl.style.opacity = '0'
                        this.$backdropEl.style.visibility = 'hidden'
                    }
                }, {
                    immediate: true
                })

                this.$backdropEl.addEventListener('click', () => this.$emit('update:visible', !this.visible))

                this.$drawableContent.appendChild(this.$backdropEl)

                this.$observer = new MutationObserver(mutations => {
                    const {target} = mutations[0]

                    if (target.classList.contains('is-visible')) {
                        let tx = 0

                        if (target.classList.contains('is-collapsed')) {
                            tx = 104
                        } else {
                            tx = 320
                        }

                        this.$drawableContent.style.transform = `translate3d(${tx}px, 0px, 0px)`
                    } else {
                        this.$drawableContent.style.transform = ''
                    }
                })

                this.$observer.observe(this.$refs.menu, {
                    attributes: true,
                    attributeFilter: ['class'] 
                })
            }
        },
        beforeDestroy () {
            if (this.drawable) {
                if (this.$drawableContent) {
                    this.$observer.disconnect()
                    this.$drawableContent.style = ''
                    this.$drawableContent.removeChild(this.$backdropEl)
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .menu-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
        background-color: #fff;
        overflow-y: auto;
        transition: transform .48s cubic-bezier(.51, .92, .24, 1.15);
        will-change: transform;
        z-index: 1;
        -webkit-overflow-scrolling: touch;

        &.is-main {
            box-shadow: 0 1px 3px transparentize(#000, .88),
                        0 1px 2px transparentize(#000, .76);
            > .menu-content {
                .bar {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 4px;
                    height: 104px;
                    background-color: #6AC06F;
                    border-top-right-radius: 4px;
                    border-bottom-right-radius: 4px;
                    transition: top .64s cubic-bezier(.51, .92, .24, 1.15);
                }

                > .menu-item {
                    display: flex;
                    flex-shrink: 0;

                    > .content {
                        width: 104px;
                        height: 104px;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        text-align: center;
                        border-width: 1px;
                        border-style: none solid solid none;
                        border-color: darken(#fff, 8%);

                        .icon {
                            font-size: 28px;
                        }

                        .title {
                            font-size: 14px;
                            margin: 8px;
                        }
                    }

                    .menu-wrapper {
                        position: absolute !important;
                        top: 0;
                        left: 105px;
                        right: 0;
                        bottom: 0;

                        .menu-content {
                            width: 100%;
                            padding: 8px 0;

                            .menu-item {

                                .content {
                                    display: flex;
                                    align-items: center;
                                    padding: 16px;

                                    .icon {
                                        font-size: 20px;
                                        margin-right: 16px;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        .menu-content {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex: auto;
            flex-direction: column;
            transition: width .48s cubic-bezier(.51, .92, .24, 1.15);
            will-change: width;

            &.is-collapsed,
            &.is-visible {
                width: 104px;
            }

            &:not(.is-collapsed) {
                width: 320px;
            }
            
            .menu-item {
                .content {
                    min-width: 0;

                    .title {
                        overflow: hidden;
                        min-width: 0;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                }

                &.is-active > .content {
                    color: #6AC06F;
                }

                &:hover > .content {
                    cursor: pointer;
                    background-color: mix(#fff, #6AC06F, 90%);
                }
            }
        }
    }
</style>
