<script setup>
import {PencilSquareIcon, TrashIcon, EyeIcon} from "@heroicons/vue/24/outline";

defineProps(['input_list', 'is_show_able', 'list_name'])
defineEmits(['del', 'update', 'show'])
</script>

<template>
    <div class="card glass shadow-md">
        <div class="card-body px-0">
            <h3 class="card-title justify-center">
                {{ list_name }}
                List
            </h3>
            <div class="flex flex-col">
                <div v-for="item in input_list" :key="item.id"
                     class="flex justify-between h-12 px-10 odd:bg-primary/10 items-center transition-all duration-150 hover:shadow-lg hover:text-xl group">
                    <p>{{ item.name }}</p>
                    <div class="flex gap-2">
                        <button @click="$emit('update',item.id)">
                            <PencilSquareIcon class="h-4 text-info transition-all duration-150 group-hover:h-6"/>
                        </button>
                        <button @click="$emit('del',item.id)">
                            <TrashIcon class="h-4 text-error transition-all duration-150 group-hover:h-6"/>
                        </button>
                        <button v-if="is_show_able" @click="$emit('show',item.id)">
                            <EyeIcon class="h-4 textarea-success transition-all duration-150 group-hover:h-6"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
