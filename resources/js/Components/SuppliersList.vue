<script setup>
import {ref, onMounted} from "vue";
import {PencilSquareIcon, TrashIcon, EyeIcon} from "@heroicons/vue/24/outline";
import AddSupplier from "@/Components/AddSupplier.vue";
import {router} from '@inertiajs/vue3'
import {useToast} from "vue-toastification";

const toast = useToast()

onMounted(get_suppliers)

const suppliers = ref([])

function get_suppliers() {
/*    router.get(route('suppliers.get'), {
        onSuccess: (response) => {
            console.log(response.props.suppliers)
            suppliers.value = response.props.suppliers
        }
    })*/
    for (let i = 0; i < 10; i++) {
        suppliers.value.push({
            id: i,
            name: i,
            phone: i,
            email: i
        })
    }
}

const select_for_update = ref({})
const show_edit = ref(false)

function update(id) {
    for (const supplier of suppliers.value) {
        if (supplier.id === id) {
            select_for_update.value = supplier
            show_edit.value = true
            break
        }
    }
}

function
del(id) {
    router.delete(route('supplier.delete', {id: id}), {
        onFinish: get_suppliers,
        onError: (error) => {
            for (const errorKey in error)
                toast.error(error[errorKey])
        },
        onSuccess: () => toast.success('delete successful!')
    })
}

</script>

<template>
    <transition name="list" tag="div" mode="out-in">
        <AddSupplier
            v-if="show_edit"
            :id="select_for_update.id"
            :name="select_for_update.name"
            :email="select_for_update.email"
            :phone="select_for_update.phone"
            @cansel="()=>show_edit=false"
            @updated="get_suppliers"
        />

        <div class="card glass shadow-md" v-else>
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
    </transition>
</template>
