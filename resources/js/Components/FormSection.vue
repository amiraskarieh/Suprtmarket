<script setup>
defineEmits(['submitted']);
</script>

<template>
    <div class="card lg:card-side glass">
        <div class="card-body lg:basis-1/5">
            <div class="card-title text-base-content">
                <slot name="title"/>
            </div>
            <p>
                <slot name="description"/>
            </p>
        </div>
        <form class="card-body" @submit.prevent="$emit('submitted')">
            <div class="card bg-primary text-primary-content">
                <div class="card-body">
                    <slot name="form"/>

                    <div class="card-actions justify-end">
                        <slot name="actions"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
