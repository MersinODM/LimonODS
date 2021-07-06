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
  <div
    v-if="lessonTable.length > 0"
    class="card-body table-responsive p-0"
  >
    <table class="table table-striped table-valign-middle">
      <thead>
        <tr>
          <th>Ders</th>
          <th>Eklenen Soru</th>
          <th>Kalan Soru</th>
          <th>Toplam</th>
          <th>Aksiyon</th>
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
          <td
            style="width:15%"
            class="text-center"
          >
            <button
              class="btn btn-warning btn-sm"
              @click="removeLesson(lt.id)"
            >
              X
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
<!--  <div-->
<!--    v-if="examLessons.length > 0"-->
<!--    class="form-row"-->
<!--  >-->
<!--    <div class="col-md-12">-->
<!--      <table class="table table-sm">-->
<!--        <thead>-->
<!--          <tr>-->
<!--            <th>Sıra</th>-->
<!--            <th>Ders</th>-->
<!--            <th>Soru Sayısı</th>-->
<!--            <th>Aksiyon</th>-->
<!--          </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--          <tr-->
<!--            v-for="(lesson, index) in examLessons"-->
<!--            :key="lesson.id"-->
<!--          >-->
<!--            <td>{{ index+1 }}</td>-->
<!--            <td style="width:40%">-->
<!--              {{ lesson.name }}-->
<!--            </td>-->
<!--            <td>{{ lesson.count }} Adet</td>-->
<!--            <td-->
<!--              style="width:15%"-->
<!--              class="text-center"-->
<!--            >-->
<!--              <button-->
<!--                class="btn btn-warning btn-sm"-->
<!--                @click="removeLesson(lesson.id)"-->
<!--              >-->
<!--                X-->
<!--              </button>-->
<!--            </td>-->
<!--          </tr>-->
<!--        </tbody>-->
<!--      </table>-->
<!--    </div>-->
<!--  </div>-->
</template>

<script>
import { ref, watch } from 'vue'
import examStore from '../store/examStore'
import { groupBy } from '../utils/collections'
import Messenger from '../../commons/utils/messenger'

export default {
  name: 'SelectedLessonListForExam',
  emits: ['lessonRemoved', 'update:modelValue', 'onUpdate:modelValue'],
  setup (props, { emit }) {
    const examLessons = examStore.getters.examLessons
    const questions = examStore.getters.questions
    const lessonTable = ref([])

    const loadExamLessons = () => {
      const questionsGroupByLesson = groupBy(questions.value, 'lesson_id')
      lessonTable.value = examLessons.value.map((currentVal) => {
        return {
          id: currentVal.id,
          name: currentVal.name,
          addedQuestions: questionsGroupByLesson[currentVal.id]?.length ?? 0,
          remainingQuestions: currentVal.count - (questionsGroupByLesson[currentVal.id]?.length ?? 0),
          total: currentVal.count
        }
      })
    }

    const removeLesson = async (id) => {
      const promptResult = await Messenger.showPrompt('Bu dersi sildiğiniz takdirde buna bağlı olarak sınav için eklediğiniz tüm sorular silinecektir! Onaylıyor musunuz?')
      if (promptResult.isConfirmed) {
        // examLessons içinde önce index imizi bulalım
        const index = examStore.getters.examLessons.value.map(l => l.id).indexOf(id)
        if (index == null) return // index yoksa geri dönelim
        // examLessons.value.splice(index, 1)
        examStore.actions.removeExamLesson(id)
        examStore.actions.removeQuestions(id)
        // emit('update:modelValue', props.modelValue)
        emit('lessonRemoved', id)
      }
    }

    watch([examLessons, questions], () => {
      loadExamLessons()
    }, { deep: true })

    loadExamLessons()
    return {
      lessonTable,
      removeLesson
    }
  }
}
</script>

<style scoped>

</style>
