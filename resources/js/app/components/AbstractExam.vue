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
            <div class="col-md-12">
              {{ questions.length }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card-body table-responsive p-0">
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
                      v-for="q in questions"
                      :key="q.id"
                    >
                      <td>
                        {{ JSON.stringify(q)}}
                      </td>
                      <td>$13 USD</td>
                      <td>
                        {{ q.length }}
                      </td>
                      <td>
                        <a
                          href="#"
                          class="text-muted"
                        >
                          <i class="fas fa-search" />
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-6" />
          </div>
          <div class="row">
            <div class="col-md-12" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { examStore } from '../store/examStore'

export default {
  name: 'AbstractExam',
  setup () {
    return {
      questions: examStore.getters.questions
    }
  }
}
</script>

<style scoped>

</style>
