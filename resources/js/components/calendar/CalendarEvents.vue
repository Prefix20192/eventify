<template>
    <div v-if="events.length > 0" class="p-4 border-t border-gray-200 dark:border-gray-700">
        <h4 class="font-medium text-gray-800 dark:text-white mb-2">События на {{ formattedDate }}</h4>
        <div class="space-y-2">
            <div
                v-for="event in events"
                :key="event.id"
                class="p-2 bg-gray-50 dark:bg-gray-700 rounded"
            >
                <p class="font-medium text-gray-800 dark:text-white">{{ event.title }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ event.time }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        events: {
            type: Array,
            default: () => []
        },
        formattedDate: String
    }
}
</script>
