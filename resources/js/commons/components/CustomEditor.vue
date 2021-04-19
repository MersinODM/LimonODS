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
    :editor="editor"
    :config="editorConfig"
  />
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue'
export default {
  name: 'CustomEditor',
  components: { ckeditor: CKEditor.component },
  props: {
    // config: {
    //   type: Object,
    //   required: true
    // },
    // modelValue: {
    //   type: String,
    //   required: false,
    //   default: ''
    // }
  },
  setup (props) {
    return {
      // eslint-disable-next-line no-undef
      editor: ClassicEditor,
      editorConfig: {
        math: {
          engine: 'katex',
          outputType: 'script',
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
        image: {
          toolbar: [
            'imageTextAlternative',
            'imageStyle:full',
            'imageStyle:side'
          ]
        },
        table: {
          contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells',
            'tableCellProperties',
            'tableProperties'
          ]
        },
        simpleUpload: {
          // The URL that the images are uploaded to.
          uploadUrl: 'http://localhost/api/storage',

          // Enable the XMLHttpRequest.withCredentials property.
          withCredentials: true

          // Headers sent along with the XMLHttpRequest to the upload server.
          // headers: {
          //   'X-CSRF-TOKEN': 'CSRF-Token',
          //   Authorization: 'Bearer <JSON Web Token>'
          // }
        },
        licenseKey: ''
      }
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
