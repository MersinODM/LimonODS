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
    <div class="card-header">
      <h5>1. Soru</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div
            v-katex:auto
            class="ck-content"
            v-html="question.body"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div
            v-for="(choice, index) in question.choices"
            :key="index"
            class="card"
          >
            <div class="card-header">
              <h5>{{ String.fromCharCode(65 + index) }}</h5>
            </div>
            <div class="card-body">
              <div
                v-katex:auto
                class="ck-content"
                v-html="choice.content"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Question',
  props: {
    question: {
      required: true,
      type: Object
    }
  }
}
</script>

<style scoped>

</style>
