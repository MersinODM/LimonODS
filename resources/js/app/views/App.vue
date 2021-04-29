<template>
  <router-view />
</template>

<script>

import { statusStore } from '../store/statusStore'

export default {
  name: 'App',
  provide: {
    statusStore
  }
}
</script>

<style scoped>

</style>
