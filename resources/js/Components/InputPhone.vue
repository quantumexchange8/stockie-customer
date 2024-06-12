<script setup>
import { onMounted, ref, watch } from "vue";

// Define props and emits
defineProps({
  modelValue: String,
  withIcon: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

// Function to focus the input element
const focus = () => input.value?.focus();

defineExpose({
  input,
  focus,
});

// Set the initial value to include the dial code +60 if not already set
onMounted(() => {
  if (!input.value.value.startsWith("+60")) {
    input.value.value = "+60";
  }
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

// Watch the input value and ensure it always starts with +60
watch(input, (newVal) => {
  if (!newVal.value.startsWith("+60")) {
    newVal.value = "+60";
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
    :value="modelValue.startsWith('+60') ? modelValue : `+60${modelValue}`"
    @input="
      (e) => {
        let value = e.target.value;
        if (!value.startsWith('+60')) {
          value = '+60' + value.replace(/^\+?60/, '');
        }
        $emit('update:modelValue', value);
      }
    "
    ref="input"
  />
</template>
