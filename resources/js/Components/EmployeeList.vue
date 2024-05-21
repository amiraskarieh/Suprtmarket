<script setup>
import {ref} from "vue";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/outline";
import AddEmployee from "@/Components/AddEmployee.vue";

const employees = ref([])

for (let i = 0; i < 10; i++) {
    employees.value.push({
        id: i,
        name: i,
        address: i,
        phone: i,
        age: i,
        salary: i,
        employment_date: i,
        marital_status_id: i,
        job_type_id: i
    })
}

const select_for_update = ref({})
const show_edit = ref(false)

function update(id) {
    for (const employee of employees.value) {
        if (employee.id === id) {
            select_for_update.value = employee
            show_edit.value = true
            break
        }
    }

}

function del(id) {

}

</script>

<template>
    <AddEmployee v-if="show_edit"
                 :id="select_for_update.id"
                 :name="select_for_update.name"
                 :address="select_for_update.address"
                 :phone="select_for_update.phone"
                 :age="select_for_update.age"
                 :salary="select_for_update.salary"
                 :employment_date="select_for_update.employment_date"
                 :marital_status_id="select_for_update.marital_status_id"
                 :job_type_id="select_for_update.job_type_id"
                 @cansel="()=>show_edit=false"/>

    <div class="card glass shadow-md" v-else>
        <div class="card-body px-0">
            <h3 class="card-title justify-center">Employee List</h3>
            <div class="flex flex-col">
                <div v-for="employee in employees" :key="employee.id"
                     class="flex justify-between h-12 px-10 odd:bg-primary/10 items-center transition-all duration-150 hover:shadow-lg hover:text-xl group">
                    <p>{{ employee.name }}</p>
                    <div class="flex gap-2">
                        <button>
                            <PencilSquareIcon @click="update(employee.id)"
                                              class="h-4 text-info transition-all duration-150 group-hover:h-6"/>
                        </button>
                        <button>
                            <TrashIcon @click="del(employee.id)"
                                       class="h-4 text-error transition-all duration-150 group-hover:h-6"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
