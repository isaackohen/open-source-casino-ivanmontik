<template>
  <TabGroup>
    <TabList>
      <Tab v-slot="{ selected }" as="template">
        <button
          :class="[
            selected
              ? 'inline-block py-4 px-4 text-md font-medium text-center text-gray-900 rounded-t-lg border-b-2 border-blue-200 hover:text-gray-600 hover:border-gray-300'
              : 'inline-block py-4 px-4 text-md font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300'
          ]"
        >
          Slots
        </button>
      </Tab>
      <Tab v-slot="{ selected }" as="template">
        <button
          :class="[
            selected
              ? 'inline-block py-4 px-4 text-md font-medium text-center text-gray-900 rounded-t-lg border-b-2 border-blue-200 hover:text-gray-600 hover:border-gray-300'
              : 'inline-block py-4 px-4 text-md font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300'
          ]"
        >
          Live Casino
        </button>
      </Tab>

      <Tab v-slot="{ selected }" as="template">
        <button
          :class="[
            selected
              ? 'inline-block py-4 px-4 text-md font-medium text-center text-gray-900 rounded-t-lg border-b-2 border-blue-200 hover:text-gray-600 hover:border-gray-300'
              : 'inline-block py-4 px-4 text-md font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300'
          ]"
        >
          Random
        </button>
      </Tab>
    </TabList>
    <TabPanels class="mt-2 mb-4">
      <TabPanel>
        <div class="p-4 bg-gray-50 rounded-lg">
          <div
            class="flex flex-wrap overflow-hidden pb-2 lg:-mx-2 xl:-mx-2"
          >
            <template v-for="game in $page.props.games2">
              <TransitionRoot
                appear
                :show="true"
                as="template"
                enter="transform transition duration-[400ms] ease"
                enter-from="opacity-0 scale-50"
                enter-to="opacity-100 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 scale-100 "
                leave-to="opacity-0 scale-95"
              >
                <div
                  class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/5 xl:my-3 xl:px-2 xl:w-1/6"
                >
                  <game-thumb
                    :href="
                      route('game.show', {
                        slug: game.game_slug
                      })
                    "
                  >
                    <img
                      class="h-full w-full shadow-sm rounded-2xl scale-105 duration-[325ms] ease hover:scale-100"
                      :src="
                        `https://dkimages.imgix.net/v2/image_sq_alt/${
                          game.game_provider
                        }/${
                          game.game_slug
                        }.png?auto=format,compress&sharp=10&q=90w=250&h=250`
                      "
                    />
                  </game-thumb>
                </div>
              </TransitionRoot>
            </template>
          </div>
        </div>
      </TabPanel>

      <TabPanel>
        <div class="p-4 bg-gray-50 rounded-lg">
          <div
            class="flex flex-wrap overflow-hidden pb-2 lg:-mx-2 xl:-mx-2"
          >
            <template v-for="game in $page.props.games3">
              <TransitionRoot
                appear
                :show="true"
                as="template"
                enter="transform transition duration-[400ms] ease"
                enter-from="opacity-0 scale-50"
                enter-to="opacity-100 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 scale-100 "
                leave-to="opacity-0 scale-95"
              >
                <div
                  class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/5 xl:my-3 xl:px-2 xl:w-1/6"
                >
                  <game-thumb
                    :href="
                      route('game.show', {
                        slug: game.game_slug
                      })
                    "
                  >
                    <img
                      class="h-full w-full shadow-sm rounded-2xl scale-105 duration-[325ms] ease hover:scale-100"
                      :src="
                        `https://dkimages.imgix.net/v2/image_sq_alt/${
                          game.game_provider
                        }/${
                          game.game_slug
                        }.png?auto=format,compress&sharp=10&q=90w=250&h=250`
                      "
                    />
                  </game-thumb>
                </div>
              </TransitionRoot>
            </template>
          </div>
        </div>
      </TabPanel>
      <TabPanel>
        <div class="p-4 bg-gray-50 rounded-lg">
          <div
            class="flex flex-wrap overflow-hidden pb-2 lg:-mx-2 xl:-mx-2"
          >
            <template v-for="game in $page.props.games4">
              <TransitionRoot
                appear
                :show="true"
                as="template"
                enter="transform transition duration-[400ms] ease"
                enter-from="opacity-0 scale-50"
                enter-to="opacity-100 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 scale-100 "
                leave-to="opacity-0 scale-95"
              >
                <div
                  class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/5 xl:my-3 xl:px-2 xl:w-1/6"
                >
                  <game-thumb
                    :href="
                      route('game.show', {
                        slug: game.game_slug
                      })
                    "
                  >
                    <img
                      class="h-full w-full shadow-sm rounded-2xl scale-105 duration-[325ms] ease hover:scale-100"
                      :src="
                        `https://dkimages.imgix.net/v2/image_sq_alt/${
                          game.game_provider
                        }/${
                          game.game_slug
                        }.png?auto=format,compress&sharp=10&q=90w=250&h=250`
                      "
                    />
                  </game-thumb>
                </div>
              </TransitionRoot>
            </template>
          </div>
        </div>
      </TabPanel>
    </TabPanels>
  </TabGroup>
</template>

<script>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import { defineComponent } from "vue";
import GameThumb from "@/Jetstream/GameThumb.vue";
import { TransitionRoot } from "@headlessui/vue";
import { ref } from "vue";

export default defineComponent({
  props: ["balances", "games"],

  setup() {
    const isShowing = true;
  },

  components: {
    TabGroup,
    TabList,
    Tab,
    TransitionRoot,
    GameThumb,
    TabPanels,
    TabPanel
  }
});
</script>
