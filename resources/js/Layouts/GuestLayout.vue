<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { LoginTopBg } from "@/Components/LoginIcon/Login";
import { StockieIcon } from "@/Components/Icons/brands";
</script>

<template>
  <div class="flex items-center justify-center">
    <div
      class="min-h-screen max-w-[450px] w-full flex flex-col items-center gap-32 bg-white"
    >
      <slot />
    </div>
  </div>
</template>
