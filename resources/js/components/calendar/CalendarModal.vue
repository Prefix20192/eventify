<template>
    <teleport to="body">
        <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md max-h-[80vh] flex flex-col">
                <CalendarHeader
                    :month="currentMonth"
                    :year="currentYear"
                    @prev-month="prevMonth"
                    @next-month="nextMonth"
                    @close="close"
                />

                <div class="p-4 overflow-y-auto">
                    <CalendarWeekDays />
                    <CalendarGrid
                        :days="daysInMonth"
                        :selected-date="selectedDate"
                        @select-day="selectDay"
                    />
                </div>

                <CalendarEvents
                    :events="selectedDayEvents"
                    :formatted-date="formattedSelectedDate"
                />
            </div>
        </div>
    </teleport>
</template>

<script>
import { ref, computed } from 'vue'
import CalendarHeader from './CalendarHeader.vue'
import CalendarWeekDays from './CalendarWeekDays.vue'
import CalendarGrid from './CalendarGrid.vue'
import CalendarEvents from './CalendarEvents.vue'

export default {
    components: {
        CalendarHeader,
        CalendarWeekDays,
        CalendarGrid,
        CalendarEvents
    },

    props: {
        events: {
            type: Array,
            default: () => []
        }
    },
    setup(props) {
        const isOpen = ref(false)
        const currentDate = ref(new Date())
        const selectedDate = ref(null)
        const originalDate = ref(new Date())

        const open = () => {
            originalDate.value = new Date()
            currentDate.value = new Date()
            isOpen.value = true
            selectedDate.value = null
        }

        const close = () => {
            currentDate.value = new Date(originalDate.value)
            isOpen.value = false
        }

        const prevMonth = () => {
            const date = new Date(currentDate.value)
            date.setMonth(date.getMonth() - 1)
            currentDate.value = date
        }

        const nextMonth = () => {
            const date = new Date(currentDate.value)
            date.setMonth(date.getMonth() + 1)
            currentDate.value = date
        }

        const selectDay = (day) => {
            if (day.isCurrentMonth) {
                selectedDate.value = day.date
            }
        }

        const currentMonth = computed(() => {
            return currentDate.value.toLocaleDateString('ru-RU', {month: 'long'})
        })

        const currentYear = computed(() => {
            return currentDate.value.getFullYear()
        })

        const daysInMonth = computed(() => {
            const year = currentDate.value.getFullYear()
            const month = currentDate.value.getMonth()

            const firstDay = new Date(year, month, 1)
            const lastDay = new Date(year, month + 1, 0)

            const prevMonthDays = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1
            const nextMonthDays = 7 - (lastDay.getDay() === 0 ? 7 : lastDay.getDay())

            const days = []

            // Дни предыдущего месяца
            for (let i = prevMonthDays; i > 0; i--) {
                const date = new Date(year, month, -i + 1)
                days.push({
                    day: date.getDate(),
                    date: date.toISOString().split('T')[0],
                    isCurrentMonth: false,
                    eventCount: getEventCount(date)
                })
            }

            // Дни текущего месяца
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const date = new Date(year, month, i)
                days.push({
                    day: i,
                    date: date.toISOString().split('T')[0],
                    isCurrentMonth: true,
                    eventCount: getEventCount(date)
                })
            }

            // Дни следующего месяца
            for (let i = 1; i <= nextMonthDays; i++) {
                const date = new Date(year, month + 1, i)
                days.push({
                    day: i,
                    date: date.toISOString().split('T')[0],
                    isCurrentMonth: false,
                    eventCount: getEventCount(date)
                })
            }

            return days
        })

        const getEventCount = (date) => {
            const dateStr = date.toISOString().split('T')[0]
            return props.events.filter(event => event.date === dateStr).length
        }

        const selectedDayEvents = computed(() => {
            if (!selectedDate.value) return []
            return props.events.filter(event => event.date === selectedDate.value)
        })

        const formattedSelectedDate = computed(() => {
            if (!selectedDate.value) return ''
            const date = new Date(selectedDate.value)
            return date.toLocaleDateString('ru-RU', {day: 'numeric', month: 'long'})
        })

        return {
            isOpen,
            currentDate,
            selectedDate,
            currentMonth,
            currentYear,
            daysInMonth,
            selectedDayEvents,
            formattedSelectedDate,
            open,
            close,
            prevMonth,
            nextMonth,
            selectDay
        }
    }
}
</script>
