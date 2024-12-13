
<script setup>
import { ref, watch } from 'vue';
import InputOtp from 'primevue/inputotp';

const props = defineProps({
    modelValue: String,
});

const emits = defineEmits(['update:modelValue']);

const value = ref(props.modelValue || '');

watch(value, (newValue) => {
    emits('update:modelValue', newValue);
});
</script>

<template>
    <div class="card flex justify-content-center">
        <InputOtp 
            v-model="value" 
            integerOnly 
            :pt="{
                root: {
                    class: 'w-full flex justify-center gap-6',
                },
                input: {
                    root: {
                        class: 'p-3 max-w-12 h-[74px] text-primary-900 text-[40px] bg-primary-25 rounded-[5px] border-none focus:ring-0 select-none'
                    }
                }
            }"
        />
    </div>
</template>