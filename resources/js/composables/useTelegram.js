import { ref, onMounted } from 'vue'

export default function useTelegram() {
    const tg = ref(null)
    const user = ref(null)
    const isReady = ref(false)

    const init = () => {
        if (window.Telegram?.WebApp) {
            tg.value = window.Telegram.WebApp
            tg.value.expand()
            tg.value.enableClosingConfirmation()

            if (tg.value.initDataUnsafe?.user) {
                user.value = tg.value.initDataUnsafe.user
            }

            isReady.value = true
            tg.value.ready()
        }
    }

    onMounted(() => {
        init()
    })

    return {
        tg,
        user,
        isReady,
        sendData: (data) => tg.value?.sendData(JSON.stringify(data)),
        close: () => tg.value?.close()
    }
}
