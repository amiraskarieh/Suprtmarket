<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password"/>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <form @submit.prevent="submit">
            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Email</span>
                </span>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="input input-bordered w-full input-secondary"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email"/>
            </label>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-sm btn-secondary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </AuthenticationCard>
</template>
