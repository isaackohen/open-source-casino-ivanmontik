<template>
  <TabGroup>
    <TabList>
      <Tab v-slot="{ selected }" as="template">
        <button
          :class="[selected ? 'bg-blue-500 text-white' : 'bg-white text-black']"
        >
          Welcome
        </button>
      </Tab>
      <Tab><button class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">Profile</button></Tab>
      <Tab>Tab 3</Tab>
    </TabList>
    <TabPanels>
      <TabPanel>
          
        <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-200">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>

      </TabPanel>
      <TabPanel>Content 2</TabPanel>
      <TabPanel>Content 3</TabPanel>
    </TabPanels>
  </TabGroup>

</template>



<script>
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
    import { defineComponent } from 'vue'

    export default defineComponent({
        components: {
          TabGroup,
          TabList,
          Tab,
          TabPanels,
          TabPanel,
        },

    })

</script>