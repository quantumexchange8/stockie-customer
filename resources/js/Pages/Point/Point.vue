<script setup>
import { ChevronLeft, HistoryIcon, InfoIcon } from '@/Components/Icons/solid';
import { Head, Link } from '@inertiajs/vue3';
import {transactionFormat} from "@/Composables/index"
import { onMounted, ref } from 'vue';

const props = defineProps({
    point: String,
})

const redeemItem = ref([]);
const expiringPoint = ref([]);
const totalPoint = ref([]);

const fetchRedeemItem = async () => {
  try {
    const response = await fetch('/point/getRedemItem');
    redeemItem.value = await response.json();
  } catch (error) {
    console.error('Error fetching item:', error);
  }
};

const fetchExpiringPoint = async () => {
  try {
    const response = await fetch('/point/getExpiringPoint');
    const result = await response.json();

    expiringPoint.value = result.expiringPoints;
    totalPoint.value = result.total_point;

  } catch (error) {
    console.error('Error fetching item:', error);
  }
};

const { formatAmountWithoutDecimals, formatDate2 } = transactionFormat();

onMounted(() => {
    fetchRedeemItem();
    fetchExpiringPoint();
});



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
                <div class="flex flex-col items-center bg-pointbg py-4">
                    <div class="text-gray-900 text-sm font-medium">Current Points</div>
                    <div class="text-[40px] text-primary-900">
                        {{ formatAmountWithoutDecimals(props.point) }}
                    </div>
                    <div class="text-primary-950 text-base font-medium">pts</div>
                </div>
            </div>

            <!-- content -->
            <div
                class="w-full rounded-[5px] flex flex-col gap-3 min-h-[80vh] p-4"
            >
                <div v-if="expiringPoint.length > 0 " class="p-3 bg-[#FDFBED] rounded-[5px] flex flex-col gap-1">
                    <div class="text-[#A35F1A] text-sm font-bold">{{ totalPoint }} points expiring soon:</div>
                    <div class="text-[#3E200A] text-xs ">
                        <div v-for="(item, index) in expiringPoint" :key="index">
                            <span class="font-bold">{{ item.expire_balance }} pts</span> on <span class="">{{ formatDate2(item.expired_at) }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <Link :href="route('point.view-history')">
                        <div class="flex justify-between items-center">
                            <div class="text-primary-900 text-xl font-semibold">Redeemable Item</div>
                            <div class="text-sm text-primary-900 font-medium flex items-center gap-2"><HistoryIcon /> View History</div>
                        </div>
                    </Link>
                </div>
                <div class="p-4 border rounded-md border-blue-50 flex items-center gap-3">
                    <div><InfoIcon /></div>
                    <div class="text-blue-500 text-sm font-medium leading-tight">Please seek help from the counter or waiter to redeem the item.</div>
                </div>

                <div class="flex flex-col ">
                    <div v-for="(item, index) in redeemItem" :key="index">
                        <div class="flex items-center gap-3 py-3 border-b border-gray-100">
                            <div class="w-10 h-10">
                                <img :src="item.image" alt="">
                            </div>
                            <div class="flex flex-col">
                                <div class="text-gray-900 text-xs font-medium">{{ item.product_name }}</div>
                                <div class="text-primary-900 text-base font-semibold">{{ item.point }} pts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>