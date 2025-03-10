<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import PasswordEyeOpen from "@/Components/PasswordEyeOpen.vue";
import PasswordEyeClose from "@/Components/PasswordEyeClose.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    organization_name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const passwordVisible = ref(false);

const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="organization_name" value="Organization Name" />

                <TextInput
                    id="organization_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.organization_name"
                    required
                />

                <InputError class="mt-2" :message="form.errors.organization_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <div class="flex space-x-2 justify-between bg-gray-100">
                    <TextInput
                        id="password"
                        :type="passwordVisible ? 'text' : 'password'"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                    />
                    <button type="button" @click="togglePasswordVisibility">
                        <component
                            :is="
                                passwordVisible
                                    ? PasswordEyeClose
                                    : PasswordEyeOpen
                            "
                        />
                    </button>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                />
            </div>

            <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
            />

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
