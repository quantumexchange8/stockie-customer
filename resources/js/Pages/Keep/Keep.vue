<script setup>
import { ChevronLeft, HistoryIcon } from '@/Components/Icons/solid';
import { transactionFormat } from '@/Composables';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    keeps: Array,
    countKeep: Object,
})

const { formatDateTime } = transactionFormat();

</script>

<template>

    <div class="flex justify-center w-full">
        <div class="max-w-md w-full flex flex-col min-h-screen bg-white">
            <!-- header -->
            <div class="flex flex-col pt-4 bg-primary-25">
                <div class="px-4">
                    <Link :href="route('dashboard')">
                        <ChevronLeft class="text-primary-900"/>
                    </Link>
                </div>
                <div class="flex flex-col gap-3 items-center bg-keepbg bg-no-repeat bg-contain bg py-7">
                    <div class="text-gray-900 text-sm font-medium">Current Keep Item</div>
                    <div class="text-[40px] text-primary-900">
                        {{ countKeep }}
                    </div>
                    <div class="text-primary-950 text-base font-medium"></div>
                </div>
            </div>

            <div
                class="w-full rounded-[5px] flex flex-col gap-3 min-h-[80vh] p-4"
            >
                <div class="flex justify-between items-center">
                    <div class="text-primary-900 text-xl font-semibold">My Keep Item</div>
                    <div>
                        <Link :href="route('keepHistory')">
                            <div class="text-sm text-primary-900 font-medium flex items-center gap-2"><HistoryIcon /> View History</div>
                        </Link>
                    </div>
                </div>

                <div class="flex flex-col ">
                    <div v-for="(keep, index) in keeps" :key="index">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10">
                                    <img :src="keep.image" alt="">
                                </div>
                                <div class="flex flex-col">
                                    <div class="text-gray-900 text-xs font-medium">{{ keep.order_item_subitem.product_item.product.product_name }}</div>
                                    <div class="text-gray-400 text-xss font-medium">{{ formatDateTime(keep.created_at) }}</div>
                                </div>
                            </div>
                            <div class="text-primary-900 text-base font-semibold" v-if="keep.qty > 0">
                                x {{ keep.qty }}
                            </div>
                            <div class="text-primary-900 text-base font-semibold" v-if="keep.cm > 0">
                                {{ keep.cm }} cm
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>