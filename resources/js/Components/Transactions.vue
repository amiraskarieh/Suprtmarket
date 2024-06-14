<script setup>
defineProps(['transactions'])
</script>

<template>
    <h2 class="w-full text-center text-xl">Transition List</h2>
    <br>
    <br>
    <main class="flex flex-col gap-3">
        <label class="collapse collapse-arrow glass" v-for="transaction in transactions" :key="transaction.id">
            <input type="radio" name="my-accordion-2"/>
            <div class="collapse-title text-xl font-medium">
                Time: {{ transaction.date }}, customer: {{ transaction.customer.name }},
                Employee: {{ transaction.employee.name }}, price {{ transaction.price }}$
            </div>
            <div class="collapse-content">
                <div class="flex flex-col sm:flex-row items-start gap-2">
                    <div class="basis-2/3 flex gap-2">
                        <div class="basis-1/2  card border border-primary">
                            <div class="card-body">
                                <h3 class="card-title">Customer</h3>
                                <span>name: {{ transaction.customer.name }}</span>
                                <span>phone: {{ transaction.customer.phone }}</span>
                            </div>
                        </div>
                        <div class="basis-1/2 card border border-primary">
                            <div class="card-body">
                                <h3 class="card-title">Employee</h3>
                                <span>name: {{ transaction.employee.name }}</span>
                                <span>phone: {{ transaction.employee.phone }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="sm:basis-1/3  flex flex-col gap-3">
                        <details class="collapse border border-primary collapse-arrow"
                                 v-for="product in transaction.products" :key="product.id">
                            <summary class="collapse-title text-xl font-medium">
                                name:{{ product.product.name }},
                                count: {{ product.count }}
                            </summary>
                            <div class="collapse-content flex flex-col">
                                <h3 class="card-title">Supplier</h3>
                                <div class="card-body">
                                    <span>name: {{ product.supplier.name }}</span>
                                    <span>email: {{ product.supplier.email }}</span>
                                    <span>phone: {{ product.supplier.phone }}</span>
                                </div>
                                <span>sell price: {{ product.product.sell_price }}$</span>
                                <span>discount: {{ product.product.discount }}%</span>
                                <span>real price: {{
                                        product.product.sell_price * (100 - product.product.discount) / 100
                                    }}$</span>
                                <div class="divider  divider-primary"></div>
                                <span>payed: {{
                                        product.product.sell_price * (100 - product.product.discount) / 100 * product.count
                                    }}$</span>
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </label>
    </main>
</template>

<style scoped>

</style>
