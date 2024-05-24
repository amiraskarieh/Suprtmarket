<script setup>
import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {onMounted, ref} from "vue";

const toast = useToast()

const props = defineProps([
    'id','name', 'description', 'available', 'discount', 'buy_price', 'sell_price', 'supplier_id', 'sell_number',
    'production_date', 'perishable_data', 'is_perishable'
])
const emit = defineEmits(['cancel', 'updated','created'])

const form = useForm({...props});

const suppliers = ref([])

async function get_supplier() {
    axios.get(route('suppliers.index')).then((response) => {
        suppliers.value = response.data
    })
}

onMounted(get_supplier)

const submit = () => {
    form.available = +form.sell_number
    form.buy_price = +form.buy_price
    form.discount = +form.discount
    form.sell_price = +form.sell_price
    form.sell_number = +form.sell_number
    console.log(form.perishable_data)
    if (form.perishable_data === undefined)
        form.perishable_data = null
    form.is_perishable = !!form.perishable_data

    if (props.id) {
        axios.put(route('products.update', [form.id]), form.data())
            .then(() => {
                    toast.success('update successful!')
                    form.reset()
                    emit('updated')
                }
            )
    } else {
        axios.post(route('products.store'), form.data())
            .then(() => {
                    toast.success('create successful!')
                    form.reset()
                    emit('created')
                }
            )
    }
}

</script>

<template>
    <div class="card shadow-md glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">
                <span v-if="!id">Add</span>
                <span v-else>Update</span>
                product
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
                    <span class="label-text">sell number</span>
                </span>
                <input
                    id="sell-number"
                    v-model="form.sell_number"
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
                    v-model="form.perishable_data"
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
                    v-model="form.supplier_id"
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
                <button type="button" class="btn btn-sm btn-secondary" @click="$emit('cancel')" v-if="!!id">
                    cancel
                </button>

                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-infinity"></span>
                    <span v-if="!id">add</span>
                    <span v-else>update</span>
                    product
                </button>
            </div>
        </form>
    </div>
</template>
