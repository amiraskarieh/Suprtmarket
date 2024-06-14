<script setup>

import {onMounted, onUnmounted, ref} from "vue";

const logs = ref([])

function get_logs() {
    axios.get(route('logs.recent'))
        .then(r => {
            logs.value = r.data
            console.log(r.data)
        })
        .catch(e => {
            console.log(e.data)
        })
}

onMounted(get_logs)
const get_log_interval = setInterval(get_logs, 2000)
onUnmounted(() => clearInterval(get_log_interval))
const operation_type_color = {
    'INSERT': "text-success",
    'DELETE': "text-error",
    'UPDATE': "text-info",
}
</script>

<template>
    <main class="max-w-4xl mx-auto">
        <transition-group name="down-up" tag="div" class="mockup-code overflow-y-auto h-96 bg-neutral">
        <pre v-for="log in logs" :key="log.id" data-prefix=">">
            <code><span class="text-primary ">[{{
                    log.created_at
                }}]</span> In table: <span
                class="text-primary">{{
                    log.logable_type.split('/')[log.logable_type.split('/').length - 1]
                }}</span> <span
                :class="operation_type_color[log.operation_type]">{{
                    log.operation_type
                }}</span> ID: <span class="text-primary">{{ log.logable_id }}</span></code>
        </pre>
        </transition-group>
    </main>
</template>

<style scoped>
.down-up-enter-active,
.down-up-leave-active {
    transition: all 0.5s ease;
}

.down-up-enter-from,
.down-up-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
</style>
