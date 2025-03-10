<script setup>
import { Head } from "@inertiajs/vue3";
import SideBar from "./Partials/SideBar.vue";
import { useForm } from "@inertiajs/vue3";
import { onBeforeMount, onUnmounted, ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

/**
 * Full page reload from the server
 * Retrieves current images from the server - if the images are not cached
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

const props = defineProps({
    employee: {
        employee_image: String,
        full_name: String,
        role: String
    },
});

const toast = useToast();
const video = ref(null);
const canvas = ref(null);
const stream = ref(null);
const activeElement = ref("img");

const image = props.employee.employee_image
const form = useForm({
    employee_image: props.employee.employee_image,
    full_name: props.employee.full_name,
    role: props.employee.role,
});

const newImage = async () => {
    activeElement.value = "video"
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
        return;
    }

}

/**
 * Shuts down the camera API immediately the user leaves this page
 */
 onUnmounted(() => {
    if (stream.value) {
        stream.value.getTracks().forEach((track) => track.stop());
    }
});

const captureImage = () => {
    navigator.permissions.query({ name: "camera" }).then((result) => { // Ensures camera permission is granted before capture
        if (result.state === "granted") {
            activeElement.value = "canvas";

            const context = canvas.value.getContext("2d");
            context.drawImage(video.value, 50, 30, 200, 100)

            const imageData = canvas.value.toDataURL("image/png");
            form.employee_image = imageData
            

        } else {
            toast.error("Grant Camera Permission")
            return;
        }

    })
};


const submit = () => {

    if (!form.employee_image) {
        // If no new image is captured, reuse the existing one
        form.employee_image = route("employees.image", { filename: image.split('/').pop() });
    }

    form.put(route("employees.update", props.employee.employee_uid), {
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
            if (stream.value) {
                stream.value.getTracks().forEach((track) => track.stop());
            }
            toast.success("Update Successful");
            // Update the image URL in the frontend
            image = form.employee_image;
        },

        onError: (errors) => {
            console.log(errors);
        },
    });
};
</script>

<template>

    <Head :title="'Edit - ' + props.employee.full_name" />
    <SideBar />
    <div class="p-4 sm:ml-64">
        <div class="flex flex-col items-center min-h-screen pt-12 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden px-6 py-2 sm:max-w-md sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div>
                        <img v-show="activeElement === 'img'"
                            :src="route('employees.image', { filename: image.split('/').pop() })"
                            class="bg-gray-100 py-5 h-1/2 w-full flex items-center justify-center rounded-md outline-none border-none hover:bg-slate-200">
                        </img>
                        <video ref="video" autoplay v-show="activeElement === 'video'"
                            class="bg-gray-100 py-5 h-1/2 w-full flex items-center justify-center rounded-md outline-none border-none hover:bg-slate-200"></video>
                        <canvas ref="canvas" v-show="activeElement === 'canvas'"
                            class="bg-gray-100 rounded-md w-full outline-none border-none hover:bg-slate-200"></canvas>
                    </div>

                    <div class="mt-2">
                        <InputLabel for="name" value="Full Name" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="John Steve Roberts"
                            v-model="form.full_name" required />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="role" value="Role" />

                        <TextInput id="role" type="text" class="mt-1 block w-full" v-model="form.role"
                            placeholder="Senior Software Engineer" required />

                    </div>

                    <div class="mt-4 flex justify-between space-x-5">
                        <button @click="newImage" class="py-3 mt-1 bg-gray-300 text-blue-500 block w-1/2 rounded-md"
                            type="button">New Image</button>
                        <button @click="captureImage" class="py-3 mt-1 bg-blue-500 text-white block w-1/2 rounded-md"
                            type="button">Capture</button>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="py-3 mt-1 bg-black text-blue-500 block w-full rounded-md">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
