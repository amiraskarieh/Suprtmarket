<script setup>
import {useForm} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import {useStore} from "@/Store/my_store.js";
import {useToast} from "vue-toastification";

const toast = useToast()
const props = defineProps(['customer_id'])
const store = useStore()
const form = useForm({
    'customer_id': props.customer_id,
    'employee_id': 0,
    'products': store.get_bag_to_array(),
    'date': `${new Date().getFullYear()}-${String(new Date().getMonth()).padStart(2, '0')}-${String(new Date().getDay()).padStart(2, '0')}`,
    'price': store.price
})

const employees = ref()
onMounted(get_employees)

function get_employees() {
    axios.get(route('employees.index'))
        .then((response) => employees.value = response.data)
}

const submit = () => {
    form.age = +form.age
    if (props.id) {
        axios.put(route('transactions.update', [form.id]), form.data())
            .then(() => {
                    toast.success('update successful!')
                    emit('updated')
                }
            )
    } else {
        axios.post(route('transactions.store'), form.data())
            .then((r) => {
                    toast.success('create successful!')
                    form.reset()
                    store.reset_bag()
                    form.price = 0
                    emit('created')
                }
            ).catch(r => {
            toast.error(r.response.data.message)
        })
    }
}

</script>

<template>
    <div class="card shadow-md glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">
                <span v-if="!name">Add</span>
                <span v-else>Update</span>
                Transaction
            </h3>

            <label v-if="!props.id" class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Employee</span>
                </span>
                <select
                    id="supplier"
                    v-model="form.employee_id"
                    type="text"
                    class="select select-bordered w-full select-primary"
                    required>
                    <option disabled selected>select user</option>
                    <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                        {{ employee.name }}-{{ employee.phone }}
                    </option>
                </select>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Price</span>
                </span>
                <input
                    id="name"
                    v-model="form.price"
                    type="text"
                    disabled
                    class="input input-bordered w-full input-primary disabled"
                    required
                    placeholder="Price"/>
            </label>

            <div class="flex items-center justify-end gap-4">
                <button type="button" class="btn btn-sm btn-secondary" @click="$emit('cancel')" v-if="!!name">
                    cancel
                </button>
                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    <span v-if="!name">add</span>
                    <span v-else>update</span>
                    transaction
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
