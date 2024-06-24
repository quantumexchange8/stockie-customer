<script setup>
import Button from '@/Components/Button.vue';
import { ArrowRedIcon } from '@/Components/Icons/brands';
import { NoPromotion } from '@/Components/Icons/nodata';
import { ChevronLeft } from '@/Components/Icons/solid';
import { Head, Link, } from '@inertiajs/vue3';


const props = defineProps({
    promotions: Array,
})


</script>

<template>
    <Head title="Promotion" />

    <div class="flex justify-center w-full" >
        <div class="max-w-md w-full flex flex-col min-h-screen">
            <div class="p-3 flex justify-between items-center">
                <Link :href="route('dashboard')">
                    <ChevronLeft />
                </Link>
                
                <div class="text-white text-base font-semibold leading-tight flex items-center" >Promotion</div>
                <div class="w-6 h-6"></div>
            </div>
            <div class="bg-white w-full px-[17px] pt-[18px] pb-5 h-full">
                <div v-if="promotions.length === 0" class="p-6 h-full flex flex-col justify-center ">
                    <div class="flex flex-col justify-center items-center gap-10" >
                        <NoPromotion/>
                        <div class="text-gray-700 text-base font-semibold leading-tight">
                            No promotion to show yet.
                        </div>
                    </div>
                </div>
                
                <div v-else class="flex flex-col gap-4" >
                    <div v-for="promotion in promotions" >
                        <div class="flex flex-col gap-3 p-3" >
                            <div>
                                <img src='https://www.its.ac.id/tmesin/wp-content/uploads/sites/22/2022/07/no-image.png' alt="" class=" rounded-lg" >
                            </div>
                            <div class="flex justify-between">
                                <div>{{ promotion.title }}</div>
                                <Button
                                    pill
                                    type="button"
                                    variant="transparent"
                                    class="p-1 focus:ring-0"
                                    size="lgNp"
                                    :href="'/promotion/promotionDetails/' + promotion.id"
                                >
                                    <ArrowRedIcon />
                                </Button>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    
    </div>

</template>