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
  <div class="card">
    <div class="card-body">
      <div
        class="card-body col-md-2  float-left"
      >
        <h4>
          {{ id }}
        </h4>
      </div>
      <div
        class="card-body col-md-4  float-left"
      >
        <h4>
          {{ title }}
        </h4>
      </div>
      <div
        class="card-body col-md-2  float-left"
      >
        <h4>
          {{ time1 }}
        </h4>
      </div>
      <div
        class="card-body col-md-2 float-left"
      >
        <h4>
          {{ time2 }}
        </h4>
      </div>
      <div class="card-body col-md-2 float-right">
        <router-link
          class="btn btn-primary"
          :to="{name: 'showExam'}"
        >
          Sınava Git
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ExamList',
  props: {
    id: {
      required: true,
      type: Number,
      default: 0
    },
    title: {
      required: true,
      type: String,
      default: ''
    },
    time1: {
      required: true,
      type: Date,
      default: Date.now()
    },
    time2: {
      required: true,
      type: Date,
      default: Date.now()
    }
  }
}
</script>

<style scoped>

</style>
