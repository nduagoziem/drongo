<script setup>
import { Head, router } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const props = defineProps({
    user_uid: String
})

const inputText = ref("http://127.0.0.1:8000/attendance/" + props.user_uid);
const inputTime = ref("");
const toast = useToast();

const copyFromInput = async () => {
    try {
        await navigator.clipboard.writeText(inputText.value);
        toast.info("Copied to Clipboard");
    } catch (err) {
        console.error("Failed to copy text: ", err);
    }
};

const openAttendancePage = () => {
    router.post(route("attendance.open", props.user_uid), {}, {
        onSuccess: () => {
            toast.success("Attendance page open")
        },
        onError: () => {
            toast.error("Failed to open attendance page")
        }
    })
}

const closeAttendancePage = () => {
    router.post(route("attendance.close", props.user_uid), {}, {
        onSuccess: () => {
            toast.success("Attendance page closed")
        },
        onError: () => {
            toast.error("Failed to close attendance page")
        }
    })
}
const lateMarkingTime = () => {
    router.post(route("attendance.timer", props.user_uid), { inputTime: inputTime.value }, {
        onSuccess: () => {
            toast.success("Success - Late marking time is " + inputTime.value)
        },
        onError: () => {
            toast.error("Failed")
        }
    })
}
</script>

<template>

    <Head title="Settings" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="bg-blue-100 p-4 sm:rounded-lg sm:p-8">
            <div class="max-w-md mb-3">
                <h5 class="font-semibold">Daily Attendance</h5>
                <p class="text-pretty text-sm">
                    Link to your employees' attendance page.
                </p>
            </div>

            <div class="flex justify-start max-w-md mb-4 space-x-1">
                <TextInput type="text" class="w-full rounded-md bg-white block" v-model="inputText" disabled />
                <button @click="copyFromInput">
                    <svg class="w-8 h-8 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <p class="text-pretty text-sm max-w-sm">
                You can open or close the attendance page after work hours. This prevents signing in before work hours
                or signing out earlier
            </p>

            <div class="mt-2">
                <div class="space-x-4">
                    <button @click="openAttendancePage"
                        class="inline-flex items-center rounded-md bg-blue-500 text-white border border-transparent px-4 py-2 text-xs font-semibold uppercase">
                        Open
                    </button>
                    <button @click="closeAttendancePage"
                        class="inline-flex items-center rounded-md bg-black text-white border border-transparent px-4 py-2 text-xs font-semibold uppercase">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-blue-100 p-4 mt-5 md:mt-10 sm:rounded-lg sm:p-8">
            <div class="max-w-md">
                <h5 class="font-semibold">Late Marking Time</h5>
                <p class="text-pretty text-sm">
                    The time at which late status is assigned. For example 30
                    minutes past 8am is late. Resets automatically at 12 AM daily. Employees can't sign in if this is not set
                </p>
                <div class="mt-2">
                    <div>
                        <div class="flex justify-start space-x-2">
                            <TextInput type="time" class="px-3 py-2 bg-white rounded-md w-1/2 block"
                                v-model="inputTime" />
                            <button @click="lateMarkingTime" type="button" class="bg-gray-900 rounded-md px-3 py-2 text-white">
                                Set
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
