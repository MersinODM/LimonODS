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
  <div>
    <div>
      <ExamList
        v-for="(exam, index) in exams"
        :id="exam.Id"
        :title="exam.Name"
        :time1="exam.StartTime"
        :time2="exam.EndTime"
      />
    </div>
  </div>
</template>

<script>
import ExamList from '../../ccomponents/ExamList'
export default {
  name: 'StudentExams',
  components: { ExamList },
  setup () {
    const exams = [
      {
        Id: 1,
        Name: '8. Sınıf 1. Deneme',
        StartTime: '2021-02-12',
        EndTime: '2021-12-12'
      },
      {
        Id: 2,
        Name: '9. Sınıf 2. Deneme',
        StartTime: '2021-03-12',
        EndTime: '2021-12-12'
      }
    ]
    return { exams }
  }

}
</script>

<style scoped>

</style>
