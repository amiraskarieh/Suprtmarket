import {defineStore} from 'pinia'
import {ref, computed} from 'vue'

export const useStore = defineStore('store', () => {
    const bag = ref({})

    function add_to_bag(id) {
        if (!is_id_in_bag(id)) {
            bag.value[id] = 0
        }
        bag.value[id] += 1
    }

    function remove_from_bag(id) {
        if (is_id_in_bag(id)) {
            bag.value[id] -= 1
            if (bag.value[id] <= 0)
                delete bag.value[id]
        }
    }

    function is_id_in_bag(id) {
        return id in bag.value
    }

    function get_count(id) {
        return computed(() => bag.value[id])
    }

    return {bag, add_to_bag, remove_from_bag, is_id_in_bag, get_count}
})
