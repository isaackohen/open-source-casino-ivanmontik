<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-indigo-700 border border-transparent rounded-md font-bold text-tab text-white uppercase tracking-wide hover:bg-indigo-500 hover:ring hover:ring-indigo-300 active:bg-indigo-800 focus:outline-none focus:border-indigo-400 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition duration-[325ms] ease-in-out">
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
