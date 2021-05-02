<template>
  <router-view />
</template>

<script>

import { statusStore } from '../store/statusStore'
import { lessonStore } from '../store/lessonStore'

import mitt from 'mitt'

// eslint-disable-next-line new-cap
const eventBus = new mitt()

export default {
  name: 'App',
  provide: {
    statusStore,
    lessonStore,
    eventBus
  },
  setup () {
    lessonStore.actions.setLessons()
  }
}
</script>

<style scoped>

</style>
