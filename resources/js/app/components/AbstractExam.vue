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
            <div class="col-md-12" >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
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
          <div class="row mt-2">
            <div class="col-md-12">
              <h4 class="text-center">
                SINAV İÇİN SEÇİLEN SORULAR
              </h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div
                class="dataTables_wrapper dt-bootstrap4 table-responsive"
              >
                <table
                  id="questionsAbstractTable"
                  class="table table-bordered table-hover dataTable dtr-inline"
                  role="grid"
                  style="width:100%"
                >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>LESSON_ID</th>
                      <th>CREATOR_ID</th>
                      <th>GİRİŞ</th>
                      <th>YAZAR</th>
                      <th>TELEFON</th>
                      <th>Ö. BRANŞI</th>
                      <th>SEVİYE</th>
                      <th>DERS</th>
                      <th>KULLANIM SAYISI</th>
                      <th>KAZANIM(LAR)</th>
                      <th>AKSİYON</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import examStore from '../store/examStore'
import { groupBy } from '../utils/collections'
import { inject, onMounted, onUnmounted, ref, watch } from 'vue'
import tr from '../../commons/utils/dataTablesTurkish'
import { formatDate } from '../../commons/utils/dayjs'
import constants from '../utils/constants'
import useCurriculumShower from '../compositions/useCurriculumShower'
import usePreviewQuestion from '../compositions/usePreviewQuestion'
import Messenger from '../../commons/utils/messenger'

export default {
  name: 'AbstractExam',
  setup () {
    const { EVENT_OPEN_MODAL, MODAL_CURRICULUM, MODAL_QUESTION } = constants()

    const eventBus = inject('eventBus')
    const { getCurriculumsByQuestionId, curriculums } = useCurriculumShower()
    const { getQuestionById, question } = usePreviewQuestion()

    const examLessons = examStore.getters.examLessons
    const questions = examStore.getters.questions
    const lessonTable = ref([])
    let table = null

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

    watch([examLessons, questions], () => {
      loadExamLessons()
    }, { deep: true })

    watch(questions, () => {
      table.clear().rows.add(questions.value).draw()
    }, { deep: true })

    loadExamLessons()

    onMounted(() => {
      table = $('#questionsAbstractTable')
        .DataTable({
          data: questions.value,
          fixedHeader: true,
          processing: true,
          serverSide: false,
          responsive: false,
          // stateSave: true,
          retrieve: false,
          searching: true,
          paging: true,
          // stateDuration: -1,
          // order: [[4, 'asc']],
          language: tr,
          columns: [
            {
              data: 'id',
              name: 'id',
              searchable: false,
              visible: false
            }, {
              data: 'lesson_id',
              name: 'lesson_id',
              searchable: false,
              visible: false
            }, {
              data: 'creator_id',
              name: 'creator_id',
              searchable: false,
              visible: false
            },
            {
              data: 'created_at',
              name: 'created_at',
              searchable: true,
              render (data) {
                return formatDate(data)
              }
            },
            {
              data: 'creator.full_name',
              name: 'creator.full_name',
              searchable: true
            },
            {
              data: 'creator.phone',
              name: 'creator.phone',
              searchable: true
            },
            {
              data: '',
              searchable: false,
              orderable: false
            },
            {
              data: 'level',
              searchable: false
            },
            {
              data: 'lesson.name',
              name: 'lesson.name',
              searchable: true
            },
            {
              data: 'exams_count',
              name: 'exams_count',
              searchable: false
            },
            {
              data: '',
              name: 'curriculum',
              searchable: true,
              orderable: false,
              render (data, type, row) {
                const count = row?.curriculums_count
                if (count <= 0) return '<span class="badge bg-danger">Kazanım Seçilmemiş</span>'
                return `<button class="btn btn-xs btn-secondary">Göster(${count} adet)</button>`
              }
            },
            {
              data: '',
              width: '10%',
              render (data, type, row, meta) {
                return '<div class="btn-group">' +
                        '<button class="btn btn-xs btn-primary">Göster</button>' +
                        '<button class="btn btn-xs btn-danger">Çıkar</button>' +
                      '</div>'
              },
              searchable: false,
              orderable: false
            }
          ]
        })

      table.on('click', '.btn-secondary', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        await getCurriculumsByQuestionId(data.id)
        await eventBus.emit(EVENT_OPEN_MODAL, { name: MODAL_CURRICULUM })
        // router.push({ name: 'showInventory', params: { inventoryId: data.id } })
      })

      table.on('click', '.btn-primary', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        // customerStore.actions.setCustomer({ id: data.customer_id, name: data.customer, identity: data.identity_no, phone: data.phone, address: data.address })
        // await router.push({ name: 'underConstruction' })
        await getQuestionById(data.id)
        await eventBus.emit(EVENT_OPEN_MODAL, { name: MODAL_QUESTION })
      })

      table.on('click', '.btn-danger', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        const promptResult = await Messenger.showPrompt('Bu soruyu sınavdan çıkarmak istediğinize emin misiniz?')
        if (promptResult.isConfirmed) {
          await examStore.actions.removeQuestion(data.id)
          // await eventBus.emit(EVENT_QUESTION_REMOVED_FROM_EXAM)
          // table.clear()
          // table.rows.add(examStore.getters.questions.value).draw()
        }
      })
    })

    onUnmounted(() => {
      table?.clear()
      table?.destroy()
    })

    return {
      question,
      curriculums,
      lessonTable,
      questions
    }
  }
}
</script>

<style scoped>

</style>
