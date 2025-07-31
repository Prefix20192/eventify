import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Events from '../pages/Events.vue'
import Settings from '../pages/Settings.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/events', component: Events },
    { path: '/settings', component: Settings },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
