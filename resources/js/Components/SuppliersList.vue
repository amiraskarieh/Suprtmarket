<script setup>
import {ref} from "vue";
import {PencilSquareIcon, TrashIcon, EyeIcon} from "@heroicons/vue/24/outline";
import AddSupplier from "@/Components/AddSupplier.vue";

const suppliers = ref([])

for (let i = 0; i < 10; i++) {
    suppliers.value.push({
        id: i,
        name: i,
        address: i,
        phone: i,
        age: i,
        salary: i,
        employment_date: i,
        marital_status_id: i,
        job_type_id: i
    })
}

const select_for_update = ref({})

function update(id) {
    for (const supplier of suppliers.value) {
        if (supplier.id == id) {
            select_for_update.value = supplier
            break
        }
    }
    modal_2.showModal()
}

function del(id) {

}

</script>

<template>

    <dialog id="modal_2" class="modal">
        <div class="modal-box">
            <AddSupplier
                :id="select_for_update.id"
                :name="select_for_update.name"
                :address="select_for_update.address"
                :phone="select_for_update.phone"
                :age="select_for_update.age"
                :salary="select_for_update.salary"
                :employment_date="select_for_update.employment_date"
                :marital_status_id="select_for_update.marital_status_id"
                :job_type_id="select_for_update.job_type_id"
                class="shadow-none w-full"/>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <div class="card glass shadow-md">
        <div class="card-body px-0">
            <h3 class="card-title justify-center">Suppliers List</h3>
            <div class="flex flex-col">
                <div v-for="supplier in suppliers" :key="supplier.id"
                     class="flex justify-between h-12 px-10 odd:bg-primary/10 items-center transition-all duration-150 hover:shadow-lg hover:text-xl group">
                    <p>{{ supplier.name }}</p>
                    <div class="flex gap-2">
                        <button>
                            <PencilSquareIcon
                                @click="update(supplier.id)"
                                class="h-4 text-info transition-all duration-150 group-hover:h-6"/>
                        </button>
                        <button>
                            <TrashIcon @click="del(supplier.id)"
                                       class="h-4 text-error transition-all duration-150 group-hover:h-6"/>
                        </button>

                        <button>
                            <EyeIcon class="h-4 textarea-success transition-all duration-150 group-hover:h-6"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
