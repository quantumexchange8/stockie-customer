<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ChevronLeft } from '@/Components/Icons/solid';
import { computed, onMounted, ref } from 'vue'
import {transactionFormat} from "@/Composables/index"
import Modal from '@/Components/Modal.vue';
import { StockieSmallIcon } from '@/Components/Icons/brands';

const orderHistory = ref([]);
const merchantDetails = ref();
const showModal = ref(false);
const selectedOrder = ref(null);

const fetchOrderHistory = async () => {
  try {
    const response = await fetch('/getOrderHistory');
    orderHistory.value = await response.json();
  } catch (error) {
    console.error('Error fetching promotions:', error);
  }
};

const fetchMerchant = async () => {
  try {
    const response = await fetch('/getMerchant');
    merchantDetails.value = await response.json();
  } catch (error) {
    console.error('Error fetching promotions:', error);
  }
};

const { formatDateTime, formatAmount } = transactionFormat();

onMounted(() => {
    fetchOrderHistory ();
    fetchMerchant();
});

const view = (order) => {
    selectedOrder.value = order;
    showModal.value = true;
}

console.log(selectedOrder.value)

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
                        <div class="text-xs text-primary-900 underline font-semibold underline-offset-4" @click="view(order)">
                            View pdf
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Modal :show="showModal" max-width="md" @close="showModal = false">
        <div class="flex flex-col gap-9 min-h-screen" >
            <div class="flex flex-col gap-9 p-1">
                <!-- top -->
                <div class='flex gap-1 min-h-[238px] w-full bg-primary-900 p-6 relative'>
                    <div class="flex flex-col gap-1 items-start w-2/3">
                        <div class="text-primary-100 text-xl font-medium">{{ merchantDetails.merchant_name }}</div>
                        <div class="text-left text-primary-25 text-sm font-medium leading-tight">{{ merchantDetails.merchant_address_line1 }}</div>
                        <div class="text-left text-primary-25 text-sm font-medium leading-tight">{{ merchantDetails.merchant_contact }}</div>
                    </div>
                    <div class="w-1/3 flex justify-end" >
                        <div class=" w-16 h-16 ">
                            <img :src="merchantDetails.merchant_settings ? merchantDetails.merchant_settings : '-'" class="rounded-full" />
                        </div>
                        
                    </div>

                    <div class="w-full px-6 flex justify-center absolute -bottom-12 left-0 right-0">
                        <div class="w-full py-6 px-4 flex flex-col items-center bg-primary-25 rounded-md" >
                            <div class="text-primary-800 text-base font-medium" >TOTAL SPENT</div>
                            <div class="text-primary-900 text-xl font-semibold">RM <span class="text-primary-900 text-3xl font-bold">{{ selectedOrder.total_amount }}</span></div>
                        </div>
                    </div>
                </div>
                <!-- content -->
                <div class="flex flex-col gap-8 pt-10 px-6">
                    <div class="flex flex-col gap-4">
                        <div class="text-left text-primary-950 text-sm" >{{ selectedOrder.payment ? formatDateTime(selectedOrder.payment.receipt_end_date) : '-' }}</div> <!-- need transaction date-->
                        <div class="flex gap-6 py-4">
                            <div class="flex flex-col justify-between border-r-2 border-primary-100 w-full">
                                <div class="text-primary-950 text-left font-light text-xs">Receipt No.</div>
                                <div class="text-primary-950 text-left text-sm font-medium">{{ selectedOrder.order_no }}</div>
                            </div>
                            <div class="flex flex-col justify-between border-r-2 border-primary-100 w-full">
                                <div class="text-primary-950 text-left font-light text-xs">Pax</div>
                                <div class="text-primary-950 text-left text-sm font-medium">{{ selectedOrder.pax }}</div>
                            </div>
                            <div class="flex flex-col justify-between w-full">
                                <div class="text-primary-950 text-left font-light text-xs">Table No.</div>
                                <div class="text-primary-950 text-left text-sm font-medium">
                                    <div v-if="selectedOrder.order_table.length > 0" class="flex flex-wrap gap-1" >
                                        <div v-for="(table_no, index) in selectedOrder.order_table" :key="table_no.table.id" class="flex">
                                            {{ table_no.table ? table_no.table.table_no : '-' }}
                                            <div v-if="index !== selectedOrder.order_table.length - 1">, </div>
                                        </div>
                                    </div>
                                    <div v-else>-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-6">
                        <div class="bg-primary-50 p-1 flex items-center w-full">
                            <div class="w-1/6 text-primary-900 text-sm text-left">Qty</div>
                            <div class="w-3/6 text-primary-900 text-sm text-left">Item</div>
                            <div class="w-2/6 text-primary-900 text-sm text-right">Amt (RM)</div>
                        </div>
                        <div v-if="selectedOrder.order_items.length > 0 " class="w-full flex flex-col gap-4">
                            <div v-for="(products, index) in selectedOrder.order_items" :key="products.product.id" class="flex flex-col">
                                <div class="flex">
                                    <div class="w-1/6 text-primary-950 font-light text-sm text-left" >{{index + 1}}</div>
                                    <div class="w-3/6 text-primary-950 font-light text-sm text-left" >{{ products.product.product_name}}</div>
                                    <div class="w-2/6 text-primary-950 font-light text-sm text-right" >{{ formatAmount(products.amount_before_discount)}}</div>
                                </div>
                                <div>
                                    {{}}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between">
                                <div class="text-primary-950 text-sm font-light" >Subtotal</div>
                                <div class="text-primary-950 text-sm ">{{ selectedOrder.amount }}</div>
                            </div>
                            <div class="flex justify-between">
                                <div class="text-primary-950 text-sm font-light" >Voucher Discount</div>
                                <div class="text-primary-950 text-sm ">{{ selectedOrder.payment.discount_id ? selectedOrder.payment.discount_amount : '0.00' }}</div>
                            </div>
                            <div class="flex justify-between">
                                <div class="text-primary-950 text-sm font-light" >Service Charge</div>
                                <div class="text-primary-950 text-sm ">{{ selectedOrder.payment.service_tax_amount}}</div>
                            </div>
                            <div class="flex justify-between">
                                <div class="text-primary-950 text-sm font-light" >SST</div>
                                <div class="text-primary-950 text-sm ">{{ selectedOrder.payment.sst_amount}}</div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <div class="w-full border-t-2 border-dashed border-[#FFE1E2] "></div>
                            <div class="w-full border-t-2 border-dashed border-[#FFE1E2] "></div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between" >
                                <div class="text-primary-950 text-sm font-light" >Points Earned</div>
                                <div class="text-primary-950 text-sm " >{{ selectedOrder.payment.point_earned }} pts</div>
                            </div>
                            <div class="flex justify-between" >
                                <div class="text-primary-950 text-sm font-light" >Points Balance</div>
                                <div class="text-primary-950 text-sm " >{{ selectedOrder.customer.point }} pts</div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <div class="w-full border-t-2 border-dashed border-[#FFE1E2] "></div>
                            <div class="w-full border-t-2 border-dashed border-[#FFE1E2] "></div>
                        </div>

                       
                        <div v-if="selectedOrder.payment.discount_id " class="w-full flex flex-col gap-4">
                            <div class="bg-primary-50 p-1 flex items-center w-full">
                                <div class="w-4/6 text-primary-900 text-sm text-left">Discount Summary</div>
                                <div class="w-2/6 text-primary-900 text-sm text-right">Amt (RM)</div>
                            </div>
                            <div v-for="(products, index) in selectedOrder.order_items" :key="products.product.id" class="flex flex-col">
                                <div class="flex">
                                    <div class="w-4/6 text-primary-950 font-light text-sm text-left" >{{ products.product.product_name}}</div>
                                    <div class="w-2/6 text-primary-950 font-light text-sm text-right" >{{ selectedOrder.payment.discount_id ? formatAmount(selectedOrder.payment.discount_amount) : '0.00' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- QR CODE -->
                        <div></div>

                        <div class="py-6 bg-primary-900 rounded-md flex flex-col gap-2">
                            <div class="text-primary-50 text-xl font-light">Thank you for your visit!</div>
                            <div class="text-white text-xs font-light flex items-center justify-center gap-2">Order invoice generated by 
                                <div class="flex items-center font-bold gap-2"> 
                                    <div class="bg-white">
                                        <StockieSmallIcon />
                                    </div>
                                    <span>stockie</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

</template>