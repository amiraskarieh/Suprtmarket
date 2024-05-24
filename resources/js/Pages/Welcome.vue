<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCardLoader from "@/Components/ProductCardLoader.vue";
import AddProduct from "@/Components/Product/AddProduct.vue";
import {useToast} from "vue-toastification";

const toast = useToast()
const products = ref([])
const loading = ref(true)

function get_products() {
    axios.get(route('products.index'))
        .then(r => products.value = r.data)
        .catch(r => toast.error(r))
        .finally(() => loading.value = false)
}

setTimeout(get_products, 2000)

const select_for_update = ref({})
const show_edit = ref(false)

function update(product) {
    select_for_update.value = product
    show_edit.value = true
}

function updated() {
    show_edit.value = true
    get_products()
}
</script>

<template>
    <AppLayout title="Welcome">
        <main class="flex gap-4 p-10">
            <div class="basis-3/4 grid lg:grid-cols-4 md:grid-cols-3 grid-cols-1 sm:grid-cols-2 gap-3">
                <template v-if="!loading">
                    <ProductCardLoader v-for="i in 12" :key="i"/>
                </template>
                <template v-else>
                    <ProductCard v-for="product in products" :key="product.id" :product="product" @update="update"/>
                </template>
            </div>
            <transition name="list" tag="div" mode="out-in" class="basis-1/4">
                <AddProduct
                    v-if="show_edit"
                    @cancel="()=>show_edit=false"
                    @updated="updated"
                    @del="get_products"
                    :name="select_for_update.name"
                    :description="select_for_update.description"
                    :available="select_for_update.available"
                    :discount="select_for_update.discount"
                    :buy_price="select_for_update.buy_price"
                    :sell_price="select_for_update.sell_price"
                    :supplier="select_for_update.supplier"
                    :sell_number="select_for_update.sell_number"
                    :production_date="select_for_update.production_date"
                    :perishable_data="select_for_update.perishable_data"
                    :is_perishable="select_for_update.is_perishable"
                />
                <div v-else class="w-full card">
                    <div class="card-body">
                        <h3 class="card-title">
                            filters
                        </h3>
                    </div>
                </div>
            </transition>
        </main>
    </AppLayout>
</template>
