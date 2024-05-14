<script setup>
import {ref} from 'vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import {useToast} from "vue-toastification";

const toast = useToast()

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onError: (error) => {
            for (const errorKey in error)
                toast.error(error[errorKey])
        },
        onSuccess: () => {
            toast.success('now, your information updated successfully!')
            clearPhotoFileInput()
        }
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <label v-if="$page.props.jetstream.managesProfilePhotos" class="form-control w-full">
                <!-- Profile Photo File Input -->
                <span class="label">
                    <span class="label-text text-primary-content">Photo</span>
                </span>
                <input
                    id="photo"
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                >


                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="avatar">
                    <div class="w-20 rounded-full">
                        <img :src="user.profile_photo_url" :alt="user.name">
                    </div>
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="avatar">
                    <span class="w-20 rounded-full" :style="'background-image: url(\'' + photoPreview + '\');'"/>
                </div>

                <div class="flex  gap-4 flex-row-reverse">
                    <button type="button" class="btn btn-sm btn-secondary mt-2 w-52" @click.prevent="selectNewPhoto">
                        Select A New Photo
                    </button>

                    <button
                        v-if="!user.profile_photo_path"
                        type="button"
                        class="btn btn-sm btn-error mt-2 w-52"
                        @click.prevent="deletePhoto"
                    >
                        Remove Photo
                    </button>
                </div>
            </label>

            <!-- Name -->
            <label class="form-control w-full">
                <span class="label">
                    <span class="label-text text-primary-content">Name</span>
                </span>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="input input-bordered w-full text-base-content"
                    required
                    autocomplete="name"
                    placeholder="Name"/>
            </label>

            <!-- Email -->
            <label class="form-control w-full">
                <span class="label">
                    <span class="label-text text-primary-content">Email</span>
                </span>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="input input-bordered w-full text-base-content"
                    required
                    autocomplete="email"
                    placeholder="Email"/>
                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </label>
        </template>

        <template #actions>
            <button type="submit" class="btn btn-sm btn-secondary" :disabled="form.processing">
                <span v-if="form.processing" class="loading loading-infinity"></span>
                Save
            </button>
        </template>
    </FormSection>
</template>
