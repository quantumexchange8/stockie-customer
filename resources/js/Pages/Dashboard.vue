<script setup>
import { ArrowIcon, ArrowRedIcon, EditIcon, LogoutIcon } from "@/Components/Icons/brands";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Dashboard" />

  <!-- <AuthenticatedLayout> -->
  <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboards</h2>
    </template> -->

  <div class="flex justify-center w-full">
    <div class="max-w-md w-full pt-[52px] px-4 flex flex-col min-h-screen">
      <!-- header -->
      <div class="w-full flex justify-between gap-4">
        <div class="flex flex-col gap-5">
          <div class="flex flex-col gap-1">
            <div class="text-xl text-white font-black">Welcome back 👋</div>
            <div class="text-xs font-semibold text-primary-200">
              {{ $page.props.auth.user.full_name }}
            </div>
          </div>
          <div>
            <LogoutIcon />
          </div>
        </div>
        <div></div>
      </div>

      <!-- content -->
      <div
        class="w-full bg-white border border-primary-200 rounded-[5px] p-3 flex flex-col gap-3"
      >
        <div class="w-full border border-primary-100 rounded-[5px]"></div>
        <div class="w-full flex items-center gap-3">
          <div
            class="py-3 px-4 bg-primary-900 flex flex-col gap-[10px] border border-primary-100 rounded-[5px] w-full h-[130px]"
          >
            <div class="w-full flex items-center justify-between">
              <div class="text-primary-25 text-base font-semibold">Points</div>
              <div>
                <ArrowIcon class="text-[#FFF9F9]" />
              </div>
            </div>
            <div class="flex flex-col">
              <div class="text-[28px] leading-tight font-semibold text-white">
                {{ $page.props.auth.user.point }}
              </div>
              <div class="text-base text-white">pts</div>
            </div>
          </div>
          <div
            class="py-3 px-4 bg-white flex flex-col gap-[10px] border border-primary-100 rounded-[5px] w-full h-[130px]"
          >
            <div class="w-full flex items-center justify-between">
              <div class="text-primary-900 text-base font-semibold">Tier</div>
              <div>
                <ArrowRedIcon />
              </div>
            </div>

            <div class="flex flex-col gap-1">
              <div></div>
              <div class="text-xl font-semibold text-primary-900">VVIP</div>
            </div>
          </div>
        </div>
        <div class="w-full flex items-center gap-3">
          <div
            class="py-3 px-4 bg-white flex flex-col gap-[10px] border border-primary-100 rounded-[5px] w-full"
          >
            <div class="flex items-center justify-between">
              <div class="text-base font-semibold text-primary-900">Account</div>
              <div>
                <EditIcon />
              </div>
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
        </div>
        <div class="w-full flex items-center gap-3">
          <div
            class="py-3 px-4 bg-white flex flex-col gap-[10px] border border-primary-100 rounded-[5px] h-[163px]"
          >
            <div class="text-primary-900 text-base font-semibold">My QR</div>
            <div class="text-gray-900 text-xss font-medium leading-tight">
              Tap to show your code
            </div>
          </div>
          <div
            class="py-3 px-4 bg-primary-900 flex flex-col gap-[10px] border border-primary-100 rounded-[5px] w-full h-[163px]"
          >
            <div class="flex justify-between items-center">
              <div class="text-primary-25 text-base font-semibold">Last Visit</div>
              <div>
                <ArrowIcon class="text-[#FFF9F9]" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- </AuthenticatedLayout> -->
</template>
