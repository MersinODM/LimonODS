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
import { onBeforeMount, ref, inject, watch } from 'vue'

export default {
  name: 'Tab',
  props: {
    title: {
      required: true,
      type: String,
      default: ''
    }
  },
  setup (props) {
    const isActive = ref(false)
    const state = inject('TabsProvider')

    watch(
      () => state.selectedIndex,
      () => {
        // state.tabs[state.selectedIndex].isActive = true
        isActive.value = props.title === state.selectedIndex
      }
    )

    onBeforeMount(() => {
      isActive.value = props.title === state.selectedIndex
      // state.tabs[state.selectedIndex].isActive = true
    })
    return { isActive }
  }
}
</script>

<style scoped>

</style>
