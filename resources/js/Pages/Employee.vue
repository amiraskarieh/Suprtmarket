<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Employee">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card glass shadow-xl grid grid-cols-3">
                    <div>
                        product
                        <div>add</div>
                        <div>update</div>
                        <div>delete</div>
                    </div>
                    <div>
                        employee
                        <div>add</div>
                        <div>update</div>
                        <div>delete</div>
                    </div>
                    <div>
                        supplayer
                        <div>add</div>
                        <div>update</div>
                        <div>delete</div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
