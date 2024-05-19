<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const toast = useToast()

const form = useForm({
    name: '',
    description: '',
    count: '0',
    discount: '0',
    price: '0',
    supplier: ''
});

const suppliers = [{id: 1, name: 'test'},{id: 2, name: 'testtfsdg'}]

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
    <div class="card shadow-xl glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">Add product</h3>
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
                    <span class="label-text">Description</span>
                </span>
                <textarea
                    id="description"
                    v-model="form.description"
                    type="txt"
                    class="textarea textarea-bordered w-full textarea-primary"
                    required
                    placeholder="Description"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Count</span>
                </span>
                <input
                    id="count"
                    v-model="form.count"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Count"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Discount</span>
                </span>
                <input
                    id="discount"
                    v-model="form.discount"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Discount"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Price</span>
                </span>
                <input
                    id="price"
                    v-model="form.price"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Price"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Supplier</span>
                </span>
                <select
                    id="supplier"
                    v-model="form.supplier"
                    type="text"
                    class="select select-bordered w-full select-primary"
                    required>
                    <option disabled selected value="">select supplier</option>
                    <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                        {{ supplier.name }}
                    </option>
                </select>
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
