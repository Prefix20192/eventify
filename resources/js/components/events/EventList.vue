<template>
    <div class="relative">
        <div class="space-y-3">
            <EventCard
                v-for="event in filteredEvents"
                :key="event.id"
                :event="event"
                @action="handleEventAction"
            />
        </div>

        <div class="mt-4 flex justify-center space-x-3">
            <button
                v-if="events.length > limit && !showAll"
                @click="showAll = true"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-full transition-colors"
            >
                Показать еще {{ events.length - limit }} событий
            </button>
            <button
                v-else-if="showAll && events.length > limit"
                @click="showAll = false"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-sm font-medium rounded-full transition-colors"
            >
                Скрыть
            </button>
        </div>

        <ScrollToTop v-if="showAll" />
    </div>
</template>

<script>
import EventCard from './EventCard.vue'
import ScrollToTop from '../scrolls/ScrollTop.vue'

export default {
    components: { EventCard, ScrollToTop },
    props: {
        events: {
            type: Array,
            required: true
        },
        limit: {
            type: Number,
            default: 3
        }
    },
    data() {
        return {
            showAll: false
        }
    },
    computed: {
        filteredEvents() {
            return this.showAll ? this.events : this.events.slice(0, this.limit)
        }
    },
    methods: {
        handleEventAction(event) {
            this.$emit('action', event)
        }
    }
}
</script>
