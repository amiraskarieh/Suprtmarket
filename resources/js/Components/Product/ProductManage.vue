<script setup>
import MyList from "@/Components/MyList.vue";
import {onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import AddProduct from "@/Components/Product/AddProduct.vue";

const select_for_update = ref({})
const show_edit = ref(false)

const products = ref([])

onMounted(get_products)

const toast = useToast()

function get_products() {
    show_edit.value = false
    axios.get(route('products.index'))
        .then((response) => products.value = response.data)
}

function update(id) {
    for (const supplier of products.value) {
        if (supplier.id === id) {
            select_for_update.value = supplier
            show_edit.value = true
            break
        }
    }
}

function updated() {
    get_products()
}

function del(id) {
    axios.delete(route('products.destroy', [id])).then(() => {
        toast.success('delete successful!')
        get_products()
    })
}

</script>

<template>

    <main class="max-w-4xl mx-auto">
        <div class="gap-4 grid grid-cols-2">
            <transition name="list" mode="out-in">

                <AddProduct v-if="show_edit"
                            :key="select_for_update.id"
                            :id="select_for_update.id"
                            :name="select_for_update.name"
                            :description="select_for_update.description"
                            :available="select_for_update.available"
                            :discount="select_for_update.discount"
                            :buy_price="select_for_update.buy_price"
                            :sell_price="select_for_update.sell_price"
                            :supplier_id="select_for_update.supplier_id"
                            :sell_number="select_for_update.sell_number"
                            :production_date="select_for_update.production_date"
                            :perishable_data="select_for_update.perishable_data"
                            :is_perishable="select_for_update.is_perishable"
                            @cancel="()=>show_edit=false"
                            @updated="updated"
                />
                <AddProduct v-else
                            key="add"
                            @created="get_products"
                />
            </transition>
            <MyList
                :input_list="products"
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
