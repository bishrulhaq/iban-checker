import { createApp } from 'vue'
import router from './router'
import { createPinia } from 'pinia'
import Notifications from '@kyvg/vue3-notification'
import { defineRule, configure } from 'vee-validate'
import { required, email, min } from '@vee-validate/rules'
import App from './App.vue'

import './style.css'

defineRule('required', required)
defineRule('email', email)
defineRule('min', min)

configure({
  generateMessage: context => context.message,
  validateOnInput: true
})

const pinia = createPinia()
const app = createApp(App)

app.use(Notifications)
app.use(router)
app.use(pinia)

app.mount('#app')
