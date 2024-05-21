<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCardLoader from "@/Components/ProductCardLoader.vue";
import AddProduct from "@/Components/AddProduct.vue";

const products = ref([])


function get_products() {
    for (let i = 0; i < 12; i++) {
        products.value.push({
            id: i,
            name: "Lorem ipsum dolor",
            description: "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.",
            price: i,
            discount: ((i ^ 3) + 40) * 33 % 10,
            count: (((i * 3) ^ 7 - 2) + 20) % 5
        })
    }
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
                <template v-if="!products.length">
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
                    :expiration_date="select_for_update.expiration_date"
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
<style>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease-in-out;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: skewX(6deg);
}
</style>
