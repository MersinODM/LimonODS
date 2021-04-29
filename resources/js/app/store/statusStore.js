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

import { reactive, computed, readonly } from 'vue'
// import now from '../helpers/dayjs'

import constants from '../utils/constants'
const { STATUS } = constants()

const state = reactive({
  status: null
})

const setCurrentStatus = (status) => {
  sessionStorage.setItem(STATUS, JSON.stringify(status))
  state.status = status
}

const status = computed(() => {
  if (!state.status) { state.status = JSON.parse(sessionStorage.getItem(STATUS)) }
  return state.status
})

export const statusStore = readonly({
  state: state,
  actions: {
    setCurrentStatus
  },
  getters: {
    status
  }
})
