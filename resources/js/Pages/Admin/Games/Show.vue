<template>
    <app-layout title="Games">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Games Control
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <test-games :apikey="apikey" class="mt-10 sm:mt-0" />
                    <jet-section-border />
                    <update-games :gamescount="gamescount" :providerscount="providerscount" :apikey="apikey" class="mt-10 sm:mt-0" />
                    <jet-section-border />
                    <gameslist :games="games" class="mt-10 sm:mt-0" />
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
    import UpdateGames from '@/Pages/Admin/Games/Partials/UpdateGames.vue'
    import TestGames from '@/Pages/Admin/Games/Partials/TestGames.vue'
    import Gameslist from '@/Pages/Admin/Games/Partials/Gameslist.vue'

    export default defineComponent({
        props: ['games', 'gamescount', 'providerscount', 'apikey'],

        components: {
            AppLayout,
            JetSectionBorder,
            TestGames,
            Gameslist,
            UpdateGames,
        },
    })
</script>
