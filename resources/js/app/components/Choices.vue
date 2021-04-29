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
  <div class="row mt-2">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div
            v-for="(c, index) in choices"
            :key="c.code"
            class="form-group"
          >
            <choice
              :value="c"
              :index="index"
            >
              <template #header>
                Seçenek {{ index + 1 }}
              </template>

<!--              <template #errorMessage>-->
<!--                <div-->
<!--                  v-if="errors[`choices[${index}].content`]"-->
<!--                  role="alert"-->
<!--                  class="invalid-feedback order-last"-->
<!--                  style="display: inline-block;"-->
<!--                >-->
<!--                  {{ errors[`choices[${index}].content`] }}-->
<!--                </div>-->
<!--              </template>-->
            </choice>
          </div>
        </div>
      </div>
      <div class="row justify-content-center mt-1">
        <div class="col-md-4">
          <button
            class="btn btn-info btn-block"
            @click="addChoice"
          >
            Seçenek Ekle
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Choice from './Choice'
import { defineComponent, provide, reactive, toRefs } from 'vue'
import mitt from 'mitt'

export default defineComponent({
  name: 'Choices',
  components: { Choice },
  props: {
    choices: {
      required: false,
      default: null,
      type: Array
    },
    errors: {
      required: false,
      default: null
    }
  },
  setup (props, { emit }) {
    const emitter = mitt()
    const state = reactive({
      correctIndex: null,
      choices: props.choices,
      form: null,
      emitter
    })

    provide('ChoicesProvider', state)

    emitter.on('removeChoice', (args) => {
      state.choices.splice(args.index, 1)
    })

    const remove = (index) => {
      state.choices.splice(index, 1)
    }

    const addChoice = () => {
      if (state.choices.length >= 5) { return }
      state.choices.push({
        content: '',
        isCorrect: false,
        code: Math.random().toString(32)
          .substring(8)
      })
    }

    return {
      addChoice,
      remove,
      ...toRefs(state)
    }
  }
})
</script>

<style scoped>

</style>
