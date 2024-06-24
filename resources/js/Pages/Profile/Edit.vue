<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link, useForm, usePage, } from '@inertiajs/vue3';
import { ChevronLeft } from '@/Components/Icons/solid';
import Label from '@/Components/Label.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';
import { ref } from 'vue';

const edit = ref(false);
const user = usePage().props.auth.user

const editDetails = () => {
    edit.value = true;
}

const cancelEdit = () => {
    edit.value = false;
}

const form = useForm({
    full_name: user.full_name,
    phone: user.phone,
    email: user.email,
    password: ''
})

</script>

<template>
    <Head title="Profile" />

    <div class="flex justify-center w-full" >
        <div class="max-w-md w-full flex flex-col min-h-screen">
            <div class="p-3 flex justify-between items-center">
                <Link :href="route('dashboard')">
                    <ChevronLeft />
                </Link>
                
                <div class="text-white text-base font-semibold leading-tight flex items-center" >Account Details</div>
                <div class="w-6 h-6"></div>
            </div>
            <div class="bg-white w-full px-8 pt-[18px] py-9 h-full flex flex-col items-center">
                <div>
                    
                </div>

                <div v-if="edit === false" class=" w-full flex flex-col gap-16 " >
                    <div class="flex flex-col gap-6" >
                        <div>
                            <Label value="Full Name" />

                            <div class="border-b border-b-gray-300 py-3 text-gray-700 text-base leading-tight" >
                                {{ $page.props.auth.user.full_name }}
                            </div>
                        </div>
                        <div>
                            <Label value="Phone No." />
                            
                            <div class="border-b border-b-gray-300 py-3 text-gray-700 text-base leading-tight" >
                                {{ $page.props.auth.user.phone }}
                            </div>
                        </div>
                        <div>
                            <Label value="Email" />
                            
                            <div class="border-b border-b-gray-300 py-3 text-gray-700 text-base leading-tight" >
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                        <div>
                            <Label value="Password" />
                            
                            <div class="border-b border-b-gray-300 py-3 text-gray-700 text-xl leading-none" >
                                ******
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center" >
                        <Button
                            variant="primary"
                            size="lg"
                            type="button"
                            @click="editDetails"
                        >
                            Edit
                        </Button>
                    </div>
                </div>

                <form v-else class=" w-full" >
                <div>
                
                </div>
                    <div class="flex flex-col gap-12" >
                        <div class="flex flex-col w-full gap-6" >
                            <div class="space-y-1" >
                                <Label value="Full Name"/>

                                <Input 
                                    class="w-full"
                                    v-model="form.full_name"
                                />
                            </div>
                            <div class="space-y-1" >
                                <Label value="Phone No."/>

                                <Input 
                                    class="w-full"
                                    v-model="form.phone"
                                />
                            </div>
                            <div class="space-y-1" >
                                <Label value="Email"/>

                                <Input 
                                    class="w-full"
                                    v-model="form.email"
                                />
                            </div>
                            <div class="space-y-1" >
                                <Label value="Password"/>

                                <Input 
                                    class="w-full"
                                    v-model="form.password"
                                />
                            </div>
                            
                        </div>
                        <div class="flex gap-2 items-center justify-center" >
                            <Button
                                variant="primary"
                                size="lg"
                                type="button"
                                @click="cancelEdit"
                            >
                                Cancel
                            </Button>
                            <Button 
                                variant="primary"
                                size="lg"
                                type="submit"
                            >
                                Done
                            </Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout> -->
</template>
