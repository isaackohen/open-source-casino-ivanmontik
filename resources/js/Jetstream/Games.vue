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
                leave-to="opacity-0 scale-95">
                <div class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-2 lg:px-2 lg:w-1/5 xl:my-2 xl:px-2 xl:w-1/6">
                    <jet-nav-link :href="route('game.show', { slug: game.game_slug })">
                        <img class="h-full w-full rounded-2xl" :src="`https://dkimages.imgix.net/v2/image_sq_alt/${game.game_provider}/${game.game_slug}.png?w=225&h=225`">
                    </jet-nav-link>
                </div>
        </TransitionRoot>
 
            </template>

<script>
    import { defineComponent } from 'vue'
    import { TransitionRoot } from '@headlessui/vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { ref } from 'vue'

    export default defineComponent({

    props: ['games'],


        setup() {
            const isShowing = ref(true)

            return {
              isShowing,
            }
          },
        components: {
            TransitionRoot,
            JetNavLink,
            JetResponsiveNavLink,
        },
    })
</script>