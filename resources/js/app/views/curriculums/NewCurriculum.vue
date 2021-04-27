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
      <h4>Yeni Kazanım(Test Amaçlıdır)</h4>
    </template>
    <template #content>
      <div class="row justify-content-center">
        <div class="col-md-6">
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
                  :searchable="true"
                  :track-by="'name'"
                  :class="{ 'select-error': lessonEM }"
                >
                  <template #noresults>
                    <div class="multiselect-option">
                      <div
                        class="row"
                        @mousedown.prevent
                      >
                        <button
                          class="btn btn-primary btn-block float-right"
                          @mousedown.prevent="showModal = !showModal"
                        >
                          Ekle
                        </button>
                      </div>
                    </div>
                  </template>
                </multiselect>
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
                  v-model="selectedLesson"
                  name="units"
                  label="name"
                  value-prop="id"
                  :options="lessons"
                  :searchable="true"
                  :track-by="'name'"
                >
                  <template #nooptions>
                    <div class="multiselect-option">
                      <div
                        class="row"
                        @mousedown.prevent
                      >
                        <button
                          class="btn btn-primary btn-block float-right"
                          @mousedown.prevent="showModal = !showModal"
                        >
                          Ekle
                        </button>
                      </div>
                    </div>
                  </template>
                </multiselect>
              </div>
              <div class="form-group">
                <label>Konu</label>
                <multiselect
                  v-model="selectedLesson"
                  name="lesson"
                  label="name"
                  value-prop="id"
                  :options="lessons"
                >
                  <template #nooptions>
                    <div class="multiselect-option">
                      <div
                        class="row"
                        @mousedown.prevent
                      >
                        <button
                          class="btn btn-primary btn-block float-right"
                          @mousedown.prevent="showModal = !showModal"
                        >
                          Ekle
                        </button>
                      </div>
                    </div>
                  </template>
                </multiselect>
              </div>
              <div class="from-group mt-2">
                <label>Kazanım Kodu</label>
                <input
                  class="form-control"
                  type="text"
                >
              </div>
              <div class="from-group mt-2">
                <label>Kazanım İçeriği</label>
                <textarea
                  class="form-control"
                  type="text"
                  style="min-height: 5em"
                />
              </div>
              <div class="row mt-2 justify-content-md-center">
                <div class="col-md-4">
                  <button class="btn btn-primary btn-block">
                    Kaydet
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          v-if="showModal"
          id="modal-default"
          class="modal fade show"
          style="display: block; padding-right: 15px;"
          aria-modal="true"
          role="dialog"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">
                  Default Modal
                </h4>
                <button
                  type="button"
                  class="close"
                  aria-label="Close"
                  @click="showModal = false"
                >
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <p>One fine body…</p>
              </div>
              <div class="modal-footer justify-content-between">
                <button
                  type="button"
                  class="btn btn-default"
                  @click="showModal = false"
                >
                  Kapat
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                >
                  Kaydet
                </button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../../commons/components/Page'
import Multiselect from '@vueform/multiselect'
import { reactive, toRefs } from 'vue'
import { number, object } from 'yup'
import { useField, useForm } from 'vee-validate'
import LessonService from '../../services/LessonService'

export default {
  name: 'NewCurriculum',
  components: {
    Page, Multiselect
  },
  setup () {
    const datas = reactive({
      lessons: [],
      showModal: false
    })

    const schema = object({
      lesson: number().typeError(() => 'Ders seçimi yapılmaldır!')
        .required(() => 'Ders seçimi yapılmaldır!')
    })

    const { handleSubmit } = useForm({
      validationSchema: schema
    })

    const { value: selectedLesson, errorMessage: lessonEM } = useField('lesson')

    const getLessons = async () => {
      datas.lessons = await LessonService.getLessons()
    }

    getLessons()
    return {
      selectedLesson,
      lessonEM,
      ...toRefs(datas)
    }
  }
}
</script>

<style scoped>

</style>
