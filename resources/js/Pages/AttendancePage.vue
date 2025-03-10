<script setup>
import { Head } from "@inertiajs/vue3";
import { onBeforeMount, ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import EmployeeSignIn from "@/Components/EmployeeSignIn.vue";
import EmployeeSignOut from "@/Components/EmployeeSignOut.vue";

const props = defineProps({
    user: {
        user_uid: String
    },
})

const activeComponent = ref("signIn");

const showEmployeeSignIn = () => {
    activeComponent.value = "signIn";
    sessionStorage.setItem("dfap", "signIn");
};
const showEmployeeSignOut = () => {
    activeComponent.value = "signOut";
    sessionStorage.setItem("dfap", "signOut");
};

onBeforeMount(() => {
    if (sessionStorage.getItem("dfap")) {
        activeComponent.value = sessionStorage.getItem("dfap");
    }
})
</script>

<template>

    <Head title="Attendance" />

    <div class="bg-gray-100 min-h-screen">
        <header class="flex justify-start">
            <ApplicationLogo />
        </header>

        <section class="py-8">
            <div class="flex flex-col items-center pt-10 sm:justify-center sm:pt-0">
                <div class="w-full overflow-hidden px-6 py-2 sm:max-w-md sm:rounded-lg">
                    <div class="flex justify-center space-x-5">
                        <button @click="showEmployeeSignIn" class="p-3 px-6 pt-2 text-white bg-blue-500 rounded-lg">
                            Sign-in
                        </button>
                        <button @click="showEmployeeSignOut" class="p-3 px-6 pt-2 text-white bg-black rounded-lg">
                            Sign-Out
                        </button>
                    </div>

                    <EmployeeSignIn v-if="activeComponent === 'signIn'" :user_uid="props.user.user_uid" />
                    <EmployeeSignOut v-if="activeComponent === 'signOut'" :user_uid="props.user.user_uid" />
                </div>
            </div>
        </section>
    </div>
</template>
