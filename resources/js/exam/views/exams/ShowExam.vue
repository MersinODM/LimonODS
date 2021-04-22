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
      <div class="row">
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
                    class="col-md-2 bg-dark text-center"
                  >
                    <h2>Geri</h2>
                  </div>
                  <div class="col-md-8 bg-gray-light">
                    <Answers
                      v-for="a in answer"
                      :title="a"
                    >
                      {{ l }}
                    </Answers>
                  </div>
                  <div class="col-md-2 bg-blue text-center">
                    <h2>İleri</h2>
                  </div>
                </div>
                <tab
                  v-for="lesson in lessons"
                  :title="lesson[0]"
                >
                  <div><h1>1-</h1></div>
                  {{ lesson[1] }}
                  <Choices
                      v-for="choice in choices"
                      :id="choice[1]"
                      :content="choice[0]"
                  >
                    {{ choice[0] }}
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
import Choices from '../../../commons/components/Choices'

export default {
  name: 'ShowExam',
  components: { Page, Tab, Tabs, Answers, Choices },
  setup: function () {
    const lessons = [
        ['Matematik','laskjdkasjd'],
        ['Türkçe','laksdjasjdkj'],
        ['Sosyal','ldsjfjsdlfj'],
        ['Fen','hsdjfıj']
    ]
    const answer = ['A', 'B', 'C', 'D']
    // const choicesTag = ['A', 'B', 'C', 'D', 'E']
    const choices = [
      ['A) Birinci Seçenek', '3333'],
      ['B) İkinci Seçenek', '4444'],
      ['C) Üçüncü Seçenek', '5555'],
      ['D) Dördüncü Seçenek', '6666']
    ]
    return {
      lessons,
      answer,
      choices
    }
  }
}

</script>

<style scoped>

</style>
