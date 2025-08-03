<template>
    <div class="grid grid-cols-7 gap-1">
        <CalendarDay
            v-for="day in days"
            :key="day.date"
            :day="day"
            :selected-date="selectedDate"
            @select="$emit('select-day', day)"
        />
    </div>
</template>

<script>
import CalendarDay from './CalendarDay.vue'

export default {
    components: { CalendarDay },
    props: {
        days: Array,
        selectedDate: String
    },
    emits: ['select-day']
}
</script>
