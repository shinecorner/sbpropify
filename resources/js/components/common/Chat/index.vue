<template>
    <div class="chat">        
        <comments ref="comments" :id="id" :type="type" :limit="limit" reversed with-scroller :show-children="false" :style="{height: height, maxHeight: maxHeight}" />
        <add-comment ref="addComment" :id="id" :type="type" :show-templates="showTemplates" />
        <el-row :gutter="10" v-if="type === 'internalNotices'" style="margin-top: 10px;">
            <el-col :span="12">
                <el-form-item class="switcher">
                    <label class="switcher__label">
                        Select property manager/admin?
                        <span class="switcher__desc">Do you want to select property manager/administrator?</span>
                    </label>
                    <el-switch v-model="isWant" @change="resetList"/>
                </el-form-item>
            </el-col>
            <el-col :span="12">
                <el-select v-if="isWant" v-model="value" multiple filterable remote reserve-keyword placeholder="Please enter a keyword" :remote-method="remoteSearch" :loading="loading" style="width: 100%">
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
                validator: type => ['pinboard', 'product', 'request', 'conversation', 'internalNotices'].includes(type)
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
            resetList(){
                this.value = []
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

        .switcher
            .el-form-item__content
                display: flex
                align-items: center
            &__label
                line-height: 1.4em
                color: #606266
            &__desc
                margin-top: 0.5em
                display: block
                font-size: 0.9em
            .el-switch
                margin-left: auto

        .card-boxs span.switcher__desc
            text-align: left
            font-weight: normal
            margin-top: 10px
            line-height: 20px
            font-size: 13px
            color: #333

        .switcher-frist .el-switch
            margin-top: 10px
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
