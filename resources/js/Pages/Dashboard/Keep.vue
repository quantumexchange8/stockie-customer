<script setup>
import { ArrowRedIcon } from '@/Components/Icons/brands';
import { onMounted, ref } from 'vue';


const countListing = ref();

const fetchTotalKeep = async () => {
  try {

    const response = await axios.get('/getTotalKeep');
    countListing.value = response.data;

  } catch (error) {
    console.error('Error fetching promotions:', error);
  }
};

onMounted(() => {
    fetchTotalKeep ();
});

</script>

<template>

    <div class="flex items-center justify-between gap-[10px]">
        <div class="text-base font-semibold text-primary-900">Keep</div>
        <div><ArrowRedIcon /></div>
    </div>

    <div class="text-primary-900 text-5xl font-semibold">
    <!-- Temp hard code -->
        {{  countListing ? countListing : 0 }}
    </div>
    
</template>