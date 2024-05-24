<script setup>
import MyList from "@/Components/MyList.vue";
import {onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import AddSupplier from "@/Components/Supplier/AddSupplier.vue";

const select_for_update = ref({})
const show_edit = ref(false)

const suppliers = ref([])

onMounted(get_suppliers)

const toast = useToast()

function get_suppliers() {
    show_edit.value = false
    axios.get(route('suppliers.index'))
        .then((response) => suppliers.value = response.data)
}

function update(id) {
    for (const supplier of suppliers.value) {
        if (supplier.id === id) {
            select_for_update.value = supplier
            show_edit.value = true
            break
        }
    }
}

function updated() {
    get_suppliers()
    select_for_update.value = {}
}

function del(id) {
    axios.delete(route('suppliers.destroy', [id])).then(() => {
        toast.success('delete successful!')
        get_suppliers()
    })
}

</script>

<template>

    <main class="max-w-4xl mx-auto">
        <div class="gap-4 grid grid-cols-2">
            <transition name="list" mode="out-in">

                <AddSupplier v-if="show_edit"
                             :key="select_for_update.id"
                             :id="select_for_update.id"
                             :name="select_for_update.name"
                             :email="select_for_update.email"
                             :phone="select_for_update.phone"
                             @cancel="()=>show_edit=false"
                             @updated="updated"
                />
                <AddSupplier v-else
                             key="add"
                             @created="get_suppliers"
                />
            </transition>
            <MyList
                :input_list="suppliers"
                :is_show_able="false"
                list_name="Supplier"
                @del="del"
                @update="update"
            />
        </div>
    </main>
</template>

<style scoped>

</style>
