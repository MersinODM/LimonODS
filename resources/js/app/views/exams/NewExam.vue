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
      <h4>
        <span class="text-bold text-blue"> Yeni</span> Sınav <span
          v-if="selectedLevel"
          class="text-bold text-green"
        >{{ selectedLevel }}. Sınıflar</span>
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <tabs>
            <tab title="Sınav Bilgileri">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Sınav Adı</label>
                    <input
                      v-model="title"
                      name="title"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': titleEM != null}"
                    >
                    <div
                      v-if="titleEM"
                      role="alert"
                      class="invalid-feedback order-last"
                      style="display: inline-block;"
                    >
                      {{ titleEM }}
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Sınav Türü</label>
                      <multiselect
                        v-model="selectedType"
                        name="type"
                        :options="examTypes"
                        :class="{ 'select-error': typeEM}"
                      />
                      <div
                        v-if="typeEM"
                        role="alert"
                        class="invalid-feedback order-last"
                        style="display: inline-block;"
                      >
                        {{ typeEM }}
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Sınıf Seviyesi</label>
                      <multiselect
                        v-model="selectedLevel"
                        name="level"
                        :options="levels"
                        :class="{ 'select-error': levelEM}"
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
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Sınav Başlangıç Tarihi</label>
                      <date-picker
                        v-model="startDate"
                        mode="dateTime"
                        is24hr
                        name="startDate"
                        :minute-increment="15"
                        :locale="tr"
                        input-format="dd.MM.yyyy HH:mm"
                        style="background-color: white"
                      >
                        <template #default="{ inputValue, inputEvents }">
                          <input
                            class="form-control text-center"
                            :class="{'is-invalid': startDateEM != null}"
                            :value="inputValue"
                            v-on="inputEvents"
                          >
                        </template>
                      </date-picker>
                      <div
                        v-if="startDateEM"
                        role="alert"
                        class="invalid-feedback order-last"
                        style="display: inline-block;"
                      >
                        {{ startDateEM }}
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Sınav Bitiş Tarihi</label>
                      <date-picker
                        v-model="endDate"
                        mode="dateTime"
                        is24hr
                        :minute-increment="15"
                        name="endDate"
                        :locale="tr"
                        input-format="dd.MM.yyyy HH:mm"
                        style="background-color: white"
                      >
                        <template #default="{ inputValue, inputEvents }">
                          <input
                            class="form-control text-center"
                            :class="{'is-invalid': endDateEM != null}"
                            :value="inputValue"
                            v-on="inputEvents"
                          >
                        </template>
                      </date-picker>
                      <div
                        v-if="endDateEM"
                        role="alert"
                        class="invalid-feedback order-last"
                        style="display: inline-block;"
                      >
                        {{ endDateEM }}
                      </div>
                    </div>
                  </div>
                  <add-lesson-to-exam v-model.lazy="examLessons" />
                  <selected-lesson-list-for-exam v-model.lazy="examLessons" />
                  <div
                    v-if="examLessonsEM"
                    role="alert"
                    class="invalid-feedback order-last"
                    style="display: inline-block;"
                  >
                    {{ examLessonsEM }}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Sınav Yönergesi</label>
                    <custom-editor
                      v-model="description"
                      name="description"
                    />
                    <div
                      v-if="descriptionEM"
                      role="alert"
                      class="invalid-feedback order-last"
                      style="display: inline-block;"
                    >
                      {{ descriptionEM }}
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <button
                        class="btn btn-primary btn-block"
                      >
                        TASLAK KAYDET
                      </button>
                    </div>
                    <div class="form-group col-md-6">
                      <button
                        class="btn btn-success btn-block"
                        @click="save"
                      >
                        SINAVI OLUŞTUR
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </tab>
            <tab title=" Soru Seçimi">
              <select-questions />
            </tab>
            <tab title="Sınav Özeti">
              <abstract-exam />
            </tab>
          </tabs>
        </div>
      </div>
    </template>
  </page>
</template>

<script>

import Page from '../../../commons/components/Page'
import Tabs from '../../../commons/components/Tabs'
import Tab from '../../../commons/components/Tab'
import Multiselect from '@vueform/multiselect'
// import DatePicker from 'vue3-datepicker'
import CustomEditor from '../../components/CustomEditor'
import useNewExam from '../../compositions/useNewExam'
import tr from 'date-fns/locale/tr'
import AddLessonToExam from '../../components/AddLessonToExam'
import SelectedLessonListForExam from '../../components/SelectedLessonListForExam'
import SelectQuestions from '../../components/SelectQuestions'
import AbstractExam from '../../components/AbstractExam'
import mitt from 'mitt'
import { DatePicker } from 'v-calendar'

// eslint-disable-next-line new-cap
const examBus = new mitt()

export default {
  name: 'NewExam',
  components: { AbstractExam, SelectQuestions, SelectedLessonListForExam, CustomEditor, Page, Tab, Tabs, Multiselect, DatePicker, AddLessonToExam },
  provide: {
    examBus
  },
  setup () {
    const examTypes = [
      { value: 1, label: 'Çoktan Seçmeli' }
    ]
    const {
      models,
      methods,
      EM
    } = useNewExam(examBus)

    return {
      ...EM,
      ...models,
      examTypes,
      ...methods,
      tr
    }
  }
}
</script>

<style scoped>

</style>
