<script setup>
import { PointReward  } from "@/Components/Icons/solid";
import { ArrowIcon } from "@/Components/Icons/brands";

</script>

<template>

    <PointReward class=" absolute bottom-0 right-0"/>
    <div class="flex flex-col gap-[10px]" >
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
</template>