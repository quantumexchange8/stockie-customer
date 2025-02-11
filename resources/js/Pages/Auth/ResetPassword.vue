<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { EyeIcon, EyeOffIcon } from "@/Components/Icons/brands";
import { ref } from "vue";
import Button from '@/Components/Button.vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const showPassword = ref(false);
const showPassword2 = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const togglePasswordVisibilityConfirm = () => {
    showPassword2.value = !showPassword2.value;
}

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <div class="flex flex-col gap-10 justify-center items-center min-h-screen">
            <div class="flex flex-col gap-2 px-5">
                <div class="text-primary-900 text-xl font-bold">Reset Password</div>
                <div class="text-gray-900 text-sm font-medium" >Please set the new password for your Stockie account.</div>
            </div>

            <form @submit.prevent="submit" class="w-full px-5 flex flex-col gap-4">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        disabled
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="">
                    <InputLabel for="password" value="Password" />
                    <div class="relative">
                        <TextInput
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            placeholder="Enter your new password here"
                        />
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                            @click="togglePasswordVisibility"
                        >
                            <template v-if="showPassword">
                                <EyeIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </template>
                            <template v-else>
                                <EyeOffIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </template>
                        </div>
                    </div>

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <div class="relative">
                        <TextInput
                            id="password_confirmation"
                            :type="showPassword2 ? 'text' : 'password'"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Enter your new password here"
                        />
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                            @click="togglePasswordVisibilityConfirm"
                        >
                            <template v-if="showPassword2">
                                <EyeIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </template>
                            <template v-else>
                                <EyeOffIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </template>
                        </div>
                    </div>

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <!-- <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Reset Password
                    </PrimaryButton> -->
                    <Button class="w-full flex justify-center" variant="primary" size="lg" :disable='form.processing' >
                        Reset Password
                   </Button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
