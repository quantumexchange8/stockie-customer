<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { VerifyoptPic } from "@/Components/Icons/logout"
import InputOtp from '@/Components/InputOtp.vue';
import { ref } from 'vue';
import Button from '@/Components/Button.vue';
import { Head, Link, useForm, usePage, } from '@inertiajs/vue3';

const value = ref(null);
const props = defineProps({
    verificationCode: Number,
    uid: Number
})

const form = useForm({
    otp: '',
    id: props.uid
})

const submit = () => {
    form.post(route('validOtp'));
}

</script>

<template>
    <GuestLayout>
        <div class="w-full">
            <div class="flex w-full" >
                <VerifyoptPic />
            </div>

            <form @submit.prevent="submit">
                <div class="flex flex-col gap-16 px-8" >
                    <div class="flex flex-col gap-2">
                        <div class=" text-primary-900 text-xl font-bold leading-tight">
                            Check Your Mailbox  ✉️
                        </div>
                        <div class=" text-gray-900 text-sm font-medium leading-tight">
                            To verify your email, kindly enter the 4 digit verification code we’ve sent to your email address.
                        </div>
                    </div>
                    
                    <div >
                        <InputOtp v-model="form.otp" />
                        
                    </div>
                    <div class="flex flex-col gap-5">
                        <Button
                            variant="primary"
                            size="lg"
                            class="flex justify-center"
                            type="submit"
                            :disabled="form.processing"
                        >
                            Verify
                        </Button>
                        <div class="flex flex-col gap-[6px] items-center">
                            <div class="text-gray-700 text-xs font-medium">
                                Didn’t receive the verification code?
                            </div>
                            <div class="text-primary-900 text-xs font-semibold underline cursor-pointer">
                                Click to resend
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    
    </GuestLayout>

</template>