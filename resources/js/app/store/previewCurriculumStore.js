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

import { computed, reactive, readonly } from 'vue'
import constants from '../utils/constants'

const {
  PREVIEW_CURRICULUMS
} = constants()
const state = reactive({
  curriculums: []
})

const setCurriculums = (curriculums) => {
  state.curriculums = curriculums
  sessionStorage.setItem(PREVIEW_CURRICULUMS, JSON.stringify(state.curriculums))
}

const curriculums = computed(() => {
  if (!state.curriculums) { state.curriculums = JSON.parse(sessionStorage.getItem(PREVIEW_CURRICULUMS)) }
  return state.curriculums
})

export default {
  state: readonly(state),
  actions: {
    setCurriculums
  },
  getters: {
    curriculums
  }
}
