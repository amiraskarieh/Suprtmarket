<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';

import {ChevronDownIcon, ShoppingCartIcon} from '@heroicons/vue/24/solid'

const themes = [
    "light",
    "dark",
    "cupcake",
    "bumblebee",
    "emerald",
    "corporate",
    "synthwave",
    "retro",
    "cyberpunk",
    "valentine",
    "halloween",
    "garden",
    "forest",
    "aqua",
    "lofi",
    "pastel",
    "fantasy",
    "wireframe",
    "black",
    "luxury",
    "dracula",
    "cmyk",
    "autumn",
    "business",
    "acid",
    "lemonade",
    "night",
    "coffee",
    "winter",
    "dim",
    "nord",
    "sunset"
]

defineProps({title: String});

const change_them = (theme) =>
    document.getElementsByTagName('html')[0].setAttribute("data-theme", theme);


</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-base-100">
            <nav class="bg-primary border-b border-base-content">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="avatar">
                                <Link class="w-9 rounded-full" :href="route('dashboard')">
                                    <ApplicationMark class="block"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="space-x-8 -my-px ms-10 flex text-primary-content">
                                <NavLink v-if="$page.props.auth.user" :href="route('dashboard')"
                                         :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <div class="flex items-center gap-10">

                            <div class="indicator">
                                <span class="indicator-item badge badge-secondary">3</span>
                                <Link as="button" class="btn btn-sm" href="#">
                                    <ShoppingCartIcon class="size-4"/>
                                </Link>
                            </div>

                            <!-- Settings Dropdown -->
                            <div v-if="$page.props.auth.user" class="dropdown">
                                <div tabindex="0">
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             :src="$page.props.auth.user.profile_photo_url"
                                             :alt="$page.props.auth.user.name">
                                    </button>

                                    <button v-else type="button" class="btn btn-sm">
                                        {{ $page.props.auth.user.name }}
                                        <ChevronDownIcon class="ms-2 size-4"/>
                                    </button>
                                </div>
                                <div tabindex="0"
                                     class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <Link class="block px-4 py-2 hover:text-primary" :href="route('profile.show')">
                                        Profile
                                    </Link>

                                    <div class="border-t border-base-content"/>

                                    <!-- Authentication -->
                                    <Link class="block px-4 py-2 hover:text-primary" method="post"
                                          :href="route('logout')">
                                        Log Out
                                    </Link>
                                </div>

                            </div>

                            <Link v-else :href="route('login')" class="btn btn-sm">
                                Login/Register
                            </Link>


                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-sm">Themes</div>
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li v-for="theme in themes" :key="theme" class="my-2">
                                        <button class="btn" @click="change_them(theme)">{{ theme }}</button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
