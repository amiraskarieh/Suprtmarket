<script setup>
import {ref} from "vue";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/outline";

const suppliers = ref([])

for (let i = 0; i < 10; i++) {
    suppliers.value.push({id: i, name: `name${i}`})
}

function del(id){

}

</script>

<template>

    <div class="card glass shadow-2xl">
        <h3 class="card-title justify-center">Suppliers List</h3>
        <div class="card-body px-0">
            <div class="flex flex-col">
                <div v-for="supplier in suppliers" :key="supplier.id" class="flex justify-between h-12 px-10 odd:bg-primary/10 items-center transition-all duration-150 hover:text-xl group">
                    <p>{{ supplier.name }}</p>
                    <div class="flex gap-2">
                        <button>
                            <PencilSquareIcon class="h-4 text-info transition-all duration-150 group-hover:h-6"/>
                        </button>
                        <button>
                            <TrashIcon @click="del(supplier.id)" class="h-4 text-error transition-all duration-150 group-hover:h-6"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
