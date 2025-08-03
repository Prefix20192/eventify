<template>
    <div
        @click="$emit('select', day)"
        class="h-10 flex items-center justify-center relative cursor-pointer rounded-full transition-colors"
        :class="dayClasses"
    >
        <span>{{ day.day }}</span>
        <span
            v-if="day.eventCount > 0"
            class="absolute top-0 right-0 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center"
        >
      <span class="text-white text-xs">{{ day.eventCount }}</span>
    </span>
    </div>
</template>

<script>
export default {
    props: {
        day: Object,
        selectedDate: String
    },
    computed: {
        dayClasses() {
            return {
                'text-gray-800 dark:text-white': this.day.isCurrentMonth,
                'text-gray-400 dark:text-gray-500': !this.day.isCurrentMonth,
                'bg-blue-100 dark:bg-blue-900': this.day.date === this.selectedDate,
                'hover:bg-gray-100 dark:hover:bg-gray-700': this.day.date !== this.selectedDate
            }
        }
    },
    emits: ['select']
}
</script>
