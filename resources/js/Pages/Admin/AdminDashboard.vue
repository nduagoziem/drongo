<script setup>
import { Head, Link } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";

defineProps({
    number_of_employees: Number,
    signed_in_employees: Number,
    signed_out_employees: Number
});
</script>

<template>

    <Head title="Dashboard" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="mx-auto space-y-6 sm:px-6 mb-5 lg:px-8">
            <header class="bg-blue-100 p-4 shadow-sm sm:rounded-lg sm:p-8">
                <div class="flex justify-center">
                    <img src="/storage/dashboard-welcome.png" alt="Welcome Image" />
                </div>
                <p class="text-pretty text-gray-600 text-center">
                    Your account has been successfully verified.
                </p>
            </header>
        </div>

        <div class="mx-auto space-y-6 sm:px-5 lg:px-8">
            <section class="p-4 bg-blue-100 shadow-sm sm:rounded-lg sm:p-8">
                <div class="flex flex-col items-center space-y-3 mb-3 md:flex-row md:justify-evenly">
                    <div class="card bg-white" style="width: 18rem">
                        <div class="card-body py-2 px-4">
                            <h5 class="card-title flex justify-center mb-3 text-body-secondary">
                                <svg class="w-12 h-12 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </h5>
                            <h6 class="card-subtitle text-center mb-3">
                                Total Number of Employees
                            </h6>
                            <p class="card-text text-center text-xl">
                                {{ number_of_employees }}
                            </p>
                        </div>
                    </div>

                    <div class="card bg-white" style="width: 18rem">
                        <div class="card-body py-2">
                            <h5 class="card-title flex justify-center mb-3 text-body-secondary">
                                <svg class="w-12 h-12 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                                </svg>
                            </h5>
                            <h6 class="card-subtitle text-center mb-3">
                                Signed In Employees
                            </h6>
                            <p class="card-text text-center text-xl">{{ signed_in_employees }}</p>
                        </div>
                    </div>
                </div>

                <!-- Second Flex Container -->
                <div class="flex flex-col items-center space-y-3 md:flex-row md:justify-evenly">
                    <div class="card bg-white" style="width: 18rem">
                        <div class="card-body py-2">
                            <h5 class="card-title flex justify-center mb-3 text-body-secondary">
                                <svg class="w-12 h-12 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>
                            </h5>
                            <h6 class="card-subtitle text-center mb-3">
                                Signed Out Employees
                            </h6>
                            <p class="card-text text-center text-xl">{{ signed_out_employees }}</p>
                        </div>
                    </div>

                    <div class="card bg-white" style="width: 18rem">
                        <Link href="/admin/settings">
                        <div class="card-body py-1 hover:bg-gray-50">
                            <h5 class="card-title flex justify-center mb-3 text-body-secondary">
                                <svg class="w-12 h-12 transition duration-75 group-hover:text-blue-500 focus:text-blue-500"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </h5>
                            <h6 class="card-subtitle text-center mb-3">
                                App Management
                            </h6>
                            <div class="flex justify-center">
                                <p class="card-text text-center w-1/2 py-2 text-blue-400 bg-black rounded-sm">
                                    Go to Settings
                                </p>
                            </div>
                        </div>
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<style scoped>
img {
    width: 200px;
    height: 200px;
}
</style>
