<script setup>
import { NoPromotion, NoPromotion2 } from '@/Components/Icons/nodata';


const props = defineProps({
    promotions: Array,
})

console.log(props.promotions)
</script>

<template>
    <div v-if="promotions.length === 0" class="flex justify-center items-center p-2" >
        <div class="flex flex-col gap-1 w-[133px]" >
            <div class="text-primary-900 text-base font-semibold leading-tight">
                No promotion to show yet.
            </div>
            <div class="text-gray-900 text-xs font-medium leading-tight">
                Stay tuned for more exciting deals tailored just for you!
            </div>
        </div>

        <NoPromotion2/>
    </div>
    <div v-else class="flex justify-center items-center p-2">
        <!-- {{ promotions }} -->
        <img src="https://www.its.ac.id/tmesin/wp-content/uploads/sites/22/2022/07/no-image.png" alt="">
    </div>

</template>