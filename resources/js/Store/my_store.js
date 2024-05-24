import {defineStore} from 'pinia'
import {ref, computed} from 'vue'

export const useStore = defineStore('store', () => {
    const bag = ref({})
    const price = ref(0)

    function reset_bag(){
        bag.value = {}
        price.value = 0
    }

    function get_bag_to_array() {
        let result = []
        for (const bagKey in bag.value) {
            result.push({'product_id': bagKey, 'count': bag.value[bagKey]})
        }
        return result
    }

    function add_to_bag(id, _price) {
        if (!is_id_in_bag(id)) {
            bag.value[id] = 0
        }
        bag.value[id] += 1
        price.value += _price
        price.value.toFixed(2)
    }

    function remove_from_bag(id, _price) {
        if (is_id_in_bag(id)) {
            bag.value[id] -= 1
            if (bag.value[id] <= 0)
                delete bag.value[id]
            price.value -= _price
            price.value.toFixed(2)
        }
    }

    function is_id_in_bag(id) {
        return id in bag.value
    }

    function get_count(id) {
        return computed(() => bag.value[id])
    }

    const is_employee = ref(false)

    function set_employee(status) {
        is_employee.value = status
    }

    const is_customer = ref(false)

    function set_customer(status) {
        is_customer.value = status
    }

    return {
        bag,
        reset_bag,
        get_bag_to_array,
        add_to_bag,
        remove_from_bag,
        is_id_in_bag,
        get_count,
        price,
        is_employee,
        set_employee,
        is_customer,
        set_customer
    }
})
