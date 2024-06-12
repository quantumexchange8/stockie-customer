<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import Label from "@/Components/Label.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Input from "@/Components/Input.vue";
import InputPhone from "@/Components/InputPhone.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { StockieIcon } from "@/Components/Icons/brands";
import { onMounted } from "vue";

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

onMounted(() => {
  if (!form.value.phone.startsWith("+60")) {
    form.value.phone = "+60";
  }
});
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
          <div>
            <Label for="email" value="Email" />

            <Input
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autocomplete="username"
              placeholder="Enter your email here"
            />

            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mt-4">
            <Label for="phone" value="Phone No." />

            <InputPhone
              id="phone"
              type="text"
              class="mt-1 block w-full"
              v-model="form.phone"
              required
              autofocus
              autocomplete="phone"
            />

            <InputError class="mt-2" :message="form.errors.phone" />
          </div>

          <div class="mt-4">
            <Label for="full_name" value="Full Name" />

            <Input
              id="full_name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.full_name"
              required
              autofocus
              autocomplete="full_name"
              placeholder="Enter your full name here"
            />

            <InputError class="mt-2" :message="form.errors.full_name" />
          </div>

          <div class="mt-4">
            <Label for="password" value="Password" />

            <Input
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="new-password"
              placeholder="Enter your password here"
            />

            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="mt-4">
            <Label for="password_confirmation" value="Confirm Password" />

            <Input
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
              placeholder="Enter your password here"
            />

            <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </div>

          <div class="flex items-center justify-end mt-4">
            <Link
              :href="route('login')"
              class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Already registered?
            </Link>

            <PrimaryButton
              class="ms-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Register
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>
