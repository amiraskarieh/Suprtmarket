<script setup>
import {useStore} from "@/Store/my_store.js";
import {useToast} from "vue-toastification";

const store = useStore()
const toast = useToast()

const props = defineProps(['product'])
const add = () => {
    store.add_to_bag(props.product.id)
    if (store.get_count(props.product.id).value > props.product.count) {
        remove()
        toast.error(`the ${props.product.name} does not exist more!`)
    }
}

const remove = () => store.remove_from_bag(props.product.id)
</script>

<template>
    <div v-if="product.count" class="card shadow-2xl image-full">
        <figure><img :src="`https://picsum.photos/id/${product.id*3}/300/200`" :alt="product.name"/>
        </figure>
        <div class="card-body">
            <h3 class="card-title">{{ product.name }}</h3>
            <p :class="{'line-clamp-2':product.discount,'line-clamp-3':!product.discount}">
                {{ product.description }}
            </p>
            <div class="card-actions justify-between items-center">
                <div>
                    <p v-if="product.discount" class="flex gap-2">
                        <span>{{ product.price * (100 - product.discount) / 100 }}$</span>
                        <span class="badge badge-secondary">{{ product.discount }}%</span>
                    </p>

                    <p :class="{'line-through':product.discount!==0}">
                        <span class="text-sm font-medium">{{ product.price }}$</span>
                    </p>
                </div>
                <button v-if="!store.is_id_in_bag(product.id)" @click="add" class="btn btn-primary btn-sm">
                    Add to bag
                </button>
                <div v-else class="join">
                    <button class="btn btn-sm btn-primary join-item" @click="remove">-</button>
                    <button class="btn btn-sm btn-primary join-item">{{ store.get_count(product.id) }}</button>
                    <button class="btn btn-sm btn-primary join-item" @click="add">+</button>
                </div>
            </div>
        </div>
    </div>
</template>
