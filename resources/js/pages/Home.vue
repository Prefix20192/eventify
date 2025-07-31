<template>
    <div class="container mx-auto px-4 py-16">
        <!-- Аватарка и календарь -->
        <div class="flex justify-between items-center mb-8 px-4">
            <!-- Аватарка -->
            <div v-if="userAvatar" class="w-24 h-24 rounded-full overflow-hidden border-2 border-blue-500">
                <img :src="userAvatar" class="w-full h-full object-cover">
            </div>
            <div v-else class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                {{ userInitials }}
            </div>

            <!-- Новая иконка календаря -->
            <div class="relative w-24 h-24 bg-white rounded-lg shadow-md border border-gray-200 flex flex-col items-center justify-center">
                <!-- Верхняя часть с днем недели -->
                <div class="w-full bg-blue-500 py-1 text-center text-white text-sm font-medium rounded-t-lg">
                    {{ currentDayFull }}
                </div>
                <!-- Большое число дня -->
                <div class="text-4xl font-bold text-gray-800 my-2">
                    {{ currentDayNumber }}
                </div>

                <!-- Счетчик событий -->
                <div v-if="events.length > 0"
                     class="absolute bottom-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                    {{ events.length }}
                </div>

                <!-- Иконка календаря на фоне -->
                <svg class="absolute top-0 left-0 w-full h-full z-0 opacity-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <!-- События -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Сегодняшние события</h2>
            <div v-if="events.length > 0">
                <div v-for="event in events" :key="event.id" class="mb-3 p-3 border-b border-gray-100 last:border-0">
                    <h3 class="font-medium text-gray-800">{{ event.title }}</h3>
                    <p class="text-sm text-gray-500">{{ event.time }}</p>
                </div>
            </div>
            <div v-else class="text-center py-4 text-gray-500">
                Нет событий на сегодня
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import useTelegram from '../composables/useTelegram'

export default {
    name: 'HomePage',
    setup() {
        const { user } = useTelegram()

        const userInitials = computed(() => {
            if (!user.value) return 'TG'
            const first = user.value.first_name?.[0] || ''
            const last = user.value.last_name?.[0] || ''
            return `${first}${last}`.toUpperCase() || 'TG'
        })

        const userAvatar = computed(() => user.value?.photo_url || null)

        return {
            userInitials,
            userAvatar
        }
    },
    data() {
        const now = new Date();

        return {
            currentDayNumber: now.getDate(), // Только число (29)
            currentDayFull: now.toLocaleDateString('ru-RU', { weekday: 'long' }), // Полное название дня недели
            events: [
                { id: 1, title: 'Встреча с командой', time: '10:00 - 11:30' },
                { id: 2, title: 'Обед', time: '13:00 - 14:00' },
            ]
        }
    }
};
</script>

<style scoped>
.calendar-day {
    font-size: 2.5rem;
    line-height: 1;
}
</style>
