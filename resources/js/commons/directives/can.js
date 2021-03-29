const can = {
  mounted (el, binding, vnode) {
    if (!JSON.parse(localStorage.getItem('permissions'))
      ?.includes(binding.expression
        ?.replace(/'/g, '')
        ?.replace(/"/g, ''))) {
      el.parentNode.removeChild(el)
    }
  }
}

export default can
