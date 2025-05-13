<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Label from "@/Components/Label.vue";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import { LoginTopBg } from "@/Components/LoginIcon/Login";
import { StockieIcon, EyeIcon, EyeOffIcon } from "@/Components/Icons/brands";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import { ref } from "vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const showPassword = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const form = useForm({
  name: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <div class="w-full flex flex-col items-center gap-32">
      <div class="relative">
        <LoginTopBg class="w-full" />

        <div class="absolute -bottom-20 left-1/2 transform -translate-x-1/2">
          <div class="flex flex-col gap-[10px] items-center">
            <div
              class="bg-white w-[62px] h-[62px] p-3 rounded-xl shadow-[0.484px_0.727px_0.969px_0.727px_rgba(0,0,0,0.3)]"
            >
              <StockieIcon
                class="drop-shadow-[1.653px_1.24px_2.191px_rgba(0,0,0,0.30)]"
              />
            </div>
            <div class="w-[201px] flex flex-col gap-1 items-center">
              <div class="text-xl text-primary-900 font-black leading-tight">stockie</div>
              <div class="text-xs text-gray-900 font-medium leading-tight">
                Your Inventory, Perfectly Managed
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-lg"
      >
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
          {{ status }}
        </div>

        <form @submit.prevent="submit">
          <div class="flex flex-col gap-11">
            <div class="flex flex-col gap-[55px]">
              <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-6">
                  <div>
                    <Label for="name" value="Username" />

                    <!-- <InputIconWrapper>

                      <template #icon>
                        <span class="text-gray-700" >+60</span>
                      </template>

                      <Input
                        id="phone"
                        type="number"
                        :class="form.errors.phone ? 'border border-primary-500 dark:border-error-500 mt-1 block w-full' : 'mt-1 block w-full'"
                        v-model="form.phone"
                        withIcon
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your phone here"
                      />

                    </InputIconWrapper> -->

                    <Input 
                      id="name"
                      type="text"
                      :class="form.errors.name ? 'border border-primary-500 dark:border-error-500 mt-1 block w-full' : 'mt-1 block w-full'"
                      v-model="form.name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                  </div>

                  <div>
                    <InputLabel for="password" value="Password" />

                    <div class="relative">
                      <Input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        :class="form.errors.password ? 'border border-primary-500 dark:border-error-500 mt-1 block w-full' : 'mt-1 block w-full'"
                        v-model="form.password"
                        autocomplete="current-password"
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
                </div>

                <div class="flex justify-between">
                  <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-xs text-gray-900 font-medium"
                      >Remember me</span
                    >
                  </label>

                  <!-- <Link
                    :href="route('password.request')"
                    class="text-xs text-primary-900 font-medium"
                  >
                    Forgot password?
                  </Link> -->
                </div>
              </div>

              <Button
                class="w-full flex justify-center"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Log in
              </Button>
            </div>

            <div class="flex flex-col gap-1 items-center">
              <div class="text-xs leading-tight font-medium text-gray-900">
                Don't have an account yet?
              </div>
              <div
                class="text-xs font-medium leading-tight underline underline-offset-4 text-primary-900"
              >
                <Link :href="route('register')"> Create an account </Link>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>
