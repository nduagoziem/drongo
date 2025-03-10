<script setup>
import { Head } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import EarlyEmployeesRanking from "./Partials/EarlyEmployeesRanking.vue";
import LateEmployeesRanking from "./Partials/LateEmployeesRanking.vue";
import { ref } from "vue";

const props = defineProps({
    earlyRanking: Array,
    lateRanking: Array,
    message: String,
})

const activeComponent = ref("early");

const early = () => {
    activeComponent.value = "early";
};

const late = () => {
    activeComponent.value = "late";
};
</script>

<template>
    <Head title="Attendance Ranking" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="mx-auto space-y-6 sm:px-5 lg:px-8">
            <div class="flex justify-evenly space-x-4">
                <button
                    @click="early"
                    class="px-3 py-2 bg-blue-500 rounded-md border-none text-white"
                >
                    Early Birds
                </button>
                <button
                    @click="late"
                    class="px-3 py-2 bg-black rounded-md border-none text-white"
                >
                    Latecomers
                </button>
            </div>

            <EarlyEmployeesRanking v-if="activeComponent === 'early'" :earlyRanking="props.earlyRanking" :message="props.message"/>
            <LateEmployeesRanking v-if="activeComponent === 'late'" :lateRanking="props.lateRanking" :message="props.message"/>
        </div>
    </div>
</template>

<style scoped></style>
