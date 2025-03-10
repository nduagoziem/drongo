<script setup>
import { Head, router } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import TextInput from "@/Components/TextInput.vue";
import { onBeforeMount, ref, watch } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

/**
 * Full page reload from the server
 * Delete button won't work properly if not implemented
*/
onBeforeMount(
    () => {
        if (!sessionStorage.getItem('page-reloaded')) {
            sessionStorage.setItem('page-reloaded', 'true');
            window.location.reload();
        } else {
            sessionStorage.removeItem('page-reloaded')
        }
    }
)

defineProps({
    employees: Array,
});

const input = ref("");
const toast = useToast();
const deleteEmployee = (employee_uid) => {
    router.delete(route("employees.destroy", employee_uid));
    toast.success("Employee deleted successfully");
};
const editEmployee = (employee_uid) => {
    router.get(route("employees.showEdit", employee_uid));
};

/**
 * Updates the UI as the user searches for employees
 */
watch(input, (value) => {
    router.get(
        route("employees.create", { search: value }),
        {},
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>

<template>

    <Head title="Employees" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="mx-auto space-y-6 sm:px-6 mb-5 lg:px-8">
            <TextInput name="search" type="text" placeholder="Search"
                class="w-full block bg-gray-100 rounded-md mt-1 outline-none border-none" v-model="input" />
        </div>

        <div class="mx-auto space-y-6 sm:px-6 mt-5 flex flex-col justify-start lg:px-8">
            <div v-for="employee in employees" :key="employee.employee_uid"
                class="flex justify-between items-center bg-gray-100 w-full h-16 rounded-md">
                <h6 class="pl-2">{{ employee.full_name }}</h6>

                <div class="space-x-3 pr-4">
                    <button :data-modal-target="'popup-modal' + employee.employee_uid"
                        :data-modal-toggle="'popup-modal' + employee.employee_uid">
                        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Confirmation Modal for deleting employees -->
                    <div :id="'popup-modal' + employee.employee_uid" tabindex="-1"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <button type="button"
                                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    :data-modal-hide="'popup-modal' + employee.employee_uid
                                        ">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-4 md:p-5 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete
                                        <p class="font-bold text-xl">
                                            {{ employee.full_name }}
                                        </p>
                                        from your employees?
                                    </h3>
                                    <button @click="deleteEmployee(employee.employee_uid)" :data-modal-hide="'popup-modal' + employee.employee_uid
                                        " type="button"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        Yes, I'm sure
                                    </button>
                                    <button :data-modal-hide="'popup-modal' + employee.employee_uid
                                        " type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        No, cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Employee Link -->
                    <button @click="editEmployee(employee.employee_uid)">
                        <svg class="w-6 h-6 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
