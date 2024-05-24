<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCardLoader from "@/Components/ProductCardLoader.vue";
import {useToast} from "vue-toastification";

const toast = useToast()
const products = ref([])
const loading = ref(true)

function get_products() {
    axios.get(route('products.index'))
        .then(r => products.value = r.data)
        .catch(r => toast.error(r))
    loading.value = false
}

setTimeout(get_products, 2000)
</script>

<template>
    <AppLayout title="Welcome">
        <main class="grid grid-cols-4 gap-4 p-10">
            <div class="col-span-3 grid lg:grid-cols-4 md:grid-cols-3 grid-cols-1 sm:grid-cols-2 gap-3">
                <template v-if="loading">
                    <ProductCardLoader v-for="i in 12" :key="i"/>
                </template>
                <template v-else>
                    <ProductCard v-for="product in products" :key="product.id" :product="product"/>
                </template>
            </div>

            <div class="col-span-1 card glass">
                <div class="card-body">
                    <h3 class="card-title ">
                        filters
                    </h3>
                </div>
            </div>
        </main>
    </AppLayout>
</template>
