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
    v-if="modelValue.length > 0"
    class="form-row"
  >
    <div class="col-md-12">
      <table class="table table-sm">
        <thead>
          <tr>
            <th>Sıra</th>
            <th>Ders</th>
            <th>Soru Sayısı</th>
            <th>Aksiyon</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(lesson, index) in modelValue"
            :key="lesson.id"
          >
            <td>{{ index+1 }}</td>
            <td style="width:40%">
              {{ lesson.name }}
            </td>
            <td>{{ lesson.count }} Adet</td>
            <td
              style="width:15%"
              class="text-center"
            >
              <button
                class="btn btn-warning btn-sm"
                @click="removeLesson(lesson.id)"
              >
                X
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { examStore } from '../store/examStore'

export default {
  name: 'SelectedLessonListForExam',
  props: {
    modelValue: {
      required: false,
      default: []
    }
  },
  emits: ['lessonRemoved', 'update:modelValue', 'onUpdate:modelValue'],
  setup (props, { emit }) {
    const removeLesson = (id) => {
      // examLessons içinde önce index imizi bulalım
      const index = props.modelValue.map(l => l.id).indexOf(id)
      if (index == null) return // index yoksa geri dönelim
      // examLessons.value.splice(index, 1)
      examStore.actions.removeExamLesson(id)
      emit('update:modelValue', props.modelValue)
      emit('lessonRemoved', id)
    }
    return {
      removeLesson
    }
  }
}
</script>

<style scoped>

</style>
