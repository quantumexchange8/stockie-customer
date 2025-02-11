<script setup>
import { ChevronLeft } from '@/Components/Icons/solid';
import { Link } from '@inertiajs/vue3';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { computed, onMounted, ref } from 'vue';
import { transactionFormat } from '@/Composables';

const keepHistory = ref([]);
const selectedTab = ref('All');

const fetchKeepHistory = async () => {
  try {
    const response = await fetch('/getKeepHistory');
    keepHistory.value = await response.json();
  } catch (error) {
    console.error('Error fetching history:', error);
  }
};

const filteredKeepHistory = computed(() => {
  if (selectedTab.value === 'All') {
    return keepHistory.value;
  }
  return keepHistory.value.filter((keepLog) => keepLog.status === selectedTab.value);
});

onMounted(() => {
    fetchKeepHistory();
});

const { formatDateTime } = transactionFormat();

</script>

<template>
    <div class="flex justify-center w-full">
        <div class="max-w-md w-full flex flex-col min-h-screen bg-white">
            <div class="flex items-center justify-between p-4 bg-primary-900">
                <div>
                    <Link :href="route('dashboard')">
                        <ChevronLeft class="text-white"/>
                    </Link>
                </div>
                <div class="text-white text-base font-semibold">
                    Keep History
                </div>
                <div class="w-6"></div>
            </div>

            <div class="w-full px-4 py-3">
                <TabGroup>
                    <TabList class="flex">
                        <Tab
                            as="template"
                            v-slot="{ selected }"
                        >
                            <button
                                @click="selectedTab = 'All'"
                                :class="[
                                'w-full py-3 text-sm font-medium',
                                ' focus:outline-none ',
                                selected
                                    ? 'border-b border-primary-900 text-primary-900'
                                    : 'text-gray-200 hover:bg-white/[0.12] hover:text-white',
                                ]"
                            >
                                All
                            </button>
                        </Tab>
                        <Tab
                            as="template"
                            v-slot="{ selected }"
                        >
                            <button
                                @click="selectedTab = 'Keep'"
                                :class="[
                                'w-full py-3 text-sm font-medium',
                                ' focus:outline-none ',
                                selected
                                    ? 'border-b border-primary-900 text-primary-900'
                                    : 'text-gray-200 hover:bg-white/[0.12] hover:text-white',
                                ]"
                            >
                                Keep
                            </button>
                        </Tab>
                        <Tab
                            as="template"
                            v-slot="{ selected }"
                        >
                            <button
                                @click="selectedTab = 'Served'"
                                :class="[
                                'w-full py-3 text-sm font-medium',
                                ' focus:outline-none ',
                                selected
                                    ? 'border-b border-primary-900 text-primary-900'
                                    : 'text-gray-200 hover:bg-white/[0.12] hover:text-white',
                                ]"
                            >
                                Served
                            </button>
                        </Tab>
                        <Tab
                            as="template"
                            v-slot="{ selected }"
                        >
                            <button
                                @click="selectedTab = 'Expired'"
                                :class="[
                                'w-full py-3 text-sm font-medium',
                                ' focus:outline-none ',
                                selected
                                    ? 'border-b border-primary-900 text-primary-900'
                                    : 'text-gray-200 hover:bg-white/[0.12] hover:text-white',
                                ]"
                            >
                                Expired
                            </button>
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel
                            :class="[
                                'rounded-xl bg-white p-3',
                                'ring-white/60 ring-offset-0 focus:outline-none focus:ring-2',
                            ]"
                        >
                            <div class="p-1">
                                <div v-for="keepLog in filteredKeepHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex flex-col gap-2 w-full">
                                            <div class="flex">
                                                <div v-if="keepLog.status === 'Keep'" class="max-w-[45px] text-xss text-primary-900 font-semibold py-1.5 px-2.5 bg-primary-50 border border-primary-50 rounded-md">Keep</div>
                                                <div v-if="keepLog.status === 'Served' || keepLog.status === 'Returned' " class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Served</div>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-3 items-center">
                                                    <div class="w-10 h-10">
                                                        <img :src="keepLog.order_item_subitem.product_item.product.product_image_url ? keepLog.order_item_subitem.product_item.product.product_image_url : '' " alt="product image" class="w-10 h-10 object-contain" >
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <div class="text-gray-900 text-xs font-medium">{{ keepLog.order_item_subitem.product_item.product.product_name }}</div>
                                                        <div class="text-gray-400 text-xss font-medium">{{ formatDateTime(keepLog.created_at) }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.qty > 0">
                                                    x {{ keepLog.qty }}
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.cm > 0">
                                                    {{ keepLog.cm }} cm
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.status !== 'Keep'">
                                                    <div v-for="returnItem in keepLog.keep_histories">
                                                        <div v-if="returnItem.qty > 0">
                                                            x {{ returnItem.qty }}
                                                        </div>
                                                        <div v-if="returnItem.cm > 0">
                                                            {{ returnItem.cm }} cm
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel
                            :class="[
                                'rounded-xl bg-white p-3',
                                'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                            ]"
                        >
                            <div class="p-1">
                                <div v-for="keepLog in filteredKeepHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex flex-col gap-2 w-full">
                                            <div class="flex">
                                                <div v-if="keepLog.status === 'Keep'" class="max-w-[45px] text-xss text-primary-900 font-semibold py-1.5 px-2.5 bg-primary-50 border border-primary-50 rounded-md">Keep</div>
                                                <div v-if="keepLog.status === 'Served'" class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Served</div>
                                                <div v-if="keepLog.status === 'Returned'" class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Returned</div>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-3 items-center">
                                                    <div>
                                                        <img :src="keepLog.order_item_subitem.product_item.product.product_image_url ? keepLog.order_item_subitem.product_item.product.product_image_url : '' " alt="product image" class="w-10 h-10 object-contain" >
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <div class="text-gray-900 text-xs font-medium">{{ keepLog.order_item_subitem.product_item.product.product_name }}</div>
                                                        <div class="text-gray-400 text-xss font-medium">{{ formatDateTime(keepLog.created_at) }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.qty > 0">
                                                    x {{ keepLog.qty }}
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.cm > 0">
                                                    {{ keepLog.cm }} cm
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel
                            :class="[
                                'rounded-xl bg-white p-3',
                                'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                            ]"
                        >
                            <div class="p-1">
                                <div v-for="keepLog in filteredKeepHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex flex-col gap-2 w-full">
                                            <div class="flex">
                                                <div v-if="keepLog.status === 'Keep'" class="max-w-[45px] text-xss text-primary-900 font-semibold py-1.5 px-2.5 bg-primary-50 border border-primary-50 rounded-md">Keep</div>
                                                <div v-if="keepLog.status === 'Served'" class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Served</div>
                                                <div v-if="keepLog.status === 'Returned'" class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Returned</div>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-3 items-center">
                                                    <div></div>
                                                    <div class="flex flex-col">
                                                        <div class="text-gray-900 text-xs font-medium">{{ keepLog.order_item_subitem.product_item.product.product_name }}</div>
                                                        <div class="text-gray-400 text-xss font-medium">{{ formatDateTime(keepLog.created_at) }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.qty > 0">
                                                    x {{ keepLog.qty }}
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.cm > 0">
                                                    {{ keepLog.cm }} cm
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel
                            :class="[
                                'rounded-xl bg-white p-3',
                                'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                            ]"
                        >
                            <div class="p-1">
                                <div v-for="keepLog in filteredKeepHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex flex-col gap-2 w-full">
                                            <div class="flex">
                                                <div v-if="keepLog.status === 'Keep'" class="max-w-[45px] text-xss text-primary-900 font-semibold py-1.5 px-2.5 bg-primary-50 border border-primary-50 rounded-md">Keep</div>
                                                <div v-if="keepLog.status === 'Served'" class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Served</div>
                                                <div v-if="keepLog.status === 'Returned'" class="max-w-[55px] text-xss text-green-700 font-semibold py-1.5 px-2.5 bg-green-50 border border-green-50 rounded-md">Returned</div>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-3 items-center">
                                                    <div></div>
                                                    <div class="flex flex-col">
                                                        <div class="text-gray-900 text-xs font-medium">{{ keepLog.order_item_subitem.product_item.product.product_name }}</div>
                                                        <div class="text-gray-400 text-xss font-medium">{{ formatDateTime(keepLog.created_at) }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.qty > 0">
                                                    x {{ keepLog.qty }}
                                                </div>
                                                <div class="text-primary-900 text-base font-semibold" v-if="keepLog.cm > 0">
                                                    {{ keepLog.cm }} cm
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </div>

</template>