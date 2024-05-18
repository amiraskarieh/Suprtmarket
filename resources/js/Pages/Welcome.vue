<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from "vue";

const products = ref([])
setTimeout(() => {
    for (let i = 0; i < 12; i++) {
        products.value.push({
            id: i,
            name: "Lorem ipsum dolor",
            description: "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.",
            price: 100,
            discount: ((i ^ 3) + 40) * 33 % 10,
        })
    }
}, 2000)

</script>

<template>
    <AppLayout title="Welcome">
        <main
            class=" mt-10 max-w-7xl mx-auto p-2 grid lg:grid-cols-4 md:grid-cols-3 grid-cols-1 sm:grid-cols-2 gap-3">
            <template v-if="!products.length">
                <div v-for="i in 12" :key="i" class="card bg-transparent border shadow-2xl">
                    <div class="card-body">
                        <div class="skeleton  w-40 h-14"></div>
                        <div class="skeleton w-full h-20"></div>
                        <div class="card-actions justify-between items-center">
                            <div class="skeleton w-32 h-8"></div>
                            <div class="skeleton btn btn-sm w-24"></div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div v-for="product in products" :key="product.id" class="card border shadow-2xl image-full">
                    <figure><img :src="`https://picsum.photos/id/${product.id*3}/300/200`" :alt="product.name"/>
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">{{ product.name }}</h2>
                        <p :class="{'line-clamp-2':product.discount,'line-clamp-3':!product.discount}">
                            {{ product.description }}</p>
                        <div class="card-actions justify-between items-center">
                            <div>
                                <p v-if="product.discount" class="flex gap-2">
                                    <span>{{ product.price * (100 - product.discount) / 100 }}$</span>
                                    <span class="badge badge-secondary">{{ product.discount }}%</span>
                                </p>

                                <p :class="{'line-through':product.discount!==0}"><span
                                    class="text-sm font-medium">{{ product.price }}$</span></p>
                            </div>
                            <button class="btn btn-primary btn-sm">Buy</button>
                        </div>
                    </div>
                </div>
            </template>
        </main>
    </AppLayout>
</template>
