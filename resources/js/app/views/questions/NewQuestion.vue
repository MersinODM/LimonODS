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
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Ders Seçimi</label>
                <multiselect
                  v-model="selectedLesson"
                  name="lesson"
                  label="name"
                  value-prop="id"
                  :options="lessons"
                  :class="{ 'select-error': lessonEM }"
                />
                <div
                  v-if="lessonEM"
                  role="alert"
                  class="invalid-feedback order-last"
                  style="display: inline-block;"
                >
                  {{ lessonEM }}
                </div>
              </div>
              <div class="form-group">
                <label>Sınıf Seçimi</label>
                <multiselect
                  v-model="selectedLevel"
                  name="level"
                  :options="levels"
                  :class="{ 'select-error': levelEM }"
                />
                <div
                  v-if="levelEM"
                  role="alert"
                  class="invalid-feedback order-last"
                  style="display: inline-block;"
                >
                  {{ levelEM }}
                </div>
              </div>
              <!--              <div class="form-group">-->
              <!--                <label>Ünite Seçimi</label>-->
              <!--                <multiselect-->
              <!--                  v-model="selectedLevel"-->
              <!--                  :options="levels"-->
              <!--                  :class="{ 'select-error': lessonEM }"-->
              <!--                />-->
              <!--                <div-->
              <!--                  v-if="lessonEM"-->
              <!--                  role="alert"-->
              <!--                  class="invalid-feedback order-last"-->
              <!--                  style="display: inline-block;"-->
              <!--                >-->
              <!--                  {{ lessonEM }}-->
              <!--                </div>-->
              <!--              </div>-->
              <div class="form-group">
                <label>Zorluk Seçimi</label>
                <multiselect
                  v-model="selectedDifficulty"
                  name="difficulty"
                  :options="difficulties"
                  :class="{ 'select-error': difficultyEM }"
                />
                <div
                  v-if="difficultyEM"
                  role="alert"
                  class="invalid-feedback order-last"
                  style="display: inline-block;"
                >
                  {{ difficultyEM }}
                </div>
              </div>
              <!--              <div class="form-group">-->
              <!--                <label>Konu Seçimi</label>-->
              <!--                <multiselect-->
              <!--                  v-model="selectedLevel"-->
              <!--                  :options="levels"-->
              <!--                  :class="{ 'select-error': lessonEM }"-->
              <!--                />-->
              <!--                <div-->
              <!--                  v-if="lessonEM"-->
              <!--                  role="alert"-->
              <!--                  class="invalid-feedback order-last"-->
              <!--                  style="display: inline-block;"-->
              <!--                >-->
              <!--                  {{ lessonEM }}-->
              <!--                </div>-->
              <!--              </div>-->
              <div class="form-group">
                <label>Kazanım Seçimi</label>
                <multiselect
                  v-model="selectedCurriculum"
                  name="curriculum"
                  :options="searchLO"
                  :searchable="true"
                  mode="multiple"
                  label="content"
                  :multiple-label="(values) => values.length + ' kazanım seçildi'"
                  value-prop="id"
                  :filter-results="false"
                  :min-chars="1"
                  :resolve-on-load="false"
                  :delay="300"
                  :class="{ 'select-error': curriculumEM }"
                />
                <div
                  v-if="curriculumEM"
                  role="alert"
                  class="invalid-feedback order-last"
                  style="display: inline-block;"
                >
                  {{ curriculumEM }}
                </div>
              </div>
              <div class="form-group">
                <button
                  class="btn btn-primary btn-block"
                  @click="save"
                >
                  Kaydet
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <tabs>
            <tab title="Düzenleme">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Madde</label>
                    <custom-editor
                      v-model="content"
                      :style="{'min-height': 12 + 'em' }"
                    />
                  </div>
                </div>
              </div>
              <c-exam
                :choices="choices"
                name="choices"
              />
              <div
                v-if="choicesEM"
                role="alert"
                class="invalid-feedback order-last"
                style="display: inline-block;"
              >
                {{ choicesEM }}
              </div>
            </tab>
            <tab title="Önizleme">
              <div class="card">
                <div class="card-body">
                  <div
                    v-katex:auto
                    class="ck-content"
                    v-html="content"
                  />
                </div>
              </div>
            </tab>
          </tabs>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../../commons/components/Page'
