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
import examStore from '../store/examStore'
import { array, date, number, object, string, ref as yupRef } from 'yup'
import { useField, useForm } from 'vee-validate'
import constants from '../utils/constants'
import Messenger from '../../commons/utils/messenger'
import { groupBy } from '../utils/collections'

export default function (examBus) {
  const { EVENT_LEVEL_CHANGED } = constants()

  const SELECTED_LESSONS_MESSAGE = 'En az bir ders seçimi yapılmaldır!'
  const QUESTION_SELECTION_MESSAGE = 'Hiç soru seçimi yapılmamış!'
  const levels = Array.from({ length: 9 }, (_, i) => i + 4)
  // levels.push("")

  // Burası önemli validasyon için
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
    // startDate: date().typeError(() => 'Sınav başlangıç tarihi seçilmelidir')
    //   .required(() => 'Sınav başlangıç tarihi seçilmelidir!'),
    // endDate: date().typeError(() => 'Sınav bitiş tarihi seçilmelidir!')
    //   .required(() => 'Sınav bitiş tarihi seçilmelidir!')
    //   .min(yupRef('startDate'), () => 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır'),
    description: string().typeError(() => 'Sınav yönergesi tanımlanmaldır!')
      .required(() => 'Sınav yönergesi mutlaka yazılmaldır!'),
    questions: array()
      .typeError(() => QUESTION_SELECTION_MESSAGE)
      .required(() => QUESTION_SELECTION_MESSAGE)
      .min(1, () => QUESTION_SELECTION_MESSAGE)
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

  //
  //
  // watch(examLessons, () => {
  //   examStore.actions.setLessons(examLessons.value)
  // })

  watch(questions, () => {
    if (questions || questions.length <= 0) return
    examStore.actions.setQuestions(questions.value)
  })

  // Burada sınıf seviyesi değişince otomatik o sınıf seviyesine ait dersler listelensin event emitter
  // nextTick ile komponent oluşur oluşmaz watch edilmesini engelliyoruz bu sayede komponent yüklenir yüklenmez
  // Messenger ın showPropmtu çalışmıyor
  // nextTick(() => {
  watch(selectedLevel, () => {
    if (selectedLevel.value === examStore.getters.level.value) return
    Messenger.showPrompt('Sınıf seviyesini değiştirmeniz ders ve soru seçimlerinin sıfırlanmasına sebep olacak. Onaylıyor msunuz?')
      .then(promptResult => {
        if (promptResult.isConfirmed) {
          examStore.actions.setLevel(selectedLevel.value)
          examStore.actions.setLessons([])
          examStore.actions.setQuestions([])
          questions.value = []
          examLessons.value = []
          examBus.emit(EVENT_LEVEL_CHANGED, selectedLevel.value)
        }
      })
  })
  // })

  watch(title, () => {
    examStore.actions.setTitle(title.value)
  })

  watch(selectedType, () => {
    examStore.actions.setType(selectedType.value)
  })

  watch(description, () => {
    examStore.actions.setDescription(description.value)
  })

  watch(examStore.getters.examLessons, () => {
    examLessons.value = examStore.getters.examLessons.value
  })

  const checkQuestionCounts = () => {
    const questionsGroupByLesson = groupBy(questions.value, 'lesson_id')
    const errorObject = examLessons.value.map((currentVal) => {
      const remainingQuestions = currentVal.count - (questionsGroupByLesson[currentVal.id]?.length ?? 0)
      if (remainingQuestions > 0) {
        return { hasError: true, message: `<b>${currentVal.name}</b> dersi için <b>${remainingQuestions}</b> adet soru seçilmelidir!` }
      } else if (remainingQuestions < 0) {
        return { hasError: true, message: `<b>${currentVal.name}</b> dersi için <b>${-1 * remainingQuestions}</b> adet çıkarılmaldır!` }
      }
      return { hasError: false, message: 'Herhangi bir sorun yok' }
    }).reduce((acc, currentVal) => { return { hasError: acc.hasError && currentVal.hasError, message: `${acc.message}<li class="text-left">${currentVal.message}</li>` } }, { hasError: true, message: '' })
    return errorObject
  }

  const save = handleSubmit(values => {
    const errorObject = checkQuestionCounts()
    if (!errorObject.hasError) {
      // Burada kayır işlemi yapılacak
    }
    console.log(values)
  })

  const EM = {
    titleEM,
    startDateEM,
    endDateEM,
    examLessonsEM,
    typeEM,
    descriptionEM,
    levelEM,
    questionEM
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

  const methods = {
    save
  }

  // sessionStorage içinde kalan bişey varsa yükleyelim
  const init = () => {
    title.value = examStore.getters.title.value
    selectedType.value = examStore.getters.type.value
    description.value = examStore.getters.description.value
    selectedLevel.value = examStore.getters.level.value
    questions.value = examStore.getters.questions.value
    examLessons.value = examStore.getters.examLessons.value
  }

  init()

  return {
    EM,
    models,
    methods,
    lessons: examStore.getters.lessons,
    handleSubmit,
    errors
  }
}
