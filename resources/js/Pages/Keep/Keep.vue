<script setup>
import { ChevronLeft, HistoryIcon } from '@/Components/Icons/solid';
import { transactionFormat } from '@/Composables';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    keeps: Array,
    countKeep: Number,
})

const { formatDateTime, formatDate } = transactionFormat();

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

                <div class="flex flex-col gap-3 max-h-[70vh] overflow-y-auto">
                    <div v-for="(keep, index) in keeps" :key="index">
                        <div class="bg-white border border-gray-100 rounded-[5px] flex flex-col">
                            <div v-if="keep.expired_status === 'upcoming'" class="bg-[#FDFBED] flex flex-col gap-1 p-3">
                                <div class="text-[#A35F1A] text-sm font-bold">Expiring soon</div>
                                <div class="text-[#3E200A] text-xs">This kept item will be expired on 23/02/2025.</div>
                            </div>
                            <div class="flex flex-col gap-3 p-4  bg-white">
                                <div class="flex justify-between">
                                    <div class="flex flex-col">
                                        <div class="text-primary-800 text-xl font-bold" v-if="keep.qty > 0">
                                            x {{ keep.qty }}
                                        </div>
                                        <div class="text-primary-800 text-xl font-bold" v-if="keep.cm > 0">
                                            {{ keep.cm }} cm
                                        </div>
                                        <div class="text-gray-900 text-xs font-medium">{{ keep.order_item_subitem.product_item.inventory_item.item_name }}</div>
                                    </div>
                                    <div class="w-10 h-10">
                                        <img :src="keep.order_item_subitem.product_item.product.product_image_url ? keep.order_item_subitem.product_item.product.product_image_url : '' " alt="product image" class="w-10 h-10 object-contain" >
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 text-gray-500 text-xs ">Kept from</div>
                                        <div class="text-xs text-gray-950">{{ keep.kept_from_table ? keep.kept_from_table : '-' }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 text-gray-500 text-xs ">Expired on</div>
                                        <div class="text-xs text-gray-950">{{ formatDate(keep.expired_to) }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 text-gray-500 text-xs ">Kept by</div>
                                        <div class="text-xs text-gray-950">{{ keep.waiter.name }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 text-gray-500 text-xs ">Remark</div>
                                        <div class="text-xs text-gray-950">{{ keep.remark ? keep.remark : '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>