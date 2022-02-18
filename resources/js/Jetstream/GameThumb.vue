<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'hover'],

        computed: {
            classes() {
                return this.hover
                    ? 'inline-flex items-center px-1 pt-1 scale-90 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition'
                    : 'inline-flex items-center px-1 pt-1 scale-100 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition'
            }
        }
    })
</script>
