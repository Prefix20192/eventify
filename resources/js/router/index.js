import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Events from '../pages/Events.vue'
import Settings from '../pages/Settings.vue'
import api from '../api/app.js'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            requiresAuth: true,
            showBackButton: false,
            showInNav: true,
            navTitle: 'Главная',
            icon: 'HomeIcon'
        }
    },
    {
        path: '/events',
        name: 'events',
        component: Events,
        meta: {
            requiresAuth: true,
            showBackButton: true,
            showInNav: true,
            navTitle: 'События',
            icon: 'CalendarIcon'
        }
    },
    {
        path: '/settings',
        name: 'settings',
        component: Settings,
        meta: {
            requiresAuth: true,
            showBackButton: true,
            showInNav: true,
            navTitle: 'Настройки',
            icon: 'CogIcon'
        }
    },
    {
        path: '/telegram-error',
        name: 'telegram-error',
        component: () => import('../pages/TelegramError.vue'),
        props: (route) => ({ errorType: route.query.error || 'default' }),
        meta: { requiresAuth: false }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


router.beforeEach(async (to, from, next) => {
    // Проверка, что мы запустили Telegram Mini App а не в тупую зашли на сайт)
    if (!api.isTelegramWebApp() && to.name !== 'telegram-error') {
        return next({
            name: 'telegram-error',
            query: { error: 'telegram_only' }
        })
    }

    if (to.meta.requiresAuth) {
        const token = localStorage.getItem('auth_token')

        try {
            if (token) {
                const user = await api.getCurrentUser()
                if(!user) throw new Error('Пользователь не найден!');
            } else {
                const tg = window.Telegram.WebApp
                const initData = tg.initData

                if (!initData) {
                    return next({
                        name: 'telegram-error',
                        query: { error: 'telegram_data_missing' }
                    })
                }

                await api.authWithTelegram(initData)
                return next()
            }
        } catch (error) {
            localStorage.removeItem('auth_token')
            if (api.isTelegramWebApp()) {
                return next({ name: 'telegram-error', query: { error: 'auth_failed' } })
            }

            return next(false)
        }
    }

    if (api.isTelegramWebApp()) {
        const tg = window.Telegram.WebApp
        if (to.meta.showBackButton) {
            tg.BackButton.show()
        } else {
            tg.BackButton.hide()
        }
    }

    next()
})

export default router
