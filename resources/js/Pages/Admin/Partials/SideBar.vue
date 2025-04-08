<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const { url } = usePage();
const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

const closeSidebar = () => {
    isSidebarOpen.value = false;
};
</script>

<template>
    <button
        @click="toggleSidebar"
        aria-controls="separator-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden"
    >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>

    <div
        v-if="isSidebarOpen"
        @click="closeSidebar"
        class="fixed inset-0 z-30 bg-black bg-opacity-50 sm:hidden"
    ></div>

    <aside
        id="separator-sidebar"
        :class="{
            '-translate-x-full': !isSidebarOpen,
            'translate-x-0': isSidebarOpen
        }"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform sm:translate-x-0 p-4 pl-5 bg-white border border-gray-100"
    >
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <Link
                        href="/admin/dashboard"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/dashboard',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/dashboard'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 22 21"
                        >
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                            />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                            />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/admin/new-employee"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/new-employee',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/new-employee'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 20 18"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="ms-3">New Employee</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/admin/employees"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/employees',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/employees'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 18"
                        >
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"
                            />
                        </svg>
                        <span class="ms-3 whitespace-nowrap">Employees</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/admin/signin-history"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/signin-history',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/signin-history'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 12H5m14 0-4 4m4-4-4-4"
                            />
                        </svg>
                        <span class="ms-3 whitespace-nowrap"
                            >Sign-in History</span
                        >
                    </Link>
                </li>
                <li>
                    <Link
                        href="/admin/signout-history"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/signout-history',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/signout-history'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 12h14M5 12l4-4m-4 4 4 4"
                            />
                        </svg>
                        <span class="ms-3 whitespace-nowrap"
                            >Sign-out History</span
                        >
                    </Link>
                </li>
                <li>
                    <Link
                        href="/admin/attendance-ranking"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/attendance-ranking',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/attendance-ranking'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="ms-3 whitespace-nowrap"
                            >Attendance Ranking</span
                        >
                    </Link>
                </li>
            </ul>
            <ul class="pt-4 mt-4 space-y-2 font-medium">
                <li>
                    <Link
                        href="/admin/profile"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/profile',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/profile'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="ms-3">Profile</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/admin/settings"
                        :class="{
                            'bg-blue-200 text-blue-500 hover:none': url === '/admin/settings',
                            'text-gray-500 hover:bg-gray-200': url !== '/admin/settings'
                        }"
                        class="flex items-center w-full p-2 no-underline rounded-lg"
                    >
                        <svg
                            class="shrink-0 w-4 h-4 transition duration-75 group-hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="ms-3">Settings</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
