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

import { reactive, computed, readonly } from 'vue'
// import now from '../helpers/dayjs'

import constants from '../utils/constants'
import notify from "../utils/notify";

const {
  EXAM_TYPE,
  EXAM_TITLE,
  EXAM_START_DATE,
  EXAM_END_DATE,
  EXAM_LEVEL,
  EXAM_DESCRIPTION,
  EXAM_LESSONS,
  EXAM_QUESTIONS
} = constants()

const state = reactive({
  type: 0,
  title: '',
  startDate: null,
  endDate: null,
  level: null,
  description: null,
  examLessons: [],
  questions: []
})

const setType = (type) => {
  state.type = type
  sessionStorage.setItem(EXAM_TYPE, JSON.stringify(state.type))
}

const setTitle = (title) => {
  state.title = title
  sessionStorage.setItem(EXAM_TITLE, JSON.stringify(state.title))
}

const setStartDate = (date) => {
  state.startDate = date
  sessionStorage.setItem(EXAM_START_DATE, JSON.stringify(state.startDate))
}

const setEndDate = (date) => {
  state.endDate = date
  sessionStorage.setItem(EXAM_END_DATE, JSON.stringify(state.endDate))
}

const setLevel = (level) => {
  state.level = level
  sessionStorage.setItem(EXAM_LEVEL, JSON.stringify(state.level))
}

const setDescription = (description) => {
  state.description = description
  sessionStorage.setItem(EXAM_DESCRIPTION, JSON.stringify(state.description))
}

const setLessons = (lessons) => {
  state.examLessons = lessons
  sessionStorage.setItem(EXAM_LESSONS, JSON.stringify(state.examLessons))
}

const setQuestions = (questions) => {
  state.questions = questions
  sessionStorage.setItem(EXAM_QUESTIONS, JSON.stringify(state.questions))
}

const addQuestion = (question) => {
  state.questions.push(question)
  notify.success('Soru eklemesi başarılı.')
  setQuestions(state.questions)
}

const removeQuestion = (id) => {
  if (state.questions.some(q => q.id === id)) {
    const index = state.questions.map(l => l.id).indexOf(id)
    state.questions.splice(index, 1)
    setQuestions(state.questions)
  }
}

const addExamLesson = (lesson) => {
  state.examLessons.push(lesson)
  setLessons(state.examLessons)
}

const removeExamLesson = (id) => {
  if (state.examLessons.some(q => q.id === id)) {
    const index = state.examLessons.map(l => l.id).indexOf(id)
    state.examLessons.splice(index, 1)
    setLessons(state.examLessons)
  }
}

const type = computed(() => {
  if (!state.type) { state.type = JSON.parse(sessionStorage.getItem(EXAM_TYPE)) }
  return state.type
})

const title = computed(() => {
  if (!state.title) { state.title = JSON.parse(sessionStorage.getItem(EXAM_TITLE)) }
  return state.title
})

const startDate = computed(() => {
  if (!state.startDate) { state.startDate = JSON.parse(sessionStorage.getItem(EXAM_START_DATE)) }
  return state.startDate
})

const endDate = computed(() => {
  if (!state.endDate) { state.endDate = JSON.parse(sessionStorage.getItem(EXAM_END_DATE)) }
  return state.endDate
})

const level = computed(() => {
  if (!state.level) { state.level = JSON.parse(sessionStorage.getItem(EXAM_LEVEL)) }
  return state.level
})

const description = computed(() => {
  if (!state.description) { state.description = JSON.parse(sessionStorage.getItem(EXAM_DESCRIPTION)) }
  return state.description
})

const examLessons = computed(() => {
  const el = JSON.parse(sessionStorage.getItem(EXAM_LESSONS))
  if (el != null && el.length > 0) {
    state.examLessons = []
    el.forEach(q => state.examLessons.push(q))
  }
  // if (!state.examLessons || state.examLessons.length <= 0) {
  //   state.examLessons = JSON.parse(sessionStorage.getItem(EXAM_LESSONS))
  // }
  return state.examLessons
})

const questions = computed(() => {
  const qs = JSON.parse(sessionStorage.getItem(EXAM_QUESTIONS))
  if (qs != null && qs.length > 0) {
    state.questions = []
    qs.forEach(q => state.questions.push(q))
  }
  return state.questions
})

export default {
  state: readonly(state),
  actions: {
    setType,
    setTitle,
    setStartDate,
    setEndDate,
    setLevel,
    setDescription,
    setLessons,
    addQuestion,
    removeQuestion,
    setQuestions,
    addExamLesson,
    removeExamLesson
  },
  getters: {
    type,
    title,
    startDate,
    endDate,
    level,
    description,
    examLessons,
    questions
  }
}
