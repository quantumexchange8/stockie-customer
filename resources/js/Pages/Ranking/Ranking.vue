<script setup>
import { ChevronLeft, CouponIcon } from '@/Components/Icons/solid';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';


const ranking = ref([]);

const fetchReward = async () => {
  try {
    const response = await fetch('/getReward');
    ranking.value = await response.json();
  } catch (error) {
    console.error('Error fetching ranking:', error);
  }
};

onMounted(() => {
    fetchReward();
});

const props = defineProps({
    rank: Object,
})

</script>

<template>
    <Head title="Dashboard" />

    <div class="flex justify-center w-full">
        <div class="max-w-md w-full flex flex-col min-h-screen bg-white">
            <!-- header -->
            <div class="flex flex-col pt-4">
                <div class="px-4">
                    <Link :href="route('dashboard')">
                        <ChevronLeft class="text-primary-900"/>
                    </Link>
                </div>
                <div class="flex flex-col gap-3 items-center bg-pointbg py-4">
                    <div class="text-gray-900 text-sm font-medium">Current Tier</div>
                    <div class="text-[40px] text-primary-900">
                        <img :src="props.rank.image" alt="">
                    </div>
                    <div class="text-primary-950 text-base font-medium">{{ props.rank.name }}</div>
                </div>
            </div>

            <!-- content -->
            <div
                class="w-full rounded-[5px] flex flex-col gap-3 min-h-[80vh] p-4"
            >
                <div class="text-primary-900 text-xl font-semibold">My Rewards</div>

                <div v-if="ranking.length > 0" class="flex flex-col gap-3">
                    <div v-for="reward in ranking" >
                        <div class="flex items-center gap-3 p-3 bg-primary-25">
                            <div><CouponIcon /></div>
                            <div class="flex flex-col w-full">
                                <div>Entry Reward for {{ props.rank.name }}</div>
                                <div v-if="reward.ranking_reward.reward_type === 'Discount (Amount)'">RM {{ reward.ranking_reward.discount }}</div>
                                <div v-if="reward.ranking_reward.reward_type === 'Discount (Percentage)'"> {{ reward.ranking_reward.discount }} %</div>
                                <div v-if="reward.ranking_reward.reward_type === 'Free Item'"> Free Item</div>
                                <div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else >
                    No Reward yet
                </div>
            </div>
        </div>
    </div>
</template>