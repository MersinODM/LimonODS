/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */

import { watch } from 'vue'
import { examStore } from '../store/examStore'
import { array, date, number, object, string, ref as yupRef } from 'yup'
import { useField, useForm } from 'vee-validate'
import constants from '../utils/constants'

export default function (examBus) {
  const { getters, actions } = examStore
  const { EVENT_LEVEL_CHANGED } = constants()

  const SELECTED_LESSONS_MESSAGE = 'En az bir ders seçimi yapılmaldır!'
  const levels = Array.from({ length: 9 }, (_, i) => i + 4)
  // levels.push("")

  const schema = object({
    examLessons: array()
      .typeError(() => SELECTED_LESSONS_MESSAGE)
      .required(() => SELECTED_LESSONS_MESSAGE)
      .min(1, () => SELECTED_LESSONS_MESSAGE)
      .strict(),
    // lesson: number().typeError(() => 'Ders seçimi yapılmalıdır!')
    //   .required(() => 'Ders seçimi yapılmalıdır!'),
    // count: number().typeError(() => 'Soru sayısı seçimi yapılmalıdır!')
    //   .required(() => 'Soru sayısı seçimi yapılmalıdır!'),
    type: number().typeError(() => 'Sınav türü seçimi yapılmalıdır!')
      .required(() => 'Sınav türü seçimi yapılmalıdır!'),
    title: string().typeError(() => 'Sınav adı/başlığı yazı tipinde olmalıdır!')
      .required(() => 'Sınav adı/başlığı gereklidir!'),
    level: number().typeError(() => 'Seviye seçimi yapılmaldır!')
      .required(() => 'Seviye seçimi yapılmaldır!'),
    startDate: date().typeError(() => 'Sınav başlangıç tarihi seçilmelidir')
      .required(() => 'Sınav başlangıç tarihi seçilmelidir!'),
    endDate: date().typeError(() => 'Sınav bitiş tarihi seçilmelidir!')
      .required(() => 'Sınav bitiş tarihi seçilmelidir!')
      .min(yupRef('startDate'), () => 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır'),
    description: string().typeError(() => 'Sınav yönergesi tanımlanmaldır!')
      .required(() => 'Sınav yönergesi mutlaka yazılmaldır!'),
    questions: array()
      .typeError(() => 'En az bir kazanım seçimi yapılmalıdır!')
      .required(() => 'En az bir kazanım seçimi yapılmalıdır!')
      .min(1, () => 'En az bir kazanım seçimi yapılmaldır!')
      .strict()
  })

  const { handleSubmit, errors } = useForm({ validationSchema: schema })

  // const { value: selectedLesson, errorMessage: lessonEM } = useField('lesson')
  // const { value: selectedCount, errorMessage: countEM } = useField('count')
  const { value: title, errorMessage: titleEM } = useField('title')
  const { value: startDate, errorMessage: startDateEM } = useField('startDate')
  const { value: endDate, errorMessage: endDateEM } = useField('endDate')
  const { value: examLessons, errorMessage: examLessonsEM } = useField('examLessons')
  const { value: selectedType, errorMessage: typeEM } = useField('type')
  const { value: selectedLevel, errorMessage: levelEM } = useField('level')
  const { value: description, errorMessage: descriptionEM } = useField('description')
  const { value: questions, errorMessage: questionEM } = useField('questions')

  // Burası önemli validasyon için
  questions.value = examStore.getters.questions
  examLessons.value = examStore.getters.examLessons

  watch(examLessons, () => {
    examStore.actions.setLessons(examLessons.value)
  })

  watch(questions, () => {
    examStore.actions.setQuestions(questions.value)
  })

  watch(selectedLevel, () => {
    examBus?.emit(EVENT_LEVEL_CHANGED, selectedLevel.value)
  })

  const EM = {
    titleEM,
    startDateEM,
    endDateEM,
    examLessonsEM,
    typeEM,
    descriptionEM,
    levelEM
  }

  const models = {
    title,
    startDate,
    endDate,
    examLessons,
    selectedType,
    description,
    selectedLevel,
    levels
  }

  const save = handleSubmit(values => {

  })

  const methods = {
    save
  }

  const init = () => {
    examLessons.value = []
  }

  // watch(selectedLesson, () => {
  //   actions.setLessons(selectedLesson)
  // })

  init()

  return {
    EM,
    models,
    methods,
    lessons: getters.lessons,
    handleSubmit,
    errors
  }
}
