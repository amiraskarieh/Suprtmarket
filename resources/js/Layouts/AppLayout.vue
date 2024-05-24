<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';
import {useStore} from "@/Store/my_store.js";
import {ChevronDownIcon, ShoppingCartIcon} from '@heroicons/vue/24/outline'

const themes = [
    "light",
    "dark",
    "cupcake",
    "bumblebee",
    "emerald"
]

defineProps({title: String});

const change_them = (theme) =>
    document.getElementsByTagName('html')[0].setAttribute("data-theme", theme);

const store = useStore()
const bagCount = () => {
    let count = 0
    for (const bagKey in store.bag) {
        count += store.get_count(bagKey).value
    }
    return count
}

</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-gradient-to-br from-base-100 via-base-content/15 to-base-300">
            <nav class="bg-primary border-b border-base-content">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="avatar">
                                <Link method="get" as="button" class="w-9 rounded-full" :href="route('home')">
                                    <ApplicationMark class="block"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="space-x-8 -my-px ms-10 flex text-primary-content">
                                <NavLink method="get" as="button" v-if="$page.props.auth.user"
                                         :href="route('dashboard')"
                                         :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink method="get" as="button" v-if="store.is_employee"
                                         :href="route('management')"
                                         :active="route().current('management')">
                                    Management
                                </NavLink>
                            </div>
                        </div>

                        <div class="flex items-center gap-10">

                            <div class="indicator">
                                <span class="indicator-item badge badge-secondary">{{ bagCount() }}</span>
                                <Link class="btn btn-sm" :href="route('dashboard')">
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
                                     class="dropdown-content z-50 menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <Link class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                          as="button" :href="route('profile.show')">
                                        Profile
                                    </Link>

                                    <Link class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                          method="post" as="button"
                                          :href="route('logout')">
                                        Log Out
                                    </Link>
                                </div>

                            </div>

                            <Link v-else :href="route('login')" class="btn btn-sm">
                                Login/Register
                            </Link>


                            <div class="dropdown">
                                <div tabindex="0" role="button" class="btn btn-sm">
                                    Theme
                                    <ChevronDownIcon class="ms-2 size-4"/>
                                </div>
                                <ul tabindex="0"
                                    class="dropdown-content z-50 p-2 shadow-2xl bg-base-200 rounded-box w-52">
                                    <li v-for="theme in themes" :key="theme">
                                        <button type="button" name="theme-dropdown"
                                                class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                                @click="change_them(theme)">
                                            {{ theme }}
                                        </button>
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
