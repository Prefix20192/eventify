<template>
    <div class="h-screen flex flex-col" :class="themeClasses">
        <template v-if="!isReady">
            <div class="fixed inset-0 flex items-center justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>
        </template>

        <template v-else>
            <main class="flex-1 overflow-hidden flex flex-col">
                <router-view :user="user" :theme="theme" />
            </main>

            <nav
                v-if="showBottomNav"
                class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 fixed bottom-0 w-full"
            >
                <div class="flex justify-around py-2">
                    <router-link
                        v-for="route in navigationRoutes"
                        :key="route.path"
                        :to="route.path"
                        class="flex flex-col items-center text-gray-600 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 px-2 py-1"
                        active-class="text-blue-500 dark:text-blue-400"
                    >
                        <component :is="route.meta.icon" class="w-6 h-6" />
                        <span class="text-xs mt-1">{{ route.meta.navTitle }}</span>
                    </router-link>
                </div>
            </nav>
        </template>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from './api/app.js'
import {
    HomeIcon,
    CalendarIcon,
    CogIcon
} from '@heroicons/vue/outline'

export default {
    components: {
        HomeIcon,
        CalendarIcon,
        CogIcon
    },
    setup() {
        const router = useRouter()
        const user = ref(null)
        const isReady = ref(false)
        const theme = ref('light')

        const navigationRoutes = computed(() => {
            return router.options.routes.filter(route => route.meta.showInNav)
        })

        const showBottomNav = computed(() => {
            return router.currentRoute.value.meta.showInNav
        })

        const themeClasses = computed(() => ({
            'bg-gray-100': theme.value === 'light',
            'bg-gray-900': theme.value === 'dark',
            'text-gray-800': theme.value === 'light',
            'text-gray-100': theme.value === 'dark'
        }))

        const initTelegramApp = () => {
            if (window.Telegram?.WebApp) {
                const tg = window.Telegram.WebApp
                tg.expand()
                theme.value = tg.colorScheme || 'light'
                tg.onEvent('themeChanged', () => {
                    theme.value = tg.colorScheme || 'light'
                })
            }
        }

        const loadUser = async () => {
            try {
                const token = localStorage.getItem('auth_token')
                if (token) {
                    user.value = await api.getCurrentUser()
                }
            } catch (error) {
                console.error('User load error:', error)
                // Ошибки теперь обрабатываются через TelegramError.vue
            } finally {
                isReady.value = true
            }
        }

        onMounted(async () => {
            initTelegramApp()
            if (router.currentRoute.value.name !== 'telegram-error') {
                await loadUser()
            } else {
                isReady.value = true
            }
        })

        return {
            user,
            isReady,
            theme,
            navigationRoutes,
            showBottomNav,
            themeClasses
        }
    }
}
</script>
