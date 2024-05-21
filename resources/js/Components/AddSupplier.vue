<script setup>
import {useToast} from "vue-toastification";
import {useForm} from "@inertiajs/vue3";

const toast = useToast()

const form = useForm({
    name: '',

});

const submit = () => {
    if (!/^\d+$/.test(form.count))
        toast.error('Incorrect count');
    if (!/^\d+$/.test(form.discount))
        toast.error('Incorrect discount');
    if (!/^\d+$/.test(form.price))
        toast.error('Incorrect price');
}

</script>

<template>
    <div class="card shadow-md glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">Add Supplier</h3>

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
                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    add product
                </button>
            </div>
        </form>
    </div>
</template>
