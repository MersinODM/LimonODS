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
      <h4>Sınav Adı</h4>
    </template>
    <template #content>
      <div
        class="row"
        style="    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -webkit-touch-callout: none;
    -ms-user-select: none;"
      >
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <tabs id="tabs">
                <div
                  class="row"
                  style="margin-bottom:10px"
                >
                  <div
                    id="back"
                    class="col-md-2 bg-dark text-center cursor-pointer"
                    style="cursor:pointer"
                    @click="backQuestion"
                  >
                    <h2>Geri</h2>
                  </div>
                  <div class="col-md-8 bg-gray-light">
                    <Answers
                      v-for="a in answer"
                      :title="a"
                    >
                      {{ a }}
                    </Answers>
                  </div>
                  <div
                    class="col-md-2 bg-blue text-center"
                    style="cursor:pointer"
                    @click="nextQuestion"
                  >
                    <h2>İleri</h2>
                  </div>
                </div>
                <tab
                  v-for="lesson in lessons"
                  :id="lesson.id"
                  :title="lesson.name"
                >
                  <div><h1>{{ 999 }} ) </h1></div>
                  {{ currentQuestion.body }}
                  <Choices
                    v-for="choice in currentQuestion.choices"
                    :id="choice.id"
                    :content="choice.content"
                  >
                    {{ choice.content }}
                  </Choices>
                </tab>
              </tabs>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../../commons/components/Page'
import Tabs from '../../../commons/components/Tabs'
import Tab from '../../../commons/components/Tab'
import Answers from '../../../commons/components/Answers'
import Choices from '../../../app/components/Choices'
import { inject, provide, reactive, ref } from 'vue'

export default {
  name: 'ShowExam',
  components: { Page, Tab, Tabs, Answers, Choices },

  setup: function (target) {
    const state = reactive({
      selectedIndex: null,
      tabs: [],
      count: 0,
      selectedId: 0
    })

    provide('TabsProvider', state)

    const tabs = inject('TabsProvider')
    const lessons = [
      {
        name: 'Matematik',
        id: 1,
        questions: [{
          id: 12,
          body: 'MMM111',
          choices: [
            { id: 32, content: 'Maaa' },
            { id: 33, content: 'Mbbb' },
            { id: 34, content: 'Mccc' },
            { id: 35, content: 'Mddd' }
          ]
        },
        {
          id: 13,
          body: 'MMM222',
          choices: [
            { id: 42, content: 'Maaa' },
            { id: 43, content: 'Mbbb' },
            { id: 44, content: 'Mccc' },
            { id: 45, content: 'Mddd' }
          ]
        },
        {
          id: 14,
          body: 'MMM333',
          choices: [
            { id: 52, content: 'Maaa' },
            { id: 53, content: 'Mbbb' },
            { id: 54, content: 'Mccc' },
            { id: 55, content: 'Mddd' }
          ]
        }]
      },
      {
        name: 'Türkçe',
        id: 1,
        questions: [{
          id: 12,
          body: 'TTT111',
          choices: [
            { id: 62, content: 'Taaa' },
            { id: 63, content: 'Tbbb' },
            { id: 64, content: 'Tccc' },
            { id: 65, content: 'Tddd' }
          ]
        },
        {
          id: 13,
          body: 'TTT222',
          choices: [
            { id: 72, content: 'Taaa' },
            { id: 73, content: 'Tbbb' },
            { id: 74, content: 'Tccc' },
            { id: 75, content: 'Tddd' }
          ]
        },
        {
          id: 14,
          body: 'TTT333',
          choices: [
            { id: 82, content: 'Taaa' },
            { id: 83, content: 'Tbbb' },
            { id: 84, content: 'Tccc' },
            { id: 85, content: 'Tddd' }
          ]
        }]
      }
    ]
    const answer = ['A', 'D', 'B', 'C']
    let qn1 = 0
    const currentQuestion = ref()
    const nextQuestion = () => {
      // TODO Burada dizi dışına taşma kontrol edilsin
      qn1++
      currentQuestion.value = lessons.filter(l => l.id === tabs.selectedId)[0].questions[qn1]
      // alert(qn1)
      loadQuestion()
    }
    const backQuestion = () => {
      qn1--
      // alert(qn1)
      loadQuestion()
    }
    const loadQuestion = () => {

    }
    return {
      lessons, answer, nextQuestion, backQuestion, currentQuestion
    }
  }

}

</script>

<style scoped>

</style>
