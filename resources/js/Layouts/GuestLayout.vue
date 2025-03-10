<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="bg-white">
        <div class="flex justify-start">
            <div>
                <Link href="/">
                    <ApplicationLogo />
                </Link>
            </div>
        </div>

        <div
            class="flex flex-col items-center pt-12 sm:justify-center sm:pt-0"
        >
            <div
                class="w-full overflow-hidden px-6 py-2 sm:max-w-md sm:rounded-lg"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
