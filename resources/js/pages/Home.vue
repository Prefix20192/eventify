<template>
    <div class="flex-1 flex flex-col h-full">
        <!-- Профиль пользователя и календарь -->
        <div v-if="userData" class="flex justify-between items-center mb-6 px-4 pt-4">
            <UserAvatar :photo-url="userData.photo_url" />
            <CalendarCard
                :day-number="currentDayNumber"
                :day-name="currentDayFull"
                :events-count="events.length"
                :events="events"
            />
        </div>

        <!-- События -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mx-4 flex-1 flex flex-col min-h-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Сегодняшние события</h2>
                <button @click="refreshData" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Загрузка -->
            <div v-if="loading" class="flex-1 flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
            </div>

            <!-- Контент (события или пустое состояние) -->
            <div v-else class="flex-1 min-h-0 overflow-y-auto">
                <EventList
                    v-if="events.length > 0"
                    :events="events"
                    @action="handleEventAction"
                />

                <EmptyEvents
                    v-else
                    @refresh="refreshData"
                />
            </div>
        </div>

    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import api from '../api/app.js'
import UserAvatar from '../components/user/UserAvatar.vue'
import CalendarCard from '../components/calendar/CalendarCard.vue'
import EventList from '../components/events/EventList.vue'
import EmptyEvents from '../components/events/EmptyEvents.vue'
import ScrollToTop from '../components/scrolls/ScrollTop.vue'
import CalendarModal from '../components/calendar/CalendarModal.vue'

export default {
    components: {
        UserAvatar,
        CalendarCard,
        EventList,
        EmptyEvents,
        ScrollToTop,
        CalendarModal
    },
    props: {
        user: {
            type: Object,
            required: false,
            default: null
        }
    },
    setup(props) {
        const userData = ref(props.user || null)
        const events = ref([])
        const loading = ref(false)
        const error = ref(null)

        const generateFakeEvents = () => {
            const today = new Date().toISOString().split('T')[0]
            const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0]

            return [
                {
                    id: 1,
                    title: 'Встреча с командой',
                    time: '10:00 - 11:30',
                    date: today  // Добавляем поле date
                },
                {
                    id: 2,
                    title: 'Обед с клиентом',
                    time: '13:00 - 14:30',
                    date: today  // Добавляем поле date
                },
                {
                    id: 3,
                    title: 'Презентация проекта',
                    time: '16:00 - 17:00',
                    date: tomorrow  // Добавляем поле date
                },
                {
                    id: 4,
                    title: 'Совещание по проекту',
                    time: '18:00 - 19:00',
                    date: tomorrow  // Добавляем поле date
                },
                {
                    id: 5,
                    title: 'Разбор задач на завтра',
                    time: '19:30 - 20:00',
                    date: tomorrow  // Добавляем поле date
                }
            ]
        }

        const checkAuth = () => {
            const token = localStorage.getItem('auth_token')
            if (!token) {
                error.value = 'Требуется авторизация'
                return false
            }
            return true
        }

        const fetchUserData = async () => {
            if (!checkAuth()) return

            try {
                if (!userData.value) {
                    userData.value = await api.getCurrentUser()
                }
            } catch (err) {
                console.error('User data error:', err)
                error.value = 'Ошибка загрузки данных пользователя'
            }
        }

        const fetchEvents = async () => {
            if (!checkAuth()) return

            try {
                loading.value = true
                const apiEvents = await api.getTodayEvents()
                events.value = apiEvents.length > 0 ? apiEvents : generateFakeEvents()
            } catch (err) {
                console.error('Events error:', err)
                error.value = 'Ошибка загрузки событий'
                events.value = generateFakeEvents()
            } finally {
                loading.value = false
            }
        }

        const refreshData = async () => {
            await Promise.all([
                fetchUserData(),
                fetchEvents()
            ])
        }

        const handleEventAction = (event) => {
            console.log('Action for event:', event)
        }

        onMounted(() => {
            refreshData()
        })

        return {
            userData,
            events,
            loading,
            error,
            currentDayNumber: computed(() => new Date().getDate()),
            currentDayFull: computed(() =>
                new Date().toLocaleDateString('ru-RU', { weekday: 'long' })
            ),
            refreshData,
            handleEventAction
        }
    }
}
</script>

<style scoped>
.calendar-day {
    font-size: 2.5rem;
    line-height: 1;
}

button:hover svg {
    transform: rotate(180deg);
    transition: transform 0.5s ease;
}
</style>
