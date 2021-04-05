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
  <page>
    <template #header>
      <h4>Yeni Soru</h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-8" />
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../../commons/components/Page'
import Multiselect from '@vueform/multiselect'
import { number, object, string, array } from 'yup'
import { useField, useForm } from 'vee-validate'
import { ref } from 'vue'
export default {
  name: 'NewQuestion',
  components: { Page, Multiselect },
  setup () {
    const lessons = ref([])
    const levels = ref([]) // Bu lessons tan gelebilir
    const units = ref([])
    const topics = ref([])
    const learningOutcomes = ref([])
    const context = ref('')
    const body = ref('')

    const schema = object({
      lesson: number().typeError(() => 'Ders seçimi yapılmaldır!')
        .required(() => 'Ders seçimi yapılmaldır!'),
      level: number().typeError(() => 'Seviye seçimi yapılmaldır!')
        .required(() => 'Seviye seçimi yapılmaldır!'),
      learningOutcomeList: array(
        number().typeError(() => 'Kazanım bilgisi kazanım id\'si olmalıdır!')
      ).min(1, () => 'En az bir kazanım seçimi yapılmaldır!'),
      body: string().typeError('Soru kökü yazı veri tipinde olmalıdır')
        .required(() => 'Soru kökü gereklidir'),
      choices: array(string().required(() => 'Seçenek içeriği gereklidir!'))
        .min(3, () => 'En az 3 seçenek eklenmelidir!')
        .max(5, () => 'En fazla 5 seçenek eklenmelidir!')
    })

    const { handleSubmit } = useForm({
      validationSchema: schema
    })

    const { value: selectedLesson, errorMessage: lessonEM } = useField('lesson')
    const { value: selectedLevel, errorMessage: levelEM } = useField('level')
    const { value: selectedLearningOutcomes, errorMessage: learningOutcomesEM } = useField('learningOutcomeList')

    const save = handleSubmit(async values => {
      await console.log(values)
    })

    return {
      selectedLesson,
      lessonEM,
      lessons,
      selectedLevel,
      levelEM,
      levels,
      units,
      topics,
      selectedLearningOutcomes,
      learningOutcomesEM,
      learningOutcomes,
      context,
      body,
      save
    }
  }
}
</script>

<style scoped>

</style>
