<template>
    <div class="chat">        
        <comments ref="comments" :id="id" :type="type" :limit="limit" reversed with-scroller :show-children="false" :style="{height: height, maxHeight: maxHeight}" />
        <add-comment ref="addComment" :id="id" :type="type" :show-templates="showTemplates" />
        <el-row v-if="type === 'internalNotices'">
            <el-col :span="12">
                Do you want to select property manager/administrator?<el-switch v-model="isWant"></el-switch>
            </el-col>
            <el-col :span="12">
                <el-select v-if="isWant" v-model="value" multiple filterable remote reserve-keyword placeholder="Please enter a keyword" :remote-method="remoteSearch" :loading="loading">
                    <el-option v-for="item in options" :key="item.id" :label="item.name" :value="item.id"></el-option>
                </el-select>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import ErrorFallback from 'components/common/Chat/Error'
    import {mapActions, mapGetters} from 'vuex'
    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
            type: {
                type: String,
                required: true,
                validator: type => ['post', 'product', 'request', 'conversation', 'internalNotices'].includes(type)
            },
            height: {
                type: String,
                default: '100%'
            },
            maxHeight: {
                type: String,
                default: '320px'
            },
            limit: {
                type: Number,
                default: 50
            },
            autofocus: {
                type: Boolean,
                default: false
            },
            showTemplates: {
                type: Boolean,
                default: false
            }
        },
        data () {
            return {
                errorFallback: ErrorFallback,
                
                options: [],
                value: [],
                list: [],
                loading: false,

                isWant: false
            }
        },
        methods: {
            ...mapActions({
                getPropertyManagers: 'getPropertyManagers',
            }),
            async remoteSearch(search) {
                if (search === '') {
                    this.options = [];
                    this.value = [];
                } else {
                    this.loading = true;
                    try {
                        let resp = [];
                        const respAssignee = await this.getPropertyManagers({request_id: this.$route.params.id});                        
                        let exclude_ids = [];                                                
                            respAssignee.data.data.map(item => {
                                if(item.type === 'manager'){
                                    exclude_ids.push(item.edit_id);
                                }                                
                            })
                            resp = await this.getPropertyManagers({
                                get_all: true,
                                search,
                                exclude_ids
                            });
                        this.options = resp.data;
                    } catch (err) {
                        displayError(err);
                    } finally {
                        this.loading = false;
                    }
                }           
            },
            focusOnAddComment() {
                this.$refs.addComment.focus()
            }
        },
        mounted () {
            if (this.autofocus) {
                this.focusOnAddComment()
            }
        }
    }
</script>

<style lang="sass" sccoped>
    .chat
        height: 100%
        display: flex
        flex-direction: column

        .comments-list 
            /deep/ .vue-recycle-scroller
                padding-bottom: 8px

                // /deep/ .vue-recycle-scroller__slot)
                //     :global(.el-divider) 
                //         margin-top: 8px

        .add-comment
            width: auto
</style>

<style lang="scss" scoped>
    // .chat {
    //     height: 100%;
    //     color: lighten(#000, 32%);
    //     display: flex;
    //     flex-direction: column;

    //     .comments-list {
    //         :global(.vue-recycle-scroller) {
    //             padding-bottom: 8px;

    //             :global(.vue-recycle-scroller__slot) {
    //                 :global(.el-divider) {
    //                     margin-top: 8px;
    //                 }
    //             }
    //         }
    //     }
    //     .add-comment {
    //         width: auto;
    //     }
    // }
</style>
