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
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Ders</label>
      <multiselect
        v-model="selectedLesson"
        :options="lessonsLocal"
        label="name"
        value-prop="id"
        name="lesson"
        :class="{ 'select-error': lessonEM}"
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
    <div class="form-group col-md-5">
      <label>Soru Sayısı</label>
      <multiselect
        v-model="selectedCount"
        :options="questionCounts"
        name="count"
        :class="{ 'select-error': countEM}"
      />
      <div
        v-if="countEM"
        role="alert"
        class="invalid-feedback order-last"
        style="display: inline-block;"
      >
        {{ countEM }}
      </div>
    </div>
    <div class="form-group col-md-1">
      <label />
      <button
        :class="{'disabled': countEM || lessonEM}"
        class="btn btn-info btn-block mt-2"
        @click="addLesson"
      >
        +
      </button>
    </div>
  </div>
</template>

<script>
import useLessonFilter from '../compositions/useLessonFilter'
import { ref, watch } from 'vue'
import Multiselect from '@vueform/multiselect'
import { useField, useForm } from 'vee-validate'
import { number, object } from 'yup'

export default {
  name: 'AddLessonToExam',
  components: { Multiselect },
  props: {
    modelValue: {
      required: false,
      default: []
    }
  },
  emits: ['lessonAdded', 'update:modelValue', 'onUpdate:modelValue'],
  setup (props, { emit }) {
    const { lessons } = useLessonFilter()
    const examLessons = ref(props.modelValue)
    const lessonsLocal = ref([])
    watch(lessons, () => {
      lessons.every(l => lessonsLocal.value.push(l))
    })
    const questionCounts = Array.from({ length: 55 }, (_, i) => i + 5)

    const schema = object({
      lesson: number().typeError(() => 'Ders seçimi yapılmalıdır!')
        .required(() => 'Ders seçimi yapılmalıdır!'),
      count: number().typeError(() => 'Soru sayısı seçimi yapılmalıdır!')
        .required(() => 'Soru sayısı seçimi yapılmalıdır!')
    })

    const { handleSubmit } = useForm({ validationSchema: schema })

    const { value: selectedLesson, errorMessage: lessonEM } = useField('lesson')
    const { value: selectedCount, errorMessage: countEM } = useField('count')

    const addLesson = handleSubmit(() => {
      // Daha önce eklenmiş ise geri dönelim
      if (!examLessons.value.some(l => l.id === selectedLesson.value)) {
        const lesson = lessonsLocal.value.filter(l => l.id === selectedLesson.value)[0]
        const data = { id: lesson.id, name: lesson.name, count: selectedCount.value }
        examLessons.value.push(data)
        emit('lessonAdded', data)
      }
      emit('update:modelValue', examLessons)
    })

    return {
      lessonsLocal,
      questionCounts,
      addLesson,
      selectedLesson,
      selectedCount,
      countEM,
      lessonEM
    }
  }
}
</script>

<style scoped>

</style>
