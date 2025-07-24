<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import forgotpw from '@/Components/Img/forgot-password.png';
import Button from '@/Components/Button.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="flex flex-col gap-10 justify-center items-center w-full min-h-screen">
            <div class="w-full">
                <img :src="forgotpw" />
            </div>
            <div class="flex flex-col gap-2 px-5">
                <div class="text-primary-900 text-xl font-bold">Enter your email</div>
                <div class="text-gray-900 text-sm font-medium" >Fret-no! We’ll sent you a recovery email to reset your password for your STOXPOS account.</div>
            </div>

            <form @submit.prevent="submit" class="w-full px-5 flex flex-col gap-7">
                <div class="w-full ">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="flex items-center w-full">
                   <Button class="w-full flex justify-center" variant="primary" size="lg" :disable='form.processing' >
                        Send
                   </Button>
                </div>
            </form>
        </div>
        
    </GuestLayout>
</template>
