<!--
  -     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
  -
  -     Licensed under the Apache License, Version 2.0 (the "License");
  -     you may not use this file except in compliance with the License.
  -     You may obtain a copy of the License at
  -
  -       http://www.apache.org/licenses/LICENSE-2.0
  -
  -     Unless required by applicable law or agreed to in writing, software
  -     distributed under the License is distributed on an "AS IS" BASIS,
  -     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  -     See the License for the specific language governing permissions and
  -     limitations under the License.
  -
  -->

<template>
  <ckeditor
    style="height:auto;"
    :model-value="modelValue"
    :editor="editor"
    :config="editorConfig"
    @input="$emit('update:modelValue', $event)"
    @ready="onReady"
  />
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue'
import AxiosAdapter from '../ckeditor/utils/AxiosAdapter'
const defaultConfig = {
  math: {
    engine: 'katex',
    outputType: 'span',
    forceOutputType: false,
    enablePreview: true
  },
  toolbar: {
    items: [
      'bold',
      'italic',
      'link',
      'bulletedList',
      'numberedList',
      'subscript',
      'superscript',
      'underline',
      'alignment',
      '|',
      'outdent',
      'indent',
      '|',
      'math',
      'specialCharacters',
      'imageUpload',
      'blockQuote',
      'insertTable',
      'undo',
      'redo'
    ]
  },
  language: 'tr',
  table: {
    contentToolbar: [
      'tableColumn',
      'tableRow',
      'mergeTableCells',
      'tableCellProperties',
      'tableProperties'
    ]
  },
  image: {
    // Configure the available styles.
    styles: [
      'alignLeft', 'alignCenter', 'alignRight'
    ],

    // Configure the available image resize options.
    resizeOptions: [
      {
        name: 'resizeImage:original',
        label: 'Original',
        value: null
      },
      {
        name: 'resizeImage:50',
        label: '50%',
        value: '50'
      },
      {
        name: 'resizeImage:75',
        label: '75%',
        value: '75'
      }
    ],
    // You need to configure the image toolbar, too, so it shows the new style
    // buttons as well as the resize buttons.
    toolbar: [
      'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
      '|',
      'resizeImage',
      '|',
      'imageTextAlternative'
    ]
  },
  licenseKey: ''
}

export default {
  name: 'CustomEditor',
  components: { ckeditor: CKEditor.component },
  props: {
    config: {
      required: false,
      default: defaultConfig
    },
    modelValue: {
      type: String,
      required: false,
      default: ''
    }
  },
  emits: ['update:modelValue'],
  setup (props) {
    const onReady = (editor) => {
      editor.plugins.get('FileRepository').createUploadAdapter = loader => {
        return new AxiosAdapter(loader)
      }
    }

    return {
      onReady,
      // eslint-disable-next-line no-undef
      editor: ClassicEditor,
      editorConfig: props.config
    }
    // onMounted(() => {
    //   ClassicEditor
    //     .create(document.querySelector('#editor'), {
    //       math: {
    //         engine: 'katex',
    //         outputType: 'script',
    //         forceOutputType: false,
    //         enablePreview: true
    //       },
    //       toolbar: {
    //         items: [
    //           'bold',
    //           'italic',
    //           'link',
    //           'bulletedList',
    //           'numberedList',
    //           'subscript',
    //           'superscript',
    //           'underline',
    //           'alignment',
    //           '|',
    //           'outdent',
    //           'indent',
    //           '|',
    //           'math',
    //           'specialCharacters',
    //           'imageUpload',
    //           'blockQuote',
    //           'insertTable',
    //           'undo',
    //           'redo'
    //         ]
    //       },
    //       language: 'tr',
    //       image: {
    //         toolbar: [
    //           'imageTextAlternative',
    //           'imageStyle:full',
    //           'imageStyle:side'
    //         ]
    //       },
    //       table: {
    //         contentToolbar: [
    //           'tableColumn',
    //           'tableRow',
    //           'mergeTableCells',
    //           'tableCellProperties',
    //           'tableProperties'
    //         ]
    //       },
    //       licenseKey: ''
    //
    //     })
    //     .then(editor => {
    //       window.editor = editor
    //     })
    //     .catch(error => {
    //       console.error('Oops, something went wrong!')
    //       console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:')
    //       console.warn('Build id: 14nbyztuod5v-3ae9ht8su7oc')
    //       console.error(error)
    //     })
    // })
  }
}
</script>

<style scoped>

</style>
