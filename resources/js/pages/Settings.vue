<template>
    <div class="container mx-auto px-4 py-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Настройки</h1>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Часовой пояс</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option>UTC +3 (Москва)</option>
                    <option>UTC +5 (Екатеринбург)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded text-blue-500 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Уведомления</span>
                </label>
            </div>

            <button class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Сохранить
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SettingsPage'
}
</script>

<style scoped>

</style>
