<template>
    <div>
        <vue-editor
            v-model="content"
            :editorOptions="editorSettings"
            :customModules="customModulesForEditor"
            ref="myTextEditor"
        ></vue-editor>
    </div>
</template>

<script>


    import {VueEditor} from 'vue2-editor'
    import { ImageDrop } from 'quill-image-drop-module'
    import ImageResize  from 'quill-image-resize-module'
    export default {
        components: {
            VueEditor
        },
        data() {
            return {
                content: '<h2 class="ql-align-center"><span class="ql-font-serif">Text content loading..</span></h2>',
                customModulesForEditor: [
                    { alias: 'imageDrop', module: ImageDrop },
                    { alias: 'imageResize', module: ImageResize }
                ],
                editorSettings: {
                    modules: {
                        imageDrop: true,
                        imageResize: {},
                        toolbar: {container: [
                                ['bold', 'italic', 'underline', 'strike' ],
                                [{ 'size': ['small', false, 'large', 'huge'] }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['image', 'video', 'code-block'],
                                [{ 'font': [] }],
                                ['clean'],
                                ['omega']
                            ],
                            handlers: {
                                'omega': () => {
                                    var range = this.editor.getSelection();
                                    if (range) {
                                        this.editor.insertText(range.index, "Ω");
                                    }
                                }
                            }
                        }
                    },
                    theme: 'snow'
                }
            }
        },
        computed: {
            editor() {
                return this.$refs.myTextEditor.quill
            },
        },

    }
</script>
