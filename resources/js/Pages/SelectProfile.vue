<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from "@/Components/Button.vue";
import { CheckIcon } from '@/Components/Icons/solid';

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

// Function to handle image selection
const selectFile = (image) => {
  selectedImage.value = image;

  console.log('w', selectedImage.value)
};


// Submit selected image to the controller
const form = useForm({
  image: null,
});

const submitImage = () => {
  if (selectedImage.value) {
    const formData = new FormData();
    formData.append('image', selectedImage.value);

    // Use Inertia's visit method to submit the form
    form.post('/save-image', {
      data: formData,
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onSuccess: () => {
        alert('Profile image updated successfully!');
      },
      onError: (error) => {
        console.error('Error submitting image:', error);
      },
    });
  } else {
    alert('Please select an image before submitting.');
  }
};

onMounted(() => {
  fetchProfileImages();
});

</script>

<template>
    <Head title="Profile" />

    <div class="flex justify-center w-full min-h-screen" >
        <div class="bg-white py-6 px-8 w-full min-h-[70vh] flex flex-col gap-9">
            <div class="flex flex-col gap-2">
                <div class="text-primary-900 text-xl font-bold leading-tight">Choose an avatar</div>
                <div class="text-gray-900 font-medium text-sm">
                    Pick the avatar that best represent yourself!
                </div>
            </div>
            <div class="grid grid-cols-2" style="gap: 32px;">
                <div
                    v-for="(image, index) in profileImages"
                    :key="index"
                    class="w-[120px] h-[120px] flex justify-center rounded-full cursor-pointer relative"
                    @click="selectFile(image)"
                >
                    <img :src="image" alt="Profile Image" 
                        class="w-[120px] h-[120px] rounded-full "
                        :class="{
                            ' border-2 border-primary-900 ': selectedImage === image,
                            ' border-none border-black': selectedImage !== image,
                        }"
                    />

                    <div v-if="selectedImage === image" class="absolute top-0 right-1 rounded-full w-7 h-7 p-1.5 bg-primary-900">
                        <CheckIcon />
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <Button
                class="w-full flex justify-center"
                :disabled="form.processing"
                @click="submitImage"
                >
                Submit
                </Button>
            </div>
        </div>
    </div>

</template>