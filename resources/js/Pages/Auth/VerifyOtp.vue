<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { VerifyoptPic } from "@/Components/Icons/logout"
import InputOtp from 'primevue/inputotp';
import { ref } from 'vue';

const value = ref(null);

</script>

<template>
    <GuestLayout>
        <div class="w-full">
            <div class="flex w-full" >
                <VerifyoptPic />
            </div>

            <div class="flex flex-col gap-16 px-8" >
                <div class="flex flex-col gap-2">
                    <div class=" text-primary-900 text-xl font-bold leading-tight">
                        Check Your Mailbox  ✉️
                    </div>
                    <div class=" text-gray-900 text-sm font-medium leading-tight">
                        To verify your email, kindly enter the 4 digit verification code we’ve sent to your email address.
                    </div>
                </div>
                <div class="flex justify-center" >
                    <!-- <InputOtp v-model="value" integerOnly /> -->
                </div>
                <div></div>
            </div>
        </div>
    
    </GuestLayout>

</template>