<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <Head title="Log in"/>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>

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
                    autocomplete="current-password"
                    placeholder="Password"/>
            </label>

            <div class="form-control">
                <label class="cursor-pointer label justify-end gap-2">
                    <span class="label-text">Remember me</span>
                    <input type="checkbox" v-model="form.remember" name="remember" class="checkbox checkbox-secondary"/>
                </label>
            </div>


            <div class="flex items-center justify-end gap-4">
                <Link as="button" :href="route('register')" class="btn btn-accent btn-sm">
                    Crete account
                </Link>

                <button class="btn btn-sm btn-secondary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    Log in
                </button>
            </div>
            <div class="form-control">
                <Link :href="route('password.request')" class="link link-hover">
                    Forgot your password?
                </Link>

            </div>
        </form>
    </AuthenticationCard>
</template>
