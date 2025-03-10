<script setup>
const props = defineProps({
    earlyRanking: Array,
    message: String
});

const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
</script>

<template>
    <h5 class="text-center font-bold mt-4 pt-4">Top 10 Early Birds in {{ month[new Date().getMonth()] }}</h5>
    <div v-show="props.message" class="flex flex-col items-center justify-center h-80">
        <p class="text-center text-gray-400">{{ props.message }}</p>
    </div>
    <div v-for="(data, index) in props.earlyRanking" :key="data.id" class="bg-gray-100 w-full h-18 p-2 rounded-md">
        <div class="flex justify-between items-center mt-3">
            <h6 class="pl-2">{{ index + 1 }}. {{ data.full_name }}</h6>

            <p class="hidden md:block pr-3">{{ data.role }}</p>
        </div>

        <span class="block text-bold md:hidden pl-2">{{ data.role }}</span>
    </div>
</template>

<style scoped></style>
