
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
                          <th>CURRICULUM_ID</th>
                          <th>CREATOR_ID</th>
                          <th>GİRİŞ</th>
                          <th>YAZAR</th>
                          <th>TELEFON</th>
                          <th>BRANŞ</th>
                          <th>DERS</th>
                          <th>KULLANIM SAYISI</th>
                          <th>KAZANIM</th>
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
import dayjs from '../../../commons/utils/dayjs'
import useLessonFilter from "../../compositions/useLessonFilter";

// import useDropOrBackInventory from '../../compositions/useDropOrBackInventory'
// import dayjs from '../../helpers/dayjs'

let table = null

export default {
  name: 'InventoryTable',
  components: { Page, Multiselect },
  setup (props) {
    // const customerStore = inject('customerStore')
    // const router = useRouter()
    const { years, selectedYear } = useYearFilter()
    const { selectedStatus, statuses } = useStatusFilter()
    const { selectedLesson } = useLessonFilter()

    watch([selectedYear, selectedStatus, selectedLesson], () => {
      table?.ajax.reload(null, false)
    })

    // onMounted(() => {
    //   table = $('#questionsTable')
    //     .on('preXhr.dt', (e, settings, data) => {
    //       // Bu event sunucuya datatable üzerinden veri gitmeden önce
    //       // yeni parametre eklemek için ateşleniyor
    //       data.year = selectedYear.value
    //       data.is_dropped = selectedInventoryState.value
    //     })
    //     .DataTable({
    //       fixedHeader: true,
    //       processing: true,
    //       serverSide: true,
    //       responsive: false,
    //       stateSave: true,
    //       retrieve: true,
    //       searching: true,
    //       paging: true,
    //       stateDuration: -1,
    //       order: [[5, 'asc']],
    //       ajax: {
    //         url: '/api/app/v1/questions/table',
    //         dataType: 'json',
    //         type: 'POST',
    //         xhrFields: {
    //           withCredentials: true
    //         }
    //       },
    //       language: tr,
    //       columns: [
    //         {
    //           data: 'id',
    //           name: 'i.id',
    //           searchable: true,
    //           visible: false
    //         }, {
    //           data: 'id',
    //           name: 'i.rack_id',
    //           searchable: true,
    //           visible: false
    //         }, {
    //           data: 'id',
    //           name: 'i.product_id',
    //           searchable: true,
    //           visible: false
    //         },
    //         {
    //           data: 'id',
    //           name: 'r.stock_room_id',
    //           searchable: true,
    //           visible: false
    //         },
    //         {
    //           data: 'id',
    //           name: 'i.customer_id',
    //           searchable: true,
    //           visible: false
    //         },
    //         {
    //           data: 'entry_date',
    //           name: 'i.entry_date',
    //           searchable: true,
    //           render (data) {
    //             if (data) {
    //               return dayjs(data).format('L')
    //             }
    //             return '<span class="badge badge-warning">BELİRTİLMEMİŞ</span>'
    //           }
    //         },
    //         {
    //           data: 'code',
    //           name: 'i.code',
    //           searchable: true
    //         },
    //         {
    //           data: 'customer',
    //           name: 'customer',
    //           searchable: true
    //         },
    //         {
    //           data: 'phone',
    //           name: 'c.phone',
    //           searchable: true
    //         },
    //         {
    //           data: 'address',
    //           name: 'c.address',
    //           searchable: true
    //         },
    //         {
    //           data: 'identity_no',
    //           name: 'c.identity_no',
    //           searchable: true
    //         },
    //         {
    //           data: 'product',
    //           name: 'product',
    //           searchable: true,
    //           render (data, type, row) {
    //             if (row.description) {
    //               return data + ' <span class="text-success text-bold">' + row.description + '</span>'
    //             }
    //             return data
    //           }
    //         },
    //         {
    //           data: 'amount',
    //           name: 'i.amount',
    //           searchable: true
    //         },
    //         {
    //           data: 'room',
    //           name: 'room',
    //           searchable: true
    //         },
    //         {
    //           data: 'rack',
    //           name: 'rack',
    //           searchable: true
    //         },
    //         {
    //           data: 'contact',
    //           name: 'i.contact',
    //           searchable: true
    //         },
    //         {
    //           data: '',
    //           width: '10%',
    //           render (data, type, row, meta) {
    //             if (row.is_dropped) {
    //               return '<div class="btn-group">' +
    //                     '<button class="btn btn-xs btn-primary">Göster</button>' +
    //                     '<button class="btn btn-xs btn-warning">Düzenle</button>' +
    //                     // '<button class="btn btn-xs btn-info">Geri Al</button>' +
    //                     '</div>'
    //             }
    //             return '<div class="btn-group">' +
    //                   '<button class="btn btn-xs btn-primary">Göster</button>' +
    //                   '<button class="btn btn-xs btn-warning">Düzenle</button>' +
    //                   // '<button class="btn btn-xs btn-danger">Düşür</button>' +
    //                   '</div>'
    //           },
    //           searchable: false,
    //           orderable: false
    //         }
    //       ]
    //     })
    //
    //   table.on('click', '.btn-primary', (e) => {
    //     const data = table.row($(e.target).parents('tr')[0]).data()
    //     router.push({ name: 'showInventory', params: { inventoryId: data.id } })
    //   })
    //
    //   table.on('click', '.btn-warning', (e) => {
    //     const data = table.row($(e.target).parents('tr')[0]).data()
    //     customerStore.actions.setCustomer({ id: data.customer_id, name: data.customer, identity: data.identity_no, phone: data.phone, address: data.address })
    //     router.push({ name: 'editInventory', params: { inventoryId: data.id } })
    //   })
    // })

    // onUnmounted(() => {
    //   table.clear()
    //   table.destroy()
    // })

    return {
      selectedLesson,
      selectedStatus,
      statuses,
      selectedYear,
      years
    }
  }
}
</script>

<style scoped>

</style>
