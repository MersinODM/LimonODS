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
    const tabs = inject('TabsProvider')

    watch(
      () => tabs.selectedIndex,
      () => {
        isActive.value = props.title === tabs.selectedIndex
      }
    )

    onBeforeMount(() => {
      isActive.value = props.title === tabs.selectedIndex
    })
    return { isActive }
  }
}
</script>

<style scoped>

</style>
