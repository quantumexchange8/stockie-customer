<script setup>
import { ArrowIcon, ArrowRedIcon, EditIcon, LogoutIcon } from "@/Components/Icons/brands";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import { onMounted, onUnmounted, ref } from "vue";
import { LogoutPic } from "@/Components/Icons/logout";
import Button from "@/Components/Button.vue";
import Promotion from "@/Pages/Dashboard/Promotion.vue"
import Points from "@/Pages/Dashboard/Points.vue"
import { LastVisit, QRPhone, TierRank } from "@/Components/Icons/solid";
import { transactionFormat } from "@/Composables";

const logoutModal = ref(false);

const props = defineProps({
  promotions: Array,
  rank: Array,
  profileImage: Object,
  lastOrder: String,
})

const openLogoutModal = () => {
  logoutModal.value = true;
};

const closeModal = () => {
  logoutModal.value = false;
};

const currentDate = ref('');
const currentTime = ref('');

const updateDateTime = () => {
  const now = new Date();
  const optionsDate = { year: 'numeric', month: '2-digit', day: '2-digit' };
  const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };

  currentDate.value = now.toLocaleDateString('en-GB', optionsDate);
  currentTime.value = now.toLocaleTimeString('en-GB', optionsTime);
};

onMounted(() => {
  updateDateTime();
  const interval = setInterval(updateDateTime, 1000);

  onUnmounted(() => {
    clearInterval(interval);
  });
});


const { formatDate, formatTime  } = transactionFormat();

</script>

<template>
  <Head title="Dashboard" />

  <div class="flex justify-center w-full">
    <div class="max-w-md w-full p-4 flex flex-col min-h-screen">
      <!-- header -->
      <div class="w-full flex justify-between gap-4">
        <div class="flex flex-col gap-5">
          <div class="flex flex-col gap-1">
            <div class="text-xl text-white font-black">Welcome back 👋</div>
            <div class="text-xs font-semibold text-primary-200">
              {{ $page.props.auth.user.full_name }}
            </div>
          </div>
          <div class="py-4">
            <LogoutIcon @click="openLogoutModal" />
          </div>
        </div>
        <div>
          <img :src="props.profileImage.profile" alt="">
        </div>
      </div>

      <!-- content -->
      <div
        class="w-full bg-white border border-primary-200 rounded-[5px] p-3 flex flex-col gap-3"
      >
        <div class="w-full border border-primary-100 rounded-[5px]" >
          <Link :href="route('promotion.promotion')">
            <Promotion :promotions="promotions"/>
          </Link>
          
        </div>
        <div class="w-full flex items-center gap-3">
          <div class="py-3 px-4 bg-primary-900 border border-primary-100 rounded-[5px] w-full h-[130px] relative">
            <Points />
          </div>
          <div class="py-3 px-4 bg-white border border-primary-100 rounded-[5px] w-full h-[130px] relative">
            <Link :href="route('ranking')">
              <TierRank class="absolute bottom-0 right-0" />
              <div class="flex flex-col gap-[10px]" > 
                <div class="w-full flex items-center justify-between">
                  <div class="text-primary-900 text-base font-semibold">Tier</div>
                  <div>
                    <ArrowRedIcon />
                  </div>
                </div>
                <div class="flex flex-col gap-1">
                  <div>
                  <img :src="rank.image" alt="">
                  </div>
                  <div class="text-xl font-semibold text-primary-900">{{rank.name}}</div>
                </div>
              </div>
            </Link>
            
          </div>
        </div>
        <div class="w-full flex items-center gap-3">
          <div class="py-3 px-4 bg-primary-100 flex flex-col gap-[10px] border border-primary-100 rounded-[5px] w-full">
            <div class="flex items-center justify-between">
              <div class="text-base font-semibold text-primary-900">Account</div>
              <Button 
                variant="transparent"
                pill
                class="p-0 focus:ring-0"
                size="lgNp"
                :href="'/profile'"
              > 
                <EditIcon />
              </Button>
            </div>

            <div class="flex flex-col items-start gap-1">
              <div class="text-xs font-semibold text-gray-900">
                {{ $page.props.auth.user.full_name }}
              </div>
              <div class="text-xs font-semibold text-gray-900">
                {{ $page.props.auth.user.email }}
              </div>
              <div class="text-xs font-semibold text-gray-900">
                {{ $page.props.auth.user.phone }}
              </div>
            </div>
          </div>
          <div>
            <Link :href="route('keep_listing')">
              <div
                class="py-3 px-4 bg-white flex flex-col gap-[10px] border border-primary-100 rounded-[5px] w-[100px] h-full"
              >
                <div class="flex items-center justify-between gap-[10px]">
                  <div class="text-base font-semibold text-primary-900">Keep</div>
                  <div><ArrowRedIcon /></div>
                </div>
                <div class="text-primary-900 text-5xl font-semibold">
                  <!-- Temp hard code -->
                  12
                </div>
              </div>
            </Link>
          </div>
        </div>
        <div class="w-full flex items-center gap-3">
          <div>
            <Link :href="route('qr')">
              <div class="py-3 px-4 bg-white border border-primary-100 rounded-[5px] h-[163px] relative" >
                <QRPhone class=" absolute bottom-0 right-0" />
                <div class="flex flex-col gap-[10px]">
                  <div class="text-primary-900 text-base font-semibold">My QR</div>
                  <div class="text-gray-900 text-xss font-medium leading-tight">
                    Tap to show your code
                  </div>
                </div>
              </div>
            </Link>
          </div>
          <div class="w-full"> 
            <Link :href="route('order_listing')">
              <div class="py-3 px-4 bg-primary-900 border border-primary-100 rounded-[5px] w-full h-[163px] relative flex flex-col ">
                <LastVisit class=" absolute bottom-0 right-0" />
                <div class="flex flex-col gap-[10px] h-full " >
                  <div class="flex justify-between items-center">
                    <div class="text-primary-25 text-base font-semibold">Last Visit</div>
                    <div>
                      <ArrowIcon class="text-[#FFF9F9]" />
                    </div>
                  </div>
                  <div class="flex flex-col justify-end items-start h-full" >
                    <div class="flex flex-col gap-1" >
                      <div class=" text-primary-200 text-xs font-medium" >
                        {{ formatDate(lastOrder.created_at) }}
                      </div>
                      <div class=" text-primary-200 text-xs font-medium" >
                        {{ formatTime(lastOrder.created_at) }}
                      </div>
                      <div class=" text-3xl text-white font-semibold leading-tight" >
                        RM {{ lastOrder.total_amount }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>

  <Modal :show="logoutModal" max-width="sm" @close="closeModal">
    <div class="flex flex-col gap-9 pt-6" >
      <LogoutPic />
      <div class="flex flex-col gap-9 px-6 pb-6 w-[283px]">
        <div class="flex flex-col items-center">
          <div class="text-primary-900 text-xl font-medium">You're leaving...</div>
          <div class="text-gray-900 text-sm font-medium leading-tight">Are you sure you want to log out this account?</div>
        </div>
        <div class="flex flex-col gap-3" >
            <Link :href="route('logout')" method="post" as="button">
              <Button variant="primary" size="lg" class="w-full">
                <span class="text-center text-white text-base font-medium w-full" >Yes, log me out</span>
              </Button>
            </Link>
            
            <Button variant="tertiary" size="lg" type="button" @click="closeModal">
              <span class="text-center text-primary-900 text-base font-medium w-full" >Cancel</span>
            </Button>
        </div>
      </div>
    </div>
  </Modal>

</template>
