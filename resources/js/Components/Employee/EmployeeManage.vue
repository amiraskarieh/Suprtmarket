<script setup>
import AddEmployee from "@/Components/Employee/AddEmployee.vue";
import MyList from "@/Components/MyList.vue";
import {onMounted, ref} from "vue";
import {useToast} from "vue-toastification";

const select_for_update = ref({})
const show_edit = ref(false)

const employees = ref([])

onMounted(get_employees)

const toast = useToast()

function get_employees() {
    show_edit.value = false
    axios.get(route('employees.index'))
        .then((response) => employees.value = response.data)
}

function update(id) {
    for (const employee of employees.value) {
        if (employee.id === id) {
            select_for_update.value = employee
            show_edit.value = true
            break
        }
    }
}

function updated() {
    get_employees()
    select_for_update.value = {}
}

function del(id) {
    axios.delete(route('employees.destroy', [id])).then(() => {
        toast.success('delete successful!')
        get_employees()
    }).catch(r=>{
        toast.error(r.response.data.message)
    })
}

</script>

<template>

    <main class="max-w-4xl mx-auto">
        <div class="gap-4 grid grid-cols-2">
            <transition name="list" mode="out-in">

                <AddEmployee v-if="show_edit"
                             :key="select_for_update.id"
                             :id="select_for_update.id"
                             :name="select_for_update.name"
                             :address="select_for_update.address"
                             :phone="select_for_update.phone"
                             :age="select_for_update.age"
                             :salary="select_for_update.salary"
                             :employment_date="select_for_update.employment_date"
                             :marital_status="select_for_update.marital_status"
                             :job_type="select_for_update.job_type"
                             @cancel="()=>show_edit=false"
                             @updated="updated"
                />
                <AddEmployee v-else
                             key="add"
                             @created="get_employees"
                />
            </transition>
            <MyList
                :input_list="employees"
                :is_show_able="false"
                list_name="Employee"
                @del="del"
                @update="update"
            />
        </div>
    </main>
</template>

