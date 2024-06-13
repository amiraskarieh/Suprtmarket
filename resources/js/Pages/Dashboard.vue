<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AddCustomer from "@/Components/AddCustomer.vue";
import Buy from "@/Components/Buy.vue";
import {useStore} from "@/Store/my_store.js";


const props = defineProps(['auth'])
const store = useStore()
store.set_customer(props.auth.user.userable_type === 'App\\Models\\Customer')
store.set_employee(props.auth.user.userable_type === 'App\\Models\\Employee')

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="max-w-4xl mt-12 mx-auto">
            <div v-if="store.is_customer">
                cu
            </div>
            <div v-else-if="store.is_employee">
                em
            </div>
            <div v-else class="w-1/2 mx-auto">
                <AddCustomer :user_id="auth.user.id" @created="() => store.set_customer(true)"/>
            </div>
        </div>
    </AppLayout>
</template>
