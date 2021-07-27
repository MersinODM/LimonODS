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
import http from '../../app/utils/http'

const AnswerService = {
  save: async (data) => {
    try {
      const response = await http.post('api/studentanswers', data)
      return response.data
    } catch (e) {
    }
  },
  update: async (data) => {
    try {
      const response = await http.put('api/studentanswers', data)
      return response.data
    } catch (e) {}
  },
  delete: async (data) => {
    try {
      console.log(data)
      const response = await http.delete('api/studentanswers', data)
      console.log(data)
      return response.data
    } catch (e) {
      // console.log(data)
    }
  },
  get: async (data) => {
    try {
      console.log(data)
      const response = await http.get('api/studentanswers', data)
      console.log(data)
      return response.data
    } catch (e) {
      // console.log(data)
    }
  }
}

export default AnswerService
