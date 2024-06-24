<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import Label from "@/Components/Label.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Input from "@/Components/Input.vue";
import InputPhone from "@/Components/InputPhone.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { EyeIcon, EyeOffIcon, StockieIcon } from "@/Components/Icons/brands";
import { onMounted, ref } from "vue";
import Button from "@/Components/Button.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";

const showPassword = ref(false);
const showPassword2 = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const togglePasswordVisibilityConfirm = () => {
    showPassword2.value = !showPassword2.value;
}

const form = useForm({
  full_name: "",
  email: "",
  phone: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};

</script>

<template>
  <GuestLayout>
    <div class="w-full flex flex-col items-center gap-9">
      <div class="w-full flex flex-col gap-[10px] items-start px-6 pt-10">
        <div
          class="bg-white w-[62px] h-[62px] p-3 rounded-xl shadow-[0.484px_0.727px_0.969px_0.727px_rgba(0,0,0,0.3)]"
        >
          <StockieIcon class="drop-shadow-[1.653px_1.24px_2.191px_rgba(0,0,0,0.30)]" />
        </div>
        <div class="w-[201px] flex flex-col gap-1 items-start">
          <div class="text-xl text-primary-900 font-black leading-tight">stockie</div>
          <div class="text-xs text-gray-900 font-medium leading-tight">
            Your Inventory, Perfectly Managed
          </div>
        </div>
      </div>

      <div class="w-full sm:max-w-md px-6 py-4 bg-white overflow-hidden sm:rounded-lg">
        <Head title="Register" />

        <form @submit.prevent="submit">
          <div class="flex flex-col gap-11" >
            <div class="flex flex-col items-center gap-6">
              <div class="space-y-1 w-full" >
                <Label for="email" value="Email" />

                <Input
                  id="email"
                  type="email"
                  class="w-full"
                  v-model="form.email"
                  required
                  autocomplete="username"
                  placeholder="Enter your email here"
                />

                <InputError class="mt-2" :message="form.errors.email" />
              </div>

              <div class="space-y-1 w-full">
                <Label for="phone" value="Phone No." />

                <InputIconWrapper> 

                  <template #icon>
                    <span class="text-gray-700" >+60</span>
                  </template>

                  <Input
                    id="phone"
                    type="text"
                    class="w-full"
                    v-model="form.phone"
                    withIcon
                    required
                    autofocus
                    autocomplete="phone"
                  />
                </InputIconWrapper>

                <InputError class="mt-2" :message="form.errors.phone" />
              </div>

              <div class="space-y-1 w-full">
                <Label for="full_name" value="Full Name" />

                <Input
                  id="full_name"
                  type="text"
                  class="w-full"
                  v-model="form.full_name"
                  required
                  autofocus
                  autocomplete="full_name"
                  placeholder="Enter your full name here"
                />

                <InputError class="mt-2" :message="form.errors.full_name" />
              </div>

              <div class="space-y-1 w-full">
                <Label for="password" value="Password" />
                <div class="relative">
                  <Input
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    class="w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Enter your password here"
                  />
                  <div
                      class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                      @click="togglePasswordVisibility"
                  >
                    <template v-if="showPassword">
                        <EyeIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    </template>
                    <template v-else>
                        <EyeOffIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    </template>
                  </div>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
              </div>

              <div class="space-y-1 w-full">
                <Label for="password_confirmation" value="Confirm Password" />
                <div class="relative">
                  <Input
                    id="password_confirmation"
                    :type="showPassword2 ? 'text' : 'password'"
                    class="w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Enter your password here"
                  />
                  <div
                      class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                      @click="togglePasswordVisibilityConfirm"
                  >
                    <template v-if="showPassword2">
                        <EyeIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    </template>
                    <template v-else>
                        <EyeOffIcon aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    </template>
                  </div>
                
                </div>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
              </div>
            </div>
            <div class="w-full">
                <Button
                  variant="primary"
                  size="lg"
                  class=" w-full flex justify-center items-center"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Register
                </Button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>
