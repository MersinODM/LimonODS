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
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">

            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                    <tr>
                      <th>Ders</th>
                      <th>Eklenen Soru</th>
                      <th>Kalan Soru</th>
                      <th>Toplam</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="lt in lessonTable"
                      :key="lt.id"
                    >
                      <td>
                        {{ lt.name }}
                      </td>
                      <td>{{ lt.addedQuestions }}</td>
                      <td>
                        {{ lt.remainingQuestions }}
                      </td>
                      <td>
                        {{ lt.total }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-6" />
          </div>
          <div class="row">
            <div class="col-md-12" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import examStore from '../store/examStore'
import { groupBy } from '../utils/collections'
import { computed, ref, watch } from 'vue'

export default {
  name: 'AbstractExam',
  setup () {
    const examLessons = examStore.getters.examLessons
    const questions = examStore.getters.questions
    const lessonTable = ref([])

    // const questionsGroupByLesson = ref(groupBy(examStore.state.questions, 'lesson_id'))
    // const examLessons = examStore.getters.examLessons
    // watch(examStore.getters.questions, () => {
    // questionsGroupByLesson.value = groupBy(examStore.state.questions, 'lesson_id')
    // })

    watch([examLessons, questions], () => {
      const questionsGroupByLesson = groupBy(questions.value, 'lesson_id')
      return examLessons.value.map((currentVal) => {
        return {
          id: currentVal.id,
          name: currentVal.name,
          addedQuestions: questionsGroupByLesson[currentVal.id]?.length ?? 0,
          remainingQuestions: currentVal.count - (questionsGroupByLesson[currentVal.id]?.length ?? 0),
          total: currentVal.count
        }
      })
    })

    return {
      lessonTable
    }
  }
}
</script>

<style scoped>

</style>
