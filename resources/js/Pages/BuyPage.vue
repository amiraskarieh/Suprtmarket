<script setup>
import Buy from "@/Components/Buy.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps(['auth'])

</script>

<template>
    <AppLayout title="Buy">
        <div class="max-w-4xl mt-12 mx-auto">
            <Buy :customer_id="auth.user.userable_id"/>
        </div>
    </AppLayout>
</template>

