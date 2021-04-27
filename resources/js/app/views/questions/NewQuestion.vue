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
                  :options="searchCurriculum"
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
                      v-model="root"
                      name="root"
                      :style="{'min-height': 12 + 'em' }"
                    />
                    <div
                      v-if="rootEM"
                      role="alert"
                      class="invalid-feedback order-last"
                      style="display: inline-block;"
                    >
                      {{ rootEM }}
                    </div>
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
              <question :question="question" />
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
import { number, object, string, array } from 'yup'
import { useField, useForm } from 'vee-validate'
import { reactive, ref, toRefs, watch } from 'vue'
import LessonService from '../../services/LessonService'
import CustomEditor from '../../../commons/components/CustomEditor'
import Question from '../../../commons/components/exams/Question'
import Tabs from '../../../commons/components/Tabs'
import Tab from '../../../commons/components/Tab'
import CExam from '../../../commons/components/Choices'
import CurriculumService from '../../services/CurriculumService'
import Messenger from '../../../commons/utils/messenger'
import QuestionService from '../../services/QuestionService'

export default {
  name: 'NewQuestion',
  components: { CExam, CustomEditor, Page, Multiselect, Tabs, Tab, Question },
  setup () {
    const data = reactive({
      lessons: [],
      levels: [], // Bu lessons tan gelebilir
      units: [],
      topics: [],
      question: {
        context: '',
        body: '',
        choices: []
      },
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
    // const state = inject('ChoicesProvider')
    const context = ref('')
    const body = ref('')

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
      root: string().typeError('Soru kökü yazı veri tipinde olmalıdır')
        .required(() => 'Madde kökü gereklidir!'),
      choices: array(
        object().shape({
          content: string().required()
            .label('Content')
        })
      )
        .test('atLeastOneTruth', 'Sadece 1 tane cevap doğru seçilmelidir!', (value) => {
          return value.filter(v => v.isCorrect).length === 1
        })
        .min(3, () => 'En az 3 seçenek eklenmelidir!')
        .max(5, () => 'En fazla 5 seçenek eklenmelidir!')

    })

    const { handleSubmit } = useForm({
      validationSchema: schema
    })
    // state.form = form

    const { value: selectedLesson, errorMessage: lessonEM } = useField('lesson')
    const { value: selectedLevel, errorMessage: levelEM } = useField('level')
    const { value: selectedDifficulty, errorMessage: difficultyEM } = useField('difficulty')
    const { value: selectedCurriculum, errorMessage: curriculumEM } = useField('curriculum')
    const { value: choices, errorMessage: choicesEM } = useField('choices')
    const { value: root, errorMessage: rootEM } = useField('root')
    choices.value = data.choices
    data.question.choices = data.choices

    watch(root, (newVal) => {
      data.question.body = newVal
    })

    const save = handleSubmit(async values => {
      const rule = data.choices.filter(c => c.content === null).length > 0
      if (rule) {
        await Messenger.showWarning('Tüm seçenekler doldurulmalıdır')
        return
      }
      const promptResult = await Messenger.showPrompt('Bu soruyu kaydetmek istediğinize emin misiniz?')
      if (promptResult.isConfirmed) {
        const questionData = {
          type: 0,
          lesson_id: selectedLesson.value,
          level: selectedLevel.value,
          curriculums: selectedCurriculum.value,
          difficulty: selectedDifficulty.value,
          body: data.question.body,
          choices: data.question.choices
        }
        await console.log(questionData)
        await QuestionService.save(questionData)
      }
    })

    // Dersleri listeleyen fonk.
    const getLessons = async () => {
      data.lessons = await LessonService.getLessons()
    }

    // Kazanım arama fonk.
    const searchCurriculum = async (text) => {
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
      root,
      rootEM,
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
      searchCurriculum
    }
  }
}
</script>

<style scoped>

</style>
