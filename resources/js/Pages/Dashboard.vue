<template>
    <app-layout title="Casino Games">
        <template #header>
            <h4 class="font-semibold text-xl text-gray-800 leading-tight">
                Casino
            </h4>
        </template>
        <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <tab-games />
            </div>
        </div>
    </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import TabGames from '@/Jetstream/TabGames.vue'
    import { ref } from 'vue'

    export default defineComponent({
        props: ['balances', 'games'],

  setup() {
    const isShowing = ref(true)

            return {
              isShowing,
              resetIsShowing() {
                isShowing.value = false

                setTimeout(() => {
                  isShowing.value = true
                }, 500)
              },
            }
          },
        components: {
            AppLayout,
            Welcome,
            TabGames,
        },
    })
</script>
