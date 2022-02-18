<template>
    <app-layout :title="`${$page.props.game_header}`">
        <template #gameheader>
            <h4 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ $page.props.game_header }}
            </h4>
            <span class="font-light text-xs text-gray-800">{{ $page.props.game_provider }} - <b>{{ $page.props.rtp }}% RTP</b></span>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div v-if="$page.props.iframe" class="container aspect-w-16 aspect-h-9 bg-white rounded-lg">
                  <iframe :src="`${this.iframe_url}`" class="rounded-lg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <div v-else class="container aspect-w-16 aspect-h-9 bg-white rounded-lg">
                <div class="flex items-center justify-center">
                 <button @click="playGame('USD')" class="underline opacity-100 ease-[300ms] text-sm mr-2 pb-2 text-gray-600 hover:text-gray-900" :class="{ 'opacity-50': gameLoadLauncher.processing }" :disabled="gameLoadLauncher.processing">
                    Play USD$
                </button>
                 <button @click="playGame('demo')" class="underline opacity-100 ease-[300ms] text-sm ml-2 pb-2 text-gray-600 hover:text-gray-900" :class="{ 'opacity-50': gameLoadLauncher.processing }" :disabled="gameLoadLauncher.processing">
                    Play DEMO
                </button>
                </div>  
            </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        props: ['game_slug', 'iframe_url'],

        data() {
            return {
                gameLoadLauncher: this.$inertia.form(),
            }
        },
        methods: {
            playGame(nativecurrency) {
                 this.$inertia.get(route('game.real.start', { currency: nativecurrency, slug: this.game_slug }), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.gameLoadLauncher = null),
                    onError: () => (this.gameLoadLauncher = null),
                })
            },
        },
        components: {
            Link,
            AppLayout,
        },
    })
</script> 