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

const CURRENT_TAB = 'store/currentTab'
const CURRENT_CONTENT = 'store/currentContent'

const state = reactive({
  currentTab: null,
  currentContent: null
})

const setCurrentTab = (tab) => {
  sessionStorage.setItem(CURRENT_TAB, JSON.stringify(tab))
  state.currentTab = tab
}

const setCurrentContent = (content) => {
  sessionStorage.setItem(CURRENT_CONTENT, JSON.stringify(content))
  state.currentContent = content
}

const currentTab = computed(() => {
  if (!state.currentTab) { state.currentTab = JSON.parse(sessionStorage.getItem(CURRENT_TAB)) }
  return state.currentTab
})
const currentContent = computed(() => {
  if (!state.currentContent) { state.currentContent = JSON.parse(sessionStorage.getItem(CURRENT_CONTENT)) }
  return state.currentContent
})

export const tabStore = readonly({
  state: state,
  actions: {
    setCurrentTab,
    setCurrentContent
  },
  getters: {
    currentTab,
    currentContent
  }
})
