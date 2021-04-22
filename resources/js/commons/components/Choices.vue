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
//Seçenekler için
<template>
  <div
    class="card"
    style="cursor: pointer"
    @click="_click(id)"
  >
    <div class="card-body">
      <div class="row">
        <div class="col-md-1">
          <h2 />
        </div>
        <div class="col-md-11">
          <div class="card-body">
            <div class="row">
              <div>
                <slot />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Choices',
  props: {
    id:{
      required: true,
      type: String,
      default: ' '
    },
    content: {
      required: true,
      type: String,
      default: ' '
    }
  },
  setup:function(){
    const _click = (id) => {
      alert(id)
    }
    return {
      _click
    }
  }
}

</script>

<style scoped>

</style>
