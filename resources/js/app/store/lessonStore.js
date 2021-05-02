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
import LessonService from '../services/LessonService'
const { LESSON, LESSONS } = constants()

const state = reactive({
  lesson: null,
  lessons: []
})

const setCurrentLesson = (lesson) => {
  sessionStorage.setItem(LESSON, JSON.stringify(lesson))
  state.lesson = lesson
}

const setLessons = async () => {
  const arr = await LessonService.getLessons()
  arr.every((lesson) => state.lessons.push(lesson))
  await sessionStorage.setItem(LESSONS, JSON.stringify(state.lessons))
}

const lesson = computed(() => {
  if (!state.lesson) { state.lesson = JSON.parse(sessionStorage.getItem(LESSON)) }
  return state.lesson
})

// const lessons = () => {
//   if (!state.lessons) { state.lessons = JSON.parse(sessionStorage.getItem(LESSON)) }
//   return state.lessons
// }

export const lessonStore = readonly({
  state: state,
  actions: {
    setCurrentLesson,
    setLessons
  },
  getters: {
    lesson,
    lessons: state.lessons
  }
})
