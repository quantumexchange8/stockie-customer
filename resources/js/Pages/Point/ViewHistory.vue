<script setup>
import { ChevronLeft } from '@/Components/Icons/solid';
import { Head, Link } from '@inertiajs/vue3';
import {transactionFormat} from "@/Composables/index"
import { computed, onMounted, ref } from 'vue'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

const pointHistory = ref([]);
const selectedTab = ref('All');

const fetchPointHistory = async () => {
  try {
    const response = await fetch('/point/getPointHistory');
    pointHistory.value = await response.json();
  } catch (error) {
    console.error('Error fetching promotions:', error);
  }
};


const filteredPointHistory = computed(() => {
  if (selectedTab.value === 'All') {
    return pointHistory.value;
  }
  return pointHistory.value.filter((pointLog) => pointLog.type === selectedTab.value);
});

onMounted(() => {
    fetchPointHistory ();
});

const { formatAmountWithoutDecimals, formatDateTime } = transactionFormat();

</script>

<template>
    <Head title="Dashboard" />

    <div class="flex justify-center w-full">
        <div class="max-w-md w-full flex flex-col min-h-screen bg-white">
            <div class="flex flex-col py-4 bg-primary-900">
                <div class="px-4">
                    <Link :href="route('dashboard')">
                        <div class="flex justify-between items-center">
                            <div><ChevronLeft class="text-white"/></div>
                            <div class="text-white text-base font-semibold">Point History</div>
                            <div></div>
                        </div>
                    </Link>
                </div>
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
                                @click="selectedTab = 'Earned'"
                                :class="[
                                'w-full py-3 text-sm font-medium',
                                ' focus:outline-none ',
                                selected
                                    ? 'border-b border-primary-900 text-primary-900'
                                    : 'text-gray-200 hover:bg-white/[0.12] hover:text-white',
                                ]"
                            >
                                Earned
                            </button>
                        </Tab>
                        <Tab
                            as="template"
                            v-slot="{ selected }"
                        >
                            <button
                                @click="selectedTab = 'Used'"
                                :class="[
                                'w-full py-3 text-sm font-medium',
                                ' focus:outline-none ',
                                selected
                                    ? 'border-b border-primary-900 text-primary-900'
                                    : 'text-gray-200 hover:bg-white/[0.12] hover:text-white',
                                ]"
                            >
                                Used
                            </button>
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel
                            :class="[
                                'rounded-xl bg-white p-3',
                                'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                            ]"
                        >
                            <div class="p-1">
                                <div v-for="pointLog in filteredPointHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div>
                                            <div>
                                                <!-- <div v-if="pointLog.type === 'Earned'">
                                                
                                                </div>
                                                <div v-if="pointLog.type === 'Used'"></div> -->
                                            </div>
                                            <div class="flex flex-col ">
                                                <div v-if="pointLog.type === 'Earned'" class="text-gray-900 font-medium">
                                                    Order #{{ pointLog.payment.order.order_no }}
                                                </div>
                                                <div v-if="pointLog.type === 'Used'" class="text-gray-900 font-medium">
                                                    {{ pointLog.qty }} x {{ pointLog.product.product_name }}
                                                </div>
                                                <div class="text-gray-400 text-xss">{{ formatDateTime(pointLog.created_at) }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span v-if="pointLog.type === 'Earned'" class="text-green-700 font-semibold">+ {{ pointLog.amount }} pts</span>
                                            <span v-if="pointLog.type === 'Used'" class="text-primary-700 font-semibold">- {{ pointLog.amount }} pts</span>
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
                                <div v-for="pointLog in filteredPointHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div>
                                            <div>
                                                <!-- <div v-if="pointLog.type === 'Earned'">
                                                
                                                </div>
                                                <div v-if="pointLog.type === 'Used'"></div> -->
                                            </div>
                                            <div class="flex flex-col ">
                                                <div v-if="pointLog.type === 'Earned'" class="text-gray-900 font-medium">
                                                    Order #{{ pointLog.payment.order.order_no }}
                                                </div>
                                                <div v-if="pointLog.type === 'Used'" class="text-gray-900 font-medium">
                                                    {{ pointLog.qty }} x {{ pointLog.product.product_name }}
                                                </div>
                                                <div class="text-gray-400 text-xss">{{ formatDateTime(pointLog.created_at) }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span v-if="pointLog.type === 'Earned'" class="text-green-700 font-semibold">+ {{ pointLog.amount }} pts</span>
                                            <span v-if="pointLog.type === 'Used'" class="text-primary-700 font-semibold">- {{ pointLog.amount }} pts</span>
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
                                <div v-for="pointLog in filteredPointHistory" class="flex flex-col">
                                    <div class="flex items-center justify-between py-2">
                                        <div>
                                            <div>
                                                <!-- <div v-if="pointLog.type === 'Earned'">
                                                
                                                </div>
                                                <div v-if="pointLog.type === 'Used'"></div> -->
                                            </div>
                                            <div class="flex flex-col ">
                                                <div v-if="pointLog.type === 'Earned'" class="text-gray-900 font-medium">
                                                    Order #{{ pointLog.payment.order.order_no }}
                                                </div>
                                                <div v-if="pointLog.type === 'Used'" class="text-gray-900 font-medium">
                                                    {{ pointLog.qty }} x {{ pointLog.product.product_name }}
                                                </div>
                                                <div class="text-gray-400 text-xss">{{ formatDateTime(pointLog.created_at) }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span v-if="pointLog.type === 'Earned'" class="text-green-700 font-semibold">+ {{ pointLog.amount }} pts</span>
                                            <span v-if="pointLog.type === 'Used'" class="text-primary-700 font-semibold">- {{ pointLog.amount }} pts</span>
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