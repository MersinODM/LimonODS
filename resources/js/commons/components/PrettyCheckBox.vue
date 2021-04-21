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
  <div class="custom-control custom-switch">
    <input
      id="customSwitch1"
      :value="modelValue"
      type="checkbox"
      class="custom-control-input"
      @change="click"
      @input="click"
    >
    <label
      class="custom-control-label"
      for="customSwitch1"
      @click.prevent="click"
    ><slot /></label>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'PrettyCheckBox',
  props: {
    modelValue: {
      default: false,
      type: Boolean
    }
  },
  setup (props, { emit }) {
    const state = ref()
    const click = ($event) => {
      const isCorrect = $event.target.checked
      if (isCorrect !== undefined) {
        state.value = isCorrect
      } else {
        state.value = !state.value
      }
      emit('update:modelValue', state.value)
    }
    return {
      click
    }
  }
}
</script>

<style scoped>

</style>
