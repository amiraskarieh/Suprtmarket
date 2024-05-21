<script setup>
import {useToast} from "vue-toastification";
import {useForm} from "@inertiajs/vue3";
import {watch} from "vue";

const toast = useToast()

const props = defineProps(['id', 'name', 'address', 'phone', 'age', 'salary', 'employment_date', 'marital_status_id',
    'job_type_id'])
const emit = defineEmits(['cansel', 'updated'])

let form = useForm({...props});

watch(() => props, (value) => {
    form = useForm(...value)
})

const submit = () => {
    if (!/^\d+$/.test(form.count))
        toast.error('Incorrect count');
    if (!/^\d+$/.test(form.discount))
        toast.error('Incorrect discount');
    if (!/^\d+$/.test(form.price))
        toast.error('Incorrect price');
    if (props.id) {
        form.put(route('supplier.update', form.id), {
            onError: (error) => {
                for (const errorKey in error)
                    toast.error(error[errorKey])
            },
            onSuccess: () => {
                toast.success('update successful!')
                emit('updated')
            }
        })
    } else {
        form.post(route('supplier.create'), {
            onError: (error) => {
                for (const errorKey in error)
                    toast.error(error[errorKey])
            },
            onSuccess: () => {
                toast.success('create successful!')
            }
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

            <div class="flex items-center justify-end gap-4">
                <button type="button" class="btn btn-sm btn-secondary" @click="$emit('cansel')" v-if="!!name">
                    cansel
                </button>
                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    <span v-if="!name">add</span>
                    <span v-else>update</span>
                    product
                </button>
            </div>
        </form>
    </div>
</template>
