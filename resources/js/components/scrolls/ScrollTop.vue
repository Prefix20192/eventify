<template>
    <button
        v-if="visible"
        @click="scrollToTop"
        class="fixed bottom-20 right-4 z-10 p-3 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-all duration-200"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
    setup() {
        const visible = ref(false)

        const handleScroll = () => {
            visible.value = window.scrollY > 200
        }

        const scrollToTop = () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
        }

        onMounted(() => {
            window.addEventListener('scroll', handleScroll)
        })

        onUnmounted(() => {
            window.removeEventListener('scroll', handleScroll)
        })

        return {
            visible,
            scrollToTop
        }
    }
}
</script>
