<script setup>
defineProps(['transactions'])
</script>

<template>
    <h2 class="w-full text-center text-xl">Transition List</h2>
    <br>
    <br>
    <main class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <div v-for="transaction in transactions" :key="transaction.id" class="card glass">
            <div class="card-body">
                <div class="flex justify-between">
                    <span>date: {{ transaction.date }}</span>
                    <span>price: {{ transaction.price }}$</span>
                </div>
                <div class="divider  divider-primary"></div>
                <span>transactions:</span>
                <div class="ml-10">
                    <div v-for="product in transaction.products" :key="product.id" class="flex gap-3">
                        -
                        <div class="flex gap-3">
                            <span>name: {{ product.product_name }}</span>
                            <span>count: {{ product.count }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</template>

<style scoped>

</style>
