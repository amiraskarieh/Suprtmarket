<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <UpdateProfileInformationForm :user="$page.props.auth.user"/>
                <div class="divider divider-primary"></div>
                <UpdatePasswordForm class="mt-10 sm:mt-0"/>
            </div>
        </div>
    </AppLayout>
</template>
