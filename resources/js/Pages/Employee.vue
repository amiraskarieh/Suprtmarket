<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AddProduct from "@/Components/AddProduct.vue";
import AddSupplier from "@/Components/AddSupplier.vue";
import SuppliersList from "@/Components/SuppliersList.vue";
</script>

<template>
    <AppLayout title="Employee">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card bg-transparent grid grid-cols-3 gap-2">
                    <div>
                        <AddProduct/>
                    </div>
                    <div>
                        employee
                        <div>add</div>
                        <div>update</div>
                        <div>delete</div>
                    </div>
                    <div class="flex flex-col gap-3">
                        supplier
                        <AddSupplier/>
                        <SuppliersList/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
