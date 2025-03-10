<script setup>
import { Head } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import { useForm } from "@inertiajs/vue3";
import { onMounted, onUnmounted, ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const toast = useToast();
const video = ref(null);
const canvas = ref(null);
const stream = ref(null);
const activeElement = ref("video");

const form = useForm({
    full_name: "",
    role: "",
    employee_image: "",
});

onMounted(async () => {
    try {
        await navigator.mediaDevices
            .getUserMedia({
                video: {
                    frameRate: { ideal: 10, max: 15 },
                    width: { min: 1024, ideal: 1280, max: 1920 },
                    height: { min: 576, ideal: 720, max: 1080 },
                },
            })
            .then((mediaStream) => {
                stream.value = mediaStream;
                video.value.srcObject = mediaStream;
            });
    } catch (err) {
        toast.warning("Camera permission denied");
    }
});

/**
 * Shuts down the camera API immediately the user leaves this page
 */
onUnmounted(() => {
    if (stream.value) {
        stream.value.getTracks().forEach((track) => track.stop());
    }
});

const captureImage = () => {
    activeElement.value = "canvas";
    const context = canvas.value.getContext("2d");
    context.drawImage(video.value, 50, 30, 200, 100);

    const imageData = canvas.value.toDataURL("image/png");
    form.employee_image = imageData;
};

const submit = () => {
    /**
     * Ensures camera permission is granted and active element is canvas
     * This will prevent registration without capturing an image
     */
    navigator.permissions.query({ name: "camera" }).then((result) => {
        if (result.state === "granted") {
            if (activeElement.value === "video") {
                toast.error("Please capture an image before submitting");
                return;
            } else {
                form.post(route("employees.store"), {
                    onSuccess: () => {
                        if (stream.value) {
                            stream.value
                                .getTracks()
                                .forEach((track) => track.stop());
                        }
                        toast.success("Registration Successful");
                    },
                });
            }
        } else {
            toast.error("Grant Camera Permission");
            return;
        }
    });
};
</script>

<template>

    <Head title="New Employee" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <canvas ref="canvas" class="fixed top-0 right-2"></canvas>

        <div class="flex flex-col items-center min-h-screen pt-12 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden px-6 py-2 sm:max-w-md sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div>
                        <video v-if="activeElement === 'video'" ref="video" autoplay
                            class="bg-gray-100 py-5 h-1/2 w-full flex items-center justify-center rounded-md outline-none border-none hover:bg-slate-200"></video>
                        <canvas ref="canvas" v-show="activeElement === 'canvas'"
                            class="bg-gray-100 rounded-md w-full outline-none border-none hover:bg-slate-200"></canvas>
                    </div>

                    <div class="mt-2">
                        <InputLabel for="full_name" value="Full Name" />

                        <TextInput id="full_name" type="text" class="mt-1 block w-full" placeholder="John Steve Roberts"
                            v-model="form.full_name" required />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="role" value="Role" />

                        <TextInput id="role" type="text" class="mt-1 block w-full" v-model="form.role"
                            placeholder="Senior Software Engineer" required />
                    </div>

                    <div class="flex justify-between mt-4 space-x-5">
                        <button @click="captureImage" type="button"
                            class="py-3 mt-1 bg-blue-500 text-white -500 block w-1/2 rounded-md">
                            Capture
                        </button>

                        <button type="submit" class="py-3 mt-1 bg-black text-white block w-1/2 rounded-md">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
