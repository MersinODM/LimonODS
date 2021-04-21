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
                  name="room"
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
                  :options="levels"
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
                <label>Ünite Seçimi</label>
                <multiselect
                  v-model="selectedLevel"
                  :options="levels"
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
                <label>Konu Seçimi</label>
                <multiselect
                  v-model="selectedLevel"
                  :options="levels"
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
                <label>Kazanım Seçimi</label>
                <multiselect
                  v-model="selectedLevel"
                  :options="levels"
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
              <c-exam :choices="choices" />
              <!--                <div class="col-md-12">-->
              <!--                  <div-->
              <!--                    v-for="(choice, index) in choices"-->
              <!--                    :key="index"-->
              <!--                    class="form-group"-->
              <!--                  >-->
              <!--                    <div class="row md-1">-->
              <!--                      <div class="col-md-12">-->
              <!--                        <label>Seçenek {{ index + 1 }}</label>-->
              <!--                        <button-->
              <!--                          class="btn btn-warning btn-sm float-right"-->
              <!--                          @click="removeChoice(index)"-->
              <!--                        >-->
              <!--                          Sil-->
              <!--                        </button>-->
              <!--                      </div>-->
              <!--                    </div>-->
              <!--                    <custom-editor v-model="choice.content" />-->
              <!--                    <pretty-check-->
              <!--                      v-model="choice.isCorrect"-->
              <!--                      @change="correctChoiceChanged(index)"-->
              <!--                    >-->
              <!--                      Doğru cevap-->
              <!--                    </pretty-check>-->
              <!--                  </div>-->
              <!--                </div>-->
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
import { number, object, string, array } from 'yup'
import { useField, useForm } from 'vee-validate'
import { ref, watch } from 'vue'
import LessonService from '../../services/LessonService'
import CustomEditor from '../../../commons/components/CustomEditor'
import Tabs from '../../../commons/components/Tabs'
import Tab from '../../../commons/components/Tab'
import CExam from '../../../commons/components/Choices'

export default {
  name: 'NewQuestion',
  components: { CExam, CustomEditor, Page, Multiselect, Tabs, Tab },
  setup () {
    const lessons = ref([])
    const levels = ref([]) // Bu lessons tan gelebilir
    const units = ref([])
    const topics = ref([])
    const learningOutcomes = ref([])
    const context = ref('')
    const body = ref('')
    const content = ref('')
    const choices = []

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

    const getLessons = async () => {
      lessons.value = await LessonService.getLessons()
    }

    watch(selectedLesson, (newVal, oldVal) => {
      selectedLevel.value = null
      levels.value = lessons.value
        .find((l) => l?.id === newVal)
        ?.levels
        .split(',')
        .map(Number)
    })

    getLessons()

    return {
      // addChoice,
      // removeChoice,
      // correctChoiceChanged,
      choices,
      content,
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
