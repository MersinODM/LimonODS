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
      <div class="noselect">
        <div class="col-md-5 float-left">
          <h4>Sınav Adı</h4>
        </div>
        <div class="col-md-2 float-left text-center">
          <TimeBox
            :minute="examTime.minute"
            :second="examTime.second"
          >
            {{ examTime }}
          </TimeBox>
        </div>
        <div
          class="card col-md-2 float-right bg-gradient-red"
          style="cursor:pointer"
          @click="finishExam"
        >
          <div class="card-body text-center">
            <h2>Bitir</h2>
          </div>
        </div>
      </div>
    </template>
    <template #content>
      <div class="card noselect">
        <div
          class="row"
        >
          <div
            id="prevButton"
            class="card-body col-md-2 text-center unclickable"
            :class="{'card-body col-md-2 text-center clickable':qn>0, 'card-body col-md-2 text-center unclickable':qn===0}"
            @click="prevQuestion"
          >
            <div class="card-body">
              <h4>Geri</h4>
            </div>
          </div>
          <div
            class="card-body col-md-8"
          >
            <Answers
              v-for="(answer1, index) in answer"
              :id="index"
              :title="answer1"
              class="p-1"
              :class="{'text-green p-2 bg-orange rounded':qn===index}"
              @click="questionDirection(index)"
            >
              {{ (index + 1) + ')' + answer1 }}
            </Answers>
          </div>
          <div
            id="nextButton"
            class="card-body col-md-2 text-center unclickable"
            :class="{'card-body col-md-2 text-center clickable':qn<answer.length-1, 'card-body col-md-2 text-center unclickable':qn===answer.length-1}"
            @click="nextQuestion"
          >
            <div class="card-body">
              <h4>İleri</h4>
            </div>
          </div>
        </div>
      </div>

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
                />
                <div>
                  {{ (Number(qn) + 1 ) + ") " + question?.body }}
                </div>
                <p />
              </tabs>
              <div>
                <Choices
                  v-for="(choice,index) in question?.choices"
                  :id="choice.id"
                  :key="index"
                  :content="choice.content"
                  :class="{'bg-green':abc[index]===answer[qn]}"
                  @click="selectChoice(index, choice.id)"
                >
                  {{ abc[index] + ") " + choice.content }}
                </Choices>
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
import TimeBox from '../../ccomponents/TimeBox'
import { inject, provide, reactive, ref } from 'vue'
import * as Json from 'postcss'

export default {
  name: 'ShowExam',
  components: { Page, Tab, Tabs, Answers, Choices, TimeBox },

  setup (props) {
    // localStorage.clear()
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
    const abc = ['A', 'B', 'C', 'D', 'E']
    const examTime = ({
      minute: 60,
      second: 0
    })
    const answer = ref([])
    const qn = ref()
    qn.value = 0
    let tabIndex = 0
    let oldtabIndex = 0
    const activeQuestion = ref()
    const question = ref()
    question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn.value]
    // Tablara ait soruları ve verilen cevapları tutan nesne
    const answerObject = ref([{
      tabIndex: Number,
      questionIndex: Number,
      answerIndex: Number
    }])
    // Cevaplar dizisine boş doldurma
    const answerWrite = () => {
      for (let j = 0; j < lessons.length; j++) {
        for (let i = 0; i < lessons[j].questions.length; i++) {
          answerObject.value.push({ questionIndex: i, answerIndex: -1, tabIndex: lessons[j].id })
          answer.value[i] = ' '
        }
      }
    }
    console.log(answerObject)
    answerWrite()
    // Sınavı Bitir
    const finishExam = () => {
      alert('Bitti')
    }
    // Seçenek tıklanması
    const answerWriteLast = (ln) => {
      for (let i = 0; i < ln; i++) {
        if (answerObject.value.filter(l => l.tabIndex === tabIndex && l.questionIndex === i)[0]?.answerIndex !== -1) {
          answer.value[i] = abc[answerObject.value.filter(l => l.tabIndex === tabIndex && l.questionIndex === i)[0]?.answerIndex]
        } else answer.value[i] = ' '
      }
    }
    // seçenek tıklandığında
    const selectChoice = (index, id) => {
      if (answerObject.value.filter(l => l.tabIndex === tabIndex && l.questionIndex === qn.value)[0].answerIndex === index) {
        answerObject.value.filter(l => l.tabIndex === tabIndex && l.questionIndex === qn.value)[0].answerIndex = -1
      } else answerObject.value.filter(l => l.tabIndex === tabIndex && l.questionIndex === qn.value)[0].answerIndex = index
      localStorage.setItem('answerObject', JSON.stringify(answerObject))
      answerWriteLast(lessons.filter(l => l.id === tabIndex)[0].questions.length)
    }
    // Üstteki cevap alanından soruya ulaşma
    const questionDirection = (index) => {
      qn.value = index
      question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn.value]
    }
    const changeTab = () => {
      tabIndex = Number(localStorage.getItem('tabIndex'))

      if (tabIndex !== oldtabIndex) {
        qn.value = 0
        question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn.value]
        oldtabIndex = tabIndex
      }
      answerWriteLast(lessons.filter(l => l.id === tabIndex)[0].questions.length)
    }

    const nextQuestion = () => {
      // TODO Burada dizi dışına taşma kontrol edilsin
      // tabIndex = Number(localStorage.getItem('tabIndex'))
      if (qn.value < lessons.filter(l => l.id === tabIndex)[0].questions.length - 1) {
        qn.value++
        question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn.value]
      }
    }
    const prevQuestion = () => {
      if (qn.value > 0) {
        qn.value--
        question.value = lessons.filter(l => l.id === tabIndex)[0]?.questions[qn.value]
      }
    }
    return {
      lessons, qn, answer, abc, nextQuestion, prevQuestion, question, changeTab, questionDirection, selectChoice, examTime, finishExam, activeQuestion
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
  .unclickable{
    cursor: default;
    background-color: #5e5d5d;
    color:white;
  }
  .clickable{
    cursor:pointer;
    background-color: rgba(7, 134, 217, 0.87);
    color:white;
  }
</style>
