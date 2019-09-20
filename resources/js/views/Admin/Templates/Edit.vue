<template>
    <div class="templates-edit">
        <heading :title="$t('general.actions.edit')" icon="ti-user" shadow="heavy" style="margin-bottom: 20px;">
            <edit-actions :queryParams="{tab: 'requests'}" :saveAction="submit" route="adminSettings"/>
        </heading>
        <el-row :gutter="20" class="crud-view">
            <el-form :model="model" label-width="100px" ref="form">
                <el-col :md="12">
                    <card :loading="loading">
                        <el-form-item :label="$t('general.name')" :rules="validationRules.name" prop="name">
                            <el-input autocomplete="off" type="text"
                                      v-model="model.name"></el-input>
                        </el-form-item>
                        <el-form-item>
                           <select-language :activeLanguage.sync="language"/>
                        </el-form-item>
                        <el-form-item :label="$t('models.template.subject')" :prop="`translations.${language}.subject`"
                                      :rules="validationRules.subject">
                            <el-input @blur="setLastFocusedElement($event)" autocomplete="off"
                                      type="text"
                                      v-model="model.translations[language].subject"></el-input>
                        </el-form-item>
                        <el-form-item :label="$t('models.template.body')" :prop="`translations.${language}.body`"
                                      :rules="validationRules.body"
                                      :key="editorKey">
                            <yimo-vue-editor
                                :config="editorConfig"
                                v-model="model.translations[language].body"></yimo-vue-editor>
                        </el-form-item>
                    </card>
                </el-col>
                <el-col :md="12">
                    <card :loading="loading">

                        <el-form-item :label="$t('models.template.category')" :rules="validationRules.category"
                                      prop="category_id">
                            <el-select :placeholder="$t('models.template.placeholders.category')"
                                       @change="setSelectedCategory"
                                       v-model="model.category_id"
                            >
                                <el-option-group
                                    :key="group.id"
                                    :label="group.name"
                                    v-for="group in categories">
                                    <el-option
                                        :key="category.id"
                                        :label="category.name"
                                        :value="category.id"
                                        v-for="category in group.categories">
                                    </el-option>
                                </el-option-group>
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('models.template.tags')" v-if="!_.isEmpty(selectedCategory)">
                            <el-button :key="tag" @click="insertTag(tag)" size="mini" type="info"
                                       v-for="tag in categoryTags">{{tag}}
                            </el-button>
                        </el-form-item>
                    </card>
                </el-col>
            </el-form>
        </el-row>
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import Card from 'components/Card';
    import EditActions from 'components/EditViewActions';
    import SelectLanguage from 'components/SelectLanguage';
    import TemplatesMixin from 'mixins/adminTemplatesMixin';
    import YimoVueEditor from 'yimo-vue-editor';

    export default {
        mixins: [TemplatesMixin({
            mode: 'edit'
        })],
        components: {
            Heading,
            Card,
            EditActions,
            'yimo-vue-editor': YimoVueEditor,
            SelectLanguage
        },
        data() {
            return {
                editorKey: 0,
                editorConfig: {
                    printLog: false,
                    menus: [
                        'source',
                        '|',
                        'bold',
                        'underline',
                        'italic',
                        'strikethrough',
                        'eraser',
                        'forecolor',
                        'bgcolor',
                        '|',
                        'quote',
                        'fontfamily',
                        'fontsize',
                        'head',
                        'unorderlist',
                        'orderlist',
                        'alignleft',
                        'aligncenter',
                        'alignright',
                        '|',
                        'link',
                        'unlink',
                        'table',
                        'emotion',
                        '|',
                        'img',
                        'video',
                        'location',
                        'insertcode',
                        '|',
                        'undo',
                        'redo',
                        'fullscreen'
                    ],
                    lang: '',
                    familys: [
                        'Arial',
                        'Verdana',
                        'Georgia',
                        'Times New Roman',
                        'Microsoft JhengHei',
                        'Trebuchet MS',
                        'Courier New',
                        'Impact',
                        'Comic Sans MS',
                        'Consolas'
                    ]
                },

            }
        },
        methods: {
            editorChangeLang() {
                this.editorConfig.lang = this.editorTooltips;
                this.editorKey+=1;
            }
        },
        mounted() {
            setTimeout(() => {
                this.editorChangeLang()
            }, 0);

            this.$root.$on('changeLanguage', () => this.editorChangeLang());
        },
        computed: {
            editorTooltips() {
                return {
                    bold: this.$t('models.editor.bold'),
                    underline: this.$t('models.editor.underline'),
                    italic: this.$t('models.editor.italic'),
                    forecolor: this.$t('models.editor.forecolor'),
                    bgcolor: this.$t('models.editor.bgcolor'),
                    strikethrough: this.$t('models.editor.strikethrough'),
                    eraser: this.$t('models.editor.eraser'),
                    source: this.$t('models.editor.source'),
                    quote: this.$t('models.editor.quote'),
                    fontfamily: this.$t('models.editor.fontfamily'),
                    fontsize: this.$t('models.editor.fontsize'),
                    head: this.$t('models.editor.head'),
                    orderlist: this.$t('models.editor.orderlist'),
                    unorderlist: this.$t('models.editor.unorderlist'),
                    alignleft: this.$t('models.editor.alignleft'),
                    aligncenter: this.$t('models.editor.aligncenter'),
                    alignright: this.$t('models.editor.alignright'),
                    link: this.$t('models.editor.link'),
                    linkTarget: this.$t('models.editor.linkTarget'),
                    text: this.$t('models.editor.text'),
                    submit: this.$t('models.editor.submit'),
                    cancel: this.$t('models.editor.cancel'),
                    unlink: this.$t('models.editor.unlink'),
                    table: this.$t('models.editor.table'),
                    emotion: this.$t('models.editor.emotion'),
                    img: this.$t('models.editor.img'),
                    uploadImg: this.$t('models.editor.uploadImg'),
                    linkImg: this.$t('models.editor.linkImg'),
                    video: this.$t('models.editor.video'),
                    width: this.$t('models.editor.width'),
                    height: this.$t('models.editor.height'),
                    location: this.$t('models.editor.location'),
                    loading: this.$t('models.editor.loading'),
                    searchlocation: this.$t('models.editor.searchlocation'),
                    dynamicMap: this.$t('models.editor.dynamicMap'),
                    clearLocation: this.$t('models.editor.clearLocation'),
                    langDynamicOneLocation: this.$t('models.editor.langDynamicOneLocation'),
                    insertcode: this.$t('models.editor.insertcode'),
                    undo: this.$t('models.editor.undo'),
                    redo: this.$t('models.editor.redo'),
                    fullscreen: this.$t('models.editor.fullscreen'),
                    openLink: this.$t('models.editor.openLink'),
                    uploadPlaceTxt: this.$t('models.editor.uploadPlaceTxt'),
                    uploadTimeoutPlaceTxt: this.$t('models.editor.uploadTimeoutPlaceTxt'),
                    uploadErrorPlaceTxt: this.$t('models.editor.uploadErrorPlaceTxt'),
                }
            }
        }
    }
</script>

<style>
</style>
