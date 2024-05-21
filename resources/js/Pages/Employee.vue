<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AddProduct from "@/Components/AddProduct.vue";
import AddSupplier from "@/Components/AddSupplier.vue";
import SuppliersList from "@/Components/SuppliersList.vue";
import AddEmployee from "@/Components/AddEmployee.vue";
import EmployeeList from "@/Components/EmployeeList.vue";
</script>

<template>
    <AppLayout title="Employee">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card bg-transparent grid grid-cols-3 gap-4">
                    <div>
                        <AddProduct class="transition-all duration-150 hover:z-10 hover:scale-105 hover:shadow-xl"/>
                    </div>

                    <div class="flex flex-col gap-6">
                        <AddEmployee class="transition-all duration-150 hover:z-10 hover:scale-105 hover:shadow-xl"/>
                        <EmployeeList class="transition-all duration-150 hover:z-10 hover:scale-105 hover:shadow-xl"/>
                    </div>

                    <div class="flex flex-col gap-6">
                        <AddSupplier class="transition-all duration-150 hover:z-10 hover:scale-105 hover:shadow-xl"/>
                        <SuppliersList class="transition-all duration-150 hover:z-10 hover:scale-105 hover:shadow-xl"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
