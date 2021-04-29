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

import { inject, ref } from 'vue'

export default function () {
  const store = inject('tabStore')
  const selectedTab = ref()
  const setCurrentTab = (tab = null) => {
    if (tab !== null) {
      store.actions.setCurrentTab(tab)
    }
    selectedTab.value = store.getters.currentTab
  }

  const getCurrentTab = () => {
    selectedTab.value = store.getters.currentTab
    return selectedTab
  }

  const setCurrentContent = (content = null) => {
    if (content !== null) {
      store.actions.setCurrentContent(content)
    }
    selectedTab.value = store.getters.currentTab
  }

  const getCurrentContent = () => {
    selectedTab.value = store.getters.currentContent
    return selectedTab
  }

  return {
    getCurrentTab,
    setCurrentTab,
    setCurrentContent,
    getCurrentContent
  }
}
