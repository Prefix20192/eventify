<template>
    <div class="flex items-center">
        <div v-if="photoUrl" class="w-20 h-20 rounded-full overflow-hidden border-2 border-blue-500">
            <img :src="photoUrl" class="w-full h-full object-cover" alt="User avatar">
        </div>
        <div v-else class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
            TG
        </div>
    </div>
</template>

<script>
export default {
    props: {
        photoUrl: {
            type: String,
            default: null
        }
    }
}
</script>

