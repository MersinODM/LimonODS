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
        class="row noselect"
      >
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <tabs @click="changeTab">
                <tab
                  v-for="lesson in lessons"
                  :id="lesson.id"
                  :key="lesson.id"
                  :title="lesson.name"
                >
                  <div>
                    <div>
                      {{ question?.body }}
                    </div>
                  </div>
                </tab>
              </tabs>
              <Choices
                v-for="choice in question?.choices"
                :id="choice.id"
                :content="choice.content"
              >
                {{ choice.content }}
              </Choices>
              <div
                class="row fixed-bottom"
                style="margin-bottom:10px"
              >
                <div
                  class="card-body col-md-12 align-center"
                  @click="questionDirection"
                >
                  <Answers
                    v-for="(a, index) in answer"
                    :id="index"
                    :key="index"
                    :title="a"
                  >
                    {{ (index + 1) + ')' + a }}
                  </Answers>
                </div>

                <div
                  id="back"
                  class="col-md-6 bg-dark text-center cursor-pointer"
                  style="cursor:pointer"
                  @click="prevQuestion"
                >
                  <h2>Geri</h2>
                </div>

                <div
                  class="col-md-6 bg-blue text-center"
                  style="cursor:pointer"
                  @click="nextQuestion"
                >
                  <h2>İleri</h2>
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
import Page from '../../../commons/components/Page'
import Tabs from '../../../commons/components/Tabs'
import Tab from '../../../commons/components/Tab'
import Answers from '../../../commons/components/Answers'
import Choices from '../../ccomponents/Choices'
import { inject, provide, reactive, ref } from 'vue'

export default {
  name: 'ShowExam',
  components: { Page, Tab, Tabs, Answers, Choices },

  setup (props) {
    const state = inject('TabsProvider')
    const lessons = [
      {
        name: 'Matematik',
        id: 0,
        questions: [{
          id: 12,
          body: 'MMM111',
          choices: [
            { id: 32, content: 'M1aaa' },
            { id: 33, content: 'Mbbb' },
            { id: 34, content: 'Mccc' },
            { id: 35, content: 'Mddd' }
          ]
        },
        {
          id: 13,
          body: 'MMM222',
          choices: [
            { id: 42, content: 'M2aaa' },
            { id: 43, content: 'Mbbb' },
            { id: 44, content: 'Mccc' },
            { id: 45, content: 'Mddd' }
          ]
        },
        {
          id: 14,
          body: 'MMM333',
          choices: [
            { id: 52, content: 'M3aaa' },
            { id: 53, content: 'Mbbb' },
            { id: 54, content: 'Mccc' },
            { id: 55, content: 'Mddd' }
          ]
        }]
      },
      {
        name: 'Türkçe',
        id: 5,
        questions: [{
          id: 12,
          body: 'TTT111',
          choices: [
            { id: 62, content: 'T1aaa' },
            { id: 63, content: 'Tbbb' },
            { id: 64, content: 'Tccc' },
            { id: 65, content: 'Tddd' }
          ]
        },
        {
          id: 13,
          body: 'TTT222',
          choices: [
            { id: 72, content: 'T2aaa' },
            { id: 73, content: 'Tbbb' },
            { id: 74, content: 'Tccc' },
            { id: 75, content: 'Tddd' }
          ]
        },
        {
          id: 14,
          body: 'TTT333',
          choices: [
            { id: 82, content: 'T3aaa' },
            { id: 83, content: 'Tbbb' },
            { id: 84, content: 'Tccc' },
            { id: 85, content: 'Tddd' }
          ]
        }]
      },
      {
        name: 'FEN',
        id: 6,
        questions: [{
          id: 12,
          body: 'FFF111',
          choices: [
            { id: 62, content: 'F1aaa' },
            { id: 63, content: 'Fbbb' },
            { id: 64, content: 'Fccc' },
            { id: 65, content: 'Fddd' }
          ]
        },
        {
          id: 13,
          body: 'FFF222',
          choices: [
            { id: 72, content: 'F2aaa' },
            { id: 73, content: 'Fbbb' },
            { id: 74, content: 'Fccc' },
            { id: 75, content: 'Fddd' }
          ]
        },
        {
          id: 14,
          body: 'FFF333',
          choices: [
            { id: 82, content: 'F3aaa' },
            { id: 83, content: 'Fbbb' },
            { id: 84, content: 'Fccc' },
            { id: 85, content: 'Fddd' }
          ]
        }]
      }
    ]

    const answer = ['A', ' ', 'B', 'C']
    let qn = 0
    let tabIndex = 0
    let oldtabIndex = 0
    let questionIndex = 0
    const question = ref()
    question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn]
    const questionDirection = () => {
      questionIndex = localStorage.getItem('questionIndex')
      qn = questionIndex
      question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn]
    }
    const changeTab = () => {
      tabIndex = Number(localStorage.getItem('tabIndex'))

      if (tabIndex !== oldtabIndex) {
        qn = 0
        question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn]
        oldtabIndex = tabIndex
      }
    }
    const nextQuestion = () => {
      // TODO Burada dizi dışına taşma kontrol edilsin
      // tabIndex = Number(localStorage.getItem('tabIndex'))
      if (qn < lessons.filter(l => l.id === tabIndex)[0].questions.length - 1) {
        qn++
        question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn]
      }
    }
    const prevQuestion = () => {
      if (qn > 0) {
        qn--
        question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn]
      }
    }
    return {
      lessons, qn, answer, nextQuestion, prevQuestion, question, changeTab, questionDirection
    }
  }

}

</script>

<style scoped>
  .noselect {
    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -webkit-touch-callout: none;
    -ms-user-select: none;
}
</style>
