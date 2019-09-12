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
                                      :rules="validationRules.body">
                            <vue-editor
                                          :editor-options="toolbarOptions"
                                          @text-change="updateValue"
                                          ref="editor"
                                          v-model="model.translations[language].body"
                            >
                            </vue-editor>
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

    let VueEditor, Quill;
    if (process.browser) {
        VueEditor = require("vue2-editor").VueEditor;
        Quill = require("vue2-editor").Quill;
    }

    export default {
        mixins: [TemplatesMixin({
            mode: 'edit'
        })],
        components: {
            Heading,
            Card,
            EditActions,
            VueEditor,
            SelectLanguage
        },
        data() {
            return {
                toolbarOptions: {
                    modules: {
                        toolbar: {
                            container: [
                                [{ font: [] }],
                                [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                                ["bold", "italic", "underline", "strike"],
                                [{ align: [] }],
                                ["blockquote", "code-block"],
                                [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
                                [{ indent: "-1" }, { indent: "+1" }],
                                [{ color: [] }, { background: [] }],
                                ["link", "image", "video"],
                                ["clean"],
                                ["showSource"],
                                // ["showHtml"]
                            ],
                            handlers: {
                                showSource: () => {
                                    if (this.txtArea.style.display === "") {
                                        const html = this.txtArea.value;
                                        if (html === '<p><br/></p>') {
                                            this.html = null;
                                        } else {
                                            this.html = html.replace(new RegExp('<p><br/>', 'g'), '<p>')
                                        }
                                        this.quill.pasteHTML(html);
                                    }
                                    this.txtArea.style.display =
                                        this.txtArea.style.display === "none" ? "" : "none";
                                }
                            }
                        }
                    }
                },
                content: "",
                rawContent: ""
            }
        },
        mounted() {
            this.quill = this.$refs.editor.quill;
            this.txtArea = document.createElement("textarea");
            this.txtArea.style.cssText =
                "width: 100%;margin: 0px;background: rgb(29, 29, 29);box-sizing: border-box;color: rgb(204, 204, 204);font-size: 15px;outline: none;padding: 20px;line-height: 24px;font-family: Consolas, Menlo, Monaco, &quot;Courier New&quot;, monospace;position: absolute;top: 0;bottom: 0;border: none;display:none;resize: none;";

            const htmlEditor = this.quill.addContainer("ql-custom");
            htmlEditor.appendChild(this.txtArea);

            this.quill.on("text-change", (delta, oldDelta, source) => {
                var html = this.quill.getHTML();
                // var html = this.quill.getText();
                this.txtArea.value = html;
            });
            this.content = this.value;
        },
        watch: {
            content() {
                this.rawContent = this.content;
            },
            rawContent() {
                this.content = this.rawContent;
            }
        },
        methods: {
            updateValue () {
                this.$emit('input', this.$refs.editor.quill.getHTML())
            }
        }
    }
</script>

<style>
    .quillWrapper {
        line-height: normal;
    }
    span.ql-formats:first-child > .ql-picker,
    span.ql-header.ql-picker {
        border: 1px solid #ddd;
        display: flex;
        height: 100%;
        padding: 2px;
        box-shadow: inset 0 1px 1px -1px rgba(0, 0, 0, 0.2);
        background: white;
    }
    .ql-toolbar.ql-snow {
        border: 1px solid #eee !important;
        background: #f5f5f58c;
        border-radius: 0 0 4px 4px;
    }
    .ql-container.ql-snow {
        background: #fff;
        width: 100%;
        min-height: 200px;
        border-top: 0 !important;
        border-left: 1px solid #ddd !important;
        border-right: 1px solid #ddd !important;
        border-bottom: 1px solid #ddd !important;
    }
    .ql-stroke {
        stroke: #555d66 !important;
    }
    .ql-snow .ql-fill,
    .ql-snow .ql-stroke.ql-fill {
        fill: #555d66 !important;
    }
    .ql-editor.ql-blank::before {
        color: rgba(0, 0, 0, 0.3) !important;
        font-style: normal !important;
    }
    .ql-editor {
        min-height: 250px;
        font-size: 14px;
        line-height: 24px;
    }
    .ql-container {
        font-size: 14px;
        line-height: 24px;
    }
    .ql-container p {
        margin-bottom: 10px;
    }
    .ql-formats button:hover,
    .ql-formats .ql-picker:hover {
        background: #abd4ff73 !important;
    }
    .ql-formats .ql-header.ql-picker:hover,
    .ql-formats .ql-font.ql-picker:hover {
        background: white !important;
        border-color: #b4b9be;
    }
    .ql-picker-label {
        display: flex !important;
    }
    .ql-align.ql-picker.ql-icon-picker .ql-picker-label {
        display: block !important;
    }

    .ql-showSource:after {
        content: "[source]";
    }
    button.ql-showSource {
        width: 100% !important;
    }

    .ql-showHtml:after {
        content: "[paste HTML mode]";
    }
    button.ql-showHtml {
        width: 100% !important;
    }
</style>
