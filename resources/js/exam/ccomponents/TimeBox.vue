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
  <div class="card">
    <div class="card-body">
      <h1>
        {{ minutes + ":" + seconds }}
      </h1>
    </div>
  </div>
</template>
<script>

import { ref } from 'vue'

export default {
  name: 'TimeBox',
  props: {
    examTime: {
      required: true,
      type: String,
      default: ''
    }
  },
  setup: function () {
    // const tm = this.props.examTime.split(':')
    let minutes = ref(60)
    let seconds = ref(0)
    // let lastTime = ref()
    setInterval(function () {
      if (seconds === 0) {
        minutes--
        seconds = 59
      } else seconds--
      // if (seconds < 10) lastTime = minutes + ':0' + seconds
      // else lastTime = minutes + ':' + seconds
      return { minutes, seconds }
      // console.log(lastTime)
    }, 1000)
  }
}
</script>

<style scoped>
  .roundtimer{
    height: 4%;
    width: 4%;
    border-radius: 100%;
    border:10px solid darkblue;
  }
</style>
