
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
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue"> Soru</span> Listesi, Seçilen Yıl:
        <span class="text-bold">{{ selectedYear!=null ? selectedYear : 'Hepsi' }}</span>, Seçilen Ders
        <span class="text-bold">{{ selectedLesson!=null ? selectedLesson : 'Hepsi' }}</span>
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-3 mt-1">
                  <div class="form-group">
                    <label>Yıl tercihi</label>
                    <multiselect
                      v-model="selectedYear"
                      :options="years"
                    />
                  </div>
                </div>
                <div class="col-md-3 mt-1">
                  <div class="form-group">
                    <label>Ders tercihi</label>
                    <multiselect
                      v-model="selectedLesson"
                      :options="lessons"
                      label="name"
                      value-prop="id"
                    />
                  </div>
                </div>
                <div class="col-md-3 mt-1">
                  <div class="form-group">
                    <label>Durum tercihi</label>
                    <multiselect
                      v-model="selectedStatus"
                      :options="statuses"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                    <table
                      id="questionsTable"
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
                          <th>BRANŞ</th>
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
        <modal>
          <template #modal-title>
            <h5>Kazanımlar</h5>
          </template>
          <template #modal-body>
            <div
              v-for="c in curriculums"
              :key="c.id"
              class="callout callout-info"
            >
              <table
                style="width:100%"
                class="table table-responsive table-sm  table-borderless"
              >
                <tbody>
                  <tr>
                    <th>Kod</th>
                    <td>{{ c.code }}</td>
                  </tr>
                  <tr>
                    <th>Sınıf Seviyesi</th>
                    <td>{{ c.level }}</td>
                  </tr>
                  <tr>
                    <th>İçerik</th>
                    <td>{{ c.content }}</td>
                  </tr>
                </tbody>
              </table>
              <h5 />
            </div>
          </template>
        </modal>
      </div>
    </template>
  </page>
</template>

<script>
import { inject, onMounted, onUnmounted, watch } from 'vue'
import Page from '../../../commons/components/Page'
import tr from '../../../commons/utils/dataTablesTurkish'
import { useRouter } from 'vue-router'
import Multiselect from '@vueform/multiselect'
import useStatusFilter from '../../compositions/useStatusFilter'
import useYearFilter from '../../../commons/compositions/useYearFilter'
import { formatDate } from '../../../commons/utils/dayjs'
import useLessonFilter from '../../compositions/useLessonFilter'
import Modal from '../../components/Modal'
import constants from '../../utils/constants'
import useCurriculumShower from '../../compositions/useCurriculumShower'

// import useDropOrBackInventory from '../../compositions/useDropOrBackInventory'
// import dayjs from '../../helpers/dayjs'

let table = null

export default {
  name: 'InventoryTable',
  components: { Page, Multiselect, Modal },
  setup (props) {
    const { EVENT_CLOSE_MODAL, EVENT_MODAL_CLOSED, EVENT_OPEN_MODAL, EVENT_MODAL_OPENED } = constants()

    const eventBus = inject('eventBus')
    const router = useRouter()
    const { years, selectedYear } = useYearFilter()
    const { selectedStatus, statuses } = useStatusFilter()
    const { selectedLesson, lessons } = useLessonFilter()
    const { getCurriculumsByQuestionId, curriculums } = useCurriculumShower()

    watch([selectedYear, selectedStatus, selectedLesson], () => {
      table?.ajax.reload(null, false)
      // eventBus.emit(EVENT_OPEN_MODAL)
    })

    onMounted(() => {
      table = $('#questionsTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.year = selectedYear.value
          data.lesson_id = selectedLesson.value
          data.status = selectedStatus.value
        })
        .DataTable({
          fixedHeader: true,
          processing: true,
          serverSide: true,
          responsive: false,
          stateSave: true,
          retrieve: true,
          searching: true,
          paging: true,
          stateDuration: -1,
          order: [[4, 'asc']],
          ajax: {
            url: '/api/app/v1/questions/table',
            dataType: 'json',
            type: 'POST',
            xhrFields: {
              withCredentials: true
            }
          },
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
                return '<button class="btn btn-xs btn-secondary">' + count + ' Adet Kazanım Göster</button>'
              }
            },
            {
              data: '',
              width: '10%',
              render (data, type, row, meta) {
                if (row.is_dropped) {
                  return '<div class="btn-group">' +
                        '<button class="btn btn-xs btn-primary">Göster</button>' +
                        '<button class="btn btn-xs btn-warning">Düzenle</button>' +
                        // '<button class="btn btn-xs btn-info">Geri Al</button>' +
                        '</div>'
                }
                return '<div class="btn-group">' +
                      '<button class="btn btn-xs btn-primary">Göster</button>' +
                      '<button class="btn btn-xs btn-warning">Düzenle</button>' +
                      // '<button class="btn btn-xs btn-danger">Düşür</button>' +
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
        await eventBus.emit(EVENT_OPEN_MODAL)
        // router.push({ name: 'showInventory', params: { inventoryId: data.id } })
      })

      table.on('click', '.btn-primary', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        // customerStore.actions.setCustomer({ id: data.customer_id, name: data.customer, identity: data.identity_no, phone: data.phone, address: data.address })
        await router.push({ name: 'underConstruction' })
      })

      table.on('click', '.btn-warning', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        // customerStore.actions.setCustomer({ id: data.customer_id, name: data.customer, identity: data.identity_no, phone: data.phone, address: data.address })
        await router.push({ name: 'underConstruction' })
      })
    })

    onUnmounted(() => {
      table?.clear()
      table?.destroy()
    })

    return {
      selectedLesson,
      lessons,
      selectedStatus,
      statuses,
      selectedYear,
      years,
      curriculums
    }
  }
}
</script>

<style scoped>

</style>
