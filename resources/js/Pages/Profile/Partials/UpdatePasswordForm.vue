<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import {useToast} from "vue-toastification";

const toast = useToast()

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onError: (error) => {
            for (const errorKey in error)
                toast.error(error[errorKey])
        },
        onSuccess: () => {
            toast.success('now, your password updated successfully!')
            form.reset()
        }
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <label class="form-control w-full">
                <span class="label">
                    <span class="label-text text-primary-content">Current Password</span>
                </span>
                <input
                    id="current_password"
                    v-model="form.current_password"
                    type="password"
                    class="input input-bordered w-full text-base-content"
                    required
                    autocomplete="password"
                    placeholder="Current Password"/>
            </label>

            <label class="form-control w-full">
                <span class="label">
                    <span class="label-text text-primary-content">New Password</span>
                </span>
                <input
                    id="current_password"
                    v-model="form.password"
                    type="password"
                    class="input input-bordered w-full text-base-content"
                    required
                    autocomplete="new-password"
                    placeholder="New Password"/>
            </label>

            <label class="form-control w-full">
                <span class="label">
                    <span class="label-text text-primary-content">Confirm Password</span>
                </span>
                <input
                    id="current_password"
                    v-model="form.password_confirmation"
                    type="password"
                    class="input input-bordered w-full text-base-content"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"/>
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
