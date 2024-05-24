<script setup>
import {useToast} from "vue-toastification";
import {useForm} from "@inertiajs/vue3";

const toast = useToast()

const props = defineProps(['id', 'name', 'email', 'phone'])
const emit = defineEmits(['cancel', 'updated', 'created'])

const form = useForm({...props});

const submit = () => {
    if (props.id) {
        axios.put(route('suppliers.update', [form.id]), form.data())
            .then(() => {
                    toast.success('update successful!')
                    form.reset()
                    emit('updated')
                }
            ).catch((error) => {
                for (const errorKey in error)
                    toast.error(error[errorKey])
            }
        )
    } else {
        console.log(form.data())
        axios.post(route('suppliers.store'), form.data())
            .then(() => {
                    toast.success('create successful!')
                    form.reset()
                    emit('created')
                }
            ).catch((error) => {
                for (const errorKey in error)
                    toast.error(error[errorKey])
            }
        )
    }
}

</script>

<template>
    <div class="card shadow-md glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">
                <span v-if="!name">Add</span>
                <span v-else>Update</span>
                Supplier
            </h3>

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
                    <span class="label-text">Email</span>
                </span>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="input input-bordered w-full input-primary"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email"/>
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

            <div class="flex items-center justify-end gap-4">
                <button type="button" class="btn btn-sm btn-secondary" @click="$emit('cancel')" v-if="!!name">
                    cancel
                </button>
                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    <span v-if="!name">add</span>
                    <span v-else>update</span>
                    supplier
                </button>
            </div>
        </form>
    </div>
</template>
