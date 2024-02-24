import { createRouter, createWebHistory } from 'vue-router'
import Home from './views/Home.vue'
import Dashboard from './views/Dashboard.vue' 
import { useUserStore } from './stores/auth';

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Home }, 
    { path: '/register', component: Home},
    { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
]

const router = createRouter({
    history: createWebHistory(), 
    routes,
})

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && useUserStore().isAuthenticated === false) { 
        return { path: '/' } 
    } else if (to.meta.requiresGuest && useUserStore().isAuthenticated === true && useUserStore().isTokenExpired) { 
        return { path: '/dashboard' } 
    }
})

export default router;