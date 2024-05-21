<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {watch} from "vue";

const toast = useToast()

const props = defineProps([
    'name', 'description', 'available', 'discount', 'buy_price', 'sell_price', 'supplier', 'sell_number',
    'production_date', 'expiration_date', 'is_perishable'
])

let form = useForm({...props});

watch(() => props, (value) => {
    form = useForm(...value)
})

const suppliers = [{id: 1, name: 'test'}, {id: 2, name: 'testtfsdg'}]

const submit = () => {
    if (!/^\d+$/.test(form.available))
        toast.error('Incorrect count');
    if (!/^\d+$/.test(form.discount))
        toast.error('Incorrect discount');
    if (!/^\d+$/.test(form.buy_price))
        toast.error('Incorrect buy price');
    if (!/^\d+$/.test(form.sell_price))
        toast.error('Incorrect sell price');

    form.transform(data => ({
        ...data,
        is_perishable: !!form.expiration_date,
    })).post(route('product.create'), {
        onFinish: () => form.reset(),
        onError: (error) => {
            for (const errorKey in error)
                toast.error(error[errorKey])
        },
        onSuccess: () => toast.success('the product added!')
    });
}

</script>

<template>
    <div class="card shadow-md glass">
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
                    v-model="form.available"
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
                    <span class="label-text">Buy Price</span>
                </span>
                <input
                    id="buy_price"
                    v-model="form.buy_price"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Buy Price"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Sell Price</span>
                </span>
                <input
                    id="sell_price"
                    v-model="form.sell_price"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Sell Price"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Production Date</span>
                </span>
                <input
                    id="sell_price"
                    v-model="form.production_date"
                    type="date"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Production Date"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Expiration Date</span>
                </span>
                <input
                    id="sell_price"
                    v-model="form.expiration_date"
                    type="date"
                    class="input input-bordered w-full input-primary"
                    placeholder="Expiration Date"/>
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
                    <option disabled selected :value="undefined">select supplier</option>
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
