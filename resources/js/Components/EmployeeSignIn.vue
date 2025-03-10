<script setup>
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { ref, onMounted, onUnmounted } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const toast = useToast();
const currentTime = ref("");
const video = ref();
const canvas = ref();
const stream = ref();
const activeElement = ref("video")

const props = defineProps({
    user_uid: String,
})

let interval;

function setCurrentTime() {
    const date = new Date();
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const seconds = String(date.getSeconds()).padStart(2, "0");
    currentTime.value = `${hours}:${minutes}:${seconds}`;
}

const form = useForm({
    employee_image: "",
    signInTime: ""
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

    setCurrentTime();
    interval = setInterval(setCurrentTime, 1000);
});

/**
 * Shuts down the camera API immediately the user leaves this page
 */
onUnmounted(() => {
    if (interval) {
        clearInterval(interval);
    }
    if (stream.value) {
        stream.value.getTracks().forEach((track) => track.stop());
    }
});

const signIn = async () => {
    /**
     * Ensures camera permission is granted and active element is canvas
     * This will prevent registration without capturing an image
     */
    navigator.permissions.query({ name: "camera" }).then(async (result) => {
        if (result.state === "granted") {
            activeElement.value = "canvas";
            const cxt = canvas.value;
            const context = cxt.getContext("2d")
            context.drawImage(video.value, 50, 30, 200, 100); // Correctly reference video.value

            const imageData = canvas.value.toDataURL("image/png");
            form.employee_image = imageData;
            form.signInTime = currentTime.value;

            try {
                const response = await axios.post(route("attendance.signIn", props.user_uid), {
                    employee_image: form.employee_image,
                    signInTime: form.signInTime,
                });

                if (response.data.success) {
                    toast.success(response.data.success);
                    toast.success(response.data.remark);
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    toast.error(response.data.failure || "Something Went Wrong. Try Again");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                }
            } catch (error) {
                toast.error(error);
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        } else {
            toast.error("Grant Camera Permission");
            return;
        }
    });
};
</script>

<template>
    <div class="flex justify-center mt-6 py-12">
        <form action="" @submit.prevent class="w-full">
            <div class="flex justify-center">
                <video v-show="activeElement === 'video'" ref="video" autoplay
                    class="bg-slate-200 rounded-md outline-none border-none mb-3  hover:bg-gray-500"></video>
                <canvas v-show="activeElement === 'canvas'" ref="canvas"
                    class="bg-slate-200 rounded-md outline-none border-none mb-3  hover:bg-gray-500"></canvas>
            </div>

            <label id="time" class="block text-sm font-medium text-gray-700">Hi, Welcome Back</label>
            <input id="time" type="time" class="mt-1 mb-10 block w-full bg-white rounded-md border-none outline-none"
                v-model="currentTime" disabled />
            <button @click="signIn"
                class="mt-1 block w-full bg-black text-blue-500 px-5 py-2 rounded-md hover:bg-slate-700">
                Sign In
            </button>
        </form>
    </div>
</template>


<style scoped>
video {
    width: 350px;
}
</style>