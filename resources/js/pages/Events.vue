<template>
    <div class="container mx-auto px-4 py-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Мои события</h1>

        <div class="bg-white rounded-lg shadow p-4">
            <div v-if="subscribedEvents.length > 0">
                <div v-for="event in subscribedEvents" :key="event.id" class="mb-4 p-3 border-b border-gray-100 last:border-0">
                    <h3 class="font-medium text-gray-800">{{ event.title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ event.date }} в {{ event.time }}</p>
                    <button
                        @click="unsubscribe(event.id)"
                        class="text-sm text-red-500 hover:text-red-700"
                    >
                        Отписаться
                    </button>
                </div>
            </div>
            <div v-else class="text-center py-8 text-gray-500">
                Вы не подписаны ни на одно событие
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EventsPage',
    data() {
        return {
            subscribedEvents: [
                { id: 1, title: 'Еженедельный митинг', date: '15.05.2023', time: '10:00' },
                { id: 2, title: 'Обучение новым технологиям', date: '20.05.2023', time: '14:00' },
            ]
        }
    },
    methods: {
        unsubscribe(eventId) {
            this.subscribedEvents = this.subscribedEvents.filter(e => e.id !== eventId);
        }
    }
}
</script>

<style scoped>

</style>
