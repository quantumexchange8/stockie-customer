<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ChevronLeft } from '@/Components/Icons/solid';
import { computed, onMounted, ref } from 'vue'
import {transactionFormat} from "@/Composables/index"
import Modal from '@/Components/Modal.vue';

const orderHistory = ref([]);

const fetchOrderHistory = async () => {
  try {
    const response = await fetch('/getOrderHistory');
    orderHistory.value = await response.json();
  } catch (error) {
    console.error('Error fetching promotions:', error);
  }
};

const { formatDateTime } = transactionFormat();

onMounted(() => {
    fetchOrderHistory ();
});
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
                    Order History
                </div>
                <div class="w-6"></div>
            </div>

            <div class="p-4">
                <div v-for="order in orderHistory" class="flex flex-col">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div class="flex flex-col ">
                            <div class="text-sm text-gray-900 font-medium">Order #{{ order.order_no }}</div>
                            <div class="text-xs text-primary-900 font-medium">Total spent: RM {{ order.total_amount }}</div>
                            <div class="text-xss text-gray-400 font-medium">{{ formatDateTime(order.updated_at) }}</div>
                        </div>
                        <div class="text-xs text-primary-900 underline font-semibold underline-offset-4">
                            View pdf
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Modal>
        
    </Modal>

</template>