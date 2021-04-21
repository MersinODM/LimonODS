/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */
import http from '../../../app/utils/http'

class AxiosAdapter {
  constructor (loader) {
    this.loader = loader
  }

  async upload () {
    const data = new FormData()
    data.append('image', await this.loader.file)
    const res = await http.post('api/v1/storage', data, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    console.log(res.data)
    // Backstage returns data:
    // {"code":0,"msg":"success","data":{"url":"/upload/struts2.jpeg"}}

    // Method Returns data format: {Default: "URL"}
    return {
      default: res.data.url
    }
  }
}

export default AxiosAdapter