import Multiselect from '@vueform/multiselect'
import { number, object, string, array, addMethod } from 'yup'
import { useField, useForm } from 'vee-validate'
import { reactive, ref, toRefs, watch } from 'vue'
import LessonService from '../../services/LessonService'
import CustomEditor from '../../../commons/components/CustomEditor'
import Tabs from '../../../commons/components/Tabs'
import Tab from '../../../commons/components/Tab'
import CExam from '../../../commons/components/Choices'
import CurriculumService from '../../services/CurriculumService'

addMethod(array, 'atLeastOneTruth', (args) => {
  const { message, predicate } = args
  return this?.test('atLeastOneTruth', message, (list) => {
    // If there are 2+ elements after filtering, we know atMostOne must be false.
    return list.filter(predicate).length === 1
  })
})

export default {
  name: 'NewQuestion',
  components: { CExam, CustomEditor, Page, Multiselect, Tabs, Tab },
  setup () {
    const data = reactive({
      lessons: [],
      levels: [], // Bu lessons tan gelebilir
      units: [],
      topics: [],
      choices: [],
      learningOutcomes: [],
      difficulties: [
        { value: 1, label: 'Çok Kolay' },
        { value: 2, label: 'Kolay' },
        { value: 3, label: 'Normal' },
        { value: 4, label: 'Zor' },
        { value: 5, label: 'Çok Zor' }
      ]
    })

    const context = ref('')
    const body = ref('')
    const content = ref('')

    const schema = object({
      lesson: number().typeError(() => 'Ders seçimi yapılmaldır!')
        .required(() => 'Ders seçimi yapılmaldır!'),
      difficulty: number().typeError(() => 'Zorluk seçimi yapılmaldır!')
        .required(() => 'Zorluk seçimi yapılmaldır!'),
      level: number().typeError(() => 'Seviye seçimi yapılmaldır!')
        .required(() => 'Seviye seçimi yapılmaldır!'),
      curriculum: array().of(
        number().typeError(() => 'Kazanım bilgisi kazanım id\'si olmalıdır!')
      )
        .typeError(() => 'En az bir kazanım seçimi yapılmalıdır!')
        .required(() => 'En az bir kazanım seçimi yapılmalıdır!')
        .min(1, () => 'En az bir kazanım seçimi yapılmaldır!')
        .strict(),
      body: string().typeError('Soru kök ü yazı veri tipinde olmalıdır')
        .required(() => 'Soru kökü gereklidir'),
      choices: array()
        .min(3, () => 'En az 3 seçenek eklenmelidir!')
        .max(5, () => 'En fazla 5 seçenek eklenmelidir!')

    })

    const { handleSubmit } = useForm({
      validationSchema: schema
    })

    const { value: selectedLesson, errorMessage: lessonEM } = useField('lesson')
    const { value: selectedLevel, errorMessage: levelEM } = useField('level')
    const { value: selectedDifficulty, errorMessage: difficultyEM } = useField('difficulty')
    const { value: selectedCurriculum, errorMessage: curriculumEM } = useField('curriculum')
    const { value: choices, errorMessage: choicesEM } = useField('choices')
    choices.value = data.choices
    const save = handleSubmit(async values => {
      await console.log(values)
    })

    const getLessons = async () => {
      data.lessons = await LessonService.getLessons()
    }

    const searchLO = async (text) => {
      const queryParams = { param: text, level: selectedLevel.value }
      return await CurriculumService.find(queryParams)
    }

    watch(selectedLesson, (newVal, oldVal) => {
      selectedLevel.value = null
      data.levels = data.lessons
        .find((l) => l?.id === newVal)
        ?.levels
        .split(',')
        .map(Number)
    })

    getLessons()

    return {
      ...toRefs(data),
      content,
      selectedLesson,
      lessonEM,
      selectedLevel,
      levelEM,
      selectedCurriculum,
      curriculumEM,
      selectedDifficulty,
      difficultyEM,
      choicesEM,
      context,
      body,
      save,
      searchLO
    }
  }
}
</script>

<style scoped>

</style>
