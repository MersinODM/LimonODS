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
import dayjs from 'dayjs'

export default function () {
  const store = inject('filterStore')
  const selectedYear = ref()

  const years = Array.from({ length: dayjs().year() - 2019 + 1 }, (v, k) => {
    const year = dayjs().year() - k
    return { label: year, value: year }
  })

  const setDefaultYear = () => {
    // if (!store.getters.year) store.actions.setYear(now().year())
    selectedYear.value = store.getters.year
  }

  return {
    years,
    selectedYear,
    setDefaultYear
  }
}
