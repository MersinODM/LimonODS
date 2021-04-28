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
  <div class="row mt-1">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <label class="float-left">
            <slot name="header" />
          </label>
          <button
            class="btn btn-danger btn-sm float-right"
            @click="remove(index)"
          >
            X
          </button>
        </div>
      </div>
      <custom-editor
        v-model="content"
        :name="name"
      />
      <slot name="errorMessage" />
      <div class="custom-control custom-switch">
        <input
          id="customSwitch1"
          v-model="isCorrect"
          type="checkbox"
          class="custom-control-input"
        >
        <label
          class="custom-control-label"
          for="customSwitch1"
          @click.prevent="isCorrect = !isCorrect"
        >Doğru</label>
      </div>
    </div>
  </div>
</template>

<script>

import CustomEditor from './CustomEditor'
import { defineComponent, inject, onMounted, ref, watch } from 'vue'
import { useField } from 'vee-validate'

export default defineComponent({
  name: 'Choice',
  components: { CustomEditor },
  props: {
    value: {
      required: false,
      default: null,
      type: Object
    },
    index: {
      required: false,
      default: null,
      type: Number
    }
  },
  setup (props, { emit }) {
    // const content = ref(props.value?.content)
    const name = 'choices[' + props.index + '].content'
    const isCorrect = ref(props.value?.isCorrect)
    const content = ref(props.value?.content)

    const state = inject('ChoicesProvider')

    const listenCorrectChange = (args) => {
      if (args.index !== props.index) {
        isCorrect.value = false
      }
    }

    const remove = (index) => {
      state.emitter.emit('removeChoice', { index })
    }

    state.emitter.on('correctIndexChanged', listenCorrectChange)

    watch(content, () => {
      state.choices[props.index].content = content.value
    })

    watch(isCorrect, () => {
      state.choices[props.index].isCorrect = isCorrect.value
      if (isCorrect.value) {
        state.emitter.emit('correctIndexChanged', { index: props.index })
      }
    })

    return {
      remove,
      content,
      isCorrect,
      name
    }
  }
})
</script>

<style scoped>

</style>
