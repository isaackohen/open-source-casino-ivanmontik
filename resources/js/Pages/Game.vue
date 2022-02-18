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
                 <button v-if="$page.props.loggedUser" @click="playGame('USD')" class="h-10 px-6 text-indigo-700 text-sm transition-colors duration-[100ms] ease border border-indigo-500 rounded-full hover:bg-indigo-500 hover:text-indigo-100" :class="{ 'opacity-25': gameLoadLauncher.processing }" :disabled="gameLoadLauncher.processing">
                    Play USD$
                </button>
                 <button v-if="$page.props.demo === 1" @click="playGame('demo')" class="h-10 px-6 ml-4 text-gray-400 text-sm transition-colors duration-[100ms] ease border border-indigo-100 rounded-full hover:bg-indigo-100 hover:text-indigo-900" :class="{ 'opacity-50': gameLoadLauncher.processing }" :disabled="gameLoadLauncher.processing">
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
        props: ['game_slug', 'iframe_url', 'loggedUser'],

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
                    onError: () => (this.iframe = null),
                })
            },
        },
        components: {
            Link,
            AppLayout,
        },
    })
</script> 