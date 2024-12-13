<script setup>
import { Head, Link, } from '@inertiajs/vue3';
import { ChevronLeft } from '@/Components/Icons/solid';

const props = defineProps({
    promotion: Object,
})

</script>

<template>
    <Head title="Promotion" />
    <div class="flex justify-center w-full" >
        <div class="max-w-md w-full flex flex-col min-h-screen">
            <div class="p-3 flex justify-between items-center">
                <Link :href="route('promotion.promotion')">
                    <ChevronLeft />
                </Link>
                
                <div class="text-white text-base font-semibold leading-tight flex items-center" >Promotion</div>
                <div class="w-6 h-6"></div>
            </div>
            <div class="bg-white w-full h-full flex flex-col">
                <img :src="promotion.image" alt="">

                <div class="p-3 flex flex-col gap-6">
                    <div class="text-gray-900 text-2xl font-semibold">
                        {{ promotion.title }}
                    </div>
                    <div class=" overflow-y-auto" >
                        {{ promotion.description }}
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    
    </div>
</template>