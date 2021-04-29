<template>
  <router-view />
</template>

<script>

import { tabStore } from '../../commons/store/tabStore'

export default {
  name: 'App',
  provide: {
    tabStore
  }
}
</script>

<style scoped>

</style>
