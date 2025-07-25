<script setup>
import { ChevronLeft, CouponIcon, InfoIcon, TooltipsIcon, XIcon } from '@/Components/Icons/solid';
import { Link } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import ProgressBar from 'primevue/progressbar';
import Modal from "@/Components/Modal.vue";
import {transactionFormat} from "@/Composables/index"

const ranking = ref([]);
const detailsModal = ref(false);
const nextYear = new Date().getFullYear() + 1;
const { formatAmount } = transactionFormat();

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
    user: Object,
    rank: Object,
    nextRank: Object,
    nextSpending: Number,
    allRank: Array,
})

const progress = computed(() => {
  if (!props.user || !props.nextRank) return 0;
  return Math.min((props.user.total_spending / props.nextRank.min_amount) * 100, 100);
});

const openDetailModal = () => {
  detailsModal.value = true;
};

const closeModal = () => {
  detailsModal.value = false;
};

</script>

<template>
    <Head title="Dashboard" />

    <div class="flex justify-center w-full">
        <div class="max-w-md w-full flex flex-col min-h-screen bg-white">
            <!-- header -->
            <div class="flex flex-col pt-4 bg-primary-900">
                <div class="px-4">
                    <Link :href="route('dashboard')">
                        <ChevronLeft class="text-white"/>
                    </Link>
                </div>
                <div class="flex flex-col gap-4 py-4 px-4">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col">
                            <div class="text-primary-100 text-xs ">Current Tier</div>
                            <div class="flex items-center gap-2">
                                <span class="text-white text-[40px] font-bold">{{ rank.name }}</span>
                                <div @click="openDetailModal">
                                    <TooltipsIcon />
                                </div>
                            </div>
                        </div>
                        <div class="text-[40px] text-primary-900">
                            <img :src="props.rank.image" alt="" class="max-w-9 max-h-9">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div>
                            <ProgressBar :value="progress" ></ProgressBar>
                        </div>
                        <div class="text-primary-100 text-xs">
                            Spend <span class="font-semibold">RM {{ nextSpending }}</span> more to unlock {{ nextRank.name }} next year.
                        </div>
                    </div>
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

    <Modal :show="detailsModal" max-width="sm" @close="closeModal">
        <div class="flex flex-col gap-9 p-6 w-full " >
            <div class="w-full flex items-center justify-between">
                <div>Tier</div>
                <div @click="closeModal"><XIcon /> </div>
            </div>
            <div class="flex flex-col gap-4">
                <div class="w-[285px] p-4 bg-[#ffffffcc] border border-blue-50 flex items-center gap-3">
                    <div>
                        <InfoIcon />
                    </div>
                    <div class="text-blue-500 font-medium text-sm text-left">Your next tier will be <span class="font-bold">{{ nextRank.name }}</span> on 01/01/{{ nextYear }}.</div>
                </div>
                <div class="bg-gray-50 w-full py-5 flex flex-col gap-2">
                    <div class="uppercase text-gray-300 font-bold text-xs">current spend</div>
                    <div class="text-gray-950 font-bold text-2xl">RM {{ user.total_spending }}</div>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-3 p-2 bg-gray-100">
                        <div class="max-w-32 w-full text-gray-950 text-xss font-semibold text-left">Tier Name</div>
                        <div class="max-w-32 w-full text-gray-950 text-xss font-semibold text-left">Min. Spend</div>
                    </div>
                    <div v-for="rank in allRank" class="flex flex-col">
                        <div class="flex items-center gap-3 p-2 ">
                            <div class="max-w-32 w-full text-gray-950 text-xss font-semibold text-left">{{rank.name}}</div>
                            <div class="max-w-32 w-full text-gray-950 text-xss font-semibold text-left">RM {{ formatAmount(rank.min_amount) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
    
</template>