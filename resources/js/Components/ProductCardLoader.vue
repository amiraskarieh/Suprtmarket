<script setup>
import {useStore} from "@/Store/my_store.js";

const store = useStore()
</script>
<template>
    <div class="card bg-transparent border shadow-2xl">
        <div class="card-body">
            <div class="skeleton  w-40 h-10"></div>
            <div class="skeleton w-full h-12"></div>
            <div class="card-actions justify-between items-center">
                <div class="skeleton w-32 h-8"></div>
                <div class="skeleton w-24 h-8"></div>
            </div>
            <div v-if="store.is_employee" class="skeleton w-full h-8"></div>
        </div>
    </div>
</template>
