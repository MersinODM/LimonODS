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
import http from '../utils/http'
import { ResponseCodes } from '../../commons/utils/constants'
import Messenger from '../../commons/utils/messenger'

// class CustomUploadAdapter {
//   constructor (loader) {
//     this.loader = loader
//   }
//
//   upload () {
//     return new Promise((resolve, reject) => {
//       this.loader.file
//         .then((image) => {
//           const data = new FormData()
//           data.append('image', image)
//           http.post('api/v1/storage', data,
//             {
//               headers: {
//                 'Content-Type': 'multipart/form-data;'
//               }
//             })
//             .then(response => {
//               if (response.code === ResponseCodes.CODE_SUCCESS) {
//                 resolve({ default: response.url })
//               } else {
//                 // eslint-disable-next-line prefer-promise-reject-errors
//                 reject()
//               }
//             })
//             .catch(e => {
//               Messenger.showWarning('Resim yükleme hatası lütfen sistem yönteicinize başvurunuz!')
//               // eslint-disable-next-line prefer-promise-reject-errors
//               reject()
//             })
//         })
//       //
//       // return this.loader.file
//       //   .then(uploadedFile => {
//       //     return new Promise((resolve, reject) => {
//       //       const data = new FormData()
//       //       data.append('image', uploadedFile)
//       //       http.post('api/v1/storage',
//       //         data,
//       //         {
//       //           headers: {
//       //             'Content-Type': 'multipart/form-data;'
//       //           }
//       //         }
//       //       ).then(response => {
//       //         if (response.code === ResponseCodes.CODE_SUCCESS) {
//       //           resolve({
//       //             default: response.data.url
//       //           })
//       //         } else {
//       //           reject(response.data.message)
//       //         }
//       //       })
//       //         .catch(response => {
//       //           reject('Upload failed')
//       //         })
//       //     })
//       //   })
//     })
//   }
//
//   abort () {
//   }
// }

function CustomUploadAdapter (loader) {
  this.loader = loader
  this.upload = async () => {
    const uploadedFile = await this.loader.file

    const data = new FormData()
    data.append('image', uploadedFile)

    try {
      const response = await http.post('api/v1/storage', data,
        {
          headers: {
            'Content-Type': 'multipart/form-data;'
          }
        })
      if (response.data.code === ResponseCodes.CODE_SUCCESS) {
        return {
          default: response.data.url
        }
      } else {
        return response.data.message
      }
    } catch (e) {
      console.log(e)
    }
  }
  this.abort = () => {
    console.log('Abort upload.')
  }
}

function CustomUploadAdapterPlugin (editor) {
  editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
    return new CustomUploadAdapter(loader)
  }
}

export
default {
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
        image: {
          // Configure the available styles.
          styles: [
            'alignLeft', 'alignCenter', 'alignRight'
          ],

          // Configure the available image resize options.
          resizeOptions: [
            {
              name: 'resizeImage:original',
              label: 'Gerçek boyut',
              value: null
            },
            {
              name: 'resizeImage:25',
              label: '25%',
              value: '25'
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
        table: {
          contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells',
            'tableCellProperties',
            'tableProperties'
          ]
        },
        extraPlugins: [CustomUploadAdapterPlugin],
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
