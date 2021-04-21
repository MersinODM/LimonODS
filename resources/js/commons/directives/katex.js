/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */

// import ktx from 'katex/dist/katex.min'
// import renderMathInElement from 'katex/contrib/auto-render/auto-render'

const katex = {
  updated (el, binding, vnode) {
    // const sourceValue = el.value
    if (binding.arg && binding.arg === 'auto') {
      // renderMathInElement(el, allOptions)
      // eslint-disable-next-line no-undef
      renderMathInElement(el, {
        delimiters: [
          { left: '$$', right: '$$', display: true },
          { left: '$', right: '$', display: false },
          { left: '\\(', right: '\\)', display: false },
          { left: '\\[', right: '\\]', display: true }
        ],
        throwOnError: true
      })
      // console.log(el)
    } else {
      const expression = binding.value.expression || binding.value
      const displayMode = {}
      if (binding.arg === 'display') {
        displayMode.displayMode = true
      }
      // const options = merge(allOptions, displayMode);

      katex.render(expression, el)
    }
  }
}

export default katex
