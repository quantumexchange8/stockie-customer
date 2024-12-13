<script setup>
import { NoPromotion, NoPromotion2 } from '@/Components/Icons/nodata';
import { onMounted, ref } from 'vue';
import Galleria from 'primevue/galleria';

const promotions = ref([]);

const fetchPromotions = async () => {
  try {
    const response = await fetch('/promotion/getPromotionImage');
    promotions.value = await response.json();
  } catch (error) {
    console.error('Error fetching promotions:', error);
  }
};

// const props = defineProps({
//     promotions: Array,
// })

onMounted(() => {
    fetchPromotions();
});

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
        <Galleria
            :value="promotions"
            :responsiveOptions="responsiveOptions"
            :numVisible="5"
            containerStyle="max-width: 640px"
            :showThumbnails="false"
            :circular="true"
            :autoPlay="true"
            :transitionInterval="5000"
        >
            <template #item="slotProps">
                <img
                :src="slotProps.item.image"
                :alt="slotProps.item.name || 'Promotion Image'"
                style="width: 100%; max-height: 160px; display: block"
                />
            </template>
        </Galleria>
    </div>

</template>