<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AddCustomer from "@/Components/AddCustomer.vue";
import {useStore} from "@/Store/my_store.js";
import Transactions from "@/Components/Transactions.vue";
import {onMounted, ref} from "vue";

const props = defineProps(['auth'])
const store = useStore()
store.set_customer(props.auth.user.userable_type === 'App\\Models\\Customer')
store.set_employee(props.auth.user.userable_type === 'App\\Models\\Employee')


const transactions = ref([])

function get_transaction() {
    const rout_name = store.is_customer ? 'customer.transactions' : 'employee.transactions'
    axios.get(route(rout_name, [props.auth.user.userable_id]))
        .then(r => {
            transactions.value = r.data
        })
}

onMounted(get_transaction)

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="max-w-4xl mt-12 mx-auto">
            <div v-if="store.is_customer || store.is_employee">
                <Transactions :transactions="transactions"/>
            </div>
            <div v-else class="w-1/2 mx-auto">
                <AddCustomer :user_id="auth.user.id" @created="() => store.set_customer(true)"/>
            </div>
        </div>
    </AppLayout>
</template>
