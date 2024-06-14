<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {onMounted, ref} from "vue";
import EmployeeManage from "@/Components/Employee/EmployeeManage.vue";
import SupplierManage from "@/Components/Supplier/SupplierManage.vue";
import ProductManage from "@/Components/Product/ProductManage.vue";
import {useStore} from "@/Store/my_store.js";
import {router} from "@inertiajs/vue3";
import SysLogs from "@/Components/SysLogs.vue";

const comp = {'product': ProductManage, 'employee': EmployeeManage, 'supplier': SupplierManage, 'syslogs':SysLogs}
const current_comp = ref('product')

const store = useStore()
onMounted(()=>{
    if (!store.is_employee) {
        router.replace('/')
    }
})
</script>

<template>
    <AppLayout title="Employee">
        <div role="tablist" class="tabs tabs-bordered tabs-lg pt-4">
            <button v-for="(_,key) in comp"
                    :key="key"
                    role="tab"
                    :class="{
                        'tab ':current_comp!==key,
                        'tab tab-active':current_comp===key
                    }"
                    @click="()=>current_comp=key">
                {{ key }}s
            </button>
        </div>
        <transition tag="div" name="list" mode="out-in" class="pt-10">
            <component :is="comp[current_comp]"/>
        </transition>
    </AppLayout>
</template>

<style>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s;
}

.list-enter-from {
    opacity: 0;
    transform: translateX(50px);
}

.list-leave-to {
    opacity: 0;
    transform: translateX(-50px);
}
</style>
