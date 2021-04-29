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

import { inject, ref, watch } from 'vue'

export default function () {
  const store = inject('statusStore')
  const selectedStatus = ref(store.getters.status)

  const statuses = [
    { value: 100, label: 'İşleme alınmamış' },
    { value: 101, label: 'Değerlendirme aşamasında' },
    { value: 102, label: 'Revizyon alması gerek' },
    { value: 103, label: 'Sorulamayacak soru' },
    { value: 104, label: 'Revizyonu tamamlandı' },
    { value: 104, label: 'Havuzda' }
  ]

  watch(selectedStatus, () => {
    store.actions.setCurrentStatus(selectedStatus)
  })

  return {
    selectedStatus,
    statuses
  }
}
