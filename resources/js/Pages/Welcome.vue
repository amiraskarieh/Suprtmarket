<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCardLoader from "@/Components/ProductCardLoader.vue";


const products = ref([])
setTimeout(() => {
    for (let i = 0; i < 12; i++) {
        products.value.push({
            id: i,
            name: "Lorem ipsum dolor",
            description: "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.",
            price: 100,
            discount: ((i ^ 3) + 40) * 33 % 10,
            count: (((i * 3) ^ 7 - 2) + 20) % 5
        })
    }
}, 2000)

</script>

<template>
    <AppLayout title="Welcome">
        <main
            class=" mt-10 max-w-7xl mx-auto p-2 grid lg:grid-cols-4 md:grid-cols-3 grid-cols-1 sm:grid-cols-2 gap-3">
            <template v-if="!products.length">
                <ProductCardLoader v-for="i in 12" :key="i"/>
            </template>
            <template v-else>
                <ProductCard v-for="product in products" :key="product.id" :product="product"/>
            </template>
        </main>
    </AppLayout>
</template>
