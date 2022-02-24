<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-bold text-tab text-white uppercase tracking-wide hover:bg-red-500 hover:ring hover:ring-red-300 active:bg-red-800 focus:outline-none focus:border-red-400 focus:ring focus:ring-red-300 disabled:opacity-25 transition duration-[325ms] ease-in-out">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    })
</script>
