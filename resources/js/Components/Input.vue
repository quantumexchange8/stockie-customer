<script setup>
import { onMounted, ref } from "vue";

defineProps({
  modelValue: String,
  withIcon: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

const focus = () => input.value?.focus();

defineExpose({
  input,
  focus,
});

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});
</script>

<template>
  <input
    :class="[
      'py-3 border-gray-300 rounded-[5px] bg-white',
      'focus:border-primary-300 focus:ring-0',
      'hover:border-primary-100',
      'text-base text-gray-700 placeholder:text-gray-200 placeholder:text-base',
      {
        'px-4': !withIcon,
        'pl-11 pr-4': withIcon,
      },
    ]"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input"
  />
</template>
