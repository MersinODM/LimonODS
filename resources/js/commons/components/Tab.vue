<template>
  <div
    v-show="isActive"
    class="tab-pane fade"
    :class="{active: isActive, show: isActive}"
  >
    <slot />
  </div>
</template>
<script>
export default {
  name: 'Tab',
  props: {
    title: {
      type: String,
      default: 'Tab'
    }
  },
  data: () => ({
    isActive: true
  })
}
</script>

<style scoped>

</style>
