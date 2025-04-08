<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Home</title>  
        <meta name="description" content="Drongo is an innovative employee attendance management system that uses facial recognition and comparison to authenticate and record employee attendance">
    </Head>
    <header class="container mx-auto flex justify-center">
        <div>
            <ApplicationLogo />
        </div>
    </header>

    <section>
        <div
            class="container flex flex-col-reverse items-center px-6 mx-auto mt-10 space-y-0 md:pl-12 md:space-y-0 md:space-x-3 md:flex-row">
            <!-- Left Flex Item -->
            <div class="flex flex-col mb-20 space-y-8">
                <h1 class="max-w-md text-3xl font-bold text-center md:text-left">
                    Keep track of your organization's attendance easily and
                    efficiently
                </h1>
                <p class="max-w-sm text-center text-blue-800 md:text-left">
                    Drongo makes it simple for companies of all sizes to manage
                    their employee attendance daily. Verify, Record and Track
                    employees with minimal effort.
                </p>
                <div class="flex justify-center md:justify-start">
                    <Link href="/register" class="p-3 px-6 pt-2 text-white bg-blue-500 rounded-full baseline">Get
                    Started</Link>
                </div>
            </div>
            <!-- Right Flex Item -->
            <div class="lg:w-1/2">
                <img src="storage/home-img.png" alt="Illustration Image" />
            </div>
        </div>
    </section>

    <footer class="flex justify-center">
        <p>
            Copyright &copy {{ new Date().getFullYear() }} Drongo, All Rights
            Reserved
        </p>
    </footer>
</template>
