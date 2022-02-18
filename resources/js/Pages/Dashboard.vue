<template>
    <app-layout title="Casino">
        <template #header>
            <h4 class="font-semibold text-xl text-gray-800 leading-tight">
                Casino
            </h4>
        </template>
        <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <top-tabs />
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                    <div class="flex flex-wrap overflow-hidden p-4 lg:-mx-2 xl:-mx-2">
                        <template v-for="game in $page.props.games">
                                <TransitionRoot
                                    appear
                                    :show="isShowing"
                                    as="template"
                                    enter="transform transition duration-[350ms] ease"
                                    enter-from="opacity-0 scale-50"
                                    enter-to="opacity-100 scale-100"
                                    leave="transform duration-200 transition ease-in-out"
                                    leave-from="opacity-100 scale-100 "
                                    leave-to="opacity-0 scale-95 "
                                >
                                    <div class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/5 xl:my-3 xl:px-2 xl:w-1/6">
                                        <game-thumb :href="route('game.show', { slug: game.game_slug })">
                                            <img class="h-full w-full shadow-xl rounded-2xl scale-105 duration-[325ms] ease hover:scale-100" :src="`https://dkimages.imgix.net/v2/image_sq_alt/${game.game_provider}/${game.game_slug}.png?w=210&h=210`">
                                        </game-thumb>
                                    </div>
                                </TransitionRoot>
                         </template>  
                    </div>     
                </div>
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
    import TopTabs from '@/Jetstream/TopTabs.vue'
    import GameThumb from '@/Jetstream/GameThumb.vue'
    import { TransitionRoot } from '@headlessui/vue'
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
            TopTabs,
            TransitionRoot,
            GameThumb,
        },
    })
</script>
