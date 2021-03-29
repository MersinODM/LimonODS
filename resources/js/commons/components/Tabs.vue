<template>
  <div class="card card-primary card-outline card-tabs">
    <div class="card-header p-0 pt-1 border-bottom-0">
      <ul class="nav nav-tabs">
        <li
          v-for="(tab, index) in tabs"
          :key="tab.title"
          class="nav-item"
          @click="selectTab(index)"
        >
          <a
            href="#"
            class="nav-link"
            :class="{active: tab.isActive}"
            @click.prevent
          >{{ tab.title }}</a>
        </li>
      </ul>
      <div class="card-body">
        <div class="tab-content">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Tabs',
  data: () => ({
    selectedIndex: 0,
    tabs: []
  }),
  created () {
    this.tabs = this.$children
  },
  mounted () {
    this.selectTab(0)
  },
  methods: {
    selectTab (index) {
      this.selectedIndex = index
      this.tabs.forEach((tab, i) => {
        tab.isActive = (i === index)
      })
    }
  }

}
</script>

<style scoped>

</style>
