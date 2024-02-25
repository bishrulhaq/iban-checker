import { createRouter, createWebHistory } from 'vue-router'
import Home from './views/Home.vue'
import validatedIBAN from './views/ValidatedIBAN.vue'
import Dashboard from './views/Dashboard.vue'
import { useUserStore } from './stores/auth'

const routes = [
  { path: '/', component: Home, meta: { requiresGuest: true } },
  { path: '/login', component: Home, meta: { requiresGuest: true } },
  { path: '/register', component: Home, meta: { requiresGuest: true } },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/validated-iban', component: validatedIBAN, meta: { requiresAdminAuth: true } }

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from) => {
  if (to.meta.requiresAuth && useUserStore().isAuthenticated === false && useUserStore().isTokenExpired === false) {
    return { path: '/' }
  } else if (to.meta.requiresGuest && useUserStore().isAuthenticated && useUserStore().isTokenExpired) {
    return { path: '/dashboard' }
  } else if (to.meta.requiresAdminAuth && useUserStore().isAuthenticated === false && useUserStore().isTokenExpired === false && useUserStore().isAdmin === false) {
    return { path: '/' }
  }
})

export default router
