import './bootstrap'

import App from './views/App.vue'
import { createApp } from 'vue'
import router from './router'
import can from '../commons/directives/can'
// import maska from 'maska'
// import uppercase from './directives/uppercase'
// import amountFormat from './directives/amount'
// import dateFormat from './directives/dateFormat'

// import { defineRule } from 'vee-validate'
// import { required, email, min } from '@vee-validate/rules'

// defineRule('required', required)
// defineRule('email', email)
// defineRule('min', min)

const app = createApp(App)
app.use(router)
// app.use(maska)
// app.directive('can', can)
// app.directive('uppercase', uppercase)
// app.directive('amount-format', amountFormat)
// app.directive('date-format', dateFormat)
router.isReady().then(() => app.mount('#exam'))
