<template>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
            <div class="text-red-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-4 dark:text-white">{{ errorData.title }}</h1>
            <p class="mb-6 text-gray-600 dark:text-gray-300">{{ errorData.message }}</p>

            <a
                v-if="errorData.showTelegramButton"
                :href="tgLink"
                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition inline-block"
            >
                Открыть в Telegram
            </a>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router'
import errorMessages from '../appMessages/errors-messages.json'

export default {
    name: 'TelegramError',
    setup() {
        const router = useRouter()
        const route = router.currentRoute.value
        const tgLink = import.meta.env.TELEGRAM_BOT_URL

        const errorData = errorMessages[route.query.error] || errorMessages.default

        const handleRetry = () => {
            if (route.query.error === 'auth_failed') {
                localStorage.removeItem('auth_token')
            }
            window.location.href = '/'
        }

        return {
            errorData,
            tgLink,
            handleRetry
        }
    }
}
</script>
