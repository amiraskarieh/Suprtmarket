<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register"/>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>

        <form @submit.prevent="submit">
            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Name</span>
                </span>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="input input-bordered w-full input-secondary"
                    required
                    autocomplete="username"
                    placeholder="Name"/>
            </label>

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

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Password</span>
                </span>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="input input-bordered w-full input-secondary"
                    required
                    autocomplete="new-password"
                    placeholder="Password"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Confirm Password</span>
                </span>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="input input-bordered w-full input-secondary"
                    required
                    autocomplete="new-password"
                    placeholder="Password"/>
            </label>

            <div class="form-control w-full flex-row items-center justify-end gap-4 mt-3">
                <Link :href="route('login')" class="btn btn-accent btn-sm">
                    Login
                </Link>

                <button type="submit" class="btn btn-sm btn-secondary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    Register
                </button>
            </div>
        </form>
    </AuthenticationCard>
</template>
