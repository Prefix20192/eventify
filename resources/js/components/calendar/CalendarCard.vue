<template>
    <div class="relative">
        <button @click="openCalendar" class="w-20 h-20 bg-white dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600 flex flex-col items-center justify-center">
            <div class="w-full bg-blue-500 py-1 text-center text-white text-xs font-medium rounded-t-lg">
                {{ dayName }}
            </div>
            <div class="text-3xl font-bold text-gray-800 dark:text-white my-1">
                {{ dayNumber }}
            </div>
            <span v-if="eventsCount > 0"
                  class="absolute bottom-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
        {{ eventsCount }}
      </span>
            <svg class="absolute top-0 left-0 w-full h-full z-0 opacity-10 dark:opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </button>

        <CalendarModal
            ref="calendarModal"
            :events="calendarEvents"
        />
    </div>
</template>

<script>
import { ref } from 'vue'
import CalendarModal from './CalendarModal.vue'

export default {
    components: { CalendarModal },
    props: {
        dayNumber: {
            type: Number,
            required: true
        },
        dayName: {
            type: String,
            required: true
        },
        eventsCount: {
            type: Number,
            default: 0
        },
        events: {
            type: Array,
            default: () => []
        }
    },
    setup(props) {
        const calendarModal = ref(null)
        const calendarEvents = ref([])

        const openCalendar = () => {
            calendarEvents.value = props.events.map(event => ({
                ...event,
                date: new Date(event.date).toISOString().split('T')[0]
            }))

            calendarModal.value.open()
        }

        return {
            calendarModal,
            calendarEvents,
            openCalendar
        }
    }
}
</script>
