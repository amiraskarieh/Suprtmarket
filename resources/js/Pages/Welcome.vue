<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCardLoader from "@/Components/ProductCardLoader.vue";
import {useToast} from "vue-toastification";
import FilterProduct from "@/Components/FilterProduct.vue";
import {useForm} from "@inertiajs/vue3";

const toast = useToast()
const products = ref([])
const loading = ref(true)

const form = useForm({name: "", max_sell_price: 100, available: false, sort_by: ''})

function get_products() {
    axios.get(route('products.index'), form.data())
        .then(r => products.value = r.data)
        .catch(r => toast.error(r))
    loading.value = false
}

setTimeout(get_products, 2000)
</script>

<template>
    <AppLayout title="Welcome">
        <main class="flex flex-col md:flex-row gap-4 p-10">
            <div class="basis-1 md:basis-1/2 lg:basis-1/4 card glass row-span-12">
                <div class="card-body">
                    <h3 class="card-title">
                        Filter products
                    </h3>

                    <FilterProduct
                        :name="form.name"
                        @name="(v)=>form.name=v"
                        :max_sell_price="form.max_sell_price"
                        @max_sell_price="(v)=>form.max_sell_price=v"
                        :available="form.available"
                        @available="(v)=>form.available=v"
                        :sort_by="form.sort_by"
                        @sort_by="(v)=>form.sort_by=v"
                    />
                    <div class="card-actions">
                        <button type="button" class="btn btn-primary btn-block" @click="get_products"> Filter</button>
                    </div>
                </div>
            </div>

            <div class="lg:basis-3/4 md:basis-1/2 basis-1 grid lg:grid-cols-4 grid-cols-1 gap-3">
                <template v-if="loading">
                    <ProductCardLoader v-for="i in 12" :key="i"/>
                </template>
                <template v-else>
                    <ProductCard v-for="product in products" :key="product.id" :product="product"/>
                </template>
            </div>
        </main>
    </AppLayout>
</template>
