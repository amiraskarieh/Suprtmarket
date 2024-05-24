<script setup>
import {useStore} from "@/Store/my_store.js";
import {useToast} from "vue-toastification";
import {router} from "@inertiajs/vue3";

const emit = defineEmits(['update', 'cancel', 'del'])
const store = useStore()
const toast = useToast()

const props = defineProps(['product'])
const add = () => {
    store.add_to_bag(props.product.id, props.product.sell_price * (100 - props.product.discount) / 100)
    if (store.get_count(props.product.id).value > props.product.available) {
        remove()
        toast.error(`the ${props.product.name} does not exist more!`)
    }
}

const remove = () => store.remove_from_bag(props.product.id, props.product.sell_price * (100 - props.product.discount) / 100)
</script>

<template>
    <div v-if="product.available" class="card shadow-2xl glass bg-primary">
        <div class="card-body">
            <h3 class="card-title justify-center">{{ product.name }}</h3>
            <p :class="{'line-clamp-2':product.discount,'line-clamp-3':!product.discount}">
                {{ product.description }}
            </p>
            <div class="card-actions justify-between items-center">
                <div>
                    <p v-if="product.discount" class="flex gap-2">
                        <span>{{ (product.sell_price * (100 - product.discount) / 100).toFixed(2) }}$</span>
                        <span class="badge badge-secondary">{{ product.discount }}%</span>
                    </p>

                    <p :class="{'line-through':product.discount!==0}">
                        <span class="text-sm font-medium">{{ product.sell_price }}$</span>
                    </p>
                </div>
                <button v-if="!store.is_id_in_bag(product.id)" @click="add" class="btn btn-accent btn-sm">
                    Add to bag
                </button>
                <div v-else class="join">
                    <button class="btn btn-sm btn-accent join-item" @click="remove">-</button>
                    <button class="btn btn-sm btn-accent join-item">{{ store.get_count(product.id) }}</button>
                    <button class="btn btn-sm btn-accent join-item" @click="add">+</button>
                </div>
            </div>
        </div>
    </div>
</template>
