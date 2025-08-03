<template>
    <div class="grid grid-cols-7 gap-1 mb-2">
        <div
            v-for="day in ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс']"
            :key="day"
            class="text-center text-sm font-medium text-gray-500 dark:text-gray-400"
        >
            {{ day }}
        </div>
    </div>
</template>
