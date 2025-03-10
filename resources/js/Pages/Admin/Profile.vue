<script setup>
import { Head, Link } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import DeleteAccountForm from "./Partials/DeleteAccountForm.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="mx-auto space-y-6 sm:px-6 mb-5 lg:px-8">
            <!-- Update Profile Information -->
            <div class="bg-blue-100 p-4 sm:rounded-lg sm:p-8">
                <div class="max-w-md">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-blue-100 p-4 sm:rounded-lg sm:p-8">
                <div class="max-w-md">
                    <UpdatePasswordForm />
                </div>
            </div>

            <!-- Logout -->
            <div class="bg-blue-100 p-4 sm:rounded-lg sm:p-8">
                <div class="max-w-md">
                    <h5>Logout Account</h5>
                    <span class="text-pretty text-sm"
                        >You will be logged out of this device.</span
                    >

                    <div class="mt-4">
                        <div>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="px-3 py-2 bg-gray-900 rounded-md text-white no-underline"
                            >
                                Logout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-gray-900 p-4 sm:rounded-lg sm:p-8">
                <div class="max-w-md">
                    <DeleteAccountForm />
                </div>
            </div>
        </div>
    </div>
</template>
