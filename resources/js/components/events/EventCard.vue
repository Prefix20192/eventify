<template>
    <div
        class="relative group p-4 rounded-lg transition-all duration-200 hover:shadow-md hover:transform hover:-translate-y-0.5"
        :class="['bg-gradient-to-r', gradientClass]"
    >
        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
            <button @click.stop="$emit('action', event)" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                </svg>
            </button>
        </div>
        <h3 class="font-medium text-white">{{ event.title }}</h3>
        <div class="flex items-center mt-2 text-white text-opacity-80">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm">{{ event.time }}</span>
        </div>
    </div>
</template>

<script>
const GRADIENT_CLASSES = [
    'from-blue-500 to-blue-600',
    'from-purple-500 to-purple-600',
    'from-green-500 to-green-600',
    'from-amber-500 to-amber-600',
    'from-rose-500 to-rose-600'
]

export default {
    props: {
        event: {
            type: Object,
            required: true
        }
    },
    computed: {
        gradientClass() {
            return GRADIENT_CLASSES[this.event.id % GRADIENT_CLASSES.length]
        }
    }
}
</script>
