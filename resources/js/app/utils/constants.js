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

export default function () {
  const CONSTANTS = {
    STATUS: 'store/status',
    LESSON: 'store/lesson',
    LESSONS: 'store/lessons',
    EXAM_TYPE: 'store/examType',
    EXAM_TITLE: 'store/examTitle',
    EXAM_START_DATE: 'store/examStartDate',
    EXAM_END_DATE: 'store/examEndDate',
    EXAM_LEVEL: 'store/examLevel',
    EXAM_DESCRIPTION: 'store/examDescription',
    EXAM_LESSONS: 'store/examLessons',
    EXAM_QUESTIONS: 'store/examQuestions',
    EVENT_CLOSE_MODAL: 'closeModal',
    EVENT_MODAL_CLOSED: 'modalClosed',
    EVENT_OPEN_MODAL: 'openModal',
    EVENT_LESSON_ADDED_TO_EXAM: 'lessonAddedToExam',
    EVENT_LEVEL_CHANGED: 'levelChanged',
    EVENT_MODAL_OPENED: 'modalOpened',
    MODAL_CURRICULUM: 'curriculumModal',
    MODAL_QUESTION: 'questionModal'
  }

  return {
    ...CONSTANTS
  }
}
