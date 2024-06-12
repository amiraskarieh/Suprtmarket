<script setup>

import {ref, watch} from "vue";

const props = defineProps([
    'name', 'max_sell_price', 'available', 'sort_by'
])
const emit = defineEmits(['name', 'max_sell_price', 'available', 'sort_by']);
const form = ref({...props});
const max = ref(0)

watch(() => props.max_sell_price, v => max.value = v * 1.5)

watch(() => form.value.name, value => emit("name", value))
watch(() => form.value.max_sell_price, value => emit("max_sell_price", value))
watch(() => form.value.available, value => emit("available", value))
watch(() => form.value.sort_by, value => emit("sort_by", value))

</script>

<template>
    <form class="flex flex-col gap-5">
        <label class="form-control w-full ">
        <span class="label">
            <span class="label-text">Name</span>
        </span>
            <input
                id="name"
                v-model.lazy="form.name"
                type="text"
                class="input input-bordered w-full input-primary"
                required
                placeholder="Name"/>
        </label>
        <label class="form-control w-full ">
        <span class="label">
            <span class="label-text">
                Max Price
                <span class="badge badge-secondary"> {{ form.max_sell_price }}</span>
            </span>
        </span>
            <input
                id="name"
                v-model.lazy="form.max_sell_price"
                :max="1000"
                min="0"
                :step="1000/20"
                type="range"
                class="range range-xs w-full range-primary"
                required
                placeholder="Name"/>
            <div class="w-full flex justify-between text-xs">
            <span v-for="i in 11" :key="i">
                <span>|</span>
            </span>
            </div>
        </label>
        <div class="form-control">
            <label class="cursor-pointer label justify-between">
                <span class="label-text">available products</span>
                <input type="checkbox" v-model="form.available" name="available" class="checkbox checkbox-primary"/>
            </label>
        </div>
        <div class="form-control w-full flex-row items-center gap-2">
            <span> sort by</span>
            <label :class="{
                'label px-3 py-2 badge cursor-pointer badge-primary badge-outline':form.sort_by !== 'sell_price',
                'label px-3 py-2 badge cursor-pointer badge-primary':form.sort_by === 'sell_price'}">
                <span class="text-base-content">sell price</span>
                <input v-model="form.sort_by" value="sell_price" type="radio" name="sort-by" class="hidden"/>
            </label>
            <label :class="{
                'label px-3 py-2 badge cursor-pointer badge-primary badge-outline':form.sort_by !== 'name',
                'label px-3 py-2 badge cursor-pointer badge-primary':form.sort_by === 'name'}">
                <span class="text-base-content">name</span>
                <input v-model="form.sort_by" value="name" type="radio" name="sort-by" class="hidden" checked/>
            </label>
        </div>
    </form>
</template>

