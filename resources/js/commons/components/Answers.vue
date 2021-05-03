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
//Öğrenci cevapları için
<template>
  <div
    class="rounAnswer"
    @click="answerClick(id)"
  >
    <div class="card">
      <div class="card-body">
        <h4>
          <slot />
        </h4>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Answers',
  props: {
    title: {
      required: true,
      type: String,
      default: ' '
    },
    id: {
      required: true,
      type: Number,
      default: 0
    }
  },

  setup: function () {
    // localStorage.setItem('questionIndex', this.index)
    const answerClick = (id) => {
      localStorage.setItem('questionIndex', id)
    }
    return { answerClick }
  }
}

</script>

<style scoped>
.rounAnswer{
  float:left;
  cursor: pointer;
}
</style>
