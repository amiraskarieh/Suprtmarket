<script setup>
import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const toast = useToast()

const props = defineProps(['name', 'address', 'phone', 'age', 'salary', 'employment_date', 'marital_status_id', 'job_type_id'])

const form = useForm({...props});

const submit = () => {
    if (!/^\d+$/.test(form.phone))
        toast.error('Incorrect phone');
    if (!/^\d+$/.test(form.age))
        toast.error('Incorrect age');
    if (!/^\d+$/.test(form.salary))
        toast.error('Incorrect salary');
}

const marital_status_ids = [{
    id: 1, name: "aa"
}]


const job_type_ids = [{
    id: 1, name: "aa"
}]
</script>

<template>
    <div class="card shadow-md glass">
        <form class="card-body" @submit.prevent="submit">
            <h3 class="card-title justify-center">Add Employee</h3>

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

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Salary</span>
                </span>
                <input
                    id="count"
                    v-model="form.salary"
                    type="text"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Salary"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Employment Date</span>
                </span>
                <input
                    id="sell_price"
                    v-model="form.employment_date"
                    type="date"
                    class="input input-bordered w-full input-primary"
                    required
                    placeholder="Employment Date"/>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Supplier</span>
                </span>
                <select
                    id="supplier"
                    v-model="form.marital_status_id"
                    type="text"
                    class="select select-bordered w-full select-primary"
                    required>
                    <option disabled selected :value="undefined">select marital status</option>
                    <option v-for="marital_status_id in marital_status_ids" :key="marital_status_id.id"
                            :value="marital_status_id.id">
                        {{ marital_status_id.name }}
                    </option>
                </select>
            </label>

            <label class="form-control w-full ">
                <span class="label">
                    <span class="label-text">Supplier</span>
                </span>
                <select
                    id="supplier"
                    v-model="form.job_type_id"
                    type="text"
                    class="select select-bordered w-full select-primary"
                    required>
                    <option disabled selected :value="undefined">select job type</option>
                    <option v-for="job_type_id in job_type_ids" :key="job_type_id.id" :value="job_type_id.id">
                        {{ job_type_id.name }}
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

