<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link, useForm, usePage, } from '@inertiajs/vue3';
import { CheckIcon, ChevronLeft } from '@/Components/Icons/solid';
import Label from '@/Components/Label.vue';
import Input from '@/Components/Input.vue';
import Button from '@/Components/Button.vue';
import { onMounted, ref, computed } from 'vue';
import Dropdown from 'primevue/dropdown';
import Dialog from 'primevue/dialog';

const props = defineProps({
  profileImage: Object,
})

const edit = ref(false);
const user = usePage().props.auth.user
const position = ref('center');
const visible = ref(false);
const profileImages = ref([]);
const selectedImage = ref(null);

const fetchProfileImages = async () => {
  try {
    const response = await fetch('/getProfileImage');
    profileImages.value = await response.json();
  } catch (error) {
    console.error('Error fetching profile images:', error);
  }
};

onMounted(() => {
  fetchProfileImages();
});

const profileImageToShow = computed(() => {
  return selectedImage.value ? URL.createObjectURL(selectedImage.value) : props.profileImage.profile;
});

const form = useForm({
    full_name: user.full_name,
    phone: user.phone,
    email: user.email,
    password: '',
    image: null
})

const dial_code = ref([
    { code: '+60' }
]);

const selectedDialCode = ref(dial_code.value[0]);

const openPosition = (pos) => {

    position.value = pos;
    visible.value = true;
}

const closePosition = () => {

    visible.value = false;
}

const selectFile = async (image) => {
  try {
    // Fetch the actual file from the URL
    const response = await fetch(image.url);
    const blob = await response.blob();
    const file = new File([blob], image.name, { type: blob.type });

    selectedImage.value = file; // Store the file object
    form.image = file; // Update the form data
    
  } catch (error) {
    console.error('Error converting image to file:', error);
  }
};

const confirmSelection = () => {
    visible.value = false;
}

const editDetails = () => {
    edit.value = true;
}

const cancelEdit = () => {

    form.reset({
        full_name: user.full_name,
        phone: user.phone,
        email: user.email,
        password: ''
    })

    edit.value = false;
}

const submit = () => {
    // console.log('selectedImage.value', form.image)
    if (selectedImage.value) {
        const formData = new FormData();
        formData.append('image', selectedImage.value);
        form.post(route("profile.update-profile"), {
            onFinish: () => form.reset({
                full_name: user.full_name,
                phone: user.phone,
                email: user.email,
                password: ''
            }),
        });
    } else {
        form.post(route("profile.update-profile"), {
            onFinish: () => {
                form.reset({
                    full_name: user.full_name,
                    phone: user.phone,
                    email: user.email,
                    password: ''
                });
            },
            onSuccess: () => {
                edit.value = false;
            }
        });
    }
  
};

</script>

<style>
    .p-dialog-mask {
        background-color: rgba(0, 0, 0, 0.20) !important; /* Apply rgba(0, 0, 0, 0.20) to the overlay */
    }
</style>

<template>
    <Head title="Profile" />

    <div class="flex justify-center w-full" >
        <div class="max-w-md w-full flex flex-col min-h-screen">
            <div class="p-3 flex justify-between items-center">
                <Link :href="route('dashboard')">
                    <ChevronLeft class="text-white" />
                </Link>
                
                <div class="text-white text-base font-semibold leading-tight flex items-center" >Account Details</div>
                <div class="w-6 h-6"></div>
            </div>
            <div class="bg-white w-full px-8 pt-[18px] py-9 h-full flex flex-col gap-9 items-center">

                <div v-if="edit === false" class=" w-full flex flex-col gap-16 " >
                    <div class="w-full flex justify-center">
                        <div class=" w-[140px] h-[140px] rounded-full">
                            <img :src="props.profileImage.profile" alt="profile">
                        </div>
                    </div>
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
                                {{ $page.props.auth.user.email ? $page.props.auth.user.email : '-' }}
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
                    <div class="w-full flex justify-center">
                        <div class=" w-[140px] h-[140px] rounded-full" @click="openPosition('bottom')" >
                            <img :src="profileImageToShow" alt="profile" class="w-full h-full rounded-full">
                        </div>
                    </div>
                    <div class="flex flex-col gap-12" >
                        <div class="flex flex-col w-full gap-6" >
                            <div class="space-y-1" >
                                <Label value="Full Name"/>

                                <Input 
                                    id="full_name"
                                    class="w-full"
                                    v-model="form.full_name"

                                />
                            </div>
                            <div class="space-y-1" >
                                <Label value="Phone No."/>

                                <div class="flex items-center gap-2">
                                    <div class="py-3 px-4 border border-gray-300 bg-white rounded-md">
                                        <Dropdown 
                                        v-model="selectedDialCode" 
                                        :options="dial_code" 
                                        optionLabel="code"  
                                        class="w-14 flex items-center justify-between text-base leading-tight" 
                                        disabled />
                                    </div>

                                    <Input 
                                        class="w-full"
                                        v-model="form.phone"
                                    />
                                </div>
                                
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
                                    type="password"

                                />
                            </div>
                            
                        </div>
                        <div class="flex gap-2 items-center justify-center" >
                            <Button
                                variant="tertiary"
                                size="lg"
                                type="button"
                                @click="cancelEdit"
                            >
                                Cancel
                            </Button>
                            <Button 
                                variant="primary"
                                size="lg"
                                type="button"
                                @click="submit"
                            >
                                Save changes
                            </Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="px-3">
        <Dialog 
            v-model:visible="visible" 
            header="Choose an avatar" 
            :style="{ width: '100%', margin: '0px 12px', border: '0px solid', borderRadius: '10px 10px 0px 0px' }" 
            :position="position" 
            modal 
            :draggable="false"
            :showHeader="false"
        >
            <div class="flex flex-col gap-8 p-6 bg-white rounded-t-[10px]">
                <div class="text-primary-900 text-base font-semibold">Choose an avatar</div>
                <div class="grid grid-cols-4 grid-rows-2 gap-4">
                    <div
                        v-for="(image, index) in profileImages"
                        :key="index"
                        class="w-[60px] h-[60px] flex justify-center rounded-full cursor-pointer relative"
                        @click="selectFile(image)"
                    >
                        <img :src="image.url" alt="Profile Image" 
                            class="w-[60px] h-[60px] rounded-full "
                            :class="{
                                'border-2 border-primary-900': selectedImage?.name === image.name, // Compare by name
                                'border-none border-black': selectedImage?.name !== image.name,
                            }"
                        />

                        <div v-if="selectedImage?.name === image.name" class="absolute top-0 right-0 rounded-full w-5 h-5 bg-primary-900 flex justify-center items-center">
                            <CheckIcon />
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full">
                    <div class="w-full">
                        <Button size="lg" variant="secondary" class="w-full flex justify-center items-center" @click="closePosition">Close</Button>
                    </div>
                    <div class="w-full">
                        <Button size="lg" variant="primary" class="w-full flex justify-center items-center" @click="confirmSelection">Confirm</Button>
                    </div>
                </div>
            </div>   
        </Dialog>
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
