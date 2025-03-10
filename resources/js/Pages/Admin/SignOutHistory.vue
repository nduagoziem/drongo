<script setup>
import { Head, router } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import { ref } from "vue";

defineProps({
    signoutHistory: {
        type: Array,
        default: () => []
    }
})

const date = ref();

const removeUrlParams = () => {
    const url = new URL(window.location);
    url.search = '';
    window.history.replaceState({}, document.title, url);
};

const getSignOutHistory = () => {
    router.get(route('signout-history'), {
        date: date.value
    }, {
        onSuccess: () => {
            removeUrlParams();
        }
    });
};
</script>

<template>

    <Head title="SignOut History" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="mx-auto space-y-6 sm:px-6 mb-5 lg:px-8">
            <div class="flex justify-evenly space-x-20">
                <form>
                    <input v-model="date" id="date" type="date"
                        class="block bg-gray-100 rounded-md border-none outline-none" />
                </form>
                <button @click="getSignOutHistory" class="px-4 py-2 rounded-md bg-black text-white">
                    Proceed
                </button>
            </div>
        </div>

        <div class="mx-auto space-y-6 sm:px-6 mt-5 flex flex-col justify-start">
            <div v-for="data in signoutHistory" :key="data.id" class="bg-gray-100 w-full h-16 rounded-md">
                <div class="flex justify-between items-center mt-1">
                    <h6 class="pl-2">{{ data.full_name }}</h6>

                    <h6 class="pr-3">{{ data.time }}</h6>
                </div>

                <div class="flex justify-between items-center rounded-md">
                    <p class="pl-2">{{ data.role }}</p>
                    <p class="pr-3">{{ data.remark }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
