<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ArrowIcon, ArrowRedIcon, EditIcon, LogoutIcon } from "@/Components/Icons/brands";
import QrcodeVue from 'qrcode.vue'
import { ref } from "vue";

const props = defineProps({
    uuid: String,
})

const foreground = ref('#7e171b')

</script>

<template>
    <Head title="Promotion" />
    
    
    <div class="flex justify-center w-full">
        <div class="max-w-md w-full p-4 flex flex-col min-h-screen">
            <!-- header -->
            <div class="w-full flex justify-between gap-4">
                <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-1">
                    <div class="text-xl text-white font-black">Welcome back 👋</div>
                    <div class="text-xs font-semibold text-primary-200">
                    {{ $page.props.auth.user.full_name }}
                    </div>
                </div>
                <div>
                    <Link :href="route('dashboard')" class="flex gap-4 py-4">
                        <LogoutIcon /> <span class="text-white">Back</span>
                    </Link>
                </div>
                </div>
                <div></div>
            </div>

            <!-- content -->
            <div
                class="w-full bg-white border border-primary-200 rounded-[5px] p-3 flex flex-col gap-3"
            >
                <div class="w-full border border-primary-100 rounded-[5px] min-h-[75vh] flex flex-col justify-center items-center" >
                    <div class="flex flex-col gap-12 items-center max-w-64">
                        <div class="text-gray-900 text-base font-medium text-center">
                            Display this QR code to start cheering 🍻 
                        </div>
                        <div>
                            <qrcode-vue :value="props.uuid" :size="250" level="H" render-as="svg" :foreground="foreground" />
                        </div>
                    
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>