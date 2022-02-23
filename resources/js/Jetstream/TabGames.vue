<template>

  <TabGroup>
    <div class="p-2 bg-gray-50 rounded-lg flex">
    <TabList>
      <Tab v-slot="{ selected }" as="slots_template">
        <button @click="resetGames('slots')"
          :class="[
            selected
              ? 'inline-block py-3 px-1 ml-1 mr-1 text-tab font-bold tracking-wider leading-none uppercase text-center text-gray-900 border-b-2 border-indigo-300 hover:text-gray-600 hover:border-indigo-200'
              : 'inline-block py-3 px-1 ml-1 mr-1 text-tab font-medium tracking-wider leading-none uppercase text-center text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-indigo-200'
          ]"
        >
          Slots
        </button>
      </Tab>
      <Tab v-slot="{ selected }" as="live_template">
        <button @click="resetGames('live')"
          :class="[
            selected
              ? 'inline-block py-3 px-1 ml-1 mr-1 text-tab font-bold tracking-wider leading-none uppercase text-center text-gray-900 border-b-2 border-indigo-400 hover:text-gray-600 hover:border-indigo-200'
              : 'inline-block py-3 px-1 ml-1 mr-1 text-tab font-medium tracking-wider leading-none uppercase text-center text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-indigo-200'
          ]"
        >
          Live Casino
        </button>
      </Tab>
      <Tab v-slot="{ selected }" as="virtualsports_template">
        <button @click="resetGames('virtualsports')"
          :class="[
            selected
              ? 'inline-block py-3 px-1 ml-1 mr-1 text-tab font-bold tracking-wider uppercase leading-none text-center text-gray-900 border-b-2 border-indigo-400 hover:text-gray-600 hover:border-indigo-200'
              : 'inline-block py-3 px-1 ml-1 mr-1 text-tab font-medium tracking-wider uppercase leading-none text-center text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-indigo-200'
          ]"
        >
          Virtual Sports
        </button>
      </Tab>
    </TabList>

  <div class="w-52 ml-2">
    <Listbox v-model="provider">
      <div class="relative mt-1">
        <ListboxButton
          class="relative w-full py-1 pl-3 pr-4 text-center text-sm font-medium text-gray-500 tracking-normal leading-none shadow-sm bg-white rounded-lg cursor-default focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white focus-visible:ring-offset-indigo-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500 sm:text-sm"
        >
          <span class="block truncate">{{ provider.name }}</span>
          <span
            class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
          >
            <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
          </span>
        </ListboxButton>

        <transition
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <ListboxOptions
            class="absolute z-50 w-full py-1 mt-1 overflow-auto text-sm font-medium tracking-normal leading-none bg-white rounded-md max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
          >
            <ListboxOption
              v-slot="{ active, selected }"
              v-for="provider in providers"
              :key="provider.name"
              @click="resetGames(currentTab)"
              :value="provider"
              as="template"
            >
              <li
                :class="[
                  active ? 'text-indigo-900 bg-indigo-100' : 'text-gray-900',
                  'cursor-default select-none relative py-2 pl-10 pr-4',
                ]"
              >
                <span
                  :class="[
                    selected ? 'font-medium' : 'font-normal',
                    'block truncate',
                  ]"
                  >{{ provider.name }}</span
                >
                <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3 text-indigo-600"
                >
                  <CheckIcon class="w-5 h-5" aria-hidden="true" />
                </span>
              </li>
            </ListboxOption>
          </ListboxOptions>
        </transition>
      </div>
    </Listbox>
  </div>
</div>
    <TabPanels class="mt-2 mb-4">
      <TabPanel>
        <div class="p-2 bg-gray-50 rounded-lg">
          <div
            class="flex flex-wrap overflow-hidden pb-2 lg:-mx-1 xl:-mx-1"
          >
            <template v-for="game in games">
              <TransitionRoot
                appear
                :show="true"
                as="template"
                enter="transform transition duration-[300ms] ease"
                enter-from="opacity-0 scale-50"
                enter-to="opacity-100 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 scale-100 "
                leave-to="opacity-0 scale-95"
              >
                <div
                  class="w-full overflow-hidden w-full px-1 my-2 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/6 xl:my-3 xl:px-2 xl:w-1/8"
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
            <template v-for="game in games">
              <TransitionRoot
                appear
                :show="true"
                as="template"
                enter="transform transition duration-[300ms] ease"
                enter-from="opacity-0 scale-50"
                enter-to="opacity-100 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 scale-100 "
                leave-to="opacity-0 scale-95"
              >
                <div
                  class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/6 xl:my-3 xl:px-2 xl:w-1/8"
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
            <template v-for="game in games">
              <TransitionRoot
                appear
                :show="true"
                as="template"
                enter="transform transition duration-[300ms] ease"
                enter-from="opacity-0 scale-50"
                enter-to="opacity-100 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 scale-100 "
                leave-to="opacity-0 scale-95"
              >
                <div
                  class="w-full overflow-hidden w-full px-1 xxs:w-1/2 xs:w-1/3 xs:px-2 sm:w-1/3 sm:px-2 md:w-1/4 md:px-2 lg:my-3 lg:px-2 lg:w-1/6 xl:my-3 xl:px-2 xl:w-1/8"
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


      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-8 overflow-hidden sm:rounded-lg text-center font-semibold text-gray-500">

        <button v-if="games.length > 1" @click="loadGames(this.currentTab)" class="h-10 px-6 text-indigo-700 text-sm transition-colors duration-[100ms] ease border border-indigo-500 rounded-full hover:bg-indigo-500 hover:text-indigo-100">
                    Load more {{ provider.value }}
                  </button>
    </div></div>
    </TabPanels>
  </TabGroup>
</template>

<script>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import { defineComponent } from "vue";
import GameThumb from "@/Jetstream/GameThumb.vue";
import { TransitionRoot } from "@headlessui/vue";
import { ref } from "vue";
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue';
import { CheckIcon } from '@heroicons/vue/solid';

export default defineComponent({
  props: ["balances", "games"],

  setup() {
    const isShowing = true;

    const providers = [
        { id: 1, name: 'All Providers', amount: 10, value: ' ' },
        { id: 2, name: 'Pragmatic Play', amount: 11, value: 'pragmatic' },
        { id: 3, name: 'NetEnt', amount: 5, value: 'netent' },
        { id: 4, name: 'Evoplay', amount: 17, value: 'evoplay' },
        { id: 5, name: 'BGaming', amount: 2, value: 'bgaming' },
      ]
      const provider = ref(providers[0])
      const filterProvider = ref(providers[0])


      return {
        providers,
        filterProvider,
        provider,
      }
  },
        data() {
            return {
                currentPage: 1,
                filterProvider: ' ',
                games: [],
                currentTab: 'slots',
                list: []
            }
        },
        mounted() {
            this.loadGames('slots', ' ');
        },
        methods: {
        resetGames(type) {
          this.currentPage = 1;
          this.games = [];
          this.currentTab = type;

          this.loadGames(type);
        },
        loadGames(type) {
            const current = this.currentPage;
            const provider = this.provider.value;
            fetch('/api/gamelist?page=' + current + '&filter[type]=' + type + '&filter[game_provider]=' + provider)
            .then(res => {return res.json()})
            .then(data => {
                
            const list = data.data;
            list.forEach((game) => {
                this.games.push(game);
            });

          this.currentPage = current + 1;

            });
        },
        },

  components: {
    Listbox, ListboxButton, ListboxOptions, ListboxOption,
    CheckIcon,
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
