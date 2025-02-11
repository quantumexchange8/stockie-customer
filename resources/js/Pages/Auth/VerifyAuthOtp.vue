<script setup>
import { Head, Link, useForm, usePage, } from '@inertiajs/vue3';
import { CheckIcon, ChevronLeft } from '@/Components/Icons/solid';
import OtpMail from '@/Components/Img/otpMail.png';
import InputOtp from '@/Components/InputOtp.vue';
import Button from '@/Components/Button.vue';

const form = useForm({
    otp: ''
})

const submit = () => {
    form.post(route('validStoreOtp'));
}

</script>

<template>

    <Head title="Verify otp" />

    <div class="flex justify-center w-full" >
        <div class="max-w-md w-full flex flex-col min-h-screen bg-white">
            <div class="p-3 flex justify-between items-center">
                <Link :href="route('dashboard')">
                    <ChevronLeft class="text-primary-900" />
                </Link>
                
                <div class="text-primary-900 text-base font-semibold leading-tight flex items-center" >Verify Email</div>
                <div class="w-6 h-6"></div>
            </div>
            <div class="bg-white w-full pt-10 py-9 h-full flex flex-col gap-5 ">
                <div>
                    <img :src="OtpMail" />
                </div>
                <form >
                    <div class="flex flex-col items-center gap-8 w-full px-8 ">
                        <div class="flex flex-col gap-1 w-full">
                            <div class="text-primary-900 text-xl font-bold" >Check Your Mailbox  ✉️</div>
                            <div class="text-gray-900 text-sm font-medium" >To verify your new email, kindly enter the 4 digit verification code we’ve sent to your email address.</div>
                        </div>
                        <div>
                            <InputOtp v-model="form.otp" />
                        </div>
                        <div class="flex flex-col gap-5 w-full" >
                            <div class=" w-full ">
                                <Button variant="primary" size="lg" type="button" @click="submit" class="w-full flex justify-center" >Verify</Button>
                            </div>
                            <div class="flex flex-col items-center gap-2">
                                <div class="text-gray-700 text-xs font-medium" >Didn’t receive the verification code?</div>
                                <Link :href="route('verify-otp')">
                                    <div class="text-primary-900 text-semibold text-xs underline underline-offset-2"  >Click to resend</div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>