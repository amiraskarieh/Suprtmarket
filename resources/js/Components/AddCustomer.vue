<script setup>
import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {onMounted, ref} from "vue";
import axios from "axios";

const toast = useToast()

const props = defineProps(['user_id', 'id', 'name',
    'age',
    'phone',
    'address'])

const emit = defineEmits(['cancel', 'updated', 'created'])

const form = useForm({...props});

const submit = () => {
    form.age = +form.age
    if (props.id) {
        axios.put(route('customers.update', [form.id]), form.data())
            .then(() => {
                    toast.success('update successful!')
                    emit('updated')
                }
            )
    } else {
        axios.post(route('customers.store'), form.data())
            .then((r) => {
                    const id = r.data
                    axios.post(route('users.addRelation'), {
                        user_id: form.user_id,
                        type: 'customer',
                        related_id: id
                    }).then(() => {
                        toast.success('create successful!')
                        form.reset()
                        get_users_without_polymorphism()
                        emit('created')
                    }).catch(r => {
                        log.error(r)
                    })
                }
            ).catch(r => {
            toast.error(r.response.data.message)
        })
    }
}

const users = ref([])

function get_users_without_polymorphism() {
    axios.get(route('users.withoutPolymorphism'))
        .then(r => users.value = r.data)
}

onMounted(get_users_without_polymorphism)

const marital_statuses = ref(['married', 'single'])

const job_types = ref(['manger', 'cashier', 'seller'])

</script>

<template>
    <div class="card shadow-md glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">
                <span v-if="!name">Add</span>
                <span v-else>Update</span>
                Customer
            </h3>

            <label v-if="!props.id" class="form-control w-full ">
                <span class="label">
                    <span class="label-text">User</span>
                </span>
                <select
                    id="supplier"
                    v-model="form.user_id"
                    type="text"
                    class="select select-bordered w-full select-primary"
                    required>
                    <option disabled selected>select user</option>
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.name }}-{{ user.email }}
                    </option>
                </select>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Name</span>
                </span>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Name"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Address</span>
                </span>
                <textarea
                    id="description"
                    v-model="form.address"
                    type="txt"
                    class="textarea textarea-bordered w-full textarea-primary"
                    required
                    placeholder="Address"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Phone</span>
                </span>
                <input
                    id="count"
                    v-model="form.phone"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Phone"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Age</span>
                </span>
                <input
                    id="count"
                    v-model="form.age"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Age"/>
            </label>

            <div class="flex items-center justify-end gap-4">
                <button type="button" class="btn btn-sm btn-secondary" @click="$emit('cancel')" v-if="!!name">
                    cancel
                </button>
                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    <span v-if="!name">add</span>
                    <span v-else>update</span>
                    customer
                </button>
            </div>
        </form>
    </div>
</template>

